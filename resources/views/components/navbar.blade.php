<nav class="navbar navbar-expand-xl navbar-presto">
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
            <ul class="navbar-nav me-3 mb-2 mb-xl-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('homepage') ? 'active' : '' }}"
                        href="{{ route('homepage') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('article.index') }}">Annunci</a>
                </li>
            </ul>

            {{-- Barra di ricerca — solo desktop --}}
            <div class="me-auto my-2 my-xl-0 d-none d-xl-block">
                @livewire('search-bar')
            </div>

            {{-- Destra: @guest / @auth --}}
            <ul class="navbar-nav ms-auto mb-2 mb-xl-0 align-items-xl-center gap-2">

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
                        <a class="btn-presto btn-sm btn-navbar-create" href="{{ route('article.create') }}">Inserisci
                            annuncio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">I miei annunci</a>
                    </li>
                    <li class="nav-item d-none d-xl-block">
                        <div class="navbar-divider"></div>
                    </li>
                    <li class="nav-item">
                        <span class="navbar-user">{{ auth()->user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-presto-outline btn-sm">Logout</button>
                        </form>
                    </li>
                @endauth

            </ul>

            {{-- Barra di ricerca — solo mobile, sotto i link --}}
            <div class="d-xl-none w-100 mt-2 mb-1">
                @livewire('search-bar')
            </div>

        </div>

    </div>
</nav>
