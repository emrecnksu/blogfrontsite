<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController
{
    public function index()
    {
        $categoriesResponse = Http::get('http://host.docker.internal/api/categories');
        $postsResponse = Http::get('http://host.docker.internal/api/posts');

        $categories = $categoriesResponse->successful() ? $categoriesResponse->json()['categories'] : [];
        $posts = $postsResponse->successful() ? $postsResponse->json()['posts'] : [];

        return view('HomePage', compact('categories', 'posts'));
    }

    public function show($id)
    {
        $postInfoResponse = Http::get("http://host.docker.internal/api/posts/show/{$id}");
        $categoriesResponse = Http::get('http://host.docker.internal/api/categories');
        $relatedPostsResponse = Http::get("http://host.docker.internal/api/posts/related/{$id}");
        $commentsResponse = Http::get("http://host.docker.internal/api/comments", ['query' => ['post_id' => $id]]);

        $categories = $categoriesResponse->successful() ? $categoriesResponse->json()['categories'] : [];
        $postInfo = $postInfoResponse->successful() ? $postInfoResponse->json()['post'] : null;
        $relatedPosts = $relatedPostsResponse->successful() ? $relatedPostsResponse->json()['relatedPosts'] : [];
        $isCategoryRelated = $relatedPostsResponse->successful() ? $relatedPostsResponse->json()['isCategoryRelated'] : false;
        $comments = $commentsResponse->successful() ? $commentsResponse->json()['comments'] : [];

        return view('PostsInfo', compact('postInfo', 'categories', 'relatedPosts', 'isCategoryRelated', 'comments'));
    }

    public function categoryPosts($id)
    {
        $response = Http::get("http://host.docker.internal/api/categories/{$id}/posts");
        $categoriesResponse = Http::get('http://host.docker.internal/api/categories');

        if ($response->successful() && $categoriesResponse->successful()) {
            $category = $response->json()['category'];
            $posts = $response->json()['posts'];
            $categories = $categoriesResponse->json()['categories'];

            return view('CategoryPosts', compact('category', 'posts', 'categories'));
        }

        return redirect()->route('index')->with('error', 'Kategoriye ait gönderiler yüklenemedi.');
    }

    public function showkvkk()
    {
        $response = Http::get('http://host.docker.internal/api/kvkk'); 
        $kvkk = $response->json('kvkk');
        $categoriesResponse = Http::get('http://host.docker.internal/api/categories');
        $categories = $categoriesResponse->successful() ? $categoriesResponse->json()['categories'] : [];

        return view('kvkk.show', compact('kvkk', 'categories'));
    }
}
