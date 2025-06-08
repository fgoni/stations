@extends('layouts.app')

@section('content')
    <div class="content flex-grow flex flex-wrap mx-4 justify-center gap-4">
        <div id="bookmarks-container" class="flex flex-wrap justify-center gap-4 min-h-[300px]">
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

            // Create a document fragment for better performance
            const fragment = document.createDocumentFragment();
            
            // Bookmarks are already in LIFO order from localStorage
            bookmarks.forEach(station => {
                const div = document.createElement('div');
                div.className = 'image-container rounded-lg shadow-lg overflow-hidden transform transition-transform hover:scale-[1.02]';
                div.setAttribute('data-url', station.url);
                
                // Create elements instead of using innerHTML for better performance
                const link = document.createElement('a');
                link.href = station.url;
                link.target = '_blank';
                link.rel = 'noopener noreferrer';
                
                const img = document.createElement('img');
                img.src = station.url;
                img.alt = station.title || 'Bookmarked station';
                img.className = 'w-full h-auto object-cover';
                img.loading = 'lazy';
                img.decoding = 'async';
                img.width = station.width || 800; // Use stored width or default
                img.height = station.height || 600; // Use stored height or default
                
                // Add error handling for images
                img.onerror = function() {
                    this.src = '/images/placeholder.jpg'; // Add a placeholder image
                };
                
                const button = document.createElement('button');
                button.className = 'bookmark-btn bookmarked';
                button.onclick = () => toggleBookmark(station, button);
                button.setAttribute('data-url', station.url);
                button.title = 'Remove bookmark';
                button.innerHTML = '<i class="fas fa-star"></i>';
                
                link.appendChild(img);
                div.appendChild(link);
                div.appendChild(button);
                
                if (station.title) {
                    const titleDiv = document.createElement('div');
                    titleDiv.className = 'absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2';
                    titleDiv.textContent = station.title;
                    div.appendChild(titleDiv);
                }
                
                fragment.appendChild(div);
            });
            
            container.appendChild(fragment);
        });
    </script>
@endsection 