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
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('POST')

                            <input type="hidden" name="token" value="{{ $token }}">

                            <label for="email" class="col-form-label pt-4">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control fc @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror


                            <label for="password" class="col-form-label pt-4">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control fc @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                            <label for="password-confirm" class="col-form-label pt-4">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control fc" name="password_confirmation" required autocomplete="new-password">

                            <br><br>
                            <button type="submit" class="button-84 form-control">{{ __('Reset Password') }}</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

