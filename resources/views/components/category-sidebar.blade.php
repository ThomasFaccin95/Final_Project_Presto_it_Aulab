<div class="col-12 col-md-3 col-lg-2">
    <div class="sidebar-categories">

        <button class="sidebar-toggle w-100 d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
            data-bs-target="#sidebarLinks" aria-expanded="true" aria-controls="sidebarLinks">
            <span class="sidebar-title">Categorie</span>
            <span class="sidebar-arrow">▲</span>
        </button>

        <div class="collapse show mt-2" id="sidebarLinks">
            <a href="{{ route('article.index') }}" class="sidebar-link {{ !isset($category) ? 'active' : '' }}">
                Tutti gli annunci
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('article.byCategory', $cat) }}"
                    class="sidebar-link {{ isset($category) && $category->id === $cat->id ? 'active' : '' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

    </div>
</div>
