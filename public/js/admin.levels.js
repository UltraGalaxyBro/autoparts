function calcularPrecoDescontado() {
    var discountValue = parseFloat(document.getElementById('discount').value);
    if (isNaN(discountValue) || discountValue === "") {
        discountValue = 0;
    }
    var originalPrice = 1000.00;
    var discountedPrice = originalPrice - (originalPrice * discountValue / 100);
    var formattedPrice = discountedPrice.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
    document.getElementById('nivel-aplicado').textContent = "R$ " + formattedPrice;
}

document.addEventListener('DOMContentLoaded', function() {
    calcularPrecoDescontado(); 
});

document.getElementById('discount').addEventListener('input', function() {
    calcularPrecoDescontado();
});

