@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Logs (Relatórios do sistema)</h4>
        <p>
            Puxando informações diretamente da pasta storage/logs/laravel.log.
        </p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        <a href="{{ route('audit.index') }}" class="btn btn-sm btn-secondary">Voltar à auditoria</a>
    </div>
    <div class="mb-5">
        <div class="card mb-4">
            <div class="card-body">
                <pre class="mb-0">{{ $logs }}</pre>
            </div>
        </div>

        <form id="cleanLogs" action="{{ route('audit.logs.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" id="btn-del-log" class="btn btn-danger">Limpar Log <i class="fa-solid fa-eraser"></i></button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('btn-del-log').addEventListener('click', function(event) {
            event.preventDefault();

            Swal.fire({
                title: "Você tem certeza?",
                text: "É uma ação irreversível apagar algo!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#bc0f0f",
                cancelButtonColor: "#808080",
                confirmButtonText: "Sim, apagar!",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Acionando o formulário
                    document.getElementById('cleanLogs').submit();
                }
            });
        });
    </script>
@endpush
