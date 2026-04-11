<x-layout>
    <x-slot:title>Crea Nuova Password — Presto</x-slot:title>

    <div class="row justify-content-center mt-5">
        <div class="col-12 col-sm-9 col-md-6 col-lg-5">
            <div class="auth-card">
                <h1 class="auth-title">Imposta la nuova password</h1>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    
                    {{-- Questo campo nascosto "token" è un codice di sicurezza obbligatorio per vedere che sia esattamente! lo stesso UTENTE--}}
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="mb-3">
                        <label for="email" class="presto-label">Email</label>
                        <input type="email" id="email" name="email"
                            class="presto-input @error('email') is-invalid @enderror" value="{{ old('email', $request->email) }}" required readonly>
                        @error('email')
                            <div class="auth-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="presto-label">Nuova Password</label>
                        <input type="password" id="password" name="password"
                            class="presto-input @error('password') is-invalid @enderror" required autofocus>
                        @error('password')
                            <div class="auth-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="presto-label">Conferma Nuova Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="presto-input" required>
                    </div>

                    <button type="submit" class="btn-presto w-100">Aggiorna Password</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>