<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelingRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LabelingController extends Controller
{
    //VALIDANDO SE O USUÁRIO POSSUI AS PERMISSÕES NECESSÁRIAS PARA ACESSAR ESTA CONTROLLER
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create labeling', ['only' => ['create']]);
    }

    public function create()
    {
        return view('admin.labeling.create');
    }

    public function store(LabelingRequest $request)
    {
        $request->validated();
        $pdf = Pdf::loadView('admin.labeling.pdf', ['request' => $request])->setPaper('a4', 'portrait');
        return $pdf->download('lote_etiquetas_id_' . uniqid() . '.pdf'); 
    }
}
