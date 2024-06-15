<div class="modal fade" id="modalNameStop" tabindex="-1" aria-labelledby="modalNameStopLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="modalNameStopLabel"><i class="fa-solid fa-info fa-2xl"></i> Informe o
                    nome da parada de agora</h3>
                <button type="button" id="close-race-stop" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('races.add-stop', ['id' => $race->id]) }}" method="POST">
                @csrf
                @method('post')

                <div class="modal-body">
                    <div class="form-floating">
                        <input autocomplete="off" type="text" class="form-control" id="name" name="name"
                            placeholder="Nome">
                        <label for="name">Nome</label>
                    </div>
                </div>
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-lg btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
