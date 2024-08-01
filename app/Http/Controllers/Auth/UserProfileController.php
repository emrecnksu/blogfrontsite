<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class UserProfileController
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = config('app.api_base_url');
    }

    public function update(Request $request)
    {
        $token = Session::get('token');

        $response = Http::withToken($token)->post("{$this->apiBaseUrl}/api/users/profile/update", [
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'current_password' => $request->current_password,
            'new_password' => $request->new_password,
            'new_password_confirmation' => $request->new_password_confirmation,
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            Session::put('name', $responseData['data']['name']);
            Session::put('surname', $responseData['data']['surname']);

            return redirect()->route('profile')->with('success', $responseData['message']);
        }

        return redirect()->back()->with('error', $responseData['error'] ?? 'Profil güncelleme başarısız oldu.');
    }

    public function show()
    {
        $token = Session::get('token');

        $response = Http::withToken($token)->get("{$this->apiBaseUrl}/api/users/profile");
        $responseData = $response->json();

        if ($response->successful()) {
            return view('profile', ['user' => $responseData['data']]);
        }

        return redirect()->back()->with('error', $responseData['message'] ?? 'Profil yüklenemedi.');
    }

    public function delete(Request $request)
    {
        $token = Session::get('token');

        $response = Http::withToken($token)->post("{$this->apiBaseUrl}/api/users/profile/delete", [
            'delete_password' => $request->delete_password,
        ]);

        $responseData = $response->json(); 
        
        if ($response->successful()) {
            Session::forget('token');
            Session::forget('name');
            Session::forget('surname');
             
            return redirect()->route('index')->with('success', $responseData['message']);  
        }

        return redirect()->back()->with('error', $responseData['error'] ?? 'Hesap silme işlemi başarısız oldu.');
    }
}
