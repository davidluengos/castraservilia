@extends('layouts.front')

@section('title', 'Contacto · Castra Servilia')

@push('head')
    @if(config('services.recaptcha.site_key'))
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    @endif
@endpush

@section('content')
    <div class="container py-4" style="max-width: 640px;">
        <h1 class="mb-4">Contacto</h1>

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if(session('status_error'))
            <div class="alert alert-danger">{{ session('status_error') }}</div>
        @endif

        <form method="POST" action="{{ route('front.contact.store') }}" id="contact-form">
            @csrf

            <div style="position:absolute; left:-10000px; top:auto; width:1px; height:1px; overflow:hidden;" aria-hidden="true">
                <label for="website">No rellenar</label>
                <input type="text" name="website" id="website" tabindex="-1" autocomplete="off" value="">
            </div>

            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" value="">

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Mensaje</label>
                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-dark">Enviar</button>
        </form>

        @if(config('services.recaptcha.site_key'))
            <p class="text-muted small mt-3 mb-0">
                Este sitio está protegido por reCAPTCHA y se aplican la
                <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Política de privacidad</a> y los
                <a href="https://policies.google.com/terms" target="_blank" rel="noopener">Términos de servicio</a> de Google.
            </p>
        @endif
    </div>
@endsection

@push('scripts')
    @if(config('services.recaptcha.site_key'))
        <script>
            (function () {
                var form = document.getElementById('contact-form');
                if (!form) return;
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    grecaptcha.ready(function () {
                        grecaptcha.execute(@json(config('services.recaptcha.site_key')), { action: 'contact' })
                            .then(function (token) {
                                document.getElementById('g-recaptcha-response').value = token;
                                form.submit();
                            });
                    });
                });
            })();
        </script>
    @endif
@endpush
