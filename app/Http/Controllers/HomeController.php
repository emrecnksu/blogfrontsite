<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController
{
    public function index()
    {
        $categoriesResponse = Http::get('http://host.docker.internal/api/categories');
        $postsResponse = Http::get('http://host.docker.internal/api/posts');

        $categories = $categoriesResponse->successful() ? $categoriesResponse->json()['data'] : [];
        $posts = $postsResponse->successful() ? $postsResponse->json()['data'] : [];

        return view('HomePage', compact('categories', 'posts'));
    }

    public function show($id)
    {
        $postInfoResponse = Http::get("http://host.docker.internal/api/posts/show/{$id}");
        $categoriesResponse = Http::get('http://host.docker.internal/api/categories');
        $relatedPostsResponse = Http::get("http://host.docker.internal/api/posts/related/{$id}");
        $commentsResponse = Http::get("http://host.docker.internal/api/comments", ['query' => ['post_id' => $id]]);

        $categories = $categoriesResponse->successful() ? $categoriesResponse->json()['data'] : [];
        $postInfo = $postInfoResponse->successful() ? $postInfoResponse->json()['data'] : null;
        $relatedPosts = $relatedPostsResponse->successful() ? $relatedPostsResponse->json()['relatedPosts'] : [];
        $isCategoryRelated = $relatedPostsResponse->successful() ? $relatedPostsResponse->json()['isCategoryRelated'] : false;
        $comments = $commentsResponse->successful() ? $commentsResponse->json()['data'] : [];

        return view('PostsInfo', compact('postInfo', 'categories', 'relatedPosts', 'isCategoryRelated', 'comments'));
    }

    public function categoryPosts($id)
    {
        $response = Http::get("http://host.docker.internal/api/categories/{$id}/posts");
        $categoriesResponse = Http::get('http://host.docker.internal/api/categories');

        if ($response->successful() && $categoriesResponse->successful()) {
            $responseData = $response->json()['data']; 
            $category = $responseData['category'];
            $posts = $responseData['posts'];
            $categories = $categoriesResponse->json()['data'];

            return view('CategoryPosts', compact('category', 'posts', 'categories'));
        }
    }

    public function showkvkk()
    {
        $response = Http::get('http://host.docker.internal/api/kvkk');
        $kvkk = $response->json('data');
        $categoriesResponse = Http::get('http://host.docker.internal/api/categories');
        $categories = $categoriesResponse->successful() ? $categoriesResponse->json()['data'] : [];

        return view('kvkk.show', compact('kvkk', 'categories'));
    }
}
