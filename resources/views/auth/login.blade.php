<x-layout>
    <x-slot:title>
        Login - Presto
    </x-slot:title>

    <div class="row justify-content-center mt-5">
        <div class="col-12 col-sm-9 col-md-6 col-lg-5">

            <div class="auth-card">

                <h1 class="auth-title">Bentornato</h1>
                <p class="auth-subtitle">Effettua il login</p>

                {{-- Credential error --}}
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="presto-label">Email</label>
                        <input type="email" id="email" name="email"
                            class="presto-input @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            required autofocus autocomplete="email" placeholder="nome@esempio.it">
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label for="password" class="presto-label">Password</label>
                        <input type="password" id="password" name="password"
                            class="presto-input @error('password') is-invalid @enderror" required
                            autocomplete="current-password" placeholder="••••••••">
                    </div>

                    {{-- remember me --}}
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label small text-secondary" for="remember">
                            Ricordami
                        </label>
                    </div>

                    <button type="submit" class="btn-presto w-100">
                        Accedi
                    </button>
                </form>

                <hr class="my-4" style="border-color: var(--color-sand-200)">

                <p class="text-center small mb-0 footer-copy ">
                    Non hai un account?
                    <a href="{{ route('register') }}" style="color: var(--color-terra-600); font-weight: 500;">
                        Registrati
                    </a>
                </p>

            </div>

        </div>
    </div>

    </div>
