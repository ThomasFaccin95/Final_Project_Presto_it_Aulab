<x-layout>

    <x-slot:title>{{ __('messages.checkout_title') }} — Presto</x-slot:title>

    <div class="form-check d-flex justify-content-center">
    <input class="form-check-input item-checkbox border-secondary" 
           type="checkbox" 
           value="{{ $item->id }}" 
           id="checkbox_{{ $item->id }}"
           data-price="{{ $item->price }}"
           data-quantity="{{ $item->quantity }}"
           style="transform: scale(1.5); cursor: pointer;">
</div>


</x-layout>