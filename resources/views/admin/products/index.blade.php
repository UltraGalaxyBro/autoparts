@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Produtos</h4>
        <p>
            A parte mais essencial do sistema na CO2 Peças. Os produtos são dependentes, para cadastro, da existência das
            unidades da CO2, categorias, montadoras e marcas. É possível, naturalmente, que um produto esteja em locais
            diferentes, ou seja, possuir mais de uma localização.
        </p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        <a href="{{ route('products.withdrawal-records') }}" class="btn btn-sm btn-dark">Histórico de retiradas
            <i class="fa-solid fa-person-walking-luggage"></i>
        </a>
        @can('create product')
            <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">Criar produto</a>
        @endcan
    </div>
    <div class="text-center mb-2">
        @hasanyrole('Super Admin|Admin')
            <div class="text-start mb-2">
                <a class="btn btn-success btn-sm" title="Exportar toda a tabela para Excel"
                    href="{{ route('products.excel-export') }}">
                    <i class="fa-solid fa-file-excel"></i>
                </a>
                <a class="btn btn-success btn-sm" title="Exportar toda a tabela para CSV"
                    href="{{ route('products.csv-export') }}">
                    <i class="fa-solid fa-file-csv"></i>
                </a>
            </div>
        @endhasanyrole
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="chkLowStock" value="low_stock">
            <label class="form-check-label" for="chkLowStock">Estoque Baixo <i
                    class="fa-solid fa-triangle-exclamation"></i></label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="chkBestSelling" value="best_selling">
            <label class="form-check-label" for="chkBestSelling">Mais Vendidos <i
                    class="fa-solid fa-sack-dollar"></i></label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="chkOnSale" value="on_sale">
            <label class="form-check-label" for="chkOnSale">Em Promoção <i class="fa-solid fa-fire"></i><i
                    class="fa-solid fa-percent"></i></label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="chkForSeparation" value="for_separation">
            <label class="form-check-label" for="chkForSeparation">Para Separação <i
                    class="fa-solid fa-person-walking-luggage"></i>
                @if ($productNeedWithdrawals > 0)
                    <span class="badge rounded-pill bg-danger">
                        {{ $productNeedWithdrawals }}
                        <span class="visually-hidden">Produtos que precisam ser retirados do estoque para separação</span>
                    </span>
                @endif
            </label>
        </div>
    </div>
    <div class="mb-5">
        <table class="table table-striped table-co2 dt-buttons" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Nome</th>
                    <th class="text-center"><small>Relacionado</small></th>
                    <th class="text-center"><small>Códigos</small></th>
                    <th class="text-center"><small>Localização e QTD.</small></th>
                    <th class="text-center"><i class="fa-solid fa-file-pen"></i></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            function setupSellButtons() {
                $('.table-co2').on('click', '.btnSell', function(event) {
                    event.preventDefault();
                    var productId = $(this).data('product-id');

                    var unitOptionsMap = {};
                    $('.table-co2 .badge-with-headquarter[data-product-id="' + productId + '"]').each(
                        function() {
                            var headquarterId = $(this).data('headquarter-id');
                            var headquarterName = $(this).data('headquarter-name');
                            unitOptionsMap[headquarterId] = headquarterName;
                        });

                    var unitOptions = [];
                    for (var headquarterId in unitOptionsMap) {
                        unitOptions.push({
                            label: unitOptionsMap[headquarterId],
                            value: headquarterId
                        });
                    }

                    Swal.fire({
                        title: 'Registrando venda manual',
                        html: '<form id="sellForm" action="{{ route('products.sell') }}" method="POST">' +
                            '@csrf' +
                            '@method('post')' +
                            '<div class="form-floating mb-3">' +
                            '<input type="hidden" name="productId" value="' + productId + '">' +
                            '<select id="unit-sell" name="unit-sell" class="form-select">' +
                            unitOptions.map(option => '<option value="' + option.value + '">' +
                                option.label + '</option>').join('') +
                            '</select>' +
                            '  <label for="unit">Loja em que o produto está</label>' +
                            '</div>' +
                            '<div class="form-floating">' +
                            '<input type="number" value="1" min="1" id="quantity-sell" name="quantity-sell" placeholder="Quantidade vendida" class="form-control text-center " required>' +
                            '  <label for="quantity-sell">Quantidade vendida</label>' +
                            '</div>' +
                            '</form>',
                        showCancelButton: true,
                        confirmButtonText: 'Registrar venda!',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: "#008000",
                        cancelButtonColor: "#808080",
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            const unit = Swal.getPopup().querySelector('#unit-sell').value;
                            const quantity = Swal.getPopup().querySelector('#quantity-sell')
                                .value;
                            if (!quantity) {
                                Swal.showValidationMessage(
                                    'Por favor, informe a quantidade vendida');
                            }
                            return {
                                unit: unit,
                                quantity: quantity
                            };
                        },
                        allowOutsideClick: () => !Swal.isLoading(),
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const sellForm = document.getElementById('sellForm');
                            sellForm.submit();
                        }
                    });
                });
            }

            function setupDeleteButtons() {
                $('.table-co2').on('click', '.btn-delete-in-group', function(event) {
                    event.preventDefault();
                    var deleteId = $(this).data('delete-id');
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
                            $('#formDelete' + deleteId).submit();
                        } else {
                            console.log("Exclusão cancelada.");
                        }
                    });
                });
            }

            var table = $('.table-co2').DataTable({
                responsive: true,
                language: {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar:",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    },
                    "select": {
                        "rows": {
                            "0": "Nenhuma linha selecionada",
                            "1": "Selecionado 1 linha",
                            "_": "Selecionado %d linhas"
                        }
                    },
                    "buttons": {
                        "copyTitle": "Copiar para a área de transferência",
                        "copySuccess": {
                            "1": "Copiado 1 linha para a área de transferência",
                            "_": "Copiadas %d linhas para a área de transferência"
                        }
                    },
                },
                ordering: false,
                processing: true,
                serverSide: true,
                deferRender: true,
                ajax: "{{ route('products.index') }}",
                columns: [{
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'related_info',
                        name: 'related_info',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'codes',
                        name: 'codes',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'stock',
                        name: 'stock',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                    },
                ],
                rowCallback: function(row, data, index) {
                    $(row).addClass('align-middle text-center');
                }
            });

            $('.form-check-input').on('change', function() {
                var filters = [];
                $('.form-check-input:checked').each(function() {
                    filters.push($(this).val());
                });
                var filterParams = filters.join('&');
                table.ajax.url("{{ route('products.index') }}?" + filterParams).load();
            });

            table.on('draw.dt', function() {
                setupSellButtons();
                setupDeleteButtons();
            });

        });
    </script>
@endpush
