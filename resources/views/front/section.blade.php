@extends('layouts.front')

@section('title', ($section->metatitle ?: $section->title) . ' · Castra Servilia')
@section('meta_description', $section->metadescription ?: '')

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Inicio</a></li>
                @foreach($breadcrumbs as $i => $crumb)
                    @if($i === count($breadcrumbs) - 1)
                        <li class="breadcrumb-item active" aria-current="page">{{ $crumb->title }}</li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ $crumb->url() }}">{{ $crumb->title }}</a></li>
                    @endif
                @endforeach
            </ol>
        </nav>

        <h1 class="mb-4">{{ $section->title }}</h1>

        @if($section->body)
            <article class="section-body mb-4">
                {!! $section->body !!}
            </article>
        @endif

        @if($section->images->isNotEmpty())
            <section class="mb-4">
                <h3 class="h5">Galería</h3>
                <div class="row g-3 gallery">
                    @foreach($section->images as $img)
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ $img->url() }}" target="_blank">
                                <img src="{{ $img->url() }}" alt="{{ $img->title }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if($section->videos->isNotEmpty())
            <section class="mb-4">
                <h3 class="h5">Vídeos</h3>
                <div class="row g-3">
                    @foreach($section->videos as $v)
                        <div class="col-md-6">
                            <div class="ratio ratio-16x9">
                                <iframe src="{{ $v->embedUrl() }}" title="{{ $v->title }}" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if($children->isNotEmpty())
            <section class="mb-4">
                <h3 class="h5">Contenido</h3>
                <div class="row g-3 child-grid">
                    @foreach($children as $child)
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ $child->url() }}" class="text-decoration-none text-reset">
                                <div class="card block-card h-100">
                                    @if($child->cover)
                                        <img src="{{ $child->cover->url() }}" class="card-img-top" alt="">
                                    @endif
                                    <div class="card-body">
                                        <h6 class="card-title mb-0">{{ $child->title }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
