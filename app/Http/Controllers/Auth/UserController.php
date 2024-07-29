<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class UserController
{
    public function signup(Request $request)
    {
        return view("register");
    }

    public function register(Request $request)
    {
        $response = Http::post('http://host.docker.internal/api/register', [
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

        return redirect()->back()->with('error', $responseData['error']);
    }

    public function loginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $response = Http::post('http://host.docker.internal/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            Session::put('token', $responseData['token']);
            Session::put('user_id', $responseData['user_id']);
            Session::put('name', $responseData['name']);
            Session::put('surname', $responseData['surname']);

            return redirect()->route('index')->with('success', $responseData['message']);
        }

        return redirect()->back()->with('error', $responseData['error']);
    }

    public function logout(Request $request)
    {
        $token = $request->session()->get('token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('http://host.docker.internal/api/logout');

        if ($response->successful()) {
            $responseData = $response->json();

            Auth::logout();
            Session::flush();;

            return redirect()->route('login.form')->with('success', $responseData['message']);
        }

        $responseData = $response->json();
        $error = isset($responseData['error']) ? $responseData['error'] : 'Bir hata oluştu. Lütfen tekrar deneyin.';
        return back()->with('error', $error);
    }
}
