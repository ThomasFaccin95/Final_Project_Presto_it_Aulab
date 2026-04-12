<x-layout>
    <x-slot:title>Crea Nuova Password — Presto</x-slot:title>

    <div class="row justify-content-center mt-5">
        <div class="col-12 col-sm-9 col-md-6 col-lg-5">
            <div class="auth-card">
                <h1 class="auth-title">{{ __('passwords.forgot_title') }}</h1>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    {{-- Questo campo nascosto "token" è un codice di sicurezza obbligatorio per vedere che sia esattamente! lo stesso UTENTE --}}
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="presto-label">{{ __('messages.email') }}</label>
                        <input type="email" id="email" name="email"
                            class="presto-input @error('email') is-invalid @enderror"
                            value="{{ old('email', $request->email) }}">
                        @error('email')
                            <div class="auth-error">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Password --}}
                    <div class="mb-3 position-relative">
                        <label for="password" class="presto-label">{{ __('messages.password') }}</label>
                        <input type="password" id="password" name="password"
                            class="presto-input @error('password') is-invalid @enderror" placeholder="••••••••">
                        <button type="button" class="toggle-password" data-target="password">
                            <i class="fa-regular fa-eye" id="icon-password"></i>
                        </button>
                        @error('password')
                            <div class="auth-error">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Password di conferma --}}
                    <div class="mb-4 position-relative">
                        <label for="password_confirmation'" class="presto-label">
                            {{ __('messages.confirm_new_password') }}
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="presto-input @error('password') is-invalid @enderror"
                            placeholder="••••••••">
                        <button type="button" class="toggle-password" data-target="password_confirmation">
                            <i class="fa-regular fa-eye" id="icon-password_confirmation"></i>
                        </button>
                        @error('password_confirmation')
                            <div class="auth-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-presto w-100">{{ __('passwords.forgot_btn') }}</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
