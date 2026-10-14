<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('front.home') }}">CASTRA SERVILIA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('front.home') }}">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="/el-club">El Club</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('front.posts.index') }}">Noticias</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('front.contact') }}">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>
