//PREVIEW E REMOÇÃO DE IMAGENS ----------------------- INÍCIO
$(document).ready(function () {
    // Default image path
    var defaultImagePath = "/img/products/default-image.png";

    // Preview image
    $('#img').change(function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#targetImg').attr('src', e.target.result);
                $('#extra-images').show();
                $('#extra-img-1').show();
            }
            reader.readAsDataURL(file);
        }
    });

    // Delete image
    $('.imgDel').click(function () {
        const imgId = $(this).attr('id').replace('imgDel', '');
        $('#img' + imgId).val('');
        $('#targetImg' + imgId).attr('src', defaultImagePath);
        if (imgId === '') {
            $('#extra-img-1').hide();
            $('#extra-img-2').hide();
            $('#imgDel1').click();
            $('#imgDel2').click();
            $('#pressedDelButton').val('Sim');
            $('#pressedDelButton1').val('Sim');
            $('#pressedDelButton2').val('Sim');

        } else if (imgId === '1') {
            $('#img2').val('');
            $('#targetImg2').attr('src', defaultImagePath);
            $('#extra-img-2').hide();
            $('#imgDel2').click();
            $('#pressedDelButton1').val('Sim');
            $('#pressedDelButton2').val('Sim');
        } else {
            $('#pressedDelButton2').val('Sim');
        }
    });

    $('#img1').off('change').on('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#targetImg1').attr('src', e.target.result);
                $('#extra-img-2').show();
            }
            reader.readAsDataURL(file);
        }
    });

    $('#img2').off('change').on('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#targetImg2').attr('src', e.target.result);
                $('#extra-img-3').show();
            }
            reader.readAsDataURL(file);
        }
    });

});
//PREVIEW E REMOÇÃO DE IMAGENS ----------------------- FIM

$(document).ready(function () {
    //CONTROLES DE APARECIMENTO DE DIVS ------------------- INÍCIO
    var $selectVisible = $("#visible");
    $selectVisible.change(function () {
        var value = $(this).val();
        if (value === "Sim") {
            $(".conditional-div").show();
        } else {
            $(".conditional-div").hide();
        }
    });

    var $selectSale = $("#sale");
    $selectSale.change(function () {
        var value1 = $(this).val();
        if (value1 === "Sim") {
            $(".conditional-div-2").show();
        } else {
            $(".conditional-div-2").hide();
        }
    });

    $selectVisible.change();
    $selectSale.change();

    $('#automaker_id').on('change', function () {
        if ($(this).val() == 9) {
            $('#original_code_null_div').show();
        } else {
            $('#original_code_null_div').hide();
        }
    });

    if ($('#automaker_id').val() == 9) {
        $('#original_code_null_div').show();
    }

    function updateBrandCodeVisibility() {
        if ($('#brand_id').val() == 1 || $('#brand_id').val() == 2) {
            $('#brand_code_null_div').show();
        } else {
            $('#brand_code_null_div').hide();
        }
    }

    $('#brand_id').on('change', updateBrandCodeVisibility);

    updateBrandCodeVisibility();

    //CONTROLES DE APARECIMENTO DE DIVS ------------------- FIM

    // MANIPULANDO O COMPORTAMENTO DOS CAMPOS COM CONDIÇÕES ------------------ INÍCIO
    function toggleInput(checkboxId, inputId) {
        if ($(checkboxId).is(':checked')) {
            $(inputId).val(null).prop('disabled', true);
        } else {
            $(inputId).prop('disabled', false);
        }
    }

    toggleInput('#original_code_null', '#original_code');
    toggleInput('#brand_code_null', '#brand_code');

    $('#original_code_null').change(function () {
        toggleInput('#original_code_null', '#original_code');
    });

    $('#brand_code_null').change(function () {
        toggleInput('#brand_code_null', '#brand_code');
    });
    // MANIPULANDO O COMPORTAMENTO DOS CAMPOS COM CONDIÇÕES ------------------ FIM

    //APLICANDO AS CALCULADORAS DE MARGEM SOBRE CUSTO E DESCONTO ------------ INÍCIO
    $("#msc").on("input", function () {
        var cost = parseFloat($("#cost").val());
        var mscPercentage = parseFloat($(this).val());
        var price = cost + (cost * (mscPercentage / 100));
        $("#price").val(price.toFixed(2));
    });

    $("#discount").on("input", function () {
        var price = parseFloat($("#price").val());
        var discountPercentage = parseFloat($(this).val());
        var salePrice = price - (price * (discountPercentage / 100));
        $("#sale_price").val(salePrice.toFixed(2));
    });
    //APLICANDO AS CALCULADORAS DE MARGEM SOBRE CUSTO E DESCONTO ------------ FIM
    $('#ncm').mask('00000000');
});