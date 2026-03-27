<x-layout>

    <x-slot:title>{{ __('messages.checkout_title') }} — Presto</x-slot:title>

    <div class="container mt-5 mb-5">
        <h2 class="mb-4">Il tuo Carrello</h2>
        <div class="row">

            <div class="col-md-8">
                {{-- # Cicla tutti gli articoli presenti nel carrello passati dal Controller. 
                 # Se la variabile $cartItems è vuota, esegue il blocco @empty  --}}

                @forelse($cartItems as $item)
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="row g-0 align-items-center">

                            {{-- # 1. ZONA CHECKBOX --}}
                            <div class="col-md-1 text-center p-2">

                                {{-- # Include il file separato per il checkbox, passando i dati del singolo $item.
                                     # Questo checkbox serve per selezionare quali articoli acquistare ora. --}}

                                @include('cart.checkbox', ['item' => $item])
                            </div>

                            {{-- # 2. ZONA IMMAGINE PRODOTTO --}}
                            <div class="col-md-3">

                                {{-- # Controlla se il modello associato all'articolo ha immagini. 
                                     # Se sì, prende la prima e la ridimensiona; altrimenti usa un'immagine segnaposto. --}}

                                <img src="{{ $item->associatedModel->images->isNotEmpty() ? $item->associatedModel->images->first()->getUrl(300, 300) : 'https://picsum.photos/300' }}"
                                    alt="{{ $item->name }}" class="img-fluid rounded-start object-fit-cover"
                                    style="height: 120px; width: 100%;">
                            </div>

                            {{-- # 3. ZONA DETTAGLI E AZIONI --}}

                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">

                                        {{-- # Stampa il nome dell'articolo --}}
                                        <h5 class="card-title mb-1">{{ $item->name }}</h5>
                                        {{-- # Stampa il prezzo formattato in euro --}}
                                        <p class="card-text fw-bold text-success mb-0">
                                            €{{ number_format($item->price, 2, ',', '.') }}
                                        </p>
                                    </div>
                                    {{-- # Stampa la quantità dell'articolo --}}
                                    <p class="card-text text-muted small mb-3">
                                        Quantità: {{ $item->quantity }}
                                    </p>

                                    {{-- # 4. PULSANTE DI RIMOZIONE SINGOLO ARTICOLO --}}
                                    {{-- # Form per rimuovere l'articolo dal carrello. 
                                         # Invia una richiesta DELETE al route 'cart.remove' con l'id dell'articolo. --}}
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Rimuovi
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- # Se non ci sono articoli nel carrello, mostra questo messaggio --}}
                @empty
                    <div class="alert alert-info text-center py-4">
                        <p class="mb-3">Il tuo carrello è vuoto.</p>
                        <a href="{{ route('article.index') }}" class="btn-presto">Torna agli acquisti</a>
                    </div>
                @endforelse
            </div>

            {{-- # COLONNA DESTRA: RIEPILOGO E CHECKOUT --}}
            <div class="col-md-4">
                {{-- # sticky-top fa in modo che il riquadro segua lo scroll della pagina --}}
                <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title">Riepilogo Ordine</h5>

                        {{-- # Mostra il totale dinamico (aggiornato da JavaScript) --}}
                        <div class="d-flex justify-content-between mb-3">
                            <span>Totale (Selezionati):</span>
                            {{-- # id="cart-total" è il bersaglio usato dal JS per scrivere il nuovo prezzo --}}
                            <strong id="cart-total" class="fs-4">€0,00</strong>
                        </div>

                        {{-- # 5. FORM DI ACQUISTO (CHECKOUT) --}}
                        <form action="{{ route('cart.checkout') }}" method="POST" id="checkout-form">
                            @csrf

                            {{-- # IMPORTANTE: Questo div è vuoto nell'HTML, ma il JavaScript (qui sotto)
                                 # ci infilerà dentro dei tag <input type="hidden"> contenenti gli ID degli articoli spuntati. --}}
                            <div id="selected-items-inputs"></div>

                            {{-- # Il pulsante parte disabilitato ('disabled') e si attiva solo se c'è almeno 1 spunta --}}
                            <button type="submit" class="btn-presto w-100" id="checkout-btn" disabled>
                                Procedi all'acquisto
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>


</x-layout>
