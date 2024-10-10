@extends('layouts.app')

@section('content')
    <div class="container">
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-8">--}}
{{--                <form action="" class="form_search">--}}
{{--                    <input type="text" class="form-control input_search" required>--}}
{{--                    <i class="fi fi-bs-search"></i>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}


        <div class="row justify-content-center pt-4">
            <div class="col-md-8">
                <div class="card shadow-lg bg-dark">
                    <div class="card-header bg-black">
                        <img src="{{ URL('app_images/logo-3.png') }}" style="width: 20px" alt="" >
                        Conferences
                    </div>

                    <div class="card-body bg-light">
                        <p>Here are a list of your Clients</p>
{{--                        @foreach($clients as $client)--}}
{{--                            <div class="py-3 text-gray-900">--}}
{{--                                <h3 class="text-lg text-gray-500">{{ $client->name }}</h3>--}}
{{--                                <p>{{$client->redirect}}</p>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}

{{--                        <div class="mt-3 p-6 bg-white border-b border-gray-200">--}}
{{--                            <form action={{url('/oauth/clients')}} method="POST">--}}
{{--                                <div>--}}
{{--                                    <x-label for="name">Name</x-label>--}}
{{--                                    <x-input type="text" name="name"></x-input>--}}
{{--                                </div>--}}

{{--                                <div>--}}
{{--                                    <x-label for="redirect">Name</x-label>--}}
{{--                                    <x-input type="text" name="redirect"></x-input>--}}
{{--                                </div>--}}
{{--                                <div>--}}
{{--                                    @csrf @method('POST')--}}
{{--                                    <x-button type="submit">Create Client</x-button>--}}

{{--                                </div>--}}

{{--                            </form>--}}
{{--                        </div>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('sidebar')
    @include('navbars.Sidebar')
@endsection
