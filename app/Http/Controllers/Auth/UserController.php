<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class UserController
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = config('app.api_base_url');
    }

    public function signup()
    {
        return view("register");
    }

    public function register(Request $request)
    {
        $response = Http::post("{$this->apiBaseUrl}/api/register", [
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            return redirect()->route('login.form')->with('success', $responseData['message']);
        }

        return redirect()->back()->with('error', $responseData['error'] ?? 'Kayıt işlemi başarısız oldu.');
    }

    public function loginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $response = Http::post("{$this->apiBaseUrl}/api/login", [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            Session::put('token', $responseData['data']['token']);
            Session::put('user_id', $responseData['data']['user']['id']);
            Session::put('name', $responseData['data']['user']['name']);
            Session::put('surname', $responseData['data']['user']['surname']);  

            return redirect()->route('index')->with('success', $responseData['message']);
        }

        return redirect()->back()->with('error', $responseData['error'] ?? 'Giriş işlemi başarısız oldu.');
    }

    public function logout(Request $request)
    {
        $token = Session::get('token');
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post("{$this->apiBaseUrl}/api/logout");

        if ($response->successful()) {
            Session::flush();
            
            return redirect()->route('login.form')->with('success', $response->json()['message']);    
        }

        return back()->with('error', $response->json()['error'] ?? 'Bir hata oluştu. Lütfen tekrar deneyin.');
    }
}
