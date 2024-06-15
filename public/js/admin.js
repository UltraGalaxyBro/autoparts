//FUNCIONALIDADE DE EMPURRAR OS ELEMENTOS HORIZONTALMENTE NA PÁGINA
const sidebarToggle = document.querySelector("#sidebar-toggle");
sidebarToggle.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("collapsed");
});

//FUNCIONALIDADE PARA EXIBIR O SWEETALERT QUANDO FOR CONFIRMAR UMA EXCLUSÃO DE ALGUM REGISTRO

document.querySelectorAll('.btnDelete').forEach(function (button) {
    //Aguardando o clique do usuário que quer apagar o registro
    button.addEventListener('click', function (event) {
        //Impede da página recarregar ao clicar no botão
        event.preventDefault();
        //capturando o id certo do registro certo que será excluído
        var deleteId = this.getAttribute('data-delete-id');
        //inicializando e configurando o Sweetalert
        Swal.fire({
            title: "Você tem certeza?",
            text: "É uma ação irreversível apagar algo!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#bc0f0f",
            cancelButtonColor: "#808080",
            confirmButtonText: "Sim, apagar!",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                //Acionando o formulário
                document.getElementById(`formDelete${deleteId}`).submit();
            }
        });
    })
})

//INICIANDO O SELECT2
$(function () {
    $('.select2').select2({
        theme: 'bootstrap-5',
        placeholder: "Selecione"
    });

    $('.select2row').select2({
        theme: 'bootstrap-5',
        placeholder: "Selecione"
    });

    $('.select2create').select2({
        theme: 'bootstrap-5',
        tags: true,
        placeholder: "Selecione ou crie"
    });
});
