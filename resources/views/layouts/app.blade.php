<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @yield('head')
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    @yield('js')
</body>
</html>
