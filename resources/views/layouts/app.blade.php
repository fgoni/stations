<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Preload critical assets -->
    <link rel="preload" href="{{ asset('css/app.css') }}" as="style">
    <link rel="preload" href="{{ asset('js/app.js') }}" as="script">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" as="style">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <!-- Inline critical CSS -->
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        .image-container {
            position: relative;
            contain: content; /* Optimize paint and layout */
            will-change: transform; /* Optimize animations */
        }
        .bookmark-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s ease;
            will-change: opacity; /* Optimize animations */
        }
        .image-container:hover .bookmark-btn {
            opacity: 1;
        }
        .bookmark-btn:hover {
            background: rgba(0, 0, 0, 0.8);
        }
        .bookmark-btn.bookmarked {
            color: #FFD700;
        }
        .toastify {
            background: white;
            color: black;
            border: 1px solid black;
            border-radius: 8px;
            padding: 12px 20px;
            font-weight: 500;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background: linear-gradient(to bottom, #2d2d2d, #1a1a1a);
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            border-radius: 8px;
            z-index: 1;
            transform-origin: top;
            transition: all 0.2s ease;
            margin-top: 8px;
            will-change: transform, opacity; /* Optimize animations */
        }
        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: all 0.2s ease;
        }
        .dropdown-content a:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .dropdown-content a.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }
    </style>

    <!-- Defer non-critical JavaScript -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/modal.js') }}" defer></script>
    <script src="{{ asset('js/layout.js') }}" defer></script>
    <script src="{{ asset('js/dropdown.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js" defer></script>
</head>
<body class="antialiased flex flex-col">
    <div class="relative">
        <div class="absolute top-4 left-4 z-20">
            <i class="fas fa-question-circle text-white text-xl cursor-pointer" id="help-icon"></i>
        </div>
    </div>
    <h2 class="text-white font-bold text-3xl text-center my-3 capitalize">{{ config('app.name') }}</h2>
    <nav class="flex justify-center mb-8">
        <div class="flex items-center gap-4">
            <div class="dropdown">
                <button class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition-colors">
                    Browse Stations
                    <i class="fas fa-chevron-down text-sm"></i>
                </button>
                <div class="dropdown-content">
                    <a href="{{ url('averagebattlestations') }}" class="{{ request()->path() === 'averagebattlestations' ? 'active' : '' }}">
                        Average Battlestations
                    </a>
                    <a href="{{ url('workstations') }}" class="{{ request()->path() === 'workstations' ? 'active' : '' }}">
                        Work Stations
                    </a>
                    <a href="{{ url('battlestations') }}" class="{{ request()->path() === 'battlestations' ? 'active' : '' }}">
                        Battlestations
                    </a>
                    <a href="{{ url('macsetups') }}" class="{{ request()->path() === 'macsetups' ? 'active' : '' }}">
                        Mac Setups
                    </a>
                    <a href="{{ url('shittybattlestations') }}" class="{{ request()->path() === 'shittybattlestations' ? 'active' : '' }}">
                        Shitty Battlestations
                    </a>
                    <a href="{{ route('bookmarks.index') }}" class="{{ request()->path() === 'bookmarks' ? 'active' : '' }}">
                        Bookmarks
                    </a>
                </div>
            </div>
            <button id="layoutToggle" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors" title="Toggle layout">
                <i class="fas fa-th-large"></i>
            </button>
        </div>
    </nav>
    <main class="flex-grow">
        @yield('content')
    </main>
    <footer class="mt-auto py-4 text-center text-gray-400 text-sm">
        Made with ❤️ by <a href="https://coffeedevs.com" target="_blank" rel="noopener noreferrer" class="text-gray-300 hover:text-white transition-colors">CoffeeDevs</a>
    </footer>

    <!-- The Modal -->
    <div id="help-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white text-black p-6 rounded-lg shadow-xl max-w-md mx-4 relative">
            <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-2xl font-bold" id="close-modal-btn">&times;</button>
            <h3 class="text-xl font-bold mb-4">About Stations</h3>
            <p>
                Stations is a demo project built to showcase a Laravel app running on Vercel infrastructure, showing how a PHP runtime can be used for backend on Vercel on-demand.
            </p>
        </div>
    </div>
</body>
</html>
