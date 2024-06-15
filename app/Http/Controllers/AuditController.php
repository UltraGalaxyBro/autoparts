<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Support\Facades\File;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $audits = Audit::orderBy('created_at', 'desc')->get();
        return view('admin.audit.index', compact('audits'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $audit = Audit::findOrFail($id);
        return view('admin.audit.show', compact('audit'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $audit = Audit::findOrFail($id);
        $audit->delete();
        return redirect()->route('audit.index')->with('success', 'Ocorrido da auditoria apagado com sucesso!');
    }

    public function logs()
    {
        $logFile = storage_path('logs/laravel.log');
        $logs = File::exists($logFile) ? File::get($logFile) : 'Sem relatórios sobre o funcionamento do sistema.';

        return view('admin.audit.logs', compact('logs'));
    }

    public function clear()
    {
        $logFile = storage_path('logs/laravel.log');
        if (File::exists($logFile)) {
            File::put($logFile, '');
        }
        return redirect()->route('audit.logs')->with('success', 'Relatórios sobre o funcionamento do sistema foram limpados.');
    }
}
