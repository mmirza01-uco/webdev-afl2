<x-template title="{{ $article->title }}">
    <a href="{{ route('articles.index') }}" class="text-muted">← Kembali ke daftar</a>

    <article class="my-4">
        <span class="badge bg-secondary mb-2">{{ $article->category->name }}</span>
        <h1>{{ $article->title }}</h1>
        <p class="text-muted">{{ $article->created_at->format('d M Y') }}</p>
        <div>{!! nl2br(e($article->content)) !!}</div>
    </article>

    <hr>

    <h3 class="mb-3">Komentar ({{ count($article->comments) }})</h3>

    @foreach ($article->comments as $comment)
        <div class="card mb-3" id="comment-{{ $comment->id }}">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">
                    {{ $comment->name }}
                    <small>— {{ $comment->created_at->format('d M Y H:i') }}</small>

                    @if ($comment->updated_at->gt($comment->created_at))
                        <small class="text-warning">
                            (diedit pada {{ $comment->updated_at->format('d M Y H:i') }})
                        </small>
                    @endif
                </h6>

                <div id="display-{{ $comment->id }}">
                    <p class="card-text">{{ $comment->content }}</p>

                    <div class="d-flex gap-2">
                        <button type="button"
                                class="btn btn-sm btn-warning"
                                onclick="toggleEdit({{ $comment->id }})">
                            Edit
                        </button>

                        <form method="POST"
                              action="{{ route('comments.destroy', $comment->id) }}"
                              onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>

                <div id="edit-{{ $comment->id }}" style="display: none;">
                    <form method="POST" action="{{ route('comments.update', $comment->id) }}">
                        @csrf
                        <div class="mb-2">
                            <textarea name="content"
                                      class="form-control"
                                      rows="3"
                                      required>{{ $comment->content }}</textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            <button type="button"
                                    class="btn btn-sm btn-secondary"
                                    onclick="toggleEdit({{ $comment->id }})">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function toggleEdit(id) {
            const display = document.getElementById('display-' + id);
            const edit    = document.getElementById('edit-' + id);

            if (edit.style.display === 'none') {
                display.style.display = 'none';
                edit.style.display = 'block';
            } else {
                display.style.display = 'block';
                edit.style.display = 'none';
            }
        }
    </script>
</x-template>