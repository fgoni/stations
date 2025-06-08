@extends('layouts.app')
@section('content')
    <div class="content flex-grow flex flex-wrap mx-4 justify-center gap-4">
        @foreach($posts as $post)
            <x-image :url="$post->url" :title="$post->title" />
        @endforeach
    </div>
@endsection
