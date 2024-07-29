<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class UserProfileController
{
    public function update(Request $request)
    {
        $token = Session::get('token');

        $response = Http::withToken($token)->post('http://host.docker.internal/api/users/profile/update', [
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'current_password' => $request->current_password,
            'new_password' => $request->new_password,
            'new_password_confirmation' => $request->new_password_confirmation,
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            // Kullanıcı bilgilerini güncelle
            Session::put('name', $request->name);
            Session::put('surname', $request->surname);

            return redirect()->route('profile')->with('success', $responseData['message']);
        }

        // Hata mesajını kontrol et ve uygun şekilde göster
        $error = isset($responseData['error']) ? $responseData['error'] : 'Bir hata oluştu. Lütfen tekrar deneyin.';
        return redirect()->back()->with('error', $error);
    }


    public function show()
    {
        $token = Session::get('token');

        $response = Http::withToken($token)->get('http://host.docker.internal/api/users/profile');
        $responseData = $response->json();

        if ($response->successful()) {
            return view('profile', ['user' => $responseData]);
        }

        return redirect()->back()->with('error', $responseData['message']);
    }

    public function delete(Request $request)
    {
        $token = Session::get('token');

        $response = Http::withToken($token)->post('http://host.docker.internal/api/users/profile/delete', [
            'delete_password' => $request->delete_password,
        ]);
        
        $responseData = $response->json();

        if ($response->successful()) {
            Session::forget('token');
            Session::forget('name');
            Session::forget('surname');
            return redirect()->route('index')->with('success', $responseData['message']);
        }

        $error = isset($responseData['error']) ? $responseData['error'] : 'Bir hata oluştu. Lütfen tekrar deneyin.';
        return redirect()->back()->with('error', $error);
    }
}
