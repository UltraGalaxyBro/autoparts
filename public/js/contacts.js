$(document).ready(function () {
    var $subject = $('#subject');
    
    // Definir o valor inicial
    var initialValue = $subject.val();
    if (initialValue === 'Devolução') {
        $(".related-devolution").show();
        $('#message-label').text('Produto(s) e o que houve sobre *');
    } else {
        $(".related-devolution").hide();
        $('#message-label').text('Mensagem *');
    }

    $subject.change(function () {
        var value = $(this).val();
        if (value === 'Devolução') {
            $(".related-devolution").show();
            $('#message-label').text('Produto(s) e o que houve sobre *');
        } else {
            $(".related-devolution").hide();
            $('#message-label').text('Mensagem *');
        }
    });
});

