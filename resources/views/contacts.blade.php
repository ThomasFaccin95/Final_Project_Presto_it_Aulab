<x-layout>
    <x-slot:title>{{ __('contacts.title') }}</x-slot:title>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-7 text-center">
                <h1 class="display-4 fw-bold welcome-title">{{ __('contacts.title') }}</h1>

                <p class="lead m-4 mb-2 welcome-subtitle">{{ __('contacts.description_1') }}</p>
                <p class="lead mb-4 welcome-subtitle">{{ __('contacts.description_2') }}</p>

                @if (session('success'))
                    <div id="flash-message" class="alert-success-presto mb-4">{{ session('success') }}</div>
                @endif

                <div class="auth-card">

                    <form method="POST" action="{{ route('contacts.send') }}">
                        @csrf

                        {{-- Nome: autocompilato e bloccato se loggato, scrivibile se ospite --}}
                        <div class="mb-3 text-start">
                            <label for="name" class="presto-label">{{ __('messages.full_name') }}</label>
                            <input type="text" id="name" name="name"
                                class="presto-input @error('name') is-invalid @enderror"
                                value="{{ auth()->check() ? auth()->user()->name : old('name') }}"
                                {{ auth()->check() ? 'readonly' : '' }}>
                            @error('name')
                                <div class="auth-error">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email: autocompilata e bloccata se loggato, scrivibile se ospite --}}
                        <div class="mb-3 text-start">
                            <label for="email" class="presto-label">{{ __('messages.email') }}</label>
                            <input type="email" id="email" name="email"
                                class="presto-input @error('email') is-invalid @enderror"
                                value="{{ auth()->check() ? auth()->user()->email : old('email') }}"
                                {{ auth()->check() ? 'readonly' : '' }}>
                            @error('email')
                                <div class="auth-error">{{ $message }}</div>
                            @enderror
                        </div>


                        {{--  Messaggio --}}
                        <div class="mb-4 text-start">
                            <label for="message" class="presto-label">
                                {{ __('contacts.message.title') }}
                            </label>
                            <textarea id="contacts" name="contacts" class="presto-input @error('contacts') is-invalid @enderror" rows="5"
                                placeholder="{{ __('contacts.message.placeholder') }}">{{ old('contacts') }}</textarea>
                            @error('contacts')
                                <div class="auth-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-presto w-50">
                            {{ __('contacts.send_application') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
