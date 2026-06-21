<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'category_id', 'amount', 'description', 'date'];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeIncome($query)
    {
        return $query->whereHas('category', fn($q) => $q->where('type', 'income'));
    }

    public function scopeExpense($query)
    {
        return $query->whereHas('category', fn($q) => $q->where('type', 'expense'));
    }

    public function scopeForPeriod($query, $from, $to)
    {
        return $query->whereBetween('date', [$from, $to]);
    }
}
