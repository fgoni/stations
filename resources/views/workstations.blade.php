@extends('layouts.app')
@section('content')
    <h2 class="text-white font-bold text-3xl text-center my-3">{{ config('app.name') }}</h2>
    <div class="content flex-grow flex flex-wrap mx-4 justify-center gap-4">
        @foreach($posts as $post)
            <x-image :url="$post->url" />
        @endforeach
    </div>
@endsection
