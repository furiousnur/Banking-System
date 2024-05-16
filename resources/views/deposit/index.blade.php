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
                                <h2>Deposit List</h2>
                            </div>
                            <div class="float-right">
                                <a href="{{ route('deposit.create') }}" class="btn btn-primary">Create Deposit</a>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">User ID</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Type</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($deposits))
                                @foreach($deposits->transactionTypes as $deposit)
                                    <tr>
                                        <th scope="row">{{ Auth::id() }}</th>
                                        <td>{{ $deposit->amount }}</td>
                                        <td>{{ $deposit->transaction_type }}</td>
                                        <td>{{ \Carbon\Carbon::parse($deposit->date)->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">No deposit found</td>
                                </tr>
                            @endif
                            </tbody>
                            <thead>
                            <tr>
                                <th scope="col">User ID</th>
                                <th scope="col">Total: {{$deposits->amount ?? ''}}</th>
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
