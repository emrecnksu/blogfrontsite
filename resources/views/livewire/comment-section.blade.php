<div>
    @if(session('error'))
        <div class="text-red-500">{{ session('error') }}</div>
    @endif

    @if(Session::has('token'))
        <form wire:submit.prevent="addComment" class="mb-8 bg-white shadow-md rounded p-4">
            <textarea wire:model="newCommentContent" placeholder="Yorumunuzu yazın" class="w-full p-2 border rounded mb-4"></textarea>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Yorum Yap</button>
        </form>
    @else
        <p class="mb-8 bg-white shadow-md rounded p-4">Yorum yapabilmek için <a href="{{ route('login.form') }}" class="text-blue-500">giriş yapmalısınız</a>.</p>
    @endif

    <div id="comments-section" class="bg-white mb-4 shadow-md rounded p-4">
        @foreach($comments as $comment)
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
                        <form wire:submit.prevent="deleteComment({{ $comment['id'] }})" class="ml-2">
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Sil</button>
                        </form>
                    </div>
                    <form wire:submit.prevent="updateComment({{ $comment['id'] }})" id="edit-form-{{ $comment['id'] }}" class="mt-2 hidden">
                        <textarea wire:model="updatedCommentContent.{{ $comment['id'] }}" rows="2" class="w-full p-2 border rounded mb-2">{{ $comment['content'] }}</textarea>
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Güncelle</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</div>
