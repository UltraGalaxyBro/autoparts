$(document).ready(function () {
    // CONTROLES DE APARECIMENTO DE DIVS ------------------- INÍCIO
    var $selectPaymentType = $("#payment_method");
    $selectPaymentType.change(function () {
        var value = $(this).val();
        if (value === "BOLETO") {
            $("#details-credit-div").hide();
            $("#details-bol-div").show();
        } else if (value === "CARTÃO DE CRÉDITO") {
            $("#details-credit-div").show();
            $("#details-bol-div").hide();
        } else {
            $("#details-credit-div").hide();
            $("#details-bol-div").hide();
        }
    });

    var $selectFreightType = $("#freight_type");
    $selectFreightType.change(function () {
        var value = $(this).val();
        if (value === "CIF") {
            $("#freight-price-div").show();
        } else {
            $("#freight-price-div").hide();
        }
    });

    $selectPaymentType.change();
    $selectFreightType.change();
    // CONTROLES DE APARECIMENTO DE DIVS ------------------- FIM

    // MANIPULANDO O COMPORTAMENTO DOS CAMPOS COM CONDIÇÕES ------------------ INÍCIO
    if ($('#freight_price_null').is(':checked')) {
        $('#freight_price').val('').prop('disabled', true);
    }

    $('#freight_price_null').change(function () {
        if ($(this).is(':checked')) {
            $('#freight_price').val('').prop('disabled', true);
        } else {
            $('#freight_price').prop('disabled', false);
        }
    });

    //CÁLCULOS DA COTAÇÃO ----------------- INÍCIO
    $(document).on('click', '.btn-delete-row-product', function () {
        calculateTotalCost();
        calculateTotalPrice();
    });

    function calculateTotalCost() {
        var total = 0;

        $('[x-model="product.cost"]').each(function (index, element) {
            var cost = parseFloat($(element).val());
            var quantity = parseFloat($(element).closest('.row').find('[x-model="product.quantity"]').val());
            if (!isNaN(cost) && !isNaN(quantity)) {
                total += cost * quantity;
            }
        });

        var formattedTotal = total.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        $('#total-cost-indicator').text(formattedTotal);

        var indicatorBg = $('#total-cost-indicator-bg');
        if (total > 0) {
            indicatorBg.removeClass('bg-secondary bg-danger').addClass('bg-primary');
        } else if (total == 0) {
            indicatorBg.removeClass('bg-primary bg-danger').addClass('bg-secondary');
        } else {
            indicatorBg.removeClass('bg-primary bg-secondary').addClass('bg-danger');
        }
    }

    function calculateTotalPrice() {
        var total = 0;

        $('[x-model="product.price"]').each(function (index, element) {
            var price = parseFloat($(element).val());
            var quantity = parseFloat($(element).closest('.row').find('[x-model="product.quantity"]').val());
            if (!isNaN(price) && !isNaN(quantity)) {
                total += price * quantity;
            }
        });

        var discount = parseFloat($('#discount').val()) || 0;
        total -= discount;

        var expenses = parseFloat($('#expenses').val()) || 0;
        total += expenses;

        var freightPrice = parseFloat($('#freight_price').val()) || 0;
        total += freightPrice;

        var formattedTotal = total.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        $('#total_price').val(total.toFixed(2));
        $('#total-price-indicator').text(formattedTotal);

        var indicatorBg = $('#total-price-indicator-bg');
        if (total > 0) {
            indicatorBg.removeClass('bg-secondary bg-danger').addClass('bg-primary');
        } else if (total == 0) {
            indicatorBg.removeClass('bg-primary bg-danger').addClass('bg-secondary');
        } else {
            indicatorBg.removeClass('bg-primary bg-secondary').addClass('bg-danger');
        }
    }

    function validateQuantity(element) {
        var quantity = parseFloat($(element).val());
        if (isNaN(quantity) || quantity <= 0) {
            $(element).val('1');
        }
    }

    $(document).on('blur', '[x-model="product.quantity"]', function () {
        validateQuantity(this);
        calculateTotalCost();
        calculateTotalPrice();
    });

    $(document).on('input', '[x-model="product.cost"], [x-model="product.quantity"]', function () {
        calculateTotalCost();
    });

    $(document).on('input', '[x-model="product.msc"], [x-model="product.price"], [x-model="product.quantity"], #discount, #expenses, #freight_price', function () {
        calculateTotalPrice();
    });

    calculateTotalCost();
    calculateTotalPrice();
    //CÁLCULOS DA COTAÇÃO ----------------- FIM
});


