<div>
    <form wire:submit="store">

        {{-- Titolo --}}
        <div class="mb-3">
            <label for="title" class="presto-label">{{ __('messages.title') }}</label>
            <input type="text" id="title" wire:model="title"
                class="presto-input @error('title') is-invalid @enderror"
                placeholder="{{ __('messages.title_placeholder') }}">
            @error('title')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Categoria --}}
        <div class="mb-3">
            <label for="category_id" class="presto-label">{{ __('messages.category') }}</label>
            <select id="category_id" wire:model="category_id"
                class="presto-input @error('category_id') is-invalid @enderror">
                <option value="0">{{ __('messages.select_category') }}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->translated_name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Prezzo --}}
        <div class="mb-3">
            <label for="price" class="presto-label">{{ __('messages.price') }}</label>
            <input type="number" id="price" wire:model="price"
                class="presto-input @error('price') is-invalid @enderror" placeholder="Es. 49.99" min="0"
                step="0.01">
            @error('price')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Descrizione --}}
        <div class="mb-3">
            <label for="description" class="presto-label">{{ __('messages.description') }}</label>
            <textarea id="description" wire:model="description" class="presto-input @error('description') is-invalid @enderror"
                rows="4" placeholder="{{ __('messages.description_placeholder') }}"></textarea>
            @error('description')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Upload immagini --}}
        <div class="mb-4">
            <label class="presto-label">{{ __('messages.images') }}</label>

            {{-- Input file multiplo --}}
            <input type="file" wire:model="images" class="presto-input @error('images.*') is-invalid @enderror"
                multiple accept="image/*">
            @error('images.*')
                <div class="auth-error">{{ $message }}</div>
            @enderror

            {{-- Indicatore caricamento Livewire --}}
            <div wire:loading wire:target="images" class="auth-error mt-2">
                Caricamento immagini...
            </div>

            {{-- Anteprima immagini caricate --}}
            @if (count($images) > 0)
                <div class="image-preview-grid mt-3">
                    @foreach ($images as $index => $image)
                        <div class="image-preview-item">
                            <img src="{{ $image->temporaryUrl() }}" alt="Anteprima {{ $index + 1 }}"
                                class="image-preview-thumb">
                            {{-- Bottone rimozione singola immagine --}}
                            <button type="button" wire:click="removeImage({{ $index }})"
                                class="image-preview-remove">
                                ✕
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <button type="submit" class="btn-presto w-100">{{ __('messages.insert_article_btn') }}</button>

    </form>
</div>
