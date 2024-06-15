<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //VALIDANDO SE O USUÁRIO POSSUI AS PERMISSÕES NECESSÁRIAS PARA ACESSAR ESTA CONTROLLER
    public function __construct()
    {
        $this->middleware('auth'); //Verificando se o usuário está loggado
        //Verificando as permissões deste usuário
        $this->middleware('permission:list cart', ['only' => ['index']]);
        $this->middleware('permission:store cart', ['only' => ['store']]);
        $this->middleware('permission:destroy cart', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        //dd($cart);
        return view('cart', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'numeric']
        ], [
            'product_id.required' => 'Necessário haver o identificador do produto que será adicionado ao carrinho.',
            'quantity.required' => 'Necessário haver a quantidade de tal produto que será adicionado ao carrinho.'
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $product = Product::findOrFail($productId);
            $codes = $product->inside_code;

            if ($product->original_code != null) {
                $codes .= ' ' . $product->original_code;
            }

            if ($product->brand_code != null) {
                $codes .= ' ' . $product->brand_code;
            }

            $price = $product->sale == 'Sim' && now()->lt($product->sale_period_until) ? $product->sale_price : $product->price;

            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => $product->brand->name,
                'codes' => $codes,
                'price' => $price,
                'quantity' => $quantity,
                'image' => $product->main_img
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart');
    }

    public function update(Request $request)
    {
        $productId = $request->productId;
        $newQuantity = $request->newQuantity;

        if (session()->has('cart') && array_key_exists($productId, session('cart'))) {
            session()->put("cart.$productId.quantity", $newQuantity);
            return response()->json(['message' => 'Quantidade atualizada com sucesso']);
        } else {
            return response()->json(['message' => 'Produto não encontrado no carrinho'], 404);
        }
    }


    public function destroy(string $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('cart')->with('success', 'Produto removido do seu carrinho!');
        } else {
            return redirect()->route('cart')->with('error', 'O produto não foi encontrado no seu carrinho.');
        }
    }
}
