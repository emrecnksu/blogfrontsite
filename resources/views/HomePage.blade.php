@extends('layouts.HomePost')

@section('title', 'Anasayfa')

@section('content')
<div class="container w-full max-w-6xl mx-auto px-2 py-8">
    <div class="flex flex-wrap -mx-2">
        @foreach ($posts as $post)
            <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/3 px-2 pb-12">
                <div class="h-full bg-white rounded overflow-hidden shadow-md hover:shadow-lg relative smooth">
                    <a href="{{ route('post.show', ['id' => $post['id']]) }}" class="no-underline hover:no-underline">
                        <img src="{{ $post['image'] }}" class="h-64 w-full rounded-t shadow-lg object-cover">
                        <div class="p-6 h-auto md:h-48">
                            <p class="text-gray-600 text-xs md:text-sm">{{ $post['category']['name'] }}</p>
                            <div class="font-bold text-xl text-gray-900">{{ $post['title'] }}</div>
                            <p class="text-gray-800 font-serif text-base mb-5">{{ Str::limit($post['content'], 120) }}</p>
                        </div>
                        <div class="flex items-center justify-between inset-x-0 bottom-0 p-6">
                            <p class="text-gray-600 text-xs md:text-sm">{{ $post['user']['name'] }} {{ $post['user']['surname'] }}</p>
                            <p class="text-gray-600 text-xs md:text-sm">{{ \Carbon\Carbon::parse($post['start_date'])->locale('tr')->timezone('Europe/Istanbul')->diffForHumans() }}</p>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
