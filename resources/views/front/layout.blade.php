<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('front.common.header')
</head>

<body class="font-sans antialiased" id="body-content">

    @include('front.common.navbar')
    <div class="container-fluid contentBackImage ">
        @yield('content')
    </div>

    @include('front.common.footer')

    @env ('local')
    <script src="http://localhost:8080/js/bundle.js"></script>
    @endenv
</body>

</html>