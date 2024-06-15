$('#img').change(function() {
    previewImage(this);
});

function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#targetImg').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

var defaultImagePath = "/img/headquarters/default-image.png";

document.getElementById('imgDel').addEventListener('click', function() {
    var imgElement = document.getElementById('targetImg');
    imgElement.src = defaultImagePath;
    var inputElement = document.getElementById('img');
    inputElement.value = '';
});