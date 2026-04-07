<x-layout>
    <x-slot:title>{{ __('messages.register') }} — Presto</x-slot:title>

    <div class="row justify-content-center mt-5">
        <div class="col-12 col-sm-9 col-md-6 col-lg-5">

            <div class="auth-card">

                <h1 class="auth-title">{{ __('messages.create_account') }}</h1>
                <p class="auth-subtitle">{{ __('messages.join_presto') }}</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nome --}}
                    <div class="mb-3">
                        <label for="name" class="presto-label">{{ __('messages.full_name') }}</label>
                        <input type="text" id="name" name="name"
                            class="presto-input @error('name') is-invalid @enderror" value="{{ old('name') }}"
                             placeholder="{{ __('messages.name_placeholder') }}"> 
                        @error('name')
                            <div class="auth-error">{{ $message }}</div>
                        @enderror
                    </div>

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
                    <div class="mb-3">
                        <label for="password" class="presto-label">{{ __('messages.password') }}</label>
                        <input type="password" id="password" name="password"
                            class="presto-input @error('password') is-invalid @enderror" placeholder="••••••••">
                        @error('password')
                            <div class="auth-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Conferma password --}}
                    <div class="mb-4">
                        <label for="password_confirmation"
                            class="presto-label">{{ __('messages.confirm_password') }}</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="presto-input @error('password') is-invalid @enderror" 
                             placeholder="••••••••">
                             @error('password_confirmation')
                            <div class="auth-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-presto w-100">{{ __('messages.create_account') }}</button>

                </form>

                <hr class="auth-divider my-4">

                <p class="text-center small mb-0 auth-subtitle">
                    {{ __('messages.already_account') }}
                    <a href="{{ route('login') }}" class="auth-link">{{ __('messages.login') }}</a>
                </p>

            </div>
        </div>
    </div>

</x-layout>
