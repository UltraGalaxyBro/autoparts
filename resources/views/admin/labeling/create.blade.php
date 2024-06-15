@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Etiquetagem</h4>
        <p>
            Gere etiquetas para embalagens dos produtos vendidos. Será baixado um arquivo PDF após a conclusão das
            configurações quando for criar um modelo de etiqueta para impressão. É uma alternativa caso não haja um
            dispositivo de gerar etiquetas automáticas. Tenha cuidado ao inserir nomes muito grandes, pois assim podem haver distorções no layout da etiquetagem.<br>
            <strong>LEMBRE-SE QUE A IMPRESSÃO FOI PROGRAMADA PARA FOLHAS EM TAMANHO A4 (210X297mm)</strong>.
        </p>
    </div>
    <div class="mb-5 mt-5">
        <form action="{{ route('labeling.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('post')
            <h5 class="text-center mb-5">Insira as configurações deste lote de etiqueta(s)</h5>
            <div x-data="{
                labels: [
                    @if (count(old('labels', [])) > 0) @foreach (old('labels', []) as $oldLabel)
                            {
                                receiver: '{{ $oldLabel['receiver'] ?? '' }}',
                    place: '{{ $oldLabel['place'] ?? '' }}',
                    nf: '{{ $oldLabel['nf'] ?? '' }}',
                    volumes: '{{ $oldLabel['volumes'] ?? '' }}',
                    size: '{{ $oldLabel['size'] ?? '' }}',
                    quantity: '{{ $oldLabel['quantity'] ?? '1' }}',
                    danger: '{{ $oldLabel['danger'] ?? 'Não' }}',

                },
                @endforeach
                @else {  receiver: '', place: '', nf: '', volumes: '', size: '', quantity: '1', danger: 'Não' } @endif
                ]
            }">
                <template x-for="(label, index) in labels" :key="index">
                    <div class="row justify-content-center mb-2">
                        <div class="mb-2">
                            <h6 class="text-center">Modelo etiqueta <span x-text="index"></span>
                                <template x-if="labels.length > 1">
                                    <button type="button" title="Excluir este modelo" class="btn btn-sm btn-danger"
                                        @click="labels.splice(index, 1)">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </template>
                            </h6>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="text" class="form-control rounded-3"
                                    x-model="label.receiver" :name="'labels[' + index + '][receiver]'">
                                <label>Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="text" class="form-control rounded-3"
                                    x-model="label.place" :name="'labels[' + index + '][place]'">
                                <label>Local</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="text" class="form-control rounded-3 nfe"
                                    x-model="label.nf" :name="'labels[' + index + '][nf]'">
                                <label>Nº nota</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="number" step="0.01"
                                    class="form-control rounded-3 volumes" x-model="label.volumes"
                                    :name="'labels[' + index + '][volumes]'">
                                <label>Nº volume</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating mb-3">
                                <select autocomplete="off" class="form-select" x-model="label.size"
                                    aria-label="Sobre qual a unidade da CO2 o produto está localizado"
                                    :name="'labels[' + index + '][size]'">
                                    <option value="" disabled selected>--Selecione--</option>
                                    <option value="P">
                                        P (=~67x101mm)
                                    </option>
                                    <option value="M">
                                        M (=~67x203mm)
                                    </option>
                                    <option value="G">
                                        G (=~210x148mm)
                                    </option>
                                    <option value="E">
                                        E (toda a folha)
                                    </option>
                                </select>
                                <label>Tamanho</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="number" step="0.01" class="form-control rounded-3"
                                    x-model="label.quantity" :name="'labels[' + index + '][quantity]'">
                                <label>QTD.</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-floating">
                                <select autocomplete="off" class="form-select" x-model="label.danger"
                                    aria-label="Indicar na etiqueta que é frágil, para ter cuidado."
                                    :name="'labels[' + index + '][danger]'">
                                    <option value="">
                                       Não
                                    </option>
                                    <option value="Sim">
                                        Sim
                                    </option>
                                </select>
                                <label>Frágil <i class="fa-solid fa-triangle-exclamation text-danger"></i></label>
                            </div>
                        </div>
                        <div class="mb-2 mt-4 text-center">
                            <template x-if="index === labels.length - 1">
                                <button type="button" title="Adicionar mais modelo de etiquetagem"
                                    class="btn btn-sm btn-primary"
                                    @click="labels.push({ receiver: '', place: '', nf: '', volumes: '', size: '', quantity: '1', danger: 'Não' });">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
            <div class="text-center mt-5">
                <button class="btn btn-lg btn-success rounded-3" title="Gerar modelo de etiqueta" type="submit"
                    onclick="this.innerText = 'Gerando...'">Gerar etiquetagem <i class="fa-solid fa-file-pdf"></i></button>
            </div>
        </form>
    </div>
@endsection
