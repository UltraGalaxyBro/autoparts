$(document).ready(function () {

    function controlarExibicaoDivs() {
        var value = $selectUpdatePassword.val();
        if (value === "Sim") {
            $(".conditional-div").show();
        } else {
            $(".conditional-div").hide();
        }
    }

    var $selectUpdatePassword = $("#updatePassword");
    controlarExibicaoDivs();
    $selectUpdatePassword.change(function () {
        controlarExibicaoDivs();
    });
});
