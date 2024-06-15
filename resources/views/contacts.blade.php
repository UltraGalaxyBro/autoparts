@extends('layouts.store')

@section('content')
    <x-alert />
    <div class="divider-2"></div>
    <div class="container pt-5 mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-5 ms-3 me-3 mb-5 border rounded shadow p-3">
                <h3 class="text-center fw-bold">Contato via e-mail</h3>
                <p class="text-end my-3">
                    <em>campos com o <strong>*</strong> são obrigatórios.</em>
                <p>
                <form action="{{ route('client-emailing') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="mb-3">
                        <label for="name" class="form-label">Seu nome completo*</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Seu e-mail válido *</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Telefone/Celular com DDD *</label>
                        <input type="telephone" class="form-control" id="telephone" name="telephone"
                            value="{{ old('telephone') }}">
                        <div class="form-check">
                            <input class="form-check-input" value="Sim" type="checkbox" id="whatsapp" name="whatsapp"
                                {{ old('whatsapp') ? 'checked' : '' }}>
                            <label class="form-check-label" for="whatsapp">
                                Este número é WhatsApp
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Assunto *</label>
                        <select class="form-select" id="subject" name="subject">
                            <option value="" selected disabled>Selecione um assunto</option>
                            <option value="Informação Geral" {{ old('subject') == 'Informação Geral' ? 'selected' : null }}>
                                Informação Geral
                            </option>
                            <option value="Suporte Técnico" {{ old('subject') == 'Suporte Técnico' ? 'selected' : null }}>
                                Suporte Técnico
                            </option>
                            <option value="Elogio/Crítica" {{ old('subject') == 'Elogio/Crítica' ? 'selected' : null }}>
                                Elogio/Crítica
                            </option>
                            <option value="Devolução" {{ old('subject') == 'Devolução' ? 'selected' : null }}>
                                Devolução
                            </option>
                            <option value="Outro" {{ old('subject') == 'Outro' ? 'selected' : null }}>
                                Outro
                            </option>
                        </select>
                    </div>
                    <div class="mb-5 related-devolution" style="display: none;">
                        <h5 class="text-center fw-bold">Condições para aceitação da devolução</h5>
                        <ul>
                            <li>
                                É imprescindível que o(s) produto(s) esteja(m) sem sinais de uso e com a devida embalagem na
                                qual fora enviada anteriormente;
                            </li>
                            <li>
                                É imprescindível que o(s) produto(s) esteja(m) dentro da janela de tempo de 7 dias após a
                                data da compra;
                            </li>
                            <li>
                                Após o envio deste formulário é necessário estar apto a esperar a resposta, via veículos de
                                comunicação coligados a <strong><em>CO2 Peças</em></strong> (seja por e-mail, WhatsApp,
                                etc.), alegando que está autorizado o pedido de devolução do solicitante. Após a autorização
                                é permitida a logística reversa despachando a mercadoria para a unidade <strong><em>CO2
                                        Peças</em></strong> na qual fora comprada a mesma anteriormente;
                            </li>
                            <li>
                                É imprescindível, caso a compra seja do tipo PESSOA JURÍDICA e após a autorização da
                                devolução sinalizada pela <strong><em>CO2 Peças</em></strong>, que haja elaborado um
                                documento fiscal de devolução do solicitante. No mesmo não deve haver destacado valores
                                sobre despesas de transporte e/ou de outra origem. O e-mail para envio de tal documento será
                                informado no e-mail de autorização emitido pela <strong><em>CO2 Peças</em></strong>;
                            </li>
                            <li>
                                Quando a mercadoria para devolução chegar na <strong><em>CO2 Peças</em></strong> e o motivo
                                para a devolução ser por alegação de defeito de fábrica, a garantia será acionada e uma
                                análise feita pela fabricante/marca deste(s) produto(s). Uma resposta sobre o caso só será
                                passada ao solicitante mediante a uma resposta da fabricante/marca sobre o(s) produto(s) do
                                caso em questão.
                            </li>
                        </ul>
                    </div>

                    <div class="mt-2 mb-3 related-devolution" style="display: none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="reason" class="form-label">Motivo da devolução *</label>
                                <select class="form-select" id="reason" name="reason">
                                    <option value="" selected disabled>Selecione um motivo</option>
                                    <option value="Arrependimento"
                                        {{ old('reason') == 'Arrependimento' ? 'selected' : null }}>
                                        Arrependimento
                                    </option>
                                    <option value="Erro do(a) vendedor(a)"
                                        {{ old('reason') == 'Erro do(a) vendedor(a)' ? 'selected' : null }}>
                                        Erro do(a) vendedor(a)
                                    </option>
                                    <option value="Defeito de fábrica"
                                        {{ old('reason') == 'Defeito de fábrica' ? 'selected' : null }}>
                                        Defeito de fábrica
                                    </option>
                                    <option value="Outro" {{ old('reason') == 'Outro' ? 'selected' : null }}>
                                        Outro
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nf" class="form-label">Nº da nota fiscal CO2 referente *</label>
                                <input type="text" class="form-control" id="nf" name="nf"
                                    value="{{ old('nf') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 related-devolution" style="display: none;">
                        <label for="files" class="form-label">Anexos sobre o(s) produto(s)</label>
                        <input class="form-control" type="file" id="files" name="files[]" multiple>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label" id="message-label">Mensagem *</label>
                        <textarea class="form-control" id="message" name="message" maxlength="750" rows="5">{{ old('message') }}</textarea>
                    </div>

                    <div class="mb-3 related-devolution" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" name="terms"
                                {{ old('terms') ? 'checked' : '' }}>
                            <label class="form-check-label" for="terms">
                                Declaro que li e aceito as <strong>Condições para aceitação da devolução</strong>, além de
                                que confirmo que todos os dados que inseri neste formulário são verdadeiros.
                            </label>
                        </div>
                    </div>
                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    <br />
                    <div class="text-end">
                        <button type="submit" title="Enviar formulário" class="btn btn-primary btn-lg text-end"
                            onclick="this.innerText = 'Enviando...'">
                            Enviar
                        </button>
                    </div>
                </form>
            </div>
            @if ($headquarters)
                <div class="col-md-5 ms-3 me-3 mb-5 border rounded shadow p-3">
                    <h3 class="text-center fw-bold">Encontrando a CO2 Peças</h3>
                    <div class="row justify-content-center text-center mt-3">
                        <ul class="list-group list-group-flush">
                            @foreach ($headquarters as $headquarter)
                                <li class="list-group-item">
                                    <div class="mb-2" style="max-width: 540px;">
                                        <div class="row g-0">
                                            <div class="col-md-4 text-center">
                                                <img src="{{ asset('img/headquarters/' . $headquarter->main_img) }}"
                                                    class="img-fluid rounded mt-1" alt="Fachada da unidade">
                                                <a href="{{ $headquarter->map }}" class="btn btn-sm btn-danger mt-1 mb-1"
                                                    target="_blank"
                                                    title="Mostrar no Google Maps a localização desta unidade."><small>Mostrar
                                                        localização
                                                        <i class="fa-solid fa-map-location-dot"></i></small></a>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $headquarter->name }}, CEP:
                                                        {{ $headquarter->zip_code }}</h6>
                                                    <p class="card-text">
                                                        {{ $headquarter->city }} - {{ $headquarter->state }} |
                                                        {{ $headquarter->neighborhood }}</br>
                                                        {{ $headquarter->street }}, Nº{{ $headquarter->number }}
                                                        @if ($headquarter->complement)
                                                            <br>
                                                            <small
                                                                class="text-body-secondary">{{ $headquarter->complement }}
                                                            </small>
                                                        @endif
                                                    </p>
                                                    <p class="card-text">
                                                        <small class="fw-bold">
                                                            <i class="fa-solid fa-phone-volume text-info"></i>
                                                            <span class="text-info">{{ $headquarter->telephone }}</span> -
                                                            <i class="fa-brands fa-whatsapp text-success"></i>
                                                            <span class="text-success">{{ $headquarter->whatsapp }}</span>
                                                        </small>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="divider"></div>
@endsection

@push('scripts')
    <script src="{{ asset('js/contacts.js') }}"></script>
@endpush
