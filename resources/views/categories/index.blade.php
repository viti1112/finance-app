<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Categories (Classifier)
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container-xl">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">All Categories</h4>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> New Category
                </a>
            </div>

            <div class="row g-4">
                {{-- Income --}}
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-success text-white fw-semibold">
                            <i class="bi bi-arrow-up-circle me-2"></i>Income Categories
                        </div>
                        <div class="list-group list-group-flush">
                            @foreach($categories->where('type', 'income') as $cat)
                                <div class="list-group-item d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="rounded-circle d-inline-block" style="width:16px;height:16px;background:{{ $cat->color }}"></span>
                                        <span>{{ $cat->name }}</span>
                                        <span class="badge bg-secondary">{{ $cat->transactions_count ?? $cat->transactions()->count() }} txns</span>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('categories.edit', $cat) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                            @if($categories->where('type', 'income')->isEmpty())
                                <div class="list-group-item text-muted text-center py-3">No income categories yet.</div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Expense --}}
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-danger text-white fw-semibold">
                            <i class="bi bi-arrow-down-circle me-2"></i>Expense Categories
                        </div>
                        <div class="list-group list-group-flush">
                            @foreach($categories->where('type', 'expense') as $cat)
                                <div class="list-group-item d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="rounded-circle d-inline-block" style="width:16px;height:16px;background:{{ $cat->color }}"></span>
                                        <span>{{ $cat->name }}</span>
                                        <span class="badge bg-secondary">{{ $cat->transactions()->count() }} txns</span>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('categories.edit', $cat) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                            @if($categories->where('type', 'expense')->isEmpty())
                                <div class="list-group-item text-muted text-center py-3">No expense categories yet.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
