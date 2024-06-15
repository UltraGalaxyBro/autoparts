$(document).ready(function () {
    $('.table-co2').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                text: '<i class="fa-regular fa-copy fa-xl"></i>',
                titleAttr: 'Copiar'
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fa-solid fa-file-excel fa-xl text-success"></i>',
                titleAttr: 'Excel'
            },
            {
                extend: 'csvHtml5',
                text: '<i class="fa-solid fa-file-csv fa-xl text-success"></i>',
                titleAttr: 'CSV'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa-solid fa-file-pdf fa-xl text-danger"></i>',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fa-solid fa-print fa-xl text-warning"></i>',
                titleAttr: 'Print'
            }

        ],
        language: {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros", 
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
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
        responsive: true,
        ordering: false
    });
});