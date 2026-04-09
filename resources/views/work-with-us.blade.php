<x-layout>
    <x-slot:title>{{ __('messages.work_with_us_title') }} — Presto</x-slot:title>

    <div class="row justify-content-center mt-5">
        <div class="col-12 col-md-8 col-lg-6">

            <h1 class="auth-title mb-1">{{ __('messages.work_with_us_title') }}</h1>
            <p class="auth-subtitle">{{ __('messages.work_with_us_subtitle') }}</p>

            @if (session('success'))
                <div id="flash-message" class="alert-success-presto mb-4">{{ session('success') }}</div>
            @endif

            @auth
                <div class="auth-card">
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

                        {{-- Motivazione libera --}}
                        <div class="mb-4">
                            <label for="motivation" class="presto-label">
                                {{ __('messages.motivation_label') }}
                            </label>
                            <textarea id="motivation" name="motivation" class="presto-input @error('motivation') is-invalid @enderror"
                                rows="5" placeholder="{{ __('messages.motivation_placeholder') }}">{{ old('motivation') }}</textarea>
                            @error('motivation')
                                <div class="auth-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn-presto w-50">
                                {{ __('messages.send_application') }}
                            </button>
                        </div>

                    </form>
                </div>
            @endauth

            @guest
                <div class="auth-card text-center">
                    <p class="welcome-subtitle mb-4">{{ __('messages.login_required') }}</p>
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('register') }}" class="btn-presto">{{ __('messages.register') }}</a>
                        <a href="{{ route('login') }}" class="btn-presto-outline">{{ __('messages.login') }}</a>
                    </div>
                </div>
            @endguest

        </div>
    </div>

</x-layout>
