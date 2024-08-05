<div>
    @if (session()->has('success'))
        <div class="bg-green-500 mt-2 text-lg px-4 py-3 mb-4 rounded" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-500 mt-2 text-lg px-4 py-3 mb-4 rounded" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if(Session::has('token'))
        <form wire:submit.prevent="addComment" class="mb-8 bg-white shadow-md rounded p-4">
            <textarea wire:model="newComment" class="w-full p-2 border rounded mb-4" placeholder="Yorumunuzu yazın"></textarea>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Yorum Yap</button>
        </form>
    @else
        <p class="mb-8 bg-white shadow-md rounded p-4">Yorum yapabilmek için <a href="{{ route('login.form') }}" class="text-blue-500">giriş yapmalısınız</a>.</p>
    @endif

    <div id="comments-section" class="bg-white shadow-md rounded p-4">
        @foreach ($comments as $comment)
            <div class="border-b pb-4 mb-4">
                <div class="flex items-center mb-2">
                    <img src="https://ui-avatars.com/api/?name={{ $comment['user']['name'] }}+{{ $comment['user']['surname'] }}&background=random&color=fff" alt="{{ $comment['user']['name'] }}" class="w-10 h-10 rounded-full mr-4">
                    <div>
                        <p class="font-bold">{{ $comment['user']['name'] }} {{ $comment['user']['surname'] }}</p>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($comment['created_at'])->diffForHumans() }}</p>
                    </div>
                </div>
                <p class="text-gray-700">{{ $comment['content'] }}</p>
                @if (Session::has('token') && Session::get('user.id') == $comment['user_id'])
                    <div class="mt-2 flex">
                        <button wire:click="editComment({{ $comment['id'] }}, '{{ $comment['content'] }}')" class="px-4 py-2 bg-yellow-500 text-white rounded">Düzenle</button>
                        <button wire:click="deleteComment({{ $comment['id'] }})" class="px-4 py-2 bg-red-500 text-white rounded ml-2">Sil</button>
                    </div>
                    @if($editCommentId === $comment['id'])
                        <form wire:submit.prevent="updateComment" class="mt-2">
                            <textarea wire:model="editCommentContent" class="w-full p-2 border rounded mb-2" required></textarea>
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Güncelle</button>
                        </form>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
</div>
