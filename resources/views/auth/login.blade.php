<x-layout>
    <x-slot:title>{{ __('messages.login') }} — Presto</x-slot:title>

    <div class="row justify-content-center mt-5">
        <div class="col-12 col-sm-9 col-md-6 col-lg-5">

            <div class="auth-card">

                <h1 class="auth-title">{{ __('messages.welcome_back') }}</h1>
                <p class="auth-subtitle">{{ __('messages.login_subtitle') }}</p>


                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="presto-label">{{ __('messages.email') }}</label>
                        <input type="email" id="email" name="email"
                            class="presto-input @error('email') is-invalid @enderror" value="{{ old('email') }}"
                             placeholder="{{ __('messages.email_placeholder') }}">
                        @error('email')
                            <div class="auth-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label for="password" class="presto-label">{{ __('messages.password') }}</label>
                        <input type="password" id="password" name="password"
                            class="presto-input @error('password') is-invalid @enderror"
                            placeholder="••••••••">
                        @error('password')
                            <div class="auth-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Ricordami --}}
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label small text-secondary" for="remember">
                            {{ __('messages.remember_me') }}
                        </label>
                    </div>

                    <button type="submit" class="btn-presto w-100">{{ __('messages.login') }}</button>

                </form>

                <hr class="auth-divider my-4">

                <p class="text-center small mb-0">
                    {{ __('messages.no_account') }}
                    <a href="{{ route('register') }}" class="auth-link">{{ __('messages.register') }}</a>
                </p>

            </div>
        </div>
    </div>

</x-layout>
