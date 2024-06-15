<div class="modal fade" id="modalAccessClient" tabindex="-1" aria-labelledby="modalAccessClientLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalAccessClientLabel"><i class="fa-solid fa-info fa-2xl"></i></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="fw-bold">Cliente, para acessar o carrinho e realizar compras é necessário fazer login ou criar uma conta caso ainda não possua.<br>Não vai demorar quase nada! <i class="fa-regular fa-thumbs-up fa-xl"></i></p>
            </div>
            <div class="modal-footer">
                <a href="{{route('auth.login')}}" class="btn btn-primary">Fazer login <i class="fa-solid fa-door-open fa-xl"></i></a>
            </div>
        </div>
    </div>
</div>
