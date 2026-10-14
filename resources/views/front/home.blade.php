@extends('layouts.front')

@section('title', 'Castra Servilia Basket · Club de baloncesto de Cáceres')

@section('content')
    @if($sliderImages->isNotEmpty())
        <div id="csHero" class="carousel slide carousel-fade cs-carousel" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach($sliderImages as $i => $img)
                    <button type="button" data-bs-target="#csHero" data-bs-slide-to="{{ $i }}" @if($i===0) class="active" aria-current="true" @endif aria-label="Slide {{ $i+1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($sliderImages as $i => $img)
                    <div class="carousel-item @if($i===0) active @endif">
                        <img src="{{ $img->url() }}" alt="{{ $img->title }}">
                        @if($img->title)
                            <div class="carousel-caption d-none d-md-block">
                                <h5 class="mb-0">{{ $img->title }}</h5>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#csHero" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#csHero" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    @endif

    <div class="container">
        @if($latestPosts->isNotEmpty())
            <section>
                <div class="section-title d-flex justify-content-between align-items-center">
                    <h2>Últimas noticias</h2>
                    <a href="{{ route('front.posts.index') }}" class="small">Ver todas &rarr;</a>
                </div>
                <div class="row g-4">
                    @foreach($latestPosts as $post)
                        <div class="col-md-4">
                            <a href="{{ route('front.posts.show', $post->slug) }}" class="text-decoration-none text-reset">
                                <div class="card block-card h-100">
                                    @if($post->cover)
                                        <img src="{{ $post->cover->url() }}" class="card-img-top" alt="">
                                    @endif
                                    <div class="card-body">
                                        <small class="text-muted">{{ $post->publishdate?->format('d/m/Y') }}</small>
                                        <h5 class="card-title mt-1">{{ $post->title }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <section>
            <div class="section-title">
                <h2>Explora el club</h2>
            </div>
            <div class="row g-4">
                @php
                    $blocks = [
                        ['El Club', '/el-club', 'Historia, instalaciones, organigrama y filosofía del club.'],
                        ['Plantillas', '/el-club/plantillas', 'Senior Masculino, Senior Femenino y CS Legendas.'],
                        ['Competición', '/competicion', 'Calendarios, clasificaciones y resultados históricos.'],
                        ['Actividades', '/actividades', 'Running on Sundays, Club de Lectura, concursos y más.'],
                        ['Colaboradores', '/colaboradores', 'Las empresas y personas que hacen posible el club.'],
                        ['Actualidad', '/actualidad', 'Noticias, eventos y boletines.'],
                    ];
                @endphp
                @foreach($blocks as [$title, $href, $desc])
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ $href }}" class="text-decoration-none text-reset">
                            <div class="card block-card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $title }}</h5>
                                    <p class="card-text text-muted small mb-0">{{ $desc }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>

        @if($colaboradores->isNotEmpty())
            <section>
                <div class="section-title">
                    <h2>Colaboradores</h2>
                </div>
                <div class="row g-3">
                    @foreach($colaboradores as $col)
                        <div class="col-6 col-md-3 col-lg-2">
                            <a href="/colaboradores/{{ $col->slug }}" class="text-decoration-none text-reset">
                                <div class="colab-card h-100">
                                    @if($col->cover)
                                        <img src="{{ $col->cover->url() }}" alt="{{ $col->title }}">
                                    @else
                                        <small class="text-center">{{ $col->title }}</small>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
