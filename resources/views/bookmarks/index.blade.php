@extends('layouts.app')

@section('content')
    <div class="content flex-grow flex flex-wrap mx-4 justify-center gap-4">
        <div id="bookmarks-container" class="flex flex-wrap justify-center gap-4">
            <!-- Bookmarks will be loaded here via JavaScript -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bookmarks = JSON.parse(localStorage.getItem('bookmarks') || '[]');
            const container = document.getElementById('bookmarks-container');
            
            if (bookmarks.length === 0) {
                container.innerHTML = '<p class="text-white text-center w-full">No bookmarked stations yet.</p>';
                return;
            }

            // Bookmarks are already in LIFO order from localStorage
            bookmarks.forEach(station => {
                const div = document.createElement('div');
                div.className = 'image-container rounded-lg shadow-lg overflow-hidden transform transition-transform hover:scale-[1.02]';
                div.setAttribute('data-url', station.url);
                div.innerHTML = `
                    <a href="${station.url}" target="_blank" rel="noopener noreferrer">
                        <img 
                            src="${station.url}" 
                            alt="${station.title || 'Bookmarked station'}" 
                            class="w-full h-auto object-cover"
                            loading="lazy"
                            decoding="async"
                        >
                    </a>
                    <button class="bookmark-btn bookmarked" onclick="toggleBookmark(${JSON.stringify(station)}, this)" data-url="${station.url}" title="Remove bookmark">
                        <i class="fas fa-star"></i>
                    </button>
                    ${station.title ? `
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2">
                            ${station.title}
                        </div>
                    ` : ''}
                `;
                container.appendChild(div);
            });
        });
    </script>
@endsection 