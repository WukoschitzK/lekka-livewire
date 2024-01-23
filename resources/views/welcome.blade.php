<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased container mx-auto">
    {{-- TODO: add to presentation, navigation without loading page --}}
    @livewire('navigation')

    <h1 class="text-3xl font-bold underline text-center my-8">
        Happy Hacking!
    </h1>

    {{-- form in form component --}}
    <livewire:form-builder />

    {{-- TODO: add to presentation, lazy loading of component with placeholder method --}}
    <livewire:recipe />
</body>

</html>
