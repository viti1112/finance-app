{{-- Shared transaction form fields --}}

<div class="mb-3">
    <label class="form-label fw-semibold">Category</label>
    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
        <option value="">-- Select Category --</option>
        @php
            $incomeCategories  = $categories->where('type', 'income');
            $expenseCategories = $categories->where('type', 'expense');
        @endphp
        @if($incomeCategories->isNotEmpty())
            <optgroup label="Income">
                @foreach($incomeCategories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $transaction->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </optgroup>
        @endif
        @if($expenseCategories->isNotEmpty())
            <optgroup label="Expense">
                @foreach($expenseCategories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $transaction->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </optgroup>
        @endif
    </select>
    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    @if($categories->isEmpty())
        <p class="text-warning small mt-1">No categories yet. <a href="{{ route('categories.create') }}">Create one first.</a></p>
    @endif
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Amount (€)</label>
    <div class="input-group">
        <span class="input-group-text">€</span>
        <input type="number" name="amount" step="0.01" min="0.01"
               class="form-control @error('amount') is-invalid @enderror"
               value="{{ old('amount', $transaction->amount ?? '') }}"
               placeholder="0.00" required>
        @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Date</label>
    <input type="date" name="date"
           class="form-control @error('date') is-invalid @enderror"
           value="{{ old('date', isset($transaction) ? $transaction->date->format('Y-m-d') : now()->toDateString()) }}"
           required>
    @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Description <span class="text-muted fw-normal">(optional)</span></label>
    <input type="text" name="description"
           class="form-control @error('description') is-invalid @enderror"
           value="{{ old('description', $transaction->description ?? '') }}"
           placeholder="e.g. Weekly groceries">
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
