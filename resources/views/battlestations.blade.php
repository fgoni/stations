@extends('layouts.app')
@section('content')
    <div class="content flex-grow flex flex-wrap mx-4 justify-center">
        @foreach($posts as $post)
            <div class="container flex flex-col items-center text-center my-6 overflow-visible">
                <a class="uppercase text-sm text-gray-400 text-center m-auto w-full" href="{{ $post->url }}">
                    View original
                </a>
                <img src="{{ $post->url }}" class="max-w-full max-h-full rounded shadow m-auto object-cover" alt="">
            </div>
        @endforeach
    </div>
@endsection
