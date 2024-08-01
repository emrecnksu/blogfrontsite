<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'KLE Blog')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/HomePage.css') }}">
</head>
<body class="bg-white font-sans leading-normal tracking-normal min-h-screen flex flex-col">
    <nav class="bg-gray-900 p-4 mt-0 w-full">
        <div class="max-w-screen-xl flex items-center justify-between mx-auto px-6 py-6">
            <a href="{{ route('index') }}" class="flex items-center text-white mr-6">
                <span class="font-bold text-3xl">KLE Blog</span>
            </a>
            <button id="mobile-menu-button" data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
            <div class="hidden w-full md:flex md:items-center md:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-row space-x-4">
                    <li class="relative group">
                        <button class="rounded-full px-3 py-2 font-semibold bg-white bg-opacity-10 flex items-center" id="categories-button">
                            <span class="mr-2 text-white">Kategoriler</span>
                        </button>
                        <div class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden" id="categories-menu">
                            @foreach ($categories as $category)
                                <a href="{{ route('category.posts', ['id' => $category['id']]) }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">{{ $category['name'] }}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
                <ul class="flex items-center ml-4">
                    @if (Session::has('token'))
                        <li class="relative group">
                            <button class="rounded-full px-3 py-2 font-semibold bg-white bg-opacity-10 flex items-center" id="user-menu-button">
                                <span class="mr-2 text-white">{{ Session::get('user.name')}} {{ Session::get('user.surname') }}</span>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden" id="user-menu">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Profil</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-gray-800 hover:bg-gray-200">Çıkış Yap</button>
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="flex items-center">
                            <a href="{{ route('register.form') }}" class="rounded-full px-3 py-2 font-semibold bg-white bg-opacity-10 flex items-center">
                                <span class="mr-2 text-white">Kayıt Ol</span>
                            </a>
                            <a href="{{ route('login.form') }}" class="rounded-full px-3 py-2 ml-5 font-semibold bg-white bg-opacity-10 flex items-center">
                                <span class="mr-2 text-white">Giriş Yap</span>
                            </a>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
        <div class="md:hidden" id="mobile-menu">
            <ul class="font-medium flex flex-col space-y-4 px-4">
                <li>
                    <a href="#" class="block px-4 py-2 text-white">Kategoriler</a>
                    <ul class="ml-4 mt-2 space-y-2">
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('category.posts', ['id' => $category['id']]) }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">{{ $category['name'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                @if (!Session::has('token'))
                    <li>
                        <a href="{{ route('register.form') }}" class="block px-4 py-2 text-white">Kayıt Ol</a>
                    </li>
                    <li>
                        <a href="{{ route('login.form') }}" class="block px-4 py-2 text-white">Giriş Yap</a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>

    <div class="container mx-auto">
        <div class="flex justify-center">
            @if (session('error'))
                <div class="bg-red-500 mt-3 text-white text-sm font-bold px-4 py-3 mb-4 rounded" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-500 text-white mt-3 text-sm font-bold px-4 py-3 mb-4 rounded" role="alert">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>

    <main class="container mx-auto py-4 flex-grow">
        @yield('content')
    </main>

    <footer class="bg-gray-900 mt-auto">
        <div class="container max-w-6xl mx-auto flex items-center px-2 py-8">
            <div class="w-full mx-auto flex flex-wrap items-center">
                <div class="flex w-full md:w-1/2 justify-center md:justify-start text-white font-extrabold">
                    <a class="text-gray-900 no-underline hover:text-gray-900 hover:no-underline" href="#">
                        <span class="text-base text-gray-200">KLE Blog</span>
                    </a>
                </div>
                <div class="flex w-full md:w-1/2 justify-center md:justify-end text-white font-extrabold">
                    <a class="text-gray-200 no-underline hover:text-gray-400 hover:no-underline" href="{{ route('kvkk.show') }}">
                        KVKK
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
            });

            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');
            const categoriesButton = document.getElementById('categories-button');
            const categoriesMenu = document.getElementById('categories-menu');

            userMenuButton.addEventListener('click', function () {
                userMenu.classList.toggle('hidden');
            });

            categoriesButton.addEventListener('click', function () {
                categoriesMenu.classList.toggle('hidden');
            });
        });
    </script>

    {{-- <script>
        var navToggle = document.getElementById("nav-toggle");
        var navContent = document.getElementById("nav-content");

        navToggle.addEventListener("click", function () {
            navContent.classList.toggle("hidden");
        });

        var userMenuButton = document.getElementById("user-menu-button");
        var userMenu = document.getElementById("user-menu");

        userMenuButton.addEventListener("click", function () {
            userMenu.classList.toggle("hidden");
        });

        var h = document.documentElement,
            b = document.body,
            st = 'scrollTop',
            sh = 'scrollHeight',
            progress = document.querySelector('#progress'),
            scroll;
        var scrollpos = window.scrollY;
        var header = document.getElementById("header");

        document.addEventListener('scroll', function() {
            scroll = (h[st] || b[st]) / ((h[sh] || b[sh]) - h.clientHeight) * 100;
            progress.style.setProperty('--scroll', scroll + '%');

            scrollpos = window.scrollY;

            if (scrollpos > 100) {
                header.classList.remove("hidden");
                header.classList.remove("fadeOutUp");
                header.classList.add("slideInDown");
            } else {
                header.classList.remove("slideInDown");
                header.classList.add("fadeOutUp");
                header.classList.add("hidden");
            }
        });

        const t = document.querySelector(".js-scroll-top");
        if (t) {
            t.onclick = () => {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                })
            };
            const e = document.querySelector(".scroll-top path"),
                o = e.getTotalLength();
            e.style.transition = e.style.WebkitTransition = "none",
                e.style.strokeDasharray = `${o} ${o}`,
                e.style.strokeDashoffset = o,
                e.getBoundingClientRect(),
                e.style.transition = e.style.WebkitTransition = "stroke-dashoffset 10ms linear";
            const n = function() {
                const t = window.scrollY || window.scrollTopBtn or document.documentElement.scrollTopBtn,
                    n = Math.max(document.body.scrollHeight, document.documentElement.scrollHeight, document.body.offsetHeight, document.documentElement.offsetHeight, document.body.clientHeight, document.documentElement.clientHeight),
                    s = Math.max(document.documentElement.clientHeight, window.innerHeight or 0);
                var l = o - t * o / (n - s);
                e.style.strokeDashoffset = l
            };
            n();
            const s = 100;
            window.addEventListener("scroll", (function(e) {
                n();
                (window.scrollY or window.scrollTopBtn or document.getElementsByTagName("html")[0].scrollTopBtn) > s ? t.classList.add("is-active") : t.classList.remove("is-active")
            }), !1)
        }
    </script> --}}
</body>
</html>
