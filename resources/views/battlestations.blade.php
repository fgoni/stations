@extends('layouts.app')
@section('content')
    <div class="content flex-grow flex flex-wrap mx-4 justify-center gap-4">
        @foreach($posts as $post)
            <x-image :url="$post->url" :title="$post->title" :width="$post->image_width ?? null" :height="$post->image_height ?? null" />
        @endforeach
    </div>
@endsection
