function buyerDivs() {
    var selectBuyer = document.getElementById('type_buyer').value;
    var pfDiv = document.getElementById('pf-div');
    var pjDiv = document.getElementById('pj-div');

    if (selectBuyer === 'PF') {
        pfDiv.classList.remove('d-none');
        pjDiv.classList.add('d-none');
    } else if (selectBuyer === 'PJ') {
        pfDiv.classList.add('d-none');
        pjDiv.classList.remove('d-none');
    } else {
        pfDiv.classList.add('d-none');
        pjDiv.classList.add('d-none');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    buyerDivs();
});

document.getElementById('type_buyer').addEventListener('change', buyerDivs);

//MÁSCARAS PARA CAMPOS (NECESSÁRIO O SCRIPT DO PLUGIN JQUERY)
$('#telephone').mask('(00) 0000-0000');
$('#celphone').mask('(00) 0 0000-0000');
$('#cpf').mask('000.000.000-00');
$('#cnpj').mask('00.000.000/0000-00');
$('#ie').mask('00.000.000-0');
