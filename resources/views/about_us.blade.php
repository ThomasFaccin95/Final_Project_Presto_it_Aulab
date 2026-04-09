<x-layout>
    <x-slot:title>{{ __('about_us.title') }}</x-slot:title>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                
                {{-- Titolo e Sottotitolo originali --}}
                <h1 class="display-4 fw-bold welcome-title">{{ __('about_us.title') }}</h1>
                <p class="lead mb-5 welcome-subtitle">{{ __('about_us.description') }}</p>
                
                {{-- Nuova Sezione Testo Tradotta --}}
                <div class="text-start bg-white p-4 p-md-5 rounded shadow-sm border mb-4" style="border-color: #E8D5B7 !important;">
                    
                    <p class="lead" style="color: #6B5C52;">
                        {!! __('about_us.paragraph_1') !!}
                    </p>

                    <p style="color: #3D3530; line-height: 1.8;">
                        {!! __('about_us.paragraph_2') !!}
                    </p>

                    <p style="color: #3D3530; line-height: 1.8;">
                        {!! __('about_us.paragraph_3') !!}
                    </p>

                    <p class="mt-4 text-center fs-5" style="color: #B5622E;">
                        {!! __('about_us.closing') !!}
                    </p>

                </div>
                
                {{-- Bottone per tornare alla Home --}}
                <div class="mt-5">
                    <a href="{{ route('homepage') }}" class="btn-presto-outline btn-sm">{{ __('messages.back_home') }}</a>
                </div>

            </div>
        </div>
    </div>
</x-layout>