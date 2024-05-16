@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Withdrawal</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('withdrawal.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="user_id" class="col-md-4 col-form-label text-md-right">User ID</label>
                            <div class="col-md-6">
                                <input id="user_id" type="text" readonly
                                       class="form-control @error('user_id') is-invalid @enderror"
                                       name="user_id" value="{{ Auth::user()->id }}-({{Auth::user()->name}})">
                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">Amount</label>
                            <div class="col-md-6">
                                <input id="amount" type="number"
                                       class="form-control @error('amount') is-invalid @enderror"
                                       placeholder="Amount" name="amount" value="{{ old('amount') }}"
                                       autocomplete="amount">
                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
