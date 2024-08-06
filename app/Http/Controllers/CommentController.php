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

        $response = Http::withToken(Session::get('token'))->post(config('app.api_base_url') . '/api/comments', [
            'post_slug' => $request->post_slug,
            'content' => $request->content,
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            return redirect()->route('post.show', ['slug' => $request->post_slug])->with('success', $responseData['message']);
        }

        return redirect()->route('post.show', ['slug' => $request->post_slug])->with('error', $responseData['message'] ?? 'Yorum eklenemedi.');
    }

    public function update(Request $request, $id)
    {
        $token = Session::get('token');

        if (!$token) {
            return redirect()->route('login.form')->with('error', 'Yetkilendirme hatası. Lütfen tekrar giriş yapın.');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post("{$this->apiBaseUrl}/api/comments/update/{$id}", [
            'post_slug' => $request->post_slug,
            'content' => $request->content,
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            return redirect()->route('post.show', ['slug' => $request->post_slug])->with('success', 'Yorum başarıyla güncellendi.');
        }

        return redirect()->route('post.show', ['slug' => $request->post_slug])->with('error', $responseData['message'] ?? 'Yorum güncellenemedi.');
    }

    public function delete(Request $request, $id)
    {
        $token = Session::get('token');

        if (!$token) {
            return redirect()->route('login.form')->with('error', 'Yetkilendirme hatası. Lütfen tekrar giriş yapın.');
        }

        $response = Http::withToken($token)->delete("{$this->apiBaseUrl}/api/comments/delete/{$id}");

        $responseData = $response->json();

        if ($response->successful()) {
            return redirect()->route('post.show', ['slug' => $request->post_slug])->with('success', $responseData['message']);
        }

        return redirect()->route('post.show', ['slug' => $request->post_slug])->with('error', $responseData['message'] ?? 'Yorum silinemedi.');
    }
}
