<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne+Mono:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Syne Mono', 'Nunito';
        }
    </style>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <style>
        .container {
            max-height: 60vh;
        }

        .active:after {
            content: '';
            height: 3px;
            background: white;
            display: block;
            border-radius: 4px;
        }

        @media (max-width: 768px) {
            .container {
                max-height: 90vh;
            }
        }
    </style>
</head>
<body class="antialiased bg-gray-800 flex flex-col">
<h2 class="text-white font-bold text-3xl text-center my-3 lowercase"
    style="text-shadow: 0 3px 5px rgba(255,255,255,0.5);">{{ config('app.name') }}</h2>
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
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

</body>
</html>
