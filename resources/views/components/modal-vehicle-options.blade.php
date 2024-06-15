<div class="modal fade" id="modalVehicleOptions" tabindex="-1" aria-labelledby="modalVehicleOptionsLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="modalVehicleOptionsLabel"><i class="fa-solid fa-info fa-2xl"></i>
                    Informe qual veículo será utilizado nesta corrida</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('races.begin') }}" method="POST">
                @csrf
                @method('post')
                <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <div class="form-floating mb-3">
                                <select autocomplete="off" class="form-select" id="headquarter_id" name="headquarter_id"
                                    aria-label="Sobre qual a unidade da CO2 o produto está localizado">
                                    @foreach ($headquarters as $headquarter)
                                        <option value="{{ $headquarter->id }}">
                                            {{ $headquarter->name }}, {{ $headquarter->city }}-{{ $headquarter->state }}
                                        </option>
                                    @endforeach
                                </select>
                                <label>Corrida sendo iniciada da unidade</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="vehicle_id" name="vehicle_id"
                                    aria-label="Sobre qual veículo será usado nesta corrida">
                                    <option value="" selected disabled>--Selecione--</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">
                                            {{ $vehicle->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="vehicle_id">Veículo</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-lg btn-success">Iniciar corrida</button>
                </div>
            </form>
        </div>
    </div>
</div>
