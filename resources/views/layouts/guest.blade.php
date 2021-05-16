<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.2.45/css/materialdesignicons.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
{{--    <link rel="stylesheet" href="../assets/css/tailwind.css">--}}
    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body x-data class="select-none">

<x-navigation-menu />

<main>
    {{ $slot }}
</main>

<footer class="container divide-y">
    <section class="h-0"></section>
    <!--    newsletter section-->
    <section class="py-8">
        <div class="flex flex-col md:flex-row lg:items-center lg:justify-between space-y-6 md:space-y-0">
            <div class="flex-1">
                <p class="font-medium">
                    Get new templates in your inbox!
                </p>
                <p class="text-gray-500 text-xs">
                    New templates or big discounts. Never spam.
                </p>
            </div>
            <form class="flex space-x-2">
                <div class="flex-1 md:w-64">
                    <input type="email" placeholder="Email address"
                           class="border-0 bg-gray-200 px-4 rounded text-sm focus:outline-none focus:ring h-full w-full"/>
                </div>
                <button type="submit" class="btn-primary">
                    Subscribe
                </button>
            </form>
        </div>
    </section>
    <footer class="py-4">
        <ul class="text-xs text-gray-500 flex flex-wrap">
            <li class="my-2 mr-6 lg:mr-8">
                <a href="#" class="transition hover:text-gray-800">
                    Help Center
                </a>
            </li>
            <li class="my-2 mr-6 lg:mr-8">
                <a href="#" class="transition hover:text-gray-800">
                    Terms of Service
                </a>
            </li>
            <li class="my-2 mr-6 lg:mr-8">
                <a href="#" class="transition hover:text-gray-800">
                    Licenses
                </a>
            </li>
            <li class="my-2">
                <a href="./redownload.html" class="transition hover:text-gray-800">
                    Redownload templates
                </a>
            </li>
        </ul>
    </footer>
</footer>

@livewireScripts
</body>
</html>
