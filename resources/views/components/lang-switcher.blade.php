@php
    $flags = [
        'it' => 'https://flagcdn.com/w40/it.png',
        'en' => 'https://flagcdn.com/w40/gb.png',
        'es' => 'https://flagcdn.com/w40/es.png',
    ];
    $labels = [
        'it' => 'Italiano',
        'en' => 'English',
        'es' => 'Español',
    ];
    $current = app()->getLocale();
@endphp

<div class="dropdown">
    {{-- Bottone con bandiera corrente --}}
    <button class="lang-dropdown-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="{{ $flags[$current] }}" alt="{{ strtoupper($current) }}" class="lang-flag">
        {{ strtoupper($current) }}
    </button>

    {{-- Menu con tutte le lingue --}}
    <ul class="dropdown-menu dropdown-menu-end lang-dropdown-menu">
        @foreach ($flags as $locale => $flag)
            <li>
                <a href="{{ route('lang.switch', $locale) }}"
                    class="dropdown-item lang-dropdown-item {{ $current === $locale ? 'active' : '' }}">
                    <img src="{{ $flag }}" alt="{{ strtoupper($locale) }}" class="lang-flag">
                    {{ $labels[$locale] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
