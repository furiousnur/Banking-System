<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'transactions_id',
        'transaction_type',
        'amount',
        'fee',
        'date',
    ];

    public function scopeWithdrawal($query)
    {
        return $query->where('transaction_type', 'Withdrawal');
    }

    public function scopeDeposit($query)
    {
        return $query->where('transaction_type', 'Deposit');
    }
}
