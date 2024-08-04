@extends('layouts.HomePost')

@section('title', $category['name'])

@section('content')
<div class="container w-full max-w-6xl mx-auto px-2 py-8">
    <div class="flex flex-wrap -mx-2">
        @forelse ($posts as $post)
            <div class="w-full md:w-1/3 px-2 pb-12">
                <div class="h-full bg-white rounded overflow-hidden shadow-md hover:shadow-lg relative smooth">
                    <a href="{{ route('post.show', ['slug' => $post['slug']]) }}" class="no-underline hover:no-underline">
                        <img src="{{ $post['image'] }}" class="h-48 w-full rounded-t shadow-lg">
                        <div class="p-6 h-auto md:h-48">
                            @if(isset($post['category']))
                                <p class="text-gray-600 text-xs md:text-sm">{{ $post['category']['name'] }}</p>
                            @endif
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
        @empty
            <div class="bg-white w-full p-8 md:p-24 text-xl md:text-2xl text-gray-800 leading-normal">
                <p>Bu kategoriye ait gönderi bulunamadı.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
