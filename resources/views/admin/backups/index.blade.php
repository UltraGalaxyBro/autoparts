@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Backups</h4>
        <p>Medida de segurança para resguardo caso haja comprometimento dos dados deste sistema. Todo dia às 11:30 da manhã
            é efetuado um backup
            automatizado de todo o banco de dados (DB). De tempos em tempos backups mais antigos são apagados para evitar
            sobrecarga.</p>
    </div>
    <div class="mb-1">
        <h5 class="text-center">
            Todos os backups realizados recentemente
        </h5>
    </div>
    <div class="mb-5">
        <table class="table table-striped table-co2 dt-buttons" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center">DATA</th>
                    <th class="text-center">Tipo de arquivo</th>
                    <th class="text-center"><i class="fa-solid fa-file-pen"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($files as $file)
                    @php
                        //FORMATANDO A DATA DO ARQUIVO PARA EXIBIÇÃO
                        $fileName = basename($file);
                        preg_match('/(\d{4}-\d{2}-\d{2}-\d{2}-\d{2}-\d{2})/', $fileName, $matches);
                        $dateTimeString = $matches[0] ?? null;
                        $dateTime = $dateTimeString
                            ? \Carbon\Carbon::createFromFormat('Y-m-d-H-i-s', $dateTimeString)
                            : null;

                        //ISOLANDO O TIPO DE ARQUIVO (A EXTENSÃO) PARA SINALIZAR O QUE O USUÁRIO PODERÁ BAIXAR OU APAGAR
                        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

                    @endphp
                    <tr class="align-middle text-center">
                        <td>
                            <i class="fa-solid fa-database"></i>
                        </td>
                        <td>
                            {{ $dateTime ? $dateTime->format('d/m/Y H:i:s') : '' }}
                        </td>
                        <td>
                            {{ $extension }}
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                @can('download backup')
                                    <a href="{{ route('backups.download', ['file' => $fileName]) }}"
                                        class="btn btn-sm btn-light" title="Baixar backup">
                                        <i class="fa-solid fa-cloud-arrow-down"></i>
                                    </a>
                                @endcan
                                @can('destroy backup')
                                    <form id="formDelete{{ $fileName }}"
                                        action="{{ route('backups.destroy', ['file' => $fileName]) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger btn-delete-in-group btnDelete"
                                            data-delete-id="{{ $fileName }}" title="Apagar backup">
                                            <i class="fa-solid fa-eraser"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
