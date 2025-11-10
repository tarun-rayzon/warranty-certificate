<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>Rayzon Solar Private Limited</title>

    <!-- Social Media Meta Tags -->
    <meta property="og:title" content="Rayzon Solar Private Limited">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('image/favicon.ico') }}">
    <meta name="robots" content="noindex, nofollow">

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead

</head>

<body oncontextmenu="return false;">
    @inertia
</body>

</html>
