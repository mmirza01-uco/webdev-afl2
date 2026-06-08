<x-template title="Daftar Artikel">
    <h1 class="mb-4">Daftar Artikel</h1>

    <form method="GET" action="{{ route('articles.index') }}" class="row g-2 mb-4">
        <div class="col-md-7">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Cari berdasarkan judul atau isi artikel..."
                   value="{{ $search ?? '' }}">
        </div>

        <div class="col-md-3">
            <select name="sort" class="form-select">
                <option value="asc"  {{ ($sort ?? 'asc') === 'asc'  ? 'selected' : '' }}>Nama A-Z</option>
                <option value="desc" {{ ($sort ?? 'asc') === 'desc' ? 'selected' : '' }}>Nama Z-A</option>
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Cari</button>
        </div>
    </form>

    @if(request('search'))
        <p class="text-muted">
            Hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
            — {{ count($articles) }} artikel ditemukan.
        </p>
    @endif

    @if (count($articles) === 0)
        <p class="text-muted">Tidak ada artikel yang cocok.</p>
    @else
        <div class="row">
            @foreach ($articles as $article)
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <span class="badge bg-secondary mb-2">
                                {{ $article->category->name }}
                            </span>
                            <h5 class="card-title">
                                <a href="{{ route('articles.show', $article->slug) }}"
                                   class="text-decoration-none">
                                    {{ $article->title }}
                                </a>
                            </h5>
                            <p class="card-text text-muted">
                                {{ Str::limit($article->content, 120) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-template>