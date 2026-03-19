<nav class="navbar navbar-expand-lg navbar-presto">
    <div class="container">

        {{-- Brand --}}
        <a class="navbar-brand" href="{{ route('homepage') }}">Presto.it</a>

        {{-- Toggler mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">

            {{-- Link sinistra --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('homepage') ? 'active' : '' }}"
                        href="{{ route('homepage') }}">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    {{-- Attivare quando esiste la rotta article.index (US2) --}}
                    <a class="nav-link" href="#">Annunci</a>
                </li>
            </ul>

            {{-- Destra: @guest / @auth --}}
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-2">

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Accedi</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn-presto btn-sm" href="{{ route('register') }}">Registrati</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item">
                        {{-- Attivare quando esiste la rotta article.create (US1) --}}
                        <a class="btn-presto btn-sm" href="#">+ Inserisci annuncio</a>
                    </li>
                    <li class="nav-item">
                        {{-- Attivare quando esiste la rotta article.mine (US1) --}}
                        <a class="nav-link" href="#">I miei annunci</a>
                    </li>
                    <li class="nav-item">
                        <div class="navbar-divider d-none d-lg-block"></div>
                    </li>
                    <li class="nav-item">
                        <span class="navbar-user">{{ auth()->user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-presto-outline btn-sm">
                                Logout
                            </button>
                        </form>
                    </li>
                @endauth

            </ul>
        </div>

    </div>
</nav>
