@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg bg-dark">
                    <div class="card-header bg-black">
                        <img src="{{ URL('app_images/logo-3.png') }}" style="width: 20px" alt="" >
                        {{ __('Confirm Password') }}
                    </div>

                    <div class="card-body bg-light">
                        {{ __('Please confirm your password before continuing.') }}

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <label for="password" class="col-form-label pt-4">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control fc @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror


                            <div class="row justify-content-end pt-4 pb-4">
                                <div class="form-check" style="width:180px;padding-left: 35px">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="button-84 form-control">{{ __('Confirm Password') }}</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
