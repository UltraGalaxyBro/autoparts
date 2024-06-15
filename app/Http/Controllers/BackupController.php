<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Backup\BackupDestination\Backup;

class BackupController extends Controller
{
    //VALIDANDO SE O USUÁRIO POSSUI AS PERMISSÕES NECESSÁRIAS PARA ACESSAR ESTA CONTROLLER
    public function __construct()
    {
        $this->middleware('auth'); //Verificando se o usuário está loggado
        //Verificando as permissões deste usuário
        $this->middleware('permission:list backups', ['only' => ['index']]);
        $this->middleware('permission:download backup', ['only' => ['download']]);
        $this->middleware('permission:destroy backup', ['only' => ['destroy']]);
    }

    public function index()
    {
        $files = Storage::files('backups/CO2');
        sort($files);
        return view('admin.backups.index', compact('files'));
    }

    public function download($file)
    {
        if (Storage::exists('backups/CO2/' . $file)) {
            return Storage::download('backups/CO2/' . $file);
        } else {
            return redirect()->back()->with('error', 'O arquivo de backup não foi encontrado. Verifique com o suporte.');
        }
    }

    public function destroy($file)
    {
        if (Storage::exists('backups/CO2/' . $file)) {
            try {
                Storage::delete('backups/CO2/' . $file);
                return redirect()->back()->with('success', 'O arquivo de backup foi excluído com sucesso.');
            } catch (\Exception $e) {
                Log::error('Erro apresentado ao tentar excluir um backup no caminho storage/backups/CO2/' . $file . '. Segue o erro apresentado: ' . $e);
                return redirect()->back()->with('error', 'Ocorreu um erro ao excluir o arquivo de backup.');
            }
        } else {
            return redirect()->back()->with('error', 'O arquivo de backup não foi encontrado.');
        }
    }
}
