<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
        }
        .image-container {
            position: relative;
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
        }
        .dropdown:hover .dropdown-content {
            display: block;
            animation: dropdownFade 0.2s ease;
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
        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        function showToast(message, isBookmarked) {
            Toastify({
                text: message,
                duration: 3000,
                gravity: "top",
                position: "right",
                style: {
                    background: "white",
                    color: "black",
                    border: "1px solid black",
                }
            }).showToast();
        }

        function toggleBookmark(station, button) {
            const bookmarks = JSON.parse(localStorage.getItem('bookmarks') || '[]');
            const existingIndex = bookmarks.findIndex(b => b.url === station.url);
            
            if (existingIndex !== -1) {
                bookmarks.splice(existingIndex, 1);
                button.classList.remove('bookmarked');
                showToast('Station removed from bookmarks', false);
            } else {
                // Add to the beginning of the array for LIFO order
                bookmarks.unshift(station);
                button.classList.add('bookmarked');
                showToast('Station added to bookmarks', true);
            }
            
            localStorage.setItem('bookmarks', JSON.stringify(bookmarks));

            // If we're on the bookmarks page, remove the image container when unbookmarked
            if (window.location.pathname === '/bookmarks') {
                const container = button.closest('.image-container');
                if (container) {
                    container.remove();
                    // If no more bookmarks, show the empty message
                    const bookmarksContainer = document.getElementById('bookmarks-container');
                    if (bookmarksContainer && bookmarksContainer.children.length === 0) {
                        bookmarksContainer.innerHTML = '<p class="text-white text-center w-full">No bookmarked stations yet.</p>';
                    }
                }
            }
        }

        // Initialize bookmark states when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Only initialize bookmark states if we're not on the bookmarks page
            if (window.location.pathname !== '/bookmarks') {
                const bookmarks = JSON.parse(localStorage.getItem('bookmarks') || '[]');
                document.querySelectorAll('.image-container').forEach(container => {
                    const url = container.getAttribute('data-url');
                    const button = container.querySelector('.bookmark-btn');
                    if (bookmarks.some(b => b.url === url)) {
                        button.classList.add('bookmarked');
                    }
                });
            }
        });
    </script>
</head>
<body class="antialiased flex flex-col">
<h2 class="text-white font-bold text-3xl text-center my-3 capitalize">{{ config('app.name') }}</h2>
<nav class="flex justify-center mb-8">
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
</nav>
<main class="flex-grow">
    @yield('content')
</main>
<footer class="mt-auto py-4 text-center text-gray-400 text-sm">
    Made with ❤️ by <a href="https://coffeedevs.com" target="_blank" rel="noopener noreferrer" class="text-gray-300 hover:text-white transition-colors">CoffeeDevs</a>
</footer>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

</body>
</html>
