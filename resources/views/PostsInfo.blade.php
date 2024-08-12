@extends('layouts.HomePost')

@section('title', $postInfo['title'])

@section('content')
<div class="text-center pt-16 md:pt-32">
    <p class="text-sm md:text-base text-green-500 font-bold">
        {{ \Carbon\Carbon::parse($postInfo['start_date'])->format('d M Y H:i:s') }}
        <span class="text-gray-900">/</span>
        {{ $postInfo['category']['name'] }}
        <span class="text-gray-900">/</span>
        @foreach ($postInfo['tags'] as $tag)
            {{ $tag['name'] }}
            @if (!$loop->last)
            @endif
        @endforeach
    </p>
    <h1 class="font-bold break-normal text-3xl md:text-5xl">{{ $postInfo['title'] }}</h1>
</div>

<div class="container w-full max-w-6xl mx-auto bg-white bg-cover mt-8 rounded" style="height: auto;">
    <img src="{{ $postInfo['image'] }}" class="w-full h-auto rounded-t shadow-lg" style="max-height: 500px; object-fit: cover;">
</div>

<div class="container max-w-5xl mx-auto mt-8">
    <div class="bg-white w-full p-8 md:p-24 text-xl md:text-2xl text-gray-800 leading-normal" style="font-family:Georgia,serif;">
        <p class="text-2xl md:text-3xl mb-5">
            {{ $postInfo['content'] }}
        </p>
    </div>

    <div class="flex w-full items-center font-sans p-8 md:p-24">
        <div class="flex-1">
            <p class="text-base font-bold text-base md:text-xl leading-none">{{ $postInfo['user']['name'] }} {{ $postInfo['user']['surname'] }}</p>
        </div>
        <p class="text-base font-bold text-base md:text-xl leading-none text-gray-600">{{ \Carbon\Carbon::parse($postInfo['start_date'])->locale('tr')->timezone('Europe/Istanbul')->diffForHumans() }}</p>
    </div>

    <!-- Yorumlar Bölümü -->
    <div class="container mx-auto mt-8 mb-3">
        <h2 class="text-2xl font-bold mb-4">Yorumlar</h2>
        <livewire:comment-component :postSlug="$postInfo['slug']" />
    </div>

    <div class="bg-gray-200">
        <div class="container w-full max-w-6xl mx-auto px-2 py-8">
            <h2 class="text-2xl font-bold mb-4">{{ $isCategoryRelated ? 'İlgili Yazılar' : 'Tavsiye Edilen Yazılar' }}</h2>
            <div class="flex flex-wrap -mx-2">
                @foreach ($relatedPosts as $relatedPost)
                    <div class="w-full md:w-1/3 px-2 pb-12">
                        <div class="h-full bg-white rounded overflow-hidden shadow-md hover:shadow-lg relative smooth">
                            <a href="{{ isset($relatedPost['slug']) ? url('/post/' . $relatedPost['slug']) : '#' }}" class="no-underline">
                                <img src="{{ $relatedPost['image'] }}" class="w-full h-64 object-cover rounded-t" alt="{{ $relatedPost['title'] }}">
                                <div class="p-4">
                                    <p class="text-lg font-bold text-gray-900">{{ $relatedPost['title'] }}</p>
                                </div>
                            </a>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
