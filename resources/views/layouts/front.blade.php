<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Castra Servilia Basket')</title>
    @hasSection('meta_description')
        <meta name="description" content="@yield('meta_description')">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background: #fafafa; color: #222; }
        .navbar-brand { font-weight: 700; letter-spacing: .5px; }
        .site-footer { background: #1a1a1a; color: #ccc; padding: 2.5rem 0 1.5rem; margin-top: 4rem; }
        .site-footer a { color: #fff; text-decoration: none; }
        .site-footer a:hover { text-decoration: underline; }
        .hero { background: linear-gradient(135deg, #c62828 0%, #8b0000 100%); color: #fff; padding: 4rem 0; margin-bottom: 2rem; }
        .block-card { height: 100%; transition: transform .15s ease, box-shadow .15s ease; }
        .block-card:hover { transform: translateY(-3px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.1); }
        .block-card .card-img-top { height: 180px; object-fit: cover; background: #eee; }
        .section-body img { max-width: 100%; height: auto; }
        .gallery img { width: 100%; height: 200px; object-fit: cover; border-radius: .25rem; }
        .child-grid .card-img-top { height: 150px; object-fit: cover; background: #eee; }
    </style>
    @stack('head')
</head>
<body>
    @include('front.partials.header')

    <main>
        @yield('content')
    </main>

    @include('front.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
