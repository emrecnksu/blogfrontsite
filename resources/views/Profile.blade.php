<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-200 font-sans leading-normal tracking-normal">

    <header class="bg-gray-900 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-white text-lg font-bold">KLE Blog</a>
            <nav>
                <ul class="flex items-center space-x-4">
                    @if (session('token'))
                        <li class="text-white">{{ session('name') }} {{ session('surname') }}</li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-white">Çıkış Yap</button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login.form') }}" class="text-white">Giriş Yap</a></li>
                        <li><a href="{{ route('register.form') }}" class="text-white">Kayıt Ol</a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </header>

    <div class="container-fluid mx-auto bg-gray-200">
        <div class="flex justify-center">
            @if (session('error'))
                @if(is_array(session('error')))
                    <div class="bg-red-500 mt-3 text-white text-sm font-bold px-4 py-3 mb-4 rounded" role="alert">
                        {{ reset(array_values(session('error'))[0]) }}
                    </div>
                @else
                    <div class="bg-red-500 mt-3 text-white text-sm font-bold px-4 py-3 mb-4 rounded" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
            @endif

            @if (session('success'))
                <div class="bg-green-500 text-white mt-3 text-sm font-bold px-4 py-3 mb-4 rounded" role="alert">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>

    <div class="container mx-auto px-4 py-4">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h1 class="text-2xl font-bold mb-4">Profil</h1>
            @if ($user)
                <!-- Profil Güncelleme Formu -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <form action="{{ route('profile.update', ['id' => $user['id']]) }}" method="POST" class="bg-white p-6 rounded shadow-md">
                        @csrf
                        <h2 class="text-xl font-bold mb-4">Profil Güncelleme</h2>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Ad</label>
                            <input type="text" name="name" id="name" value="{{ $user['name'] }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="surname">Soyad</label>
                            <input type="text" name="surname" id="surname" value="{{ $user['surname'] }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">E-posta</label>
                            <input type="email" name="email" id="email" value="{{ $user['email'] }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="current_password">Mevcut Şifre</label>
                            <input type="password" name="current_password" id="current_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="new_password">Yeni Şifre</label>
                            <input type="password" name="new_password" id="new_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="new_password_confirmation">Yeni Şifre Tekrar</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Güncelle</button>
                        </div>
                    </form>

                    <!-- Hesap Silme Formu -->
                    <form action="{{ route('profile.delete', ['id' => $user['id']]) }}" method="POST" class="bg-white p-6 rounded shadow-md">
                        @csrf
                        <h2 class="text-xl font-bold mb-4">Hesabı Sil</h2>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="delete_password">Mevcut Şifre</label>
                            <input type="password" name="delete_password" id="delete_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Hesabı Sil</button>
                    </form>
                </div>
            @else
                <p>Kullanıcı bilgileri yüklenemedi.</p>
            @endif
        </div>
    </div>
</body>
</html>
