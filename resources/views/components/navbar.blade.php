<nav class="navbar navbar-expand-xl navbar-presto">
    <div class="container">

        {{-- Brand --}}
        <a class="navbar-brand" href="{{ route('homepage') }}"> <img src="{{ asset('images/watermark.png') }}"
                alt="Presto.it" class="img-fluid" style="height: 60px; width: 100px;"></a>

        {{-- Lang switcher + Toggler mobile --}}
        <div class="d-flex align-items-center gap-3 ms-auto d-xl-none">
            <x-lang-switcher />
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarMain">

            {{-- Barra di ricerca — mobile e tablet, sopra tutto --}}
            <div class="d-xl-none w-100 mt-2 mb-3 text-center">
                @livewire('search-bar')
            </div>

            {{-- Link sinistra — solo desktop --}}
            <ul class="navbar-nav me-3 mb-2 mb-xl-0 d-none d-xl-flex">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('homepage') ? 'active' : '' }}"
                        href="{{ route('homepage') }}">{{ __('messages.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('article.index') }}">{{ __('messages.articles') }}</a>
                </li>
            </ul>

            {{-- Barra di ricerca — solo desktop --}}
            <div class="me-auto my-2 my-xl-0 d-none d-xl-block">
                @livewire('search-bar')
            </div>

            {{-- Destra: @guest / @auth --}}
            <ul class="navbar-nav ms-auto mb-2 mb-xl-0 align-items-xl-center gap-2">

                @guest
                    {{-- Mobile/tablet: guest --}}
                    <li class="nav-item d-xl-none">
                        <div class="d-flex flex-column align-items-center gap-2 mt-1 mb-2 w-100">
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <a class="nav-link {{ request()->routeIs('homepage') ? 'active' : '' }}"
                                    href="{{ route('homepage') }}">{{ __('messages.home') }}</a>
                                <a class="nav-link" href="{{ route('article.index') }}">{{ __('messages.articles') }}</a>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('messages.login') }}</a>
                                <a class="btn-presto btn-sm"
                                    href="{{ route('register') }}">{{ __('messages.register') }}</a>
                            </div>
                        </div>
                    </li>

                    {{-- Desktop: guest --}}
                    <li class="nav-item d-none d-xl-block">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('messages.login') }}</a>
                    </li>
                    <li class="nav-item d-none d-xl-block">
                        <a class="btn-presto btn-sm" href="{{ route('register') }}">{{ __('messages.register') }}</a>
                    </li>
                @endguest

                @auth
                    {{-- Mobile/tablet: due righe centrate --}}
                    <li class="nav-item d-xl-none">
                        <div class="d-flex flex-column align-items-center gap-2 mt-1 mb-2 w-100">

                            {{-- Prima riga: Home, Annunci, + Annuncio --}}
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <a class="nav-link {{ request()->routeIs('homepage') ? 'active' : '' }}"
                                    href="{{ route('homepage') }}">{{ __('messages.home') }}</a>
                                <a class="nav-link" href="{{ route('article.index') }}">{{ __('messages.articles') }}</a>
                                <a class="btn-presto btn-sm btn-navbar-create"
                                    href="{{ route('article.create') }}">{{ __('messages.insert_article') }}</a>
                            </div>

                            {{-- Seconda riga: nome utente e carrello --}}
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <div class="dropdown">
                                    <span class="navbar-user dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="cursor: pointer;">
                                        {{ auth()->user()->name }}
                                    </span>
                                    <ul class="dropdown-menu">
                                        @if (!auth()->user()->isRevisor())
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('work-with-us') }}">{{ __('messages.work_with_us') }}</a>
                                            </li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('article.my') }}">{{ __('messages.my_articles') }}</a>
                                        </li>
                                        @if (auth()->user()->isRevisor())
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('revisor.index') }}">{{ __('messages.revisor_panel') }}</a>
                                            </li>
                                        @endif
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        @foreach (['it' => ['flag' => 'https://flagcdn.com/w40/it.png', 'label' => 'Italiano'], 'en' => ['flag' => 'https://flagcdn.com/w40/gb.png', 'label' => 'English'], 'es' => ['flag' => 'https://flagcdn.com/w40/es.png', 'label' => 'Español']] as $locale => $data)
                                            <li>
                                                <a href="{{ route('lang.switch', $locale) }}"
                                                    class="dropdown-item d-flex align-items-center gap-2 {{ app()->getLocale() === $locale ? 'active' : '' }}">
                                                    <img src="{{ $data['flag'] }}" alt="{{ strtoupper($locale) }}"
                                                        class="lang-flag">
                                                    {{ $data['label'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit"
                                                    class="dropdown-item text-danger">{{ __('messages.logout') }}</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>

                                {{-- Carrello --}}
                                <a href="{{ route('cart.index') }}" class="nav-link cart-nav-link">
                                    🛒
                                    @php $cartCount = auth()->user()->cartItems()->count(); @endphp
                                    @if ($cartCount > 0)
                                        <span class="cart-badge">{{ $cartCount }}</span>
                                    @endif
                                </a>
                            </div>

                        </div>
                    </li>

                    {{-- Desktop: + Annuncio --}}
                    <li class="nav-item d-none d-xl-flex align-items-center">
                        <a class="btn-presto btn-sm btn-navbar-create"
                            href="{{ route('article.create') }}">{{ __('messages.insert_article') }}</a>
                    </li>
                    <li class="nav-item d-none d-xl-block">
                        <div class="navbar-divider"></div>
                    </li>

                    {{-- Dropdown nome utente — solo desktop --}}
                    <li class="nav-item dropdown d-none d-xl-block">
                        <span class="navbar-user dropdown-toggle" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" style="cursor: pointer;">
                            {{ auth()->user()->name }}
                        </span>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if (!auth()->user()->isRevisor())
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('work-with-us') }}">{{ __('messages.work_with_us') }}</a>
                                </li>
                            @endif
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('article.my') }}">{{ __('messages.my_articles') }}</a>
                            </li>
                            @if (auth()->user()->isRevisor())
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('revisor.index') }}">{{ __('messages.revisor_panel') }}</a>
                                </li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            @foreach (['it' => ['flag' => 'https://flagcdn.com/w40/it.png', 'label' => 'Italiano'], 'en' => ['flag' => 'https://flagcdn.com/w40/gb.png', 'label' => 'English'], 'es' => ['flag' => 'https://flagcdn.com/w40/es.png', 'label' => 'Español']] as $locale => $data)
                                <li>
                                    <a href="{{ route('lang.switch', $locale) }}"
                                        class="dropdown-item d-flex align-items-center gap-2 {{ app()->getLocale() === $locale ? 'active' : '' }}">
                                        <img src="{{ $data['flag'] }}" alt="{{ strtoupper($locale) }}"
                                            class="lang-flag">
                                        {{ $data['label'] }}
                                    </a>
                                </li>
                            @endforeach
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item text-danger">{{ __('messages.logout') }}</button>
                                </form>
                            </li>
                        </ul>
                    </li>

                    {{-- Carrello — solo desktop --}}
                    <li class="nav-item d-none d-xl-block">
                        <a href="{{ route('cart.index') }}" class="nav-link cart-nav-link">
                            🛒
                            @php $cartCount = auth()->user()->cartItems()->count(); @endphp
                            @if ($cartCount > 0)
                                <span class="cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>
                @endauth

            </ul>

            {{-- Lang switcher — solo desktop, visibile solo per guest --}}
            @guest
                <div class="d-none d-xl-flex align-items-center ms-3">
                    <x-lang-switcher />
                </div>
            @endguest

        </div>

    </div>
</nav>
