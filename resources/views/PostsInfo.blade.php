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
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-bold mb-4">Yorumlar</h2>

        @if (Session::has('token'))
            <!-- Yorum Formu -->
            <form action="{{ route('comments.store') }}" method="POST" class="mb-8 bg-white shadow-md rounded p-4">
                @csrf
                <input type="hidden" name="post_id" value="{{ $postInfo['id'] }}">
                <input type="hidden" name="post_slug" value="{{ $postInfo['slug'] }}">
                <textarea name="content" rows="4" class="w-full p-2 border rounded mb-4" placeholder="Yorumunuzu yazın" required></textarea>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Yorum Yap</button>
            </form>
        @else
            <p class="mb-8 bg-white shadow-md rounded p-4">Yorum yapabilmek için <a href="{{ route('login.form') }}" class="text-blue-500">giriş yapmalısınız</a>.</p>
        @endif

        <!-- Yorumlar Listesi -->
        <div id="comments-section" class="bg-white mb-4 shadow-md rounded p-4">
            @foreach ($comments as $comment)
                @if($comment['post_id'] == $postInfo['id'])
                    <div class="border-b pb-4 mb-4">
                        <div class="flex items-center mb-2">
                            @if(isset($comment['user']))
                                <img src="https://ui-avatars.com/api/?name={{ $comment['user']['name'] }}+{{ $comment['user']['surname'] }}&background=random&color=fff" alt="{{ $comment['user']['name'] }}" class="w-10 h-10 rounded-full mr-4">
                                <div>
                                    <p class="font-bold">{{ $comment['user']['name'] }} {{ $comment['user']['surname'] }}</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($comment['created_at'])->diffForHumans() }}</p>
                                </div>
                            @else
                                <img src="https://ui-avatars.com/api/?name=Unknown&background=random&color=fff" alt="Unknown" class="w-10 h-10 rounded-full mr-4">
                                <div>
                                    <p class="font-bold">Bilinmeyen Kullanıcı</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($comment['created_at'])->diffForHumans() }}</p>
                                </div>
                            @endif
                        </div>
                        <p class="text-gray-700">{{ $comment['content'] }}</p>
                        @if (Session::has('token') && Session::get('user.id') == $comment['user_id'])
                            <div class="mt-2 flex">
                                <button onclick="document.getElementById('edit-form-{{ $comment['id'] }}').classList.toggle('hidden')" class="px-4 py-2 bg-yellow-500 text-white rounded">Düzenle</button>
                                <form action="{{ route('comments.delete', $comment['id']) }}" method="POST" class="ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="post_slug" value="{{ $postInfo['slug'] }}">
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Sil</button>
                                </form>
                            </div>
                            <form id="edit-form-{{ $comment['id'] }}" action="{{ route('comments.update', $comment['id']) }}" method="POST" class="mt-2 hidden">
                                @csrf
                                @method('POST')
                                <textarea name="content" rows="2" class="w-full p-2 border rounded mb-2" required>{{ $comment['content'] }}</textarea>
                                <input type="hidden" name="post_slug" value="{{ $postInfo['slug'] }}">
                                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Güncelle</button>
                            </form>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="border-radius bg-gray-100">
        <div class="container w-full max-w-6xl mx-auto px-2 py-8">
            <h2 class="text-2xl font-bold mb-4">{{ $isCategoryRelated ? 'İlgili Yazılar' : 'Tavsiye Edilen Yazılar' }}</h2>
            <div class="flex flex-wrap -mx-2">
                @foreach ($relatedPosts as $relatedPost)
                    <div class="w-full md:w-1/3 px-2 pb-12">
                        <div class="h-full bg-gray-100 rounded overflow-hidden shadow-md hover:shadow-lg relative smooth">
                            <a href="{{ url('/post/' . $relatedPost['slug']) }}" class="no-underline">
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
