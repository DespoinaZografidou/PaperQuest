<nav class="navbar navbar-expand-md navbar-dark bg-black shadow-lg pt-0 pb-0 pl-0 pr-0 fixed-top" style=" z-index: 10;">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ URL('app_images/logo.png') }}" style="width: 120px" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto"></ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item button-57">
                        <a class="nav-link" href="{{ url('/') }}">&nbsp;<i class="fi fi-sr-home"></i>&nbsp;</a>
                    </li>
                    @if (Route::has('login'))
                        <li class="nav-item button-57">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item button-57">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item button-57">
                        <a class="nav-link" href="{{ url('/home') }}">&nbsp;<i class="fi fi-sr-home"></i>&nbsp;</a>
                    </li>

                    <li class="nav-item dropdown" style="display: inline-block;padding: 5px;">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

{{--                            <a class="dropdown-item" href="">Profile</a>--}}
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
