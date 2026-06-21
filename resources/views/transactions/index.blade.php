<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transactions</h2>
    </x-slot>

    <div class="py-4">
        <div class="container-xl">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Filters --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('transactions.index') }}" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Type</label>
                            <select name="type" class="form-select form-select-sm">
                                <option value="">All Types</option>
                                <option value="income"  {{ request('type') === 'income'  ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Expense</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Category</label>
                            <select name="category_id" class="form-select form-select-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }} ({{ $cat->type }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold">From</label>
                            <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold">To</label>
                            <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-sm btn-primary w-100">
                                <i class="bi bi-search me-1"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Table --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">{{ $transactions->total() }} transactions</span>
                    <a href="{{ route('transactions.create') }}" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Add New
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th class="text-end">Amount</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $t)
                                <tr>
                                    <td class="text-muted small align-middle">{{ $t->date->format('d M Y') }}</td>
                                    <td class="align-middle">
                                        <span class="badge" style="background-color: {{ $t->category->color }}">
                                            {{ $t->category->name }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        @if($t->category->type === 'income')
                                            <span class="badge bg-success-subtle text-success">Income</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Expense</span>
                                        @endif
                                    </td>
                                    <td class="text-muted align-middle">{{ $t->description ?? '—' }}</td>
                                    <td class="text-end fw-semibold align-middle {{ $t->category->type === 'income' ? 'text-success' : 'text-danger' }}">
                                        {{ $t->category->type === 'income' ? '+' : '-' }}{{ number_format($t->amount, 2) }} €
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('transactions.edit', $t) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('transactions.destroy', $t) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this transaction?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No transactions found. <a href="{{ route('transactions.create') }}">Add one!</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($transactions->hasPages())
                    <div class="card-footer bg-transparent">
                        {{ $transactions->withQueryString()->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
