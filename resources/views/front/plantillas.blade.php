@extends('layouts.front')

@section('title', 'Plantillas · Castra Servilia')

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

        <h1 class="mb-4">Plantillas</h1>

        @foreach($teams as $team)
            @php $label = $teamLabels[$team->id] ?? $team->title; @endphp
            <section class="mb-5">
                <div class="section-title">
                    <h2>{{ $label }}</h2>
                </div>
                @if($team->children->isEmpty())
                    <p class="text-muted small">Sin miembros registrados.</p>
                @else
                    <div class="row g-3 player-grid">
                        @foreach($team->children as $player)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <a href="{{ $player->url() }}" class="text-decoration-none text-reset">
                                    <div class="card block-card h-100 player-card">
                                        @if($player->cover)
                                            <img src="{{ $player->cover->url() }}" class="card-img-top" alt="{{ $player->title }}">
                                        @else
                                            <div class="card-img-top player-placeholder d-flex align-items-center justify-content-center text-muted small">Sin foto</div>
                                        @endif
                                        <div class="card-body p-2 d-flex align-items-baseline gap-2">
                                            @if($player->dorsal !== null)
                                                <span class="dorsal-badge">{{ (int) $player->dorsal }}</span>
                                            @endif
                                            <p class="card-title mb-0 small fw-semibold">{{ $player->title }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        @endforeach
    </div>

    @push('head')
        <style>
            .player-grid .player-card { border-top-width: 3px; }
            .player-grid .card-img-top { height: 260px; object-fit: cover; object-position: center top; background: #eee; }
            .player-grid .player-placeholder { height: 260px; }
            .player-grid .card-title { line-height: 1.2; }
            .player-grid .dorsal-badge {
                flex: 0 0 auto;
                background: var(--cs-green); color: #fff;
                font-weight: 700; font-size: .95rem; line-height: 1;
                padding: .2rem .4rem; border-radius: .2rem;
                min-width: 1.6rem; text-align: center;
            }
        </style>
    @endpush
@endsection
