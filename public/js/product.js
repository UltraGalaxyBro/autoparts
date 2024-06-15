$(document).ready(function () {
    $('#increaseBtn').click(function () {
        increaseQuantity();
    });

    $('#decreaseBtn').click(function () {
        decreaseQuantity();
    });

    $('#quantityShowed').on('input', function () {
        updateQuantity();
        updateTotal();
    });
});

function increaseQuantity() {
    var quantityInput = $('#quantityShowed');
    var quantity = parseInt(quantityInput.val());
    quantity++;
    quantityInput.val(quantity);
    updateQuantity();
    updateTotal();
}

function decreaseQuantity() {
    var quantityInput = $('#quantityShowed');
    var quantity = parseInt(quantityInput.val());
    if (quantity > 1) {
        quantity--;
        quantityInput.val(quantity);
        updateQuantity();
        updateTotal();
    }
}

function updateQuantity() {
    var quantityInput = $('#quantityShowed');
    var quantityForm = $('#quantity');
    var quantity = parseInt(quantityInput.val());
    quantityForm.val(quantity);
}

function updateTotal() {
    var quantity = parseInt($('#quantityShowed').val());
    var pricePerItem = parseFloat($('#priceProduct').val().replace(',', '.'));
    var total = quantity * pricePerItem;
    $('#totalProduct').text('R$ ' + total.toFixed(2).replace('.', ','));
}





