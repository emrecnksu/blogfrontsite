<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="flex items-center justify-center h-screen">
    <div class="w-full max-w-md mx-auto bg-gray-800 p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-8">Hesabınızı Oluşturun</h2>
        
        @if (session('error'))
            <div class="bg-red-500 text-white text-sm font-bold px-4 py-3 mb-4 rounded" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white text-sm font-bold px-4 py-3 mb-4 rounded" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-300">Ad</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 bg-gray-900 border border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('name') }}">
            </div>
            <div class="mb-4">
                <label for="surname" class="block text-sm font-medium text-gray-300">Soyad</label>
                <input type="text" id="surname" name="surname" class="mt-1 block w-full px-3 py-2 bg-gray-900 border border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('surname') }}">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-300">E-Posta</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 bg-gray-900 border border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('email') }}">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-300">Şifre</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 bg-gray-900 border border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Şifre Tekrarı</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full px-3 py-2 bg-gray-900 border border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Kayıt Ol</button>
        </form>
        
        <div class="mt-6 text-center">
            <p class="text-sm">Zaten hesabınız var mı? <a href="{{ route('login.form') }}" class="text-indigo-400 hover:underline">Giriş Yap</a></p>
        </div>
    </div>
</body>
</html>
