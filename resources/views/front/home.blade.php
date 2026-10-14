@extends('layouts.front')

@section('title', 'Castra Servilia Basket · Club de baloncesto de Cáceres')

@section('content')
    <section class="hero">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Castra Servilia Basket</h1>
            <p class="lead mb-4">Un club pequeño con espíritu grande.</p>
            <a href="/el-club" class="btn btn-light btn-lg">Conoce el club</a>
        </div>
    </section>

    <div class="container">
        @if($latestPosts->isNotEmpty())
            <section class="mb-5">
                <div class="d-flex justify-content-between align-items-end mb-3">
                    <h2 class="mb-0">Últimas noticias</h2>
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

        <section class="mb-5">
            <h2 class="mb-3">Explora</h2>
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
            <section class="mb-5">
                <h2 class="mb-3">Colaboradores</h2>
                <div class="row g-3">
                    @foreach($colaboradores as $col)
                        <div class="col-6 col-md-3 col-lg-2">
                            <a href="/colaboradores/{{ $col->slug }}" class="text-decoration-none text-reset">
                                <div class="card block-card h-100 text-center">
                                    @if($col->cover)
                                        <img src="{{ $col->cover->url() }}" class="card-img-top p-2" alt="{{ $col->title }}" style="height: 100px; object-fit: contain;">
                                    @endif
                                    <div class="card-body p-2">
                                        <small>{{ $col->title }}</small>
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
