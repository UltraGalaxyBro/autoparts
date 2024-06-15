<div class="modal fade" id="cookieConsentModal" tabindex="-1" aria-labelledby="cookieConsentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cookieConsentModalLabel">
                    <i class="fa-solid fa-cookie fa-xl"></i> Aviso sobre cookies
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="cookie-consent__message fw-bold">
                    {!! trans('cookie-consent::texts.message') !!}
                </p>
                <p class="">
                    Para mais detalhes acesse <a href="{{ route('policies') }}"
                        title="Página em que são descrito os detalhes sobre o uso de cookies de nossos usuários.">Políticas
                        de Cookies</a>.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-primary js-cookie-consent-agree">{{ trans('cookie-consent::texts.agree') }} <i
                        class="fa-solid fa-cookie-bite fa-xl"></i></button>
            </div>
        </div>
    </div>
</div>
