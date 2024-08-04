@extends('layouts.HomePost')

@section('title', 'Anasayfa')

@section('content')
<div class="container w-full max-w-6xl mx-auto px-2 py-8">
    <div class="flex flex-wrap -mx-2">
        @foreach ($posts as $post)
            <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/3 px-2 pb-12">
                <div class="h-full bg-gray-100 rounded overflow-hidden shadow-md hover:shadow-lg relative smooth flex flex-col justify-between">
                    <a href="{{ route('post.show', ['slug' => $post['slug']]) }}" class="no-underline hover:no-underline flex-grow flex flex-col">
                        <img src="{{ $post['image'] }}" class="h-64 w-full rounded-t shadow-lg object-cover">
                        <div class="p-6 flex-grow">
                            <p class="text-gray-600 text-sm md:text-sm">{{ $post['category']['name'] }}</p>
                            <div class="font-bold text-xl text-gray-900">{{ $post['title'] }}</div>
                            <p class="text-gray-800 font-serif text-base mb-5">{{ Str::limit($post['content'], 120) }}</p>
                        </div>
                    </a>
                    <div class="p-6 bg-gray-100 rounded-b flex items-center justify-between">
                        <p class="text-gray-600 text-sm md:text-sm">{{ $post['user']['name'] }} {{ $post['user']['surname'] }}</p>
                        <p class="text-gray-600 text-sm md:text-sm">{{ \Carbon\Carbon::parse($post['start_date'])->locale('tr')->timezone('Europe/Istanbul')->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
