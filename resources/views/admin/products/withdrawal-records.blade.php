@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Histórico de retiradas</h4>
        <p>
            Por aqui é possível ver todas as retiradas registradas sobre os produtos em estoque. É cabível para comodidade
            de alerta entrar no grupo para o Telegram, podendo assim receber o aviso quando houver retiradas solicitadas.
        </p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        <a class="btn btn-sm btn-light m-3" title="Ir ao grupo para receber as notificações"
            href="https://t.me/+MJch9CpTTHc4MjUx" target="_blank" rel="noopener noreferrer">Receber solicitações via Telegram
            <i class="fa-brands fa-telegram text-info"></i></a>
        @can('list products')
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary">Listar produtos</a>
        @endcan
    </div>
    <div class="mb-5">
        <table class="table table-striped table-co2 dt-buttons" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Momento da requisição</th>
                    <th class="text-center">Produto</th>
                    <th class="text-center"><small>Localização</small></th>
                    <th class="text-center"><small>Requisitado por</small></th>
                    <th class="text-center"><small>Status da retirada</small></th>
                    <th class="text-center"><small>Separado por</small></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($withdrawals as $item)
                    @if ($item->withdrawal_status == 'PENDENTE')
                        <tr class="align-middle text-center">
                            <td>
                                {{ $item->created_at->format('d-m-Y H:i') }}
                            </td>
                            <td>
                                {{ $item->product->name }}<br>
                                {{ $item->product->inside_code }}
                            </td>
                            <td>
                                {{ $item->headquarter->name }},
                                {{ $item->headquarter->city }}-{{ $item->headquarter->state }}<br>
                                {{ $item->indoor_location }}<br>
                                {{ $item->quantity }} unid.
                            </td>
                            <td>
                                {{ $item->required_by }}
                            </td>
                            <td>
                                <span class="text-danger">{{ $item->withdrawal_status }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                    <form action="{{ route('products.reverse-sell') }}" method="POST">
                                        @csrf
                                        @method('post')

                                        <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                        <input type="hidden" name="product_sale_id" value="{{ $item->product_sale_id }}">

                                        <button type="submit" class="btn btn-sm btn-danger">Reverter
                                            <i class="fa-solid fa-arrow-rotate-left"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('products.withdrawal', ['id' => $item->product_id]) }}"
                                        class="btn btn-sm btn-dark">Realizar a separação
                                        <i class="fa-solid fa-person-walking-luggage"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @else
                        <tr class="align-middle text-center">
                            <td>
                                {{ $item->created_at->format('d-m-Y H:i') }}
                            </td>
                            <td>
                                {{ $item->product->name }}<br>
                                {{ $item->product->inside_code }}
                            </td>
                            <td>
                                {{ $item->headquarter->name }},
                                {{ $item->headquarter->city }}-{{ $item->headquarter->state }}<br>
                                {{ $item->indoor_location }}<br>
                                {{ $item->quantity }} unid.
                            </td>
                            <td>
                                {{ $item->required_by }}
                            </td>
                            <td>
                                <span class="text-success">{{ $item->withdrawal_status }}</span>
                            </td>
                            <td>
                                {{ $item->completed_by }}
                                <form action="{{ route('products.reverse-sell') }}" method="POST">
                                    @csrf
                                    @method('post')

                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                    <input type="hidden" name="product_sale_id" value="{{ $item->product_sale_id }}">

                                    <button type="submit" class="btn btn-sm btn-danger">Reverter
                                        <i class="fa-solid fa-arrow-rotate-left"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
