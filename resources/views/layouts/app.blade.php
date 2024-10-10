<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ URL('app_images/logo-2.png') }}" type="image/x-icon" />
    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-bold-straight/css/uicons-bold-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{--    <script  src="https://cdn.tiny.cloud/1/bd2i56if5ei2bm5nl06ldj9h5xhhqetk86p622lvpngti5ws/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>--}}
    <!-- Place the first <script> tag in your HTML's <head> -->
    <script src="https://cdn.tiny.cloud/1/bd2i56if5ei2bm5nl06ldj9h5xhhqetk86p622lvpngti5ws/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Include Select2 CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>





    <!-- Scripts -->
    @vite(['resources/sass/app.scss','resources/css/app.css', 'resources/css/forms.css', 'resources/css/navbars.css',  'resources/css/tables.css', 'resources/js/app.js'])
</head>
<body class="bg-dark">
@include('navbars.MenuNavBar')

    <div id="app" class="py-5 mt-4 pl-5">
        @include('warningMessages.messages')
        <main class="py-4">
            @yield('content')
        </main>
    </div>
@yield('sidebar')
</body>
<footer class="bg-dark">

</footer>
</html>
