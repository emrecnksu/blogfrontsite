<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KLE Blog</title>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body class="flex items-center justify-center h-screen">
    <!-- Navigation -->
    <nav class="bg-gray-900 p-8 mt-0 w-full fixed top-0">
        <div class="flex pl-4 text-sm">
            <header class="container mx-auto px-4 py-6 flex items-center justify-between">
                <a href="{{ route('index') }}" class="font-bold text-white text-xl">KLE Blog</a>
            </header>
        </div>
    </nav>

    <!-- Login Form -->
    <div class="w-full max-w-md mx-auto bg-gray-800 p-8 rounded-lg shadow-lg mt-24">
        <div class="flex justify-center mb-6">
            <img src="https://www.kletech.com/wp-content/uploads/2020/03/Kle_logo300x200-1.png" class="w-12 h-12 text-indigo-500">
        </div>
        <h2 class="text-2xl font-bold text-center mb-8">Hesabınıza Giriş Yapın</h2>

        @if (session('error'))
            <div class="bg-red-500 text-white text-sm font-bold px-4 py-3 mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-500 text-white text-sm font-bold px-4 py-3 mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-300">E-Posta</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 bg-gray-900 border border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-300">Şifre</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 bg-gray-900 border border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                <div class="flex justify-end mt-2">
                    <a href="#" class="text-sm text-indigo-400 hover:underline">Şifrenizi mi unuttunuz?</a>
                </div>
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Giriş Yap</button>
        </form>
        <div class="mt-6 text-center">
            <p class="text-sm">Hesabınız yok mu? <a href="{{ route('register.form') }}" class="text-indigo-400 hover:underline">Kayıt olun</a></p>
        </div>
    </div>
</body>
</html>
