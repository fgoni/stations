@props(['url', 'title' => null])

<div class="image-container" data-url="{{ $url }}">
    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer">
        <img src="{{ $url }}" alt="{{ $title ?? 'Post image' }}" class="w-full h-auto object-cover">
    </a>
    <button 
        class="bookmark-btn" 
        onclick="toggleBookmark({{ json_encode(['url' => $url, 'title' => $title]) }}, this)" 
        data-url="{{ $url }}" 
        title="Bookmark station"
    >
        <i class="fas fa-star"></i>
    </button>
    @if($title)
        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2">
            {{ $title }}
        </div>
    @endif
</div> 