{{-- Shared form fields for Category create/edit --}}

<div class="mb-3">
    <label class="form-label fw-semibold">Name</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $category->name ?? '') }}" placeholder="e.g. Salary, Food..." required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Type</label>
    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
        <option value="">-- Select type --</option>
        <option value="income"  {{ old('type', $category->type ?? '') === 'income'  ? 'selected' : '' }}>Income</option>
        <option value="expense" {{ old('type', $category->type ?? '') === 'expense' ? 'selected' : '' }}>Expense</option>
    </select>
    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Color</label>
    <div class="d-flex align-items-center gap-3">
        <input type="color" name="color" class="form-control form-control-color"
               value="{{ old('color', $category->color ?? '#6c757d') }}" style="width:60px;height:40px">
        <span class="text-muted small">Choose a color to identify this category</span>
    </div>
    @error('color') <div class="text-danger small">{{ $message }}</div> @enderror
</div>
