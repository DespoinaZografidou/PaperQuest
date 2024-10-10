@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg bg-dark">
                    <div class="card-header bg-black">
                        <img src="{{ URL('app_images/logo-3.png') }}" style="width: 20px" alt="" >
                        {{ __('Login') }}
                    </div>

                    <div class="card-body bg-light">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            @method('POST')

                            <label for="email" class="col-form-label pt-4">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control fc @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <label for="password" class="col-form-label pt-4">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control fc @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                            <div class="row justify-content-between pt-4 pb-4">
                                <div class="form-check" style="width:180px;padding-left: 35px">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                                </div>

                                <div class="form-check" style="width:230px;">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="button-84 form-control">{{ __('Login') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('sidebar')
    @include('navbars.SideBar')
@endsection
