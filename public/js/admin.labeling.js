function aplicarMascaras() {
    $('.nfe').mask('NFe 0000000');
    $('.volumes').mask('00');
}

$(document).ready(function () {
    aplicarMascaras();

    $(document).on('click', '.btn-primary', function () {
        aplicarMascaras();
    });
});
