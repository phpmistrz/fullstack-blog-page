@props(['title', 'description', 'noFollow' => false])


<!DOCTYPE html>
<html lang="pl">

<head>
    @include('partials.meta')
    @include('partials.fonts')
    @include('partials.favicon')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-primary-800 font-text text-fontPrimary overflow-x-hidden">

    {{ $slot }}

</body>

</html>
