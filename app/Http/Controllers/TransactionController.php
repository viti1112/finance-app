<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->transactions()->with('category');

        if ($request->filled('type')) {
            $type = $request->type;
            $query->whereHas('category', fn($q) => $q->where('type', $type));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        $transactions = $query->orderByDesc('date')->orderByDesc('created_at')->paginate(15);
        $categories = Auth::user()->categories()->orderBy('type')->orderBy('name')->get();

        return view('transactions.index', compact('transactions', 'categories'));
    }

    public function create()
    {
        $categories = Auth::user()->categories()->orderBy('type')->orderBy('name')->get();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount'      => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'date'        => 'required|date',
        ]);

        $category = Auth::user()->categories()->findOrFail($validated['category_id']);
        Auth::user()->transactions()->create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction added successfully.');
    }

    public function edit(Transaction $transaction)
    {
        $this->authorize('update', $transaction);
        $categories = Auth::user()->categories()->orderBy('type')->orderBy('name')->get();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount'      => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'date'        => 'required|date',
        ]);

        Auth::user()->categories()->findOrFail($validated['category_id']);
        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}
