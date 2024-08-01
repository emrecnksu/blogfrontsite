<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CommentController
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = config('app.api_base_url');
    }

    public function store(Request $request)
    {
        $token = Session::get('token');

        if (!$token) {
            return redirect()->route('login.form')->with('error', 'Yetkilendirme hatası. Lütfen tekrar giriş yapın.');
        }

        $response = Http::withToken($token)->post("{$this->apiBaseUrl}/api/comments", [
            'post_id' => $request->post_id,
            'content' => $request->content,
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            return redirect()->route('post.show', ['id' => $request->post_id])->with('success', $responseData['message']);
        }

        return redirect()->route('post.show', ['id' => $request->post_id])->with('error', $responseData['message'] ?? 'Yorum eklenemedi.');
    }

    public function update(Request $request, $id)
    {
        $token = Session::get('token');

        if (!$token) {
            return redirect()->route('login.form')->with('error', 'Yetkilendirme hatası. Lütfen tekrar giriş yapın.');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post("{$this->apiBaseUrl}/api/comments/{$id}", [
            'post_id' => $request->post_id,
            'content' => $request->content,
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            return redirect()->route('post.show', ['id' => $request->post_id])->with('success', $responseData['message']);
        }

        return redirect()->route('post.show', ['id' => $request->post_id])->with('error', $responseData['message'] ?? 'Yorum güncellenemedi.');
    }

    public function delete(Request $request, $id)
    {
        $token = Session::get('token');

        if (!$token) {
            return redirect()->route('login.form')->with('error', 'Yetkilendirme hatası. Lütfen tekrar giriş yapın.');
        }

        $response = Http::withToken($token)->delete("{$this->apiBaseUrl}/api/comments/{$id}");

        $responseData = $response->json();

        if ($response->successful()) {
            return redirect()->route('post.show', ['id' => $request->post_id])->with('success', $responseData['message']);
        }

        return redirect()->route('post.show', ['id' => $request->post_id])->with('error', $responseData['message'] ?? 'Yorum silinemedi.');
    }
}
