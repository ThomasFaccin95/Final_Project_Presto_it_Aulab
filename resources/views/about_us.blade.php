<x-layout>
        <x-slot:title>{{ __('about_us.title') }}</x-slot:title>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
               <h1 class="display-4 fw-bold welcome-title">{{ __('about_us.title') }}</h1>
                
                 <p class="lead mb-4 welcome-subtitle">{{ __('about_us.description') }}</p>
                
                <div class="mt-5">
                    <a href="{{ route('homepage') }}" class="btn-presto-outline btn-sm">{{ __('messages.back_home') }}</a>
                </div>
            </div>


        </div>
    </div>
</x-layout>