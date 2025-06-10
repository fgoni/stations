@extends('layouts.app')
@section('content')
    <h2 class="text-white font-bold text-3xl text-center my-3">{{ config('app.name') }}</h2>
    <div class="content-container">
        <div class="content flex-grow">
            @foreach($posts as $post)
                <x-image :url="$post->url" :title="$post->title" />
            @endforeach
        </div>
    </div>
@endsection
