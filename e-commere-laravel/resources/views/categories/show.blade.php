<x-layout title="Show Category">
    <div class="container mt-5">
        <h1 class="mb-4">Category Details</h1>

        <form method="POST" action="{{ route('categories.update', $category) }}">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header">
                    <h2 ondblclick="editField('name')">
                        <span id="name-text">{{ $category->name }}</span>
                        <input type="text" name="name" id="name-input" value="{{ $category->name }}" class="form-control d-none">
                    </h2>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="h5">ID: {{ $category->id }}</label>
                    </div>

                    <div class="mb-3">
                        <label class="h5">Description:</label>
                        <p id="description-text" ondblclick="editField('description')">{{ $category->description ?? 'No description provided.' }}</p>
                        <textarea name="description" id="description-input" class="form-control d-none">{{ $category->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="h5">Created At:</label>
                        <div>{{ $category->created_at->format('Y-m-d H:i') }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="h5">Updated At:</label>
                        <div>{{ $category->updated_at->format('Y-m-d H:i') }}</div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-start gap-2">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </div>
        </form>

        <form method="POST" action="{{ route('categories.destroy', $category) }}" class="mt-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this categories?')">Delete Category</button>
        </form>
    </div>

    @push('scripts')
        <script>
            let escapeCount = 0;
            let escapeTimer;

            function editField(field) {
                const textEl = document.getElementById(field + '-text');
                const inputEl = document.getElementById(field + '-input');

                if (!textEl || !inputEl) return;

                textEl.classList.add('d-none');
                inputEl.classList.remove('d-none');
                inputEl.focus();

                function handleKeyDown(e) {
                    if (e.key === 'Escape') {
                        escapeCount++;

                        if (escapeCount === 1) {
                            inputEl.classList.add('d-none');
                            textEl.classList.remove('d-none');
                        }

                        if (escapeCount === 2) {
                            const inputs = document.querySelectorAll('input, textarea');
                            const spans = document.querySelectorAll('span[id$="-text"], p[id$="-text"]');

                            inputs.forEach(el => el.classList.add('d-none'));
                            spans.forEach(el => el.classList.remove('d-none'));

                            escapeCount = 0;
                            clearTimeout(escapeTimer);
                        }

                        clearTimeout(escapeTimer);
                        escapeTimer = setTimeout(() => {
                            escapeCount = 0;
                        }, 1000);
                    }
                }

                inputEl.addEventListener('keydown', handleKeyDown);
            }
        </script>
    @endpush
</x-layout>
