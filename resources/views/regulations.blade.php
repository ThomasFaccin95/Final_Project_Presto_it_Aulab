<x-layout>
    <x-slot:title>{{ __('regulations.title') }}</x-slot:title>

    <div class="row justify-content-center">
        <div class="col-12 col-md-8">

            <h1 class="fw-bold mb-2">{{ __('regulations.title') }}</h1>
            <p class="text-muted mb-5">{{ __('regulations.subtitle') }} - {{ date('Y') }}</p>

            <h4 class="fw-bold mt-4 mb-3">{{ __('regulations.intro_title') }}</h4>
            <p>{{ __('regulations.intro_desc') }}</p>

            <h4 class="fw-bold mt-4 mb-3">{{ __('regulations.role_title') }}</h4>
            <p>{{ __('regulations.role_desc') }}</p>

            <h4 class="fw-bold mt-4 mb-3">{{ __('regulations.vision_title') }}</h4>
            <p>{{ __('regulations.vision_desc') }}</p>
            <ul>
                <li class="mb-2">{{ __('regulations.vision_faces') }}</li>
                <li class="mb-2">{{ __('regulations.vision_labels') }}</li>
            </ul>

            <h4 class="fw-bold mt-4 mb-3">{{ __('regulations.approve_title') }}</h4>
            <p>{{ __('regulations.approve_desc') }}</p>
            <ul>
                <li class="mb-2">{{ __('regulations.approve_1') }}</li>
                <li class="mb-2">{{ __('regulations.approve_2') }}</li>
                <li class="mb-2">{{ __('regulations.approve_3') }}</li>
                <li class="mb-2">{{ __('regulations.approve_4') }}</li>
            </ul>

            <h4 class="fw-bold mt-4 mb-3">{{ __('regulations.reject_title') }}</h4>
            <p>{{ __('regulations.reject_desc') }}</p>
            <ul>
                <li class="mb-2">{{ __('regulations.reject_1') }}</li>
                <li class="mb-2">{{ __('regulations.reject_2') }}</li>
                <li class="mb-2">{{ __('regulations.reject_3') }}</li>
                <li class="mb-2">{{ __('regulations.reject_4') }}</li>
            </ul>

            <h4 class="fw-bold mt-4 mb-3">{{ __('regulations.privacy_title') }}</h4>
            <p>{{ __('regulations.privacy_desc') }}</p>

            <h4 class="fw-bold mt-4 mb-3">{{ __('regulations.sanctions_title') }}</h4>
            <p>{{ __('regulations.sanctions_desc') }}</p>

            <div class="mt-5">
                <a href="{{ route('homepage') }}" class="btn-presto-outline btn-sm">{{ __('messages.back_home') }}</a>
            </div>

        </div>
    </div>
</x-layout>
