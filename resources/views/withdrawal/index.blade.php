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
                @if (session('errors'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('errors') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-lg-12 margin-tb">
                            <div class="float-left">
                                <h2>Withdrawal List</h2>
                            </div>
                            <div class="float-right">
                                <a href="{{ route('withdrawal.create') }}" class="btn btn-primary">Create Withdrawal</a>
                            </div>
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">User ID</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Fee</th>
                                <th scope="col">Type</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($withdrawals))
                                @foreach($withdrawals->transactionTypes as $withdrawal)
                                    <tr>
                                        <th scope="row">{{ Auth::id() }}</th>
                                        <td>{{ $withdrawal->amount }}</td>
                                        <td>{{ $withdrawal->fee }}</td>
                                        <td>{{ $withdrawal->transaction_type }}</td>
                                        <td>{{ \Carbon\Carbon::parse($withdrawal->date)->format('Y-m-d') }}</td>
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
                                <th scope="col">Total: {{$withdrawals->transactionTypes->sum('amount') ?? ''}}</th>
                                <th scope="col">Total Fee: {{$withdrawals->transactionTypes->sum('fee') ?? ''}}</th>
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
