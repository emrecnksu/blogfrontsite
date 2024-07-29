<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CommentController
{
    public function store(Request $request)
    {
        $token = Session::get('token');

        if (!$token) {
            return redirect()->route('login.form')->with('error', 'Yetkilendirme hatası. Lütfen tekrar giriş yapın.');
        }

        $response = Http::withToken($token)->post('http://host.docker.internal/api/comments', [
            'post_id' => $request->post_id,
            'content' => $request->content,
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            return redirect()->route('post.show', ['id' => $request->post_id])->with('success', $responseData['message']);
        }

        return redirect()->route('post.show', ['id' => $request->post_id])->with('error', $responseData['error'] ?? 'Yorum eklenemedi.');
    }

    public function update(Request $request, $id)
    {
        $token = Session::get('token');

        if (!$token) {
            return redirect()->route('login.form')->with('error', 'Yetkilendirme hatası. Lütfen tekrar giriş yapın.');
        }

        $response = Http::withToken($token)->put("http://host.docker.internal/api/comments/{$id}", [
            'content' => $request->content,
            'post_id' => $request->post_id,
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            return redirect()->route('post.show', ['id' => $request->post_id])->with('success', $responseData['message']);
        }

        return redirect()->route('post.show', ['id' => $request->post_id])->with('error', $responseData['error'] ?? 'Yorum güncellenemedi.');
    }

    public function delete(Request $request, $id)
    {
        $token = Session::get('token');

        if (!$token) {
            return redirect()->route('login.form')->with('error', 'Yetkilendirme hatası. Lütfen tekrar giriş yapın.');
        }

        $response = Http::withToken($token)->delete("http://host.docker.internal/api/comments/{$id}", [
            'post_id' => $request->post_id,
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            return redirect()->route('post.show', ['id' => $request->post_id])->with('success', $responseData['message']);
        }

        return redirect()->route('post.show', ['id' => $request->post_id])->with('error', $responseData['error'] ?? 'Yorum silinemedi.');
    }
}

