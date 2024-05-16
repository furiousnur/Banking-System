<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $withdrawals = Transactions::with(['transactionTypes' => function ($query) {
            $query->withdrawal();
        }])->where('user_id', Auth::id())->latest()->first();

        return view('withdrawal.index', compact('withdrawals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('withdrawal.create');
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
        DB::transaction(function () use ($request) {
            $user = Auth::user();
            $isIndividual = $user->account_type === 'Individual';
            $isFriday = now()->dayOfWeek === 5;
            if ($isIndividual) {
                $withdrawalRate = $isIndividual ? 0.015 : 0.025;
                $totalWithdrawalAmount = $request->amount;
                $withdrawals = Transactions::with(['transactionTypes' => function ($query) {
                    $query->withdrawal();
                }])->where('user_id', Auth::id())->latest()->first();
                $isFreeThisMonth = $withdrawals ? $withdrawals->transactionTypes->sum('amount') <= 5000 : false;
                $withdrawalFee = ($isFreeThisMonth || $isFriday) ? 0 :
                    abs($totalWithdrawalAmount - 1000) * $withdrawalRate;
                $deposit = Transactions::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'transaction_type' => 'Deposit',
                    ],
                    [
                        'amount' => 0,
                        'date' => now(),
                    ]
                );
                if ($deposit->amount === 0) {
                    return redirect()->route('withdrawal.index')->with('errors', 'No previous deposit found for this user.');
                }
                $amountWithFee = $totalWithdrawalAmount + $withdrawalFee;
                if ($deposit->amount < $amountWithFee) {
                    return redirect()->route('withdrawal.index')->with('errors', 'Your withdrawal amount plus withdrawal fee is greater than your deposit amount.');
                }
                $deposit->decrement('amount', $amountWithFee);
            } else {
                $totalWithdrawalAmount = Transactions::where('user_id', $user->id)
                    ->where('transaction_type', 'Withdrawal')
                    ->sum('amount');
                $withdrawalRate = ($user->account_type === 'Business' && $totalWithdrawalAmount > 50000) ? 0.015 : 0.025;
                $withdrawalFee = $request->amount * $withdrawalRate;
                $deposit = Transactions::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'transaction_type' => 'Deposit',
                    ],
                    [
                        'amount' => 0,
                        'date' => now(),
                    ]
                );

                if ($deposit->amount < $request->amount + $withdrawalFee) {
                    return redirect()->route('withdrawal.index')->with('errors', 'Insufficient funds for withdrawal.');
                }

                $deposit->decrement('amount', $request->amount + $withdrawalFee);
            }
            $deposit->date = now();
            $deposit->transactionTypes()->create([
                'transaction_type' => 'Withdrawal',
                'amount' => $request->amount,
                'fee' => $withdrawalFee,
                'date' => now(),
            ]);
        });
        return redirect()->route('withdrawal.index')->with('success', 'Withdrawal successful!');
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
