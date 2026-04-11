<x-layout>
    <x-slot:title>Recupera Password — Presto</x-slot:title>

    <div class="row justify-content-center mt-5">
        <div class="col-12 col-sm-9 col-md-6 col-lg-5">
            <div class="auth-card">
                <h1 class="auth-title">Password dimenticata?</h1>
                <p class="auth-subtitle mb-4">Inserisci la tua email e ti invieremo un link per reimpostare la tua password in sicurezza.</p>

              @if (session('success'))
                    <div id="flash-message" class="alert-success-presto mb-4">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="presto-label">Email</label>
                        <input type="email" id="email" name="email"
                            class="presto-input @error('email') is-invalid @enderror" value="{{ old('email') }}"
                             placeholder="{{ __('messages.email_placeholder') }}">
                        @error('email')
                            <div class="auth-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-presto w-100">Invia link di ripristino</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>