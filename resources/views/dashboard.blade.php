<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard — Personal Finance
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container-xl">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Balance Cards --}}
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #28a745 !important;">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 small">Total Balance</p>
                                    <h3 class="mb-0 fw-bold {{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($balance, 2) }} €
                                    </h3>
                                </div>
                                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-wallet2 fs-3 text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #17a2b8 !important;">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 small">Total Income</p>
                                    <h3 class="mb-0 fw-bold text-info">
                                        +{{ number_format($totalIncome, 2) }} €
                                    </h3>
                                </div>
                                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-arrow-up-circle fs-3 text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #dc3545 !important;">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 small">Total Expenses</p>
                                    <h3 class="mb-0 fw-bold text-danger">
                                        -{{ number_format($totalExpense, 2) }} €
                                    </h3>
                                </div>
                                <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-arrow-down-circle fs-3 text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- This Month --}}
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent fw-semibold">
                            <i class="bi bi-calendar-month me-2 text-primary"></i>This Month
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Income:</span>
                                <span class="text-success fw-semibold">+{{ number_format($monthIncome, 2) }} €</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Expenses:</span>
                                <span class="text-danger fw-semibold">-{{ number_format($monthExpense, 2) }} €</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="fw-semibold">Net:</span>
                                <span class="fw-bold {{ ($monthIncome - $monthExpense) >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($monthIncome - $monthExpense, 2) }} €
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent fw-semibold">
                            <i class="bi bi-lightning me-2 text-warning"></i>Quick Actions
                        </div>
                        <div class="card-body d-flex flex-column gap-2">
                            <a href="{{ route('transactions.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle me-2"></i>Add Transaction
                            </a>
                            <a href="{{ route('categories.create') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-tag me-2"></i>Add Category
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Transactions --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent fw-semibold d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-clock-history me-2 text-secondary"></i>Recent Transactions</span>
                    <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
                </div>
                <div class="card-body p-0">
                    @if($recentTransactions->isEmpty())
                        <p class="text-center text-muted py-4">No transactions yet. <a href="{{ route('transactions.create') }}">Add one!</a></p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $t)
                                        <tr>
                                            <td class="text-muted small">{{ $t->date->format('d M Y') }}</td>
                                            <td>
                                                <span class="badge" style="background-color: {{ $t->category->color }}">
                                                    {{ $t->category->name }}
                                                </span>
                                            </td>
                                            <td class="text-muted">{{ $t->description ?? '—' }}</td>
                                            <td class="text-end fw-semibold {{ $t->category->type === 'income' ? 'text-success' : 'text-danger' }}">
                                                {{ $t->category->type === 'income' ? '+' : '-' }}{{ number_format($t->amount, 2) }} €
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
