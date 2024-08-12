<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = config('app.api_base_url');
    }

    public function index()
    {
        $postsResponse = Http::get("{$this->apiBaseUrl}/api/posts");
        $posts = $postsResponse->successful() ? $postsResponse->json()['data'] : [];

        return view('HomePage', compact('posts'));
    }

    public function show($slug)
    {
        $postInfoResponse = Http::get("{$this->apiBaseUrl}/api/post/{$slug}");
        $relatedPostsResponse = Http::get("{$this->apiBaseUrl}/api/posts/related/{$slug}");
        $commentsResponse = Http::get("{$this->apiBaseUrl}/api/comments", ['query' => ['post_slug' => $slug]]);

        $postInfo = $postInfoResponse->successful() ? $postInfoResponse->json()['data'] : null;

        $relatedPosts = $relatedPostsResponse->successful() ? $relatedPostsResponse->json()['data']['relatedPosts'] : [];
        $isCategoryRelated = $relatedPostsResponse->successful() ? $relatedPostsResponse->json()['data']['isCategoryRelated'] : false;
        $comments = $commentsResponse->successful() ? $commentsResponse->json()['data'] : [];

        return view('PostsInfo', compact('postInfo', 'relatedPosts', 'isCategoryRelated', 'comments'));
    }

    public function categoryPosts($slug)
    {
        $response = Http::get("{$this->apiBaseUrl}/api/categories/{$slug}/posts");

        if ($response->successful()) {
            $responseData = $response->json()['data'];
            $category = $responseData['category'];
            $posts = $responseData['posts'];

            return view('CategoryPosts', compact('category', 'posts'));
        }
    }

    public function showContent($type)
    {
        $response = Http::get("{$this->apiBaseUrl}/api/text-contents/{$type}");
        $textContent = $response->successful() ? $response->json()['text_content'] : '';
        $textContent = $response->successful() ? $response->json()['data']['text_content'] : '';

        return view('TextContent.ContentPage', compact('textContent', 'type'));
    }
}

