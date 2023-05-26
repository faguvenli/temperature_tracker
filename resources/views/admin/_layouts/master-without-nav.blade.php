<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | ILMED</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Admin Panel" name="description" />
    <meta content="İlkin Yazılım" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    @include('admin._layouts.head-css')"
</head>
@yield('body')
@yield('content')
<!-- JAVASCRIPT -->
@include('admin._layouts.vendor-scripts')
</body>

</html>
