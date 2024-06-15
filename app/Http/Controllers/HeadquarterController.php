<?php

namespace App\Http\Controllers;

use App\Http\Requests\HeadquarterRequest;
use App\Models\Headquarter;
use App\Models\ProductLocation;
use Exception;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class HeadquarterController extends Controller
{
    //VALIDANDO SE O USUÁRIO POSSUI AS PERMISSÕES NECESSÁRIAS PARA ACESSAR ESTA CONTROLLER
    public function __construct()
    {
        $this->middleware('auth'); //Verificando se o usuário está loggado
        //Verificando as permissões deste usuário
        $this->middleware('permission:list headquarters', ['only' => ['index']]);
        $this->middleware('permission:create headquarter', ['only' => ['create']]);
        $this->middleware('permission:show headquarter', ['only' => ['show']]);
        $this->middleware('permission:edit headquarter', ['only' => ['edit']]);
        $this->middleware('permission:destroy headquarter', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $headquarters = Headquarter::orderByDesc('created_at')->get();
        $totalData = Headquarter::count();
        return view('admin.headquarters.index', ['headquarters' => $headquarters, 'totalData' => $totalData]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.headquarters.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(HeadquarterRequest $request)
    {
        DB::beginTransaction();

        try {
            $request->validated();
            if ($request->file('img') !== null) {
                // ALTERANDO O NOME DA IMAGEM
                $newName = strtolower(str_replace(' ', '_', $request->name)) . '.' . $request->img->extension();
                // REDIMENSIONANDO A IMAGEM
                $manager = new ImageManager(Driver::class);
                $image = $manager->read($request->file('img'));
                $image->resize(800, 600);
                $path = public_path('img/headquarters/' . $newName);
                if (File::exists($path)) {
                    File::delete($path);
                }
                $image->save($path);
                $request->merge(['main_img' => $newName]);
            }
            Headquarter::create($request->all());
            DB::commit();
            return redirect()->route('headquarters.index')->with('success', 'Unidade da CO2 Peças criada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao criar uma unidade da CO2 Peças: ' . $e);
            return redirect()->back()->with('error', 'Erro ao criar unidade da CO2 Peças. Contate o suporte para saber mais sobre.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $headquarter = Headquarter::findOrFail($id);
        $totalProducts = ProductLocation::where('headquarter_id', $id)->distinct('product_id')->count('product_id');

        return view('admin.headquarters.show', compact('headquarter', 'totalProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $headquarter = Headquarter::findOrFail($id);
        return view('admin.headquarters.edit', compact('headquarter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HeadquarterRequest $request, string $id)
    {
        DB::beginTransaction();

        try {
            $request->validated();
            if ($request->file('img') !== null) {
                // ALTERANDO O NOME DA IMAGEM
                $newName = strtolower(str_replace(' ', '_', $request->name)) . '.' . $request->img->extension();
                // REDIMENSIONANDO A IMAGEM
                $manager = new ImageManager(Driver::class);
                $image = $manager->read($request->file('img'));
                $image->resize(800, 600);
                $path = public_path('img/headquarters/' . $newName);
                if (File::exists($path)) {
                    File::delete($path);
                }
                $image->save($path);
                $request->merge(['main_img' => $newName]);
            }

            $headquarter = Headquarter::findOrFail($id);
            $headquarter->update($request->all());
            DB::commit();
            return redirect()->route('headquarters.index')->with('success', 'Unidade da CO2 Peças editada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao editar uma unidade da CO2 Peças: ' . $e);
            return redirect()->back()->with('error', 'Erro ao editar unidade da CO2 Peças. Contate o suporte para saber mais sobre.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $headquarter = Headquarter::findOrFail($id);
            $headquarter->delete();
            $path = public_path('img/headquarters/' . $headquarter->main_img);
            if (File::exists($path)) {
                File::delete($path);
            }
            DB::commit();
            return redirect()->route('headquarters.index')->with('success', 'Unidade apagada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao apagar uma unidade da CO2 Peças: ' . $e);
            return redirect()->back()->with('error', 'Erro ao apagar unidade da CO2 Peças. Contate o suporte para saber mais sobre.');
        }
    }
}
