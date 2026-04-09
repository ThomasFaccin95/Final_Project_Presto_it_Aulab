<x-layout>
    <x-slot:title>{{ __('contacts.title') }}</x-slot:title>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h1 class="display-4 fw-bold welcome-title">{{ __('contacts.title') }}</h1>

                <p class="lead m-4 mb-2 welcome-subtitle">{{ __('contacts.description_1') }}</p>
                <p class="lead mb-4 welcome-subtitle">{{ __('contacts.description_2') }}</p>

                @if (session('success'))
                    <div id="flash-message" class="alert-success-presto mb-4">{{ session('success') }}</div>
                @endif

                @auth
                    <div class="auth-card">
                        {{-- NOTA: Ricordati di cambiare la rotta se crei un controller apposito per i contatti --}}
                        <form method="POST" action="{{ route('work-with-us.send') }}">
                            @csrf

                            {{-- Nome precompilato con i dati dell'utente loggato --}}
                            <div class="mb-3">
                                <label class="presto-label">{{ __('messages.full_name') }}</label>
                                <input type="text" class="presto-input" value="{{ auth()->user()->name }}" readonly>
                            </div>

                            {{-- Email precompilata con i dati dell'utente loggato --}}
                            <div class="mb-3">
                                <label class="presto-label">{{ __('messages.email') }}</label>
                                <input type="email" class="presto-input" value="{{ auth()->user()->email }}" readonly>
                            </div>


                            {{--  Messaggio --}}
                            <div class="mb-4 text-start">
                                <label for="message" class="presto-label">
                                    {{ __('contacts.message.title') }}
                                </label>
                                <textarea id="message" name="message" 
                                    class="presto-input @error('message') is-invalid @enderror"
                                    rows="5" 
                                    placeholder="{{ __('contacts.message.placeholder') }}">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="auth-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn-presto w-100">
                                Invia Messaggio
                            </button>
                        </form>
                    </div>
                @endauth

                <div class="mt-5">
                    <a href="{{ route('homepage') }}" class="btn-presto-outline btn-sm">{{ __('messages.back_home') }}</a>
                </div>
            </div>
        </div>
    </div>
</x-layout>