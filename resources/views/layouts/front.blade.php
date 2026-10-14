<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Castra Servilia Basket')</title>
    @hasSection('meta_description')
        <meta name="description" content="@yield('meta_description')">
    @endif
    <link rel="icon" href="{{ asset('front/images/escudo-castra-servilia.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --cs-green: #099a35;
            --cs-green-dark: #076a24;
            --cs-charcoal: #383838;
            --cs-charcoal-light: #474747;
            --cs-text: #333;
            --cs-muted: #6f6f6f;
            --cs-surface: #f8f8f8;
        }
        body { font-family: system-ui, -apple-system, sans-serif; background: var(--cs-surface); color: var(--cs-text); }
        a { color: var(--cs-green); }
        a:hover { color: var(--cs-green-dark); }
        .btn-brand { background: var(--cs-green); color: #fff; border: 0; }
        .btn-brand:hover { background: var(--cs-green-dark); color: #fff; }

        .navbar-cs { background: var(--cs-charcoal); border-bottom: 3px solid var(--cs-green); }
        .navbar-cs .navbar-brand { display: flex; align-items: center; gap: .6rem; font-weight: 700; letter-spacing: .5px; color: #fff; }
        .navbar-cs .navbar-brand img { height: 42px; width: auto; }
        .navbar-cs .nav-link { color: #e5e5e5; }
        .navbar-cs .nav-link:hover, .navbar-cs .nav-link.active { color: var(--cs-green); }

        .site-footer { background: var(--cs-charcoal); color: #ccc; padding: 2.5rem 0 1.5rem; margin-top: 4rem; border-top: 3px solid var(--cs-green); }
        .site-footer a { color: #fff; text-decoration: none; }
        .site-footer a:hover { color: var(--cs-green); text-decoration: underline; }

        .section-title { border-top: 1px solid var(--cs-green); border-bottom: 2px solid #000; padding: .6rem 0; margin: 2rem 0 1.5rem; background: var(--cs-surface); }
        .section-title h2 { margin: 0; font-size: 1.4rem; }

        .cs-carousel .carousel-item img { width: 100%; height: 420px; object-fit: cover; }
        .cs-carousel .carousel-caption { background: rgba(0,0,0,.5); border-radius: .25rem; padding: .5rem 1rem; left: 10%; right: 10%; bottom: 3rem; }

        .block-card { height: 100%; transition: transform .15s ease, box-shadow .15s ease; border-top: 2px solid var(--cs-green); }
        .block-card:hover { transform: translateY(-3px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.1); }
        .block-card .card-img-top { height: 180px; object-fit: cover; background: #eee; }

        .section-body img { max-width: 100%; height: auto; }
        .gallery img { width: 100%; height: 200px; object-fit: cover; border-radius: .25rem; }
        .child-grid .card-img-top { height: 150px; object-fit: cover; background: #eee; }

        .colab-card { background: #fff; border: 1px solid #e0e0e0; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: .75rem; }
        .colab-card img { max-height: 80px; max-width: 100%; object-fit: contain; }
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
