@extends('layouts.front')

@section('title', 'Noticias · Castra Servilia')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Noticias</h1>

        @if($posts->isEmpty())
            <p class="text-muted">No hay noticias publicadas.</p>
        @else
            <div class="row g-4">
                @foreach($posts as $post)
                    <div class="col-md-6 col-lg-4">
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

            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection
