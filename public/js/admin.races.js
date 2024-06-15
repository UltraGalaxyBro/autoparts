//OBTENDO A GEOLOCALIZAÇÃO DO USUÁRIO E INSERINDO NOS INPUTS CORRESPONDENTES DENTRO DO FORMULÁRIO
$('#modalNameStop').on('show.bs.modal', function (event) {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            // Preencher os campos de latitude e longitude
            $('#latitude').val(latitude);
            $('#longitude').val(longitude);
        });
    } else {
        alert("Geolocalização não suportada neste navegador.");
    }
});