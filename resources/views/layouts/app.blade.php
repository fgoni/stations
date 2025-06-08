<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
    </style>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
</head>
<body class="antialiased bg-black flex flex-col">
<h2 class="text-white font-bold text-3xl text-center my-3 lowercase">{{ config('app.name') }}</h2>
<nav>
    <ul class="flex justify-around mx-auto text-white text-xl font-bold lowercase flex-col md:flex-row text-center">
        <li class="{{ request()->path() === 'averagebattlestations' ? 'active' : '' }}"><a
                href="{{ url('averagebattlestations') }}">Average Battlestations</a></li>
        <li class="{{ request()->path() === 'workstations' ? 'active' : '' }}"><a
                href="{{ url('workstations') }}">Work
                Stations</a></li>
        <li class="{{ request()->path() === 'battlestations' ? 'active' : '' }}"><a
                href="{{ url('battlestations') }}">Battlestations</a>
        </li>
        <li class="{{ request()->path() === 'macsetups' ? 'active' : '' }}"><a href="{{ url('macsetups') }}">Mac
                Setups</a></li>
        <li class="{{ request()->path() === 'shittybattlestations' ? 'active' : '' }}"><a
                href="{{ url('shittybattlestations') }}">Shitty Battlestations</a></li>
    </ul>
</nav>
@yield('content')
<footer class="mt-auto py-4 text-center text-gray-500 text-sm">
    Made with ❤️ by <a href="https://coffeedevs.com" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition-colors">CoffeeDevs</a>
</footer>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

</body>
</html>
