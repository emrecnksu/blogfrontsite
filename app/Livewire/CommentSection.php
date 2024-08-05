<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CommentSection extends Component
{
    public $postId;
    public $comments = [];
    public $newCommentContent = '';
    public $updatedCommentContent = [];
    protected $apiBaseUrl;

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->apiBaseUrl = config('app.api_base_url');
        $this->loadComments();
    }

    public function loadComments()
    {
        $response = Http::get("http://host.docker.internal/api/comments?post_slug=" . $this->postId);
        $this->comments = $response->json('data') ?? [];
    }

    public function addComment()
{
    $this->validate(['newCommentContent' => 'required|string']);

    $token = Session::get('token');
    if ($token) {
        $response = Http::withToken($token)->post("http://host.docker.internal/api/comments", [
            'post_slug' => $this->postId,
            'content' => $this->ontent,
        ]);

        if ($response->successful()) {
            $this->newCommentContent = '';
            $this->loadComments();
        } else {
            $errorBody = $response->body(); // Sunucudan gelen hata mesajı
            session()->flash('error', 'Yorum eklenemedi: ' . $errorBody);
        }
    } else {
        session()->flash('error', 'Giriş yapmalısınız.');
    }
}

    public function updateComment($commentId)
    {
        $this->validate(['updatedCommentContent.' . $commentId => 'required|string']);

        $token = Session::get('token');
        if ($token) {
            $response = Http::withToken($token)->post("{$this->apiBaseUrl}/api/comments/update/{$commentId}", [
                'post_slug' => $this->postId,
                'content' => $this->updatedCommentContent[$commentId],
            ]);

            if ($response->successful()) {
                $this->loadComments();
            } else {
                session()->flash('error', 'Yorum güncellenemedi.');
            }
        } else {
            session()->flash('error', 'Giriş yapmalısınız.');
        }
    }

    public function deleteComment($commentId)
    {
        $token = Session::get('token');
        if ($token) {
            $response = Http::withToken($token)->delete("{$this->apiBaseUrl}/api/comments/delete/{$commentId}");

            if ($response->successful()) {
                $this->loadComments();
            } else {
                session()->flash('error', 'Yorum silinemedi.');
            }
        } else {
            session()->flash('error', 'Giriş yapmalısınız.');
        }
    }

    public function render()
    {
        return view('livewire.comment-section');
    }
}
