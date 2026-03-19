<footer class="footer container-fluid text-light py-5 mt-5">
    <div class="container">
        <div class="row gy-4">

            {{-- Colonna 1: Brand --}}
            <div class="col-12 col-md-4">
                <h5 class="fw-bold mb-3 footer-brand">Presto.it</h5>
                <p class="small mb-3 footer-text">
                    Il portale numero uno per vendere e comprare articoli di ogni tipo.
                    Veloce, sicuro e alla portata di tutti.
                </p>
                {{-- Social icons: da aggiungere in seguito --}}
            </div>

            {{-- Colonna 2: Link utili --}}
            <div class="col-12 col-md-4">
                <h6 class="text-uppercase fw-bold mb-3 small footer-heading">Link utili</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="{{ route('homepage') }}" class="footer-link small">Home</a>
                    </li>
                    <li class="mb-2">
                        {{-- Attivare quando esiste la rotta article.index (US2) --}}
                        <a href="#" class="footer-link small">Tutti gli articoli</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="footer-link small">Chi siamo</a>
                    </li>
                    <li>
                        <a href="#" class="footer-link small">Contatti</a>
                    </li>
                </ul>
            </div>

            {{-- Colonna 3: Diventa revisore --}}
            <div class="col-12 col-md-4">
                <h6 class="text-uppercase fw-bold mb-3 small footer-heading">Vuoi guadagnare?</h6>
                <p class="small mb-3 footer-text">
                    Diventa revisore della nostra community e aiutaci a rendere il portale più sicuro.
                </p>
                @auth
                    {{-- Attivare quando esiste la rotta work-with-us (US3) --}}
                    {{-- <a href="{{ route('work-with-us') }}" class="btn-presto-outline btn-sm">Candidati ora</a> --}}
                @endauth
                @guest
                    <a href="{{ route('register') }}" class="btn-presto btn-sm">Registrati</a>
                @endguest
            </div>

        </div>

        <hr class="footer-divider my-4">

        <div class="row">
            <div class="col-12 text-center">
                <p class="small mb-0 footer-copy">
                    &copy; {{ date('Y') }} Presto.it — Tutti i diritti riservati.
                    Realizzato dal Team Presto.
                </p>
            </div>
        </div>

    </div>
</footer>
