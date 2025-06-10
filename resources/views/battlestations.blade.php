@extends('layouts.app')
@section('content')
    <div class="content-container">
        <div class="content flex-grow">
            @foreach($posts as $post)
                <x-image :url="$post->url" :title="$post->title" :width="$post->image_width ?? null" :height="$post->image_height ?? null" />
            @endforeach
        </div>
    </div>
@endsection
