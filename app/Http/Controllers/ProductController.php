<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Http\Requests\ProductRequest;
use App\Models\Automaker;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Headquarter;
use App\Models\Product;
use App\Models\ProductLocation;
use App\Models\ProductSale;
use App\Models\ProductWithdrawal;
use App\Models\Supplier;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Maatwebsite\Excel\Facades\Excel;
use Telegram\Bot\Laravel\Facades\Telegram;
use Yajra\DataTables\Facades\DataTables;

//use Telegram\Bot\Laravel\Facades\Telegram;

class ProductController extends Controller
{
    //VALIDANDO SE O USUÁRIO POSSUI AS PERMISSÕES NECESSÁRIAS PARA ACESSAR ESTA CONTROLLER
    public function __construct()
    {
        $this->middleware('auth'); //Verificando se o usuário está loggado
        //Verificando as permissões deste usuário
        $this->middleware('permission:list products', ['only' => ['index']]);
        $this->middleware('permission:create product', ['only' => ['create']]);
        $this->middleware('permission:show product', ['only' => ['show']]);
        $this->middleware('permission:edit product', ['only' => ['edit']]);
        $this->middleware('permission:destroy product', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Product::with('category', 'automaker', 'brand', 'productLocations', 'productSales')->latest('updated_at');

            if ($request->has('low_stock')) {
                $data->whereHas('productLocations', function ($query) {
                    $query->where('quantity', '<=', DB::raw('stock_alert_at'));
                });
            }

            if ($request->has('best_selling')) {
                $data->whereHas('productSales')
                    ->withCount(['productSales as total_quantity_sold' => function ($query) {
                        $query->select(DB::raw('SUM(quantity_sold)'));
                    }])
                    ->orderBy('total_quantity_sold', 'desc');
            }

            if ($request->has('on_sale')) {
                $data->where('sale', 'Sim')->where('sale_period_until', '>=', Carbon::now());
            }

            if ($request->has('for_separation')) {
                $data->whereHas('productWithdrawals', function ($query) {
                    $query->where('withdrawal_status', 'PENDENTE');
                });
            }

            return DataTables::eloquent($data)
                ->addColumn('name', function ($product) {
                    $name = '<div class="position-relative mt-1 mb-2">';
                    $name .= '<img class="rounded" loading="lazy" src="' . asset('img/products/' . $product->main_img) . '" alt="Imagem sobre o produto" width="55px" height="55px">';
                    if ($product->visible == 'Sim') {
                        $name .= '<div class="badge bg-primary rounded-pill position-absolute top-100 start-75 translate-middle">';
                        $name .= '<i class="fa-solid fa-store fa-xl"></i>';
                        $name .= '</div>';
                    } else {
                        $name .= '<div class="badge bg-secondary rounded-pill position-absolute top-100 start-75 translate-middle">';
                        $name .= '<i class="fa-solid fa-store-slash"></i>';
                        $name .= '</div>';
                    }

                    if ($product->sale == 'Sim' && Carbon::now()->lt($product->sale_period_until)) {
                        $name .= '<div class="badge bg-danger rounded-pill position-absolute top-100 end-50 translate-middle">';
                        $name .= '<i class="fa-solid fa-fire"></i></i><i class="fa-solid fa-percent"></i>';
                        $name .= '</div>';
                    }

                    if ($product->total_quantity_sale > 0) {
                        $name .= '<div title="Sinalizando quantos produtos já foram vendidos" class="badge bg-success rounded-pill position-absolute top-25 start-50 translate-middle">';
                        $name .= '<i class="fa-solid fa-sack-dollar"></i> ' . $product->total_quantity_sale . ' und.';
                        $name .= '</div>';
                    }

                    $name .= '</div>';
                    $name .= '<span style="font-size: 10px;">' . $product->name . '</span>';
                    return $name;
                })
                ->addColumn('related_info', function ($product) {
                    $relatedInfo = '<i class="fa-solid fa-layer-group pe-2"></i>' . $product->category->name . '<br>';
                    $relatedInfo .= '<i class="fa-solid fa-industry pe-2"></i>' . $product->automaker->name . '<br>';
                    $relatedInfo .= '<i class="fa-solid fa-copyright pe-2"></i>' . $product->brand->name;
                    if ($product->ncm) {
                        $relatedInfo .= '<br><strong>NCM</strong> ' . $product->ncm;
                    }

                    return $relatedInfo;
                })
                ->addColumn('codes', function ($product) {
                    $codes = '<span>';
                    $codes .= '<img class="mb-2 me-1" src="' . asset('img/logo.svg') . '" width="20px" height="20px" alt="Logo">';
                    $codes .= $product->inside_code;
                    $codes .= '</span>';

                    if ($product->original_code !== null) {
                        $codes .= '<br><i class="fa-solid fa-industry pe-2"></i>' . $product->original_code;
                    }

                    if ($product->brand_code !== null) {
                        $codes .= '<br><i class="fa-solid fa-copyright pe-2"></i>' . $product->brand_code;
                    }

                    foreach ($product->productLocations as $productLocation) {
                        if ($productLocation->supplier_code) {
                            $codes .= '<br><i class="fa-solid fa-people-carry-box pe-2"></i>' . $productLocation->supplier_code;
                        }
                    }

                    if ($product->cross_code) {
                        $codes .= '<span class="visually-hidden">Códigos relacionados: ' . $product->cross_code . '</span>';
                    }

                    return $codes;
                })
                ->addColumn('stock', function ($product) {
                    $html = '';
                    foreach ($product->productLocations as $productLocation) {
                        $html .= '<span class="badge badge-with-headquarter text-bg-light shadow my-1" style="font-size: 13px;" data-product-id="' . $product->id . '" data-headquarter-id="' . $productLocation->headquarter_id . '" data-headquarter-name="' . $productLocation->headquarter->name . ', ' . $productLocation->headquarter->city . ' - ' . $productLocation->headquarter->state . '" title="' . $productLocation->headquarter->name . ', ' . $productLocation->headquarter->city . ' - ' . $productLocation->headquarter->state . '">';
                        $html .= '<i class="fa-solid fa-location-dot"></i> ' . $productLocation->indoor_location . ', ';

                        if ($productLocation->stock_alert_at !== null && $productLocation->quantity <= $productLocation->stock_alert_at) {
                            $html .= '<span class="text-danger">';
                            $html .= '<i class="fa-solid fa-triangle-exclamation"></i> ' . $productLocation->quantity . '<span style="font-size: 8px;"> ' . $product->measure . '</span>';
                            $html .= '</span><br>';
                        } else {
                            $html .= $productLocation->quantity . ' <span style="font-size: 8px;">' . $product->measure . '</span><br>';
                        }

                        $html .= '</span><br>';
                    }

                    return $html;
                })
                ->addColumn('actions', function ($product) {
                    $user = Auth::user();
                    $actions = '<div class="btn-group btn-group-sm" role="group" aria-label="Ações">';
                    $actions .= '<button type="button" class="btn btn-sm btn-success btnSell" data-product-id="' . $product->id . '" title="Sinalizar manualmente venda deste produto"><i class="fa-solid fa-comment-dollar"></i></button>';

                    if ($user->can('show product')) {
                        $actions .= '<a href="' . route('products.show', ['id' => $product->id]) . '" class="btn btn-sm btn-info" title="Visualizar detalhes"><i class="fa-solid fa-eye"></i></a>';
                    }

                    if ($product->productWithdrawals->contains('withdrawal_status', 'PENDENTE')) {
                        if ($user->hasAnyRole(['Super Admin', 'Admin']) || $product->productWithdrawals->contains('headquarter_id', $user->headquarter_id)) {
                            $actions .= '<a href="' . route('products.withdrawal', ['id' => $product->id]) . '" class="btn btn-sm btn-dark" title="Sinalizar a separação de um produto do estoque"><i class="fa-solid fa-person-walking-luggage"></i></a>';
                        }
                    }

                    if ($user->can('edit product')) {
                        $actions .= '<a href="' . route('products.edit', ['id' => $product->id]) . '" class="btn btn-sm btn-warning" title="Editar"><i class="fa-solid fa-pen"></i></a>';
                    }

                    if ($user->can('destroy product')) {
                        $actions .= '<form id="formDelete' . $product->id . '" action="' . route('products.destroy', ['id' => $product->id]) . '" method="POST">';
                        $actions .= csrf_field();
                        $actions .= method_field('DELETE');
                        $actions .= '<button type="submit" class="btn btn-sm btn-danger btn-delete-in-group btnDeleteProduct" data-delete-id="' . $product->id . '" title="Apagar"><i class="fa-solid fa-eraser"></i></button>';
                        $actions .= '</form>';
                    }
                    $actions .= '</div>';

                    return $actions;
                })
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                })
                ->filterColumn('related_info', function ($query, $keyword) {
                    $query->whereHas('category', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    })->orWhereHas('automaker', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    })->orWhereHas('brand', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('codes', function ($query, $keyword) {
                    $query->where('inside_code', 'like', "%{$keyword}%")
                        ->orWhere('original_code', 'like', "%{$keyword}%")
                        ->orWhere('brand_code', 'like', "%{$keyword}%")
                        ->orWhere('cross_code', 'like', "%{$keyword}%")
                        ->orWhereHas('productLocations', function ($q) use ($keyword) {
                            $q->where('supplier_code', 'like', "%{$keyword}%");
                        });
                })
                ->filterColumn('stock', function ($query, $keyword) {
                    $query->whereHas('productLocations', function ($q) use ($keyword) {
                        $q->where('indoor_location', 'like', "%{$keyword}%");
                    });
                })
                ->rawColumns(['name', 'related_info', 'codes', 'stock', 'actions'])
                ->make(true);
        }

        $productNeedWithdrawals = ProductWithdrawal::where('withdrawal_status', 'PENDENTE')->count();

        return view('admin.products.index', compact('productNeedWithdrawals'));
    }

    public function excelExport()
    {
        return Excel::download(new ProductsExport, 'produtosEstoque_Data' . Carbon::now()->format('d-m-Y') . '.xlsx');
    }

    public function csvExport()
    {
        return Excel::download(new ProductsExport, 'products_' . uniqid() . '.csv');
    }

    public function sell(Request $request)
    {
        $productId = $request->input('productId');
        $chatId = '-1002154815451'; //Lembre-se que você capturou esse valor usando no post a seguinte requisição http: https://api.telegram.org/bot7049066161:AAFhhGPw9R8LmCfYYv8p7n6WnJaaulZJsdU/getUpdates
        $url = url('admin/products/withdrawal/' . $productId);
        $headquarterId = $request->input('unit-sell');
        $user = auth()->user();
        $quantity = intval($request->input('quantity-sell'));

        DB::beginTransaction();

        try {

            $productSale = ProductSale::create([
                'product_id' => $productId,
                'headquarter_id' => $headquarterId,
                'sale_mode' => 'FORA E-COMMERCE',
                'user_id' => $user->id,
                'quantity_sold' => $quantity,
            ]);

            $productLocations = ProductLocation::where('product_id', $productId)->where('headquarter_id', $headquarterId)->get();

            $totalQuantityInStock = 0;

            foreach ($productLocations as $productLocation) {
                $totalQuantityInStock += $productLocation->quantity;
            }

            if ($totalQuantityInStock >= $quantity) {
                $remainingQuantityToSell = $quantity;

                foreach ($productLocations as $productLocation) {
                    $availableQuantity = $productLocation->quantity;

                    if ($availableQuantity > 0) {
                        if ($remainingQuantityToSell >= $availableQuantity) {
                            $remainingQuantityToSell -= $availableQuantity;

                            $productWithdrawal = ProductWithdrawal::create([
                                'product_sale_id' => $productSale->id,
                                'product_id' => $productId,
                                'headquarter_id' => $headquarterId,
                                'indoor_location' => $productLocation->indoor_location,
                                'quantity' => $availableQuantity,
                                'required_by' => $user->name,
                                'withdrawal_status' => 'PENDENTE',
                                'product_sale_id' => $productSale->id,
                            ]);

                            $productLocation->quantity = 0;

                            $response = Telegram::sendMessage([
                                'chat_id' => $chatId,
                                'text' => 'Solicitação de separação para retirada de produto na unidade *' . $productSale->headquarter->name . ' (' . $productSale->headquarter->city . '-' . $productSale->headquarter->state . ')*. Solicitação requerida por *' . $user->name . '*. Responda através do link: ' . $url,
                                'parse_mode' => 'Markdown',
                            ]);

                        } else {
                            $productLocation->quantity -= $remainingQuantityToSell;

                            $productWithdrawal = ProductWithdrawal::create([
                                'product_sale_id' => $productSale->id,
                                'product_id' => $productId,
                                'headquarter_id' => $headquarterId,
                                'indoor_location' => $productLocation->indoor_location,
                                'quantity' => $remainingQuantityToSell,
                                'required_by' => $user->name,
                                'withdrawal_status' => 'PENDENTE',
                                'product_sale_id' => $productSale->id,
                            ]);

                            $remainingQuantityToSell = 0;

                            $response = Telegram::sendMessage([
                                'chat_id' => $chatId,
                                'text' => 'Solicitação de separação para retirada de produto na unidade *' . $productSale->headquarter->name . ' (' . $productSale->headquarter->city . '-' . $productSale->headquarter->state . ')*. Solicitação requerida por *' . $user->name . '*. Responda através do link: ' . $url,
                                'parse_mode' => 'Markdown',
                            ]);
                        }

                        $productLocation->save();

                        if ($remainingQuantityToSell == 0) {
                            break;
                        }
                    }
                }

                if ($remainingQuantityToSell > 0) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Quantidade insuficiente em estoque para realizar esta venda.');
                }
            } else {
                return redirect()->route('products.index')->with('warning', 'Quantidade em estoque é insuficiente. Nesta unidade da loja há a quantidade apenas de ' . $totalQuantityInStock . ' unidades.');
            }

            $product = Product::findOrFail($productId);
            $product->save();

            DB::commit();

            return redirect()->route('products.index')->with('info', 'Requisição para separação sobre este produto em estoque gerada com sucesso! Caso engano, vá para o Histórico de retiradas e reverta a ação.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao sinalizar venda de um produto: ' . $e);
            return redirect()->back()->with('error', 'Erro ao sinalizar venda de produto. Contate o suporte para saber mais sobre.');
        }
    }

    public function reverseSale(Request $request)
    {
        $productSaleId = $request->product_sale_id;
        $productId = $request->product_id;
        $chatId = '-1002154815451'; //Lembre-se que você capturou esse valor usando no post a seguinte requisição http: https://api.telegram.org/bot7049066161:AAFhhGPw9R8LmCfYYv8p7n6WnJaaulZJsdU/getUpdates
        $url = url('admin/products/show/' . $productId);

        DB::beginTransaction();

        try {
            $productSale = ProductSale::findOrFail($productSaleId);

            $productWithdrawals = ProductWithdrawal::where('product_sale_id', $productSaleId)->get();

            foreach ($productWithdrawals as $withdrawal) {
                // Repor o estoque
                $productLocation = ProductLocation::where('product_id', $withdrawal->product_id)
                    ->where('headquarter_id', $withdrawal->headquarter_id)
                    ->where('indoor_location', $withdrawal->indoor_location)
                    ->first();

                if ($productLocation) {
                    $productLocation->quantity += $withdrawal->quantity;
                    $productLocation->save();

                    $response = Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => 'Atenção em *' . $productSale->headquarter->name . ' (' . $productSale->headquarter->city . '-' . $productSale->headquarter->state . ')*! Cancelada a requisição de retirada do produto *' . $productLocation->product->name . ' (' . $productLocation->product->inside_code . ')*. Devolva a quantidade de *' . $withdrawal->quantity . '* unidades na localização *' . $productLocation->indoor_location . '*. Detalhes de tal produto se encontram aqui: ' . $url,
                        'parse_mode' => 'Markdown',
                    ]);

                } else {
                    // Caso não exista, criar um novo registro de localização do produto
                    $productLocation = ProductLocation::create([
                        'product_id' => $withdrawal->product_id,
                        'supplier_id' => 1, //Simboliza o ID do fornecedor que é o NULO
                        'headquarter_id' => $withdrawal->headquarter_id,
                        'indoor_location' => $withdrawal->indoor_location,
                        'quantity' => $withdrawal->quantity,
                        'stock_alert_at' => 1,
                    ]);

                    $response = Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => 'Atenção em *' . $productSale->headquarter->name . ' (' . $productSale->headquarter->city . '-' . $productSale->headquarter->state . ')*! Cancelada a requisição de retirada do produto *' . $productLocation->product->name . ' (' . $productLocation->product->inside_code . ')*. Devolva a quantidade de *' . $withdrawal->quantity . '* unidades na localização *' . $productLocation->indoor_location . '*. Detalhes de tal produto se encontram aqui: ' . $url,
                        'parse_mode' => 'Markdown',
                    ]);
                }

                $withdrawal->delete();
            }

            $productSale->delete();

            DB::commit();

            return redirect()->route('products.index')->with('info', 'Venda revertida e estoque reposto no sistema. Retorne a quantidade do produto em seu(s) devido(s) lugar(es) anteriormente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro ao reverter venda de produto e retirada: ' . $e);
            return redirect()->back()->with('error', 'Erro ao reverter venda de produto e retirada. Contate o suporte para saber mais.');
        }
    }

    public function withdrawalRecords()
    {
        $user = Auth::user();
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            $withdrawals = ProductWithdrawal::latest()->get();
        } else {
            $withdrawals = ProductWithdrawal::where('headquarter_id', $user->headquarter_id)->latest()->get();
        }

        return view('admin.products.withdrawal-records', compact('withdrawals'));
    }

    public function withdrawal(string $id)
    {
        $product = Product::with('category', 'automaker', 'brand', 'productLocations', 'productWithdrawals')->findOrFail($id);
        return view('admin.products.withdrawal', compact('product'));
    }

    public function withdrawalComplete(Request $request)
    {

        $request->validate(
            [
                'selectedProductWithdrawalsIds' => 'required',
            ],
            [
                'selectedProductWithdrawalsIds.required' => 'Você precisa selecionar ao menos 1 requisação de retirada.',
            ]
        );

        try {

            $user = auth()->user();
            $selectedWithdrawals = ProductWithdrawal::whereIn('id', $request->selectedProductWithdrawalsIds)->get();

            foreach ($selectedWithdrawals as $withdrawal) {
                $withdrawal->update([
                    'withdrawal_status' => 'CONCLUÍDA',
                    'completed_by' => $user->name,
                ]);
            }

            DB::commit();
            return redirect()->route('products.index')->with('success', 'A retirada foi sinalizada com sucesso. Obrigado!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao sinalizar a retirada de um lote de produtos: ' . $e);
            return redirect()->back()->with('error', 'Erro ao sinalizar a retirada de um lote de produtos. Contate o suporte para saber mais sobre.');
        }
    }

    public function create()
    {
        $categories = Category::orderBy('shard_code', 'asc')->get();
        $automakers = Automaker::orderBy('shard_code', 'asc')->get();
        $brands = Brand::orderByRaw("CASE WHEN name LIKE '%*%' THEN 0 ELSE 1 END, name ASC")->get();
        $suppliers = Supplier::orderByRaw("CASE WHEN name LIKE '%*%' THEN 0 ELSE 1 END, name ASC")->get();
        $headquarters = Headquarter::get();

        return view('admin.products.create', compact('categories', 'automakers', 'suppliers', 'headquarters', 'brands'));
    }

    public function store(ProductRequest $request)
    {
        $request->validated();

        DB::beginTransaction();

        try {
            //VALIDANDO SE A MARCA FOI INSERIDA NA HORA DO FORMULÁRIO DEVIDO A MESMA NÃO ESTAR PREVIAMENTE CADASTRADA
            if (!is_numeric($request->brand_id)) {
                if (!Brand::where('name', $request->brand_id)->first()) {
                    $brand = Brand::create([
                        'name' => $request->brand_id,
                    ]);

                    $request->merge([
                        'brand_id' => $brand->id,
                    ]);
                } else {
                    return redirect()->back()->with('warning', 'Já existe este nome de marca!');
                }
            }

            //INÍCIO DA CONSTRUÇÃO DAS PALAVRAS-CHAVE E NOME DAS IMAGENS
            $keywords = $request->name;
            $codesImg = '';
            //ADQUIRINDO OS DADOS DAS OUTRAS TABELAS RELACIONADAS E CONSTRUINDO O CÓDIGO INTERNO
            $category = DB::table('categories')->where('id', $request->category_id)->first();
            $shard_code_categories = $category->shard_code;
            $automaker = DB::table('automakers')->where('id', $request->automaker_id)->first();
            $shard_code_automakers = $automaker->shard_code;
            $brand = DB::table('brands')->where('id', $request->brand_id)->first();

            $inside_code = 'CO2-' . $shard_code_categories . $shard_code_automakers;

            for ($i = 0; $i <= 999; $i++) {
                $suffix = str_pad($i, 3, '0', STR_PAD_LEFT); // Preencher com zeros à esquerda
                $proposed_code = $inside_code . $suffix;
                // VERIFICANDO SE JÁ EXISTE CÓDIGO INTERNO GERADO
                $existing_product = Product::where('inside_code', $proposed_code)->first();

                // SAIR DO LOOP NA GERAÇÃO DE CÓDIGO INTERNO E ESCOLHENDO O CÓDIGO INTERNO
                if (!$existing_product) {
                    $inside_code = $proposed_code;
                    break;
                }
            }

            $keywords .= ', ' . $category->name;
            $codesImg .= $category->name . '_';

            if ($request->automaker_id != 8 && $request->automaker_id != 9) {
                $keywords .= ', ' . $automaker->name;
                $codesImg .= $automaker->name . '_';
            }

            if ($request->original_code != null) {
                $keywords .= ', ' . $request->original_code;
                $codesImg .= $request->original_code . '_';
            }

            if ($request->brand_id > 2) {
                $keywords .= ', ' . $brand->name;
                $codesImg .= $brand->name . '_';
            }

            if ($request->brand_code != null) {
                $keywords .= ', ' . $request->brand_code;
                $codesImg .= $request->brand_code;
            }

            //IMAGEM PRINCIPAL
            if ($request->file('img') !== null) {
                // ALTERANDO O NOME DA IMAGEM
                $newName = $request->name;
                $newName .= '_mi_' . $codesImg . '.' . $request->img->extension();
                $newName = mb_strtolower($newName);
                $newName = str_replace(
                    array('á', 'à', 'ã', 'â', 'é', 'è', 'ê', 'í', 'ì', 'î', 'ó', 'ò', 'ô', 'õ', 'ú', 'ù', 'û', 'ç', ' ', '/', '\\', '?', '=', '&', '#', '"', '(', ')', '*', '!'),
                    array('a', 'a', 'a', 'a', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'c', '_', '', '', '', '', '', '', '', '', '', '', ''),
                    $newName
                );
                // REDIMENSIONANDO A IMAGEM
                $manager = new ImageManager(Driver::class);
                $image = $manager->read($request->file('img'));
                $image->resize(500, 500);
                $path = public_path('img/products/' . $newName);
                if (File::exists($path)) {
                    File::delete($path);
                }
                $image->save($path);
                $request->merge(['main_img' => $newName]);
            }
            //IMAGEM EXTRA 1
            if ($request->file('img1') !== null) {
                // ALTERANDO O NOME DA IMAGEM
                $newName = $request->name;
                $newName .= '_ei1_' . $codesImg . '.' . $request->img1->extension();
                $newName = mb_strtolower($newName);
                $newName = str_replace(
                    array('á', 'à', 'ã', 'â', 'é', 'è', 'ê', 'í', 'ì', 'î', 'ó', 'ò', 'ô', 'õ', 'ú', 'ù', 'û', 'ç', ' ', '/', '\\', '?', '=', '&', '#', '"', '(', ')', '*', '!'),
                    array('a', 'a', 'a', 'a', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'c', '_', '', '', '', '', '', '', '', '', '', '', ''),
                    $newName
                );
                // REDIMENSIONANDO A IMAGEM
                $manager = new ImageManager(Driver::class);
                $image = $manager->read($request->file('img1'));
                $image->resize(500, 500);
                $path = public_path('img/products/extra/' . $newName);
                if (File::exists($path)) {
                    File::delete($path);
                }
                $image->save($path);
                $request->merge(['extra_img' => $newName]);
            }
            //IMAGEM EXTRA 2
            if ($request->file('img2') !== null) {
                // ALTERANDO O NOME DA IMAGEM
                $newName = $request->name;
                $newName .= '_ei2_' . $codesImg . '.' . $request->img2->extension();
                $newName = mb_strtolower($newName);
                $newName = str_replace(
                    array('á', 'à', 'ã', 'â', 'é', 'è', 'ê', 'í', 'ì', 'î', 'ó', 'ò', 'ô', 'õ', 'ú', 'ù', 'û', 'ç', ' ', '/', '\\', '?', '=', '&', '#', '"', '(', ')', '*', '!'),
                    array('a', 'a', 'a', 'a', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'c', '_', '', '', '', '', '', '', '', '', '', '', ''),
                    $newName
                );
                // REDIMENSIONANDO A IMAGEM
                $manager = new ImageManager(Driver::class);
                $image = $manager->read($request->file('img2'));
                $image->resize(500, 500);
                $path = public_path('img/products/extra/' . $newName);
                if (File::exists($path)) {
                    File::delete($path);
                }
                $image->save($path);
                $request->merge(['extra_img2' => $newName]);
            }

            $keywords .= ', ' . $inside_code;
            $request->merge(['keywords' => $keywords]);
            $request->merge(['inside_code' => $inside_code]);

            $product = Product::create($request->all());

            foreach ($request->locations as $locationData) {
                $stockAlertAt = $locationData['stock_alert_at'] === null ? 1 : $locationData['stock_alert_at'];
                ProductLocation::create([
                    'product_id' => $product->id,
                    'supplier_id' => $locationData['supplier_id'],
                    'supplier_code' => $locationData['supplier_code'],
                    'headquarter_id' => $locationData['headquarter_id'],
                    'indoor_location' => $locationData['indoor_location'],
                    'quantity' => $locationData['quantity'],
                    'stock_alert_at' => $stockAlertAt,
                ]);
            }
            DB::commit();
            return redirect()->route('products.index')->with('success', 'Produto criado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao criar um produto: ' . $e);
            return redirect()->back()->with('error', 'Erro ao criar produto. Contate o suporte para saber mais sobre.');
        }
    }

    public function show(string $id)
    {
        $product = Product::with('category', 'automaker', 'brand', 'productLocations')->findOrFail($id);

        // Extrair os códigos do produto principal
        $codes = [];
        foreach (['brand_code', 'original_code', 'cross_code'] as $column) {
            $codes = array_merge($codes, explode(' ', $product->{$column}));
        }
        $codes = array_unique(array_filter($codes)); // Remover valores duplicados e vazios

        // Buscar produtos relacionados com base nos códigos
        $relatedProducts = Product::where(function ($query) use ($codes) {
            foreach ($codes as $code) {
                // Para cada código, verifique se ele está presente em qualquer parte das três colunas
                $query->orWhere('brand_code', 'like', "%$code%")
                    ->orWhere('original_code', 'like', "%$code%")
                    ->orWhere('cross_code', 'like', "%$code%");
            }
        })
            ->where('id', '!=', $id)
            ->get();

        return view('admin.products.show', compact('product', 'relatedProducts'));
    }

    public function edit(string $id)
    {
        $categories = Category::orderBy('shard_code', 'asc')->get();
        $automakers = Automaker::orderBy('shard_code', 'asc')->get();
        $brands = Brand::orderByRaw("CASE WHEN name LIKE '%*%' THEN 0 ELSE 1 END, name ASC")->get();
        $suppliers = Supplier::orderByRaw("CASE WHEN name LIKE '%*%' THEN 0 ELSE 1 END, name ASC")->get();
        $headquarters = Headquarter::get();
        $product = Product::with('category', 'automaker', 'brand', 'productLocations')->findOrFail($id);

        return view('admin.products.edit', compact('product', 'categories', 'automakers', 'brands', 'headquarters', 'suppliers'));
    }

    public function update(ProductRequest $request, string $id)
    {

        $request->validated();

        if ($request->original_code_null === 'on') {
            $request->merge([
                'original_code' => null,
            ]);
        }

        if ($request->brand_code_null === 'on') {
            $request->merge([
                'brand_code' => null,
            ]);
        }

        DB::beginTransaction();

        try {

            //VALIDANDO SE A MARCA FOI INSERIDA NA HORA DO FORMULÁRIO DEVIDO A MESMA NÃO ESTAR PREVIAMENTE CADASTRADA
            if (!is_numeric($request->brand_id)) {
                if (!Brand::where('name', $request->brand_id)->first()) {
                    $brand = Brand::create([
                        'name' => $request->brand_id,
                    ]);

                    $request->merge([
                        'brand_id' => $brand->id,
                    ]);
                } else {
                    return redirect()->back()->with('warning', 'Já existe este nome de marca!');
                }
            }

            $product = Product::findOrFail($id);
            //INÍCIO DA CONSTRUÇÃO DAS PALAVRAS-CHAVE E NOME DAS IMAGENS
            $keywords = $request->name;
            $codesImg = '';
            //ADQUIRINDO OS DADOS DAS OUTRAS TABELAS RELACIONADAS E CONSTRUINDO O CÓDIGO INTERNO
            $category = DB::table('categories')->where('id', $request->category_id)->first();
            $automaker = DB::table('automakers')->where('id', $request->automaker_id)->first();
            $brand = DB::table('brands')->where('id', $request->brand_id)->first();

            if ($product->category_id != $request->category_id || $product->automaker_id != $request->automaker_id) {
                $shard_code_categories = $category->shard_code;
                $shard_code_automakers = $automaker->shard_code;

                $inside_code = 'CO2-' . $shard_code_categories . $shard_code_automakers;
                for ($i = 0; $i <= 999; $i++) {
                    $suffix = str_pad($i, 3, '0', STR_PAD_LEFT); // Preencher com zeros à esquerda
                    $proposed_code = $inside_code . $suffix;
                    // VERIFICANDO SE JÁ EXISTE CÓDIGO INTERNO GERADO
                    $existing_product = Product::where('inside_code', $proposed_code)->first();

                    // SAIR DO LOOP NA GERAÇÃO DE CÓDIGO INTERNO E ESCOLHENDO O CÓDIGO INTERNO
                    if (!$existing_product) {
                        $inside_code = $proposed_code;
                        break;
                    }
                }
            } else {
                $inside_code = $product->inside_code;
            }

            $keywords .= ', ' . $category->name;
            $codesImg .= $category->name . '_';

            if ($request->automaker_id != 8 && $request->automaker_id != 9) {
                $keywords .= ', ' . $automaker->name;
                $codesImg .= $automaker->name . '_';
            }

            if ($request->original_code != null) {
                $keywords .= ', ' . $request->original_code;
                $codesImg .= $request->original_code . '_';
            }

            if ($request->brand_id != 1) {
                $keywords .= ', ' . $brand->name;
                $codesImg .= $brand->name . '_';
            }

            if ($request->brand_code != null) {
                $keywords .= ', ' . $request->brand_code;
                $codesImg .= $request->brand_code;
            }

            //IMAGEM PRINCIPAL
            if ($request->hasFile('img')) {
                if ($request->file('img') !== 'default-image.png') {
                    // ALTERANDO O NOME DA IMAGEM
                    $newName = $request->name;
                    $newName .= '_mi_' . $codesImg . '.' . $request->img->extension();
                    $newName = mb_strtolower($newName);
                    $newName = str_replace(
                        array('á', 'à', 'ã', 'â', 'é', 'è', 'ê', 'í', 'ì', 'î', 'ó', 'ò', 'ô', 'õ', 'ú', 'ù', 'û', 'ç', ' ', '/', '\\', '?', '=', '&', '#', '"', '(', ')', '*', '!'),
                        array('a', 'a', 'a', 'a', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'c', '_', '', '', '', '', '', '', '', '', '', '', ''),
                        $newName
                    );
                    // REDIMENSIONANDO A IMAGEM
                    $manager = new ImageManager(Driver::class);
                    $image = $manager->read($request->file('img'));
                    $image->resize(500, 500);
                    $path = public_path('img/products/' . $newName);

                    if (public_path('img/products/' . $product->main_img) && $product->main_img != 'default-image.png') {
                        File::delete(public_path('img/products/' . $product->main_img));
                    }

                    $image->save($path);
                    $request->merge(['main_img' => $newName]);
                }
            } elseif (!$request->hasFile('img') && $request->pressedDelButton == 'Sim') {
                if ($product->main_img !== 'default-image.png') {
                    if (public_path('img/products/' . $product->main_img)) {
                        File::delete(public_path('img/products/' . $product->main_img));
                    }
                    $request->merge(['main_img' => 'default-image.png']);
                }
            } else {
            }
            //IMAGEM EXTRA 1
            if ($request->hasFile('img1')) {
                if ($request->file('img1') !== 'default-image.png') {
                    // ALTERANDO O NOME DA IMAGEM
                    $newName = $request->name;
                    $newName .= '_ei1_' . $codesImg . '.' . $request->img1->extension();
                    $newName = mb_strtolower($newName);
                    $newName = str_replace(
                        array('á', 'à', 'ã', 'â', 'é', 'è', 'ê', 'í', 'ì', 'î', 'ó', 'ò', 'ô', 'õ', 'ú', 'ù', 'û', 'ç', ' ', '/', '\\', '?', '=', '&', '#', '"', '(', ')', '*', '!'),
                        array('a', 'a', 'a', 'a', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'c', '_', '', '', '', '', '', '', '', '', '', '', ''),
                        $newName
                    );
                    // REDIMENSIONANDO A IMAGEM
                    $manager = new ImageManager(Driver::class);
                    $image = $manager->read($request->file('img1'));
                    $image->resize(500, 500);
                    $path = public_path('img/products/extra/' . $newName);

                    if (public_path('img/products/extra/' . $product->extra_img) && $product->extra_img != 'default-image.png') {
                        File::delete(public_path('img/products/extra/' . $product->extra_img));
                    }

                    $image->save($path);
                    $request->merge(['extra_img' => $newName]);
                }
            } elseif (!$request->hasFile('img1') && $request->pressedDelButton1 == 'Sim') {
                if ($product->extra_img !== 'default-image.png') {
                    if (public_path('img/products/extra/' . $product->extra_img)) {
                        File::delete(public_path('img/products/extra/' . $product->extra_img));
                    }
                    $request->merge(['extra_img' => 'default-image.png']);
                }
            } else {
            }
            //IMAGEM EXTRA 2
            if ($request->hasFile('img2')) {
                if ($request->file('img2') !== 'default-image.png') {
                    // ALTERANDO O NOME DA IMAGEM
                    $newName = $request->name;
                    $newName .= '_ei2_' . $codesImg . '.' . $request->img2->extension();
                    $newName = mb_strtolower($newName);
                    $newName = str_replace(
                        array('á', 'à', 'ã', 'â', 'é', 'è', 'ê', 'í', 'ì', 'î', 'ó', 'ò', 'ô', 'õ', 'ú', 'ù', 'û', 'ç', ' ', '/', '\\', '?', '=', '&', '#', '"', '(', ')', '*', '!'),
                        array('a', 'a', 'a', 'a', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'c', '_', '', '', '', '', '', '', '', '', '', '', ''),
                        $newName
                    );
                    // REDIMENSIONANDO A IMAGEM
                    $manager = new ImageManager(Driver::class);
                    $image = $manager->read($request->file('img2'));
                    $image->resize(500, 500);
                    $path = public_path('img/products/extra/' . $newName);

                    if (public_path('img/products/extra/' . $product->extra_img2) && $product->extra_img2 != 'default-image.png') {
                        File::delete(public_path('img/products/extra/' . $product->extra_img2));
                    }

                    $image->save($path);
                    $request->merge(['extra_img2' => $newName]);
                }
            } elseif (!$request->hasFile('img2') && $request->pressedDelButton2 == 'Sim') {
                if ($product->extra_img2 !== 'default-image.png') {
                    if (public_path('img/products/extra/' . $product->extra_img2)) {
                        File::delete(public_path('img/products/extra/' . $product->extra_img2));
                    }
                    $request->merge(['extra_img2' => 'default-image.png']);
                }
            } else {
            }

            $keywords .= ', ' . $inside_code;
            $request->merge(['keywords' => $keywords]);
            $request->merge(['inside_code' => $inside_code]);

            $product->update($request->all());
            //REFEDININDO AS LOCALIZAÇÕES NO EDIT
            ProductLocation::where('product_id', $product->id)->delete();

            foreach ($request->locations as $locationData) {
                $stockAlertAt = $locationData['stock_alert_at'] === null ? 1 : $locationData['stock_alert_at'];

                ProductLocation::create([
                    'product_id' => $product->id,
                    'supplier_id' => $locationData['supplier_id'],
                    'supplier_code' => $locationData['supplier_code'],
                    'headquarter_id' => $locationData['headquarter_id'],
                    'indoor_location' => $locationData['indoor_location'],
                    'quantity' => $locationData['quantity'],
                    'stock_alert_at' => $stockAlertAt,

                ]);
            }
            DB::commit();
            return redirect()->route('products.index')->with('success', 'Produto editado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao editar um produto: ' . $e);
            return redirect()->back()->with('error', 'Erro ao editar produto. Contate o suporte para saber mais sobre.');
        }
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $product = Product::findOrFail($id);

            if ($product->main_img != 'default-image.png' && $product->main_img != null) {
                File::delete(public_path('img/products/' . $product->main_img));
            }

            if ($product->extra_img != 'default-image.png' && $product->extra_img != null) {
                File::delete(public_path('img/products/extra/' . $product->extra_img));
            }

            if ($product->extra_img2 != 'default-image.png' && $product->extra_img2 != null) {
                File::delete(public_path('img/products/extra/' . $product->extra_img2));
            }

            $product->delete();
            DB::commit();
            return redirect()->route('products.index')->with('success', 'Produto apagado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao apagar um produto: ' . $e);
            return redirect()->back()->with('error', 'Erro ao apagar produto. Contate o suporte para saber mais sobre.');
        }
    }
}
