@extends('layouts.app')

@section('content')

    <div class="container">
{{--        <div> --}}
{{--            @if(Auth::check())--}}
{{--                @if(Auth::user()->tokens->isNotEmpty())--}}
{{--                    <ul>--}}
{{--                        @foreach(Auth::user()->tokens as $token)--}}
{{--                            <li>Token ID: {{ $token->id }} - Created At: {{ $token->created_at }}</li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                @else--}}
{{--                    <p>No tokens found for this user.</p>--}}
{{--                @endif--}}
{{--            @else--}}
{{--                <p>User is not authenticated.</p>--}}
{{--            @endif--}}
{{--        </div>--}}
        <div class="row justify-content-center pt-4">
            <div class="col-md-7">
                <div class="card shadow-lg bg-dark">
                    <div class="card-header bg-black"><i class="fi fi-ss-admin-alt"></i> Update My Profile</div>
                    <form class="modal-content" action="{{ route("my.profile.update") }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('GET')
                        <div class="card-body" style="background-color: rgb(36, 37, 38);">
                            <div class="row justify-content-between pb-3">
                                <div class="col-lg-5 row justify-content-center pr-4 pl-2 mt-5 pt-5 pb-5">
                                    <div class="profile_div">
                                        <div class="profile_frame neon_border @if(Auth::User()->account_status==1) neon-green @elseif(Auth::User()->account_status==0) neon-red @endif">
                                            <img src="{{ asset(Auth::User()->profile_picture) }}" class="profile"  alt=""/>
                                        </div>
                                        <div class="profile_status @if(Auth::User()->account_status==1) active_account @elseif(Auth::User()->account_status==0) unactive_account @endif"></div>
                                        <label for="imageInput"><i class="fi fi-sr-cloud-upload-alt upload"></i></label>
                                        <input type="file" name="image" id="imageInput" accept="image/*" style="display: none;">
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="row justify-content-between">
                                        <input id="id" name="id" value="{{Auth::User()->id}}" hidden>

                                        <div class="col-md-6">
                                            <label class="col-form-label pt-4" style="color: white;">Firstname</label>
                                            <input class="form-control" id="firstname" name="firstname" value="{{Auth::User()->firstname}}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-form-label pt-4" style="color: white;">Lastname</label>
                                            <input class="form-control" id="lastname" name="lastname" value="{{Auth::User()->lastname}}" readonly>
                                        </div>
                                    </div>

                                    <label for="email" class="col-form-label pt-4" style="color: white;">Email Address</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{Auth::User()->email}}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <label class="col-form-label pt-4" style="color: white;">Role</label>
                                    <input type="text" class="form-control" value="{{Auth::User()->system_role}}" readonly>


                                    <label class="col-form-label pt-4" style="color: white;">Account Status</label>
                                    <input type="text" class="form-control" value="@if(Auth::User()->account_status==1) Unlocked @elseif(Auth::User()->account_status==0) Locked @endif"  readonly>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-black">
                            <button type="submit" class="button-84 col-md-12">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow-lg bg-dark">
                    <div class="card-header bg-black"><i class="fi fi-ss-key"></i> Change Password </div>
                    <form action="{{route('my.profile.change.password')}}" method="POST">
                        @csrf
                        @method('GET')
                        <div class="card-body" style="background-color: rgb(36, 37, 38);">
                            <input id="id" name="id" value="{{Auth::User()->id}}" hidden>
                            <label for="current_password" class="col-form-label" style="color: white;">{{ __('Current Password') }}</label>
                            <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror " name="current_password" value="" required autocomplete="current-password" autofocus>
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <label for="password" class="col-form-label pt-4" style="color: white;">{{ __('New Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <label for="password-confirm" class="col-form-label pt-4" style="color: white;">{{ __('Confirm New Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                        </div>
                        <div class="card-footer bg-black">
                            <button type="submit" class="button-84 form-control">{{ __('Change My Password') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow-lg bg-dark">
                    <div class="card-header bg-black"><i class="fi fi-ss-remove-user"></i> Delete Account </div>
                        <div class="card-body" style="background-color: rgb(36, 37, 38);">
                            <label for="password" class="col-form-label pt-4" style="color: white;">If you wish to delete your account, click the button below to make a request. </label>
                        </div>
                        <div class="card-footer bg-black">
                            <button type="submit" class="button-84 form-control dr">{{ __('Delete Request') }}</button>
                        </div>

                </div>
            </div>
        </div>
    </div>
    @include('allRoles.popUpForms.account_Delete')
    <script>
        $('#imageInput').on('change', function(e) {

            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.profile').attr('src', e.target.result);
            }

            reader.readAsDataURL(file);
        });

    </script>
@endsection
@section('sidebar')
    @include('navbars.SideBar')
@endsection
