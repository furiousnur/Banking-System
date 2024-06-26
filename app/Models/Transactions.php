<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_type',
        'amount',
        'fee',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionTypes()
    {
        return $this->hasMany(TransactionType::class);
    }
}
