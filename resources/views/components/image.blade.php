@props(['url'])

<div class="container flex flex-col items-center text-center my-6 overflow-visible px-4">
    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="block">
        <img src="{{ $url }}" class="rounded shadow" alt="">
    </a>
</div> 