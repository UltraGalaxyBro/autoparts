<div class="modal fade" id="modalObservationRace" tabindex="-1" aria-labelledby="modalObservationRaceLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="modalObservationRaceLabel">Parabéns por concluir esta corrida! <i
                        class="fa-regular fa-thumbs-up fa-xl"></i></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('races.finish', ['id' => $race->id]) }}" method="POST">
                @csrf
                @method('put')

                <div class="modal-body">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Coloque alguma observação sobre esta corrida se achar necessário."
                            id="observation" name="observation"></textarea>
                        <label for="observation">Observação sobre a corrida (opcional)</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-lg btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
