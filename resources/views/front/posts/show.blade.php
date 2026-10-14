@extends('layouts.front')

@section('title', ($post->metatitle ?: $post->title) . ' · Castra Servilia')
@section('meta_description', $post->metadescription ?: '')

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('front.posts.index') }}">Noticias</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
            </ol>
        </nav>

        <article>
            <header class="mb-4">
                <h1>{{ $post->title }}</h1>
                <p class="text-muted small">{{ $post->publishdate?->format('d \d\e F \d\e Y') }}</p>
            </header>

            <div class="section-body">
                {!! $post->renderedBody() !!}
            </div>

            @if($post->images->isNotEmpty())
                <section class="mt-4">
                    <h3 class="h5">Imágenes</h3>
                    <div class="row g-3 gallery">
                        @foreach($post->images as $img)
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="{{ $img->url() }}" target="_blank">
                                    <img src="{{ $img->url() }}" alt="{{ $img->title }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </article>
    </div>
@endsection
