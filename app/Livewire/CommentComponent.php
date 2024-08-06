<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CommentComponent extends Component
{
    public $postSlug;
    public $comments = [];
    public $newComment = '';
    public $editCommentId;
    public $editCommentContent = '';
    protected $apiBaseUrl;

    public function mount($postSlug)
    {
        $this->apiBaseUrl = config('app.api_base_url');
        $this->postSlug = $postSlug;
        $this->loadComments();
    }

    public function loadComments()
    {
        $response = Http::get("{$this->apiBaseUrl}/api/comments", [
            'post_slug' => $this->postSlug,
        ]);

        if ($response->successful()) {
            $this->comments = $response->json('data');
        }
    }

    public function addComment()
    {
        $response = Http::withToken(Session::get('token'))->post("{$this->apiBaseUrl}/api/comments", [
            'post_slug' => $this->postSlug,
            'content' => $this->newComment,
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            $this->newComment = '';
            $this->loadComments();
            session()->flash('success', $responseData['message']);
        } else {
            $errorMessage = $responseData['message'] ?? 'Yorum eklenemedi.';
            if (isset($responseData['errors'])) {
                $errorMessage = implode(', ', array_map(function($errors) {
                    return implode(', ', $errors);
                }, $responseData['errors']));
            }
            session()->flash('error', $errorMessage);
        }
    }

    public function editComment($id, $content)
    {
        $this->editCommentId = $id;
        $this->editCommentContent = $content;
    }

    public function updateComment()
    {
        $response = Http::withToken(Session::get('token'))->post("{$this->apiBaseUrl}/api/comments/update/{$this->editCommentId}", [
            'content' => $this->editCommentContent,
            'post_slug' => $this->postSlug, 
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            $this->editCommentId = null;
            $this->editCommentContent = '';
            $this->loadComments();
            session()->flash('success', $responseData['message']);
        } else {
            session()->flash('error', $responseData['message'] ?? 'Yorum güncellenemedi.');
        }
    }

    public function deleteComment($id)
    {
        $response = Http::withToken(Session::get('token'))->delete("{$this->apiBaseUrl}/api/comments/delete/{$id}");

        if ($response->successful()) {
            $this->loadComments();
            session()->flash('success', 'Yorum başarıyla silindi.');
        } else {
            session()->flash('error', 'Yorum silinemedi.');
        }
    }

    public function render()
    {
        return view('livewire.comment-component');
    }
}
