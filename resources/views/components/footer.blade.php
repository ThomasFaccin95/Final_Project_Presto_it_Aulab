<footer class="footer container-fluid text-light py-5 mt-5">
    <div class="container">
        <div class="row gy-4">

            {{-- Colonna 1: Brand --}}
            <div class="col-12 col-md-4">
                <h5 class="fw-bold mb-3 footer-brand">Presto.it</h5>
                <p class="small mb-3 footer-text">{{ __('messages.footer_desc') }}</p>
                {{-- Social icons: da aggiungere in seguito --}}
            </div>

            {{-- Colonna 2: Link utili --}}
            <div class="col-12 col-md-4">
                <h6 class="text-uppercase fw-bold mb-3 small footer-heading">{{ __('messages.useful_links') }}</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="{{ route('homepage') }}" class="footer-link small">{{ __('messages.home') }}</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('article.index') }}"
                            class="footer-link small">{{ __('messages.all_articles') }}</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="footer-link small">{{ __('messages.about') }}</a>
                    </li>
                    <li>
                        <a href="#" class="footer-link small">{{ __('messages.contacts') }}</a>
                    </li>
                </ul>
            </div>

            {{-- Colonna 3: Diventa revisore --}}
            <div class="col-12 col-md-4">
                @if (!auth()->check() || !auth()->user()->isRevisor())
                    <h6 class="text-uppercase fw-bold mb-3 small footer-heading">{{ __('messages.earn') }}</h6>
                    <p class="small mb-3 footer-text">{{ __('messages.earn_desc') }}</p>
                    @auth
                        <a href="{{ route('work-with-us') }}"
                            class="btn-presto-outline btn-sm">{{ __('messages.apply') }}</a>
                    @endauth
                    @guest
                        <a href="{{ route('register') }}" class="btn-presto btn-sm">{{ __('messages.register') }}</a>
                    @endguest
                @else
                    <h6 class="text-uppercase fw-bold mb-3 small footer-heading">{{ __('messages.revisor_area') }}</h6>
                    <p class="small mb-3 footer-text">{{ __('messages.revisor_area_desc') }}</p>
                    <a href="{{ route('revisor.index') }}"
                        class="btn-presto-outline btn-sm me-2">{{ __('messages.revisor_panel') }}</a>
                    <a href="{{ route('regulations') }}"
                        class="btn-presto-outline btn-sm">{{ __('messages.regulations') }}</a>
                @endif
            </div>

        </div>

        <hr class="footer-divider my-4">

        <div class="row align-items-center">
            <div class="col-12 col-md-8 text-center text-md-start">
                <p class="small mb-0 footer-copy">
                    {{ __('messages.rights', ['year' => date('Y')]) }}
                </p>
            </div>
            {{-- Selettore lingua nel footer --}}
            <div class="col-12 col-md-4 d-flex justify-content-center justify-content-md-end mt-3 mt-md-0">
                <x-lang-switcher />
            </div>
        </div>

    </div>
</footer>
