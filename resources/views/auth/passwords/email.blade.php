@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg bg-dark">
                    <div class="card-header bg-black">
                        <img src="{{ URL('app_images/logo-3.png') }}" style="width: 20px" alt="" >
                        {{ __('Reset Password') }}
                    </div>

                    <div class="card-body bg-light">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <label for="email" class="col-form-label pt-4">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control fc @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                            <br><br>
                            <button type="submit" class="button-84 form-control">{{ __('Send Password Reset Link') }}</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
