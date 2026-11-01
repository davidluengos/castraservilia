@extends('layouts.front')

@section('title', 'Contacto · Castra Servilia')

@section('content')
    <div class="container py-4" style="max-width: 640px;">
        <h1 class="mb-4">Contacto</h1>

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if(session('status_error'))
            <div class="alert alert-danger">{{ session('status_error') }}</div>
        @endif

        <form method="POST" action="{{ route('front.contact.store') }}">
            @csrf

            <div style="position:absolute; left:-10000px; top:auto; width:1px; height:1px; overflow:hidden;" aria-hidden="true">
                <label for="website">No rellenar</label>
                <input type="text" name="website" id="website" tabindex="-1" autocomplete="off" value="">
            </div>

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
    </div>
@endsection
