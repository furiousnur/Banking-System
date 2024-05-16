@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-lg-12 margin-tb">
                            <div class="float-left">
                                <h2>Transaction List</h2>
                            </div>
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Type</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($transactions))
                                    @foreach($transactions->transactionTypes as $transaction)
                                        <tr>
                                            <th scope="row">{{ Auth::id() }}</th>
                                            <td>{{ $transaction->amount }}</td>
                                            <td>{{ $transaction->transaction_type }}</td>
                                            <td>{{ \Carbon\Carbon::parse($transaction->date)->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">No withdrawal found</td>
                                    </tr>
                                @endif
                            </tbody>
                            <thead>
                            <tr>
                                <th scope="col">User ID</th>
                                <th scope="col">Total: {{$transactions->amount ?? ''}}</th>
                                <th scope="col">Type</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
