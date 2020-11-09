@extends('layouts.app')

    @section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <h4 style="text-align: center; color: #000d1a; font-weight: bold;" class="pt-3">Create Expense Entry</h4>
                        <div class="card-body">
                            <form method="POST" action="/entry">
                                @csrf

                                <div class="form-group row">
                                    <label for="amount" class="col-md-4 col-form-label font-weight-bold text-md-right">
                                        {{ __('Amount') }} : </label>

                                    <div class="col-md-6">
                                        <input id="amount" type="number" max="-1" class="form-control @error('amount') is-invalid @enderror"
                                               name="amount" value="{{ old('amount') }}" required autocomplete="amount" autofocus>
                                        <span><em>Input should be started with a negative(-) sign</em></span>
                                        @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="code" class="col-md-4 col-form-label font-weight-bold text-md-right">
                                        {{ __('Currency Code') }} : </label>

                                    <div class="col-md-6">
                                        <input id="code" type="text" class="form-control @error('code') is-invalid
                                    @enderror" name="code" required autocomplete="current-code">
                                        <span><em>Format required: USD, EUR etc</em></span>

                                        @error('code')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="account" class="col-md-4 col-form-label font-weight-bold text-md-right">
                                        {{ __('Account ID') }} : </label>

                                    <div class="col-md-6">
                                        <input id="account" type="number" class="form-control @error('account') is-invalid
                                    @enderror" name="account" required autocomplete="current-account">

                                        @error('account')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="category" class="col-md-4 col-form-label font-weight-bold text-md-right">
                                        {{ __('Category ID') }} : </label>

                                    <div class="col-md-6">
                                        <input id="category" type="number" class="form-control @error('category') is-invalid
                                    @enderror" name="category" required autocomplete="current-category">

                                        @error('category')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Create') }} <i class="fas fa-sign-in-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endsection
