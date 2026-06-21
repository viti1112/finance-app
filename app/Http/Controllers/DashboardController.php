<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalIncome = $user->transactions()
            ->income()
            ->sum('amount');

        $totalExpense = $user->transactions()
            ->expense()
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        $recentTransactions = $user->transactions()
            ->with('category')
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $currentMonth = now()->format('Y-m');
        $monthIncome = $user->transactions()
            ->income()
            ->whereRaw("strftime('%Y-%m', date) = ?", [$currentMonth])
            ->sum('amount');

        $monthExpense = $user->transactions()
            ->expense()
            ->whereRaw("strftime('%Y-%m', date) = ?", [$currentMonth])
            ->sum('amount');

        return view('dashboard', compact(
            'totalIncome',
            'totalExpense',
            'balance',
            'recentTransactions',
            'monthIncome',
            'monthExpense'
        ));
    }
}
