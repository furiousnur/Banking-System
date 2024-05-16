<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deposits = Transactions::with(['transactionTypes' => function ($query) {
            $query->deposit();
        }])->where('user_id', Auth::id())->latest()->first();
        return view('deposit.index', compact('deposits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('deposit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
        ]);
        $deposit = Transactions::firstOrCreate(
            [
                'user_id' => $request->user_id,
                'transaction_type' => 'Deposit',
            ],
            [
                'amount' => 0,
                'date' => now(),
            ]
        );
        $deposit->increment('amount', $request->amount);
        $deposit->transactionTypes()->create([
            'transaction_type' => 'Deposit',
            'amount' => $request->amount,
            'date' => now(),
        ]);

        return redirect()->route('deposit.index')->with('success', 'Deposit successful!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
