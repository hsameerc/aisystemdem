<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss','resources/js/jquery.js', 'resources/js/app.js'])
</head>
<body class="text-center text-dark">
<div id="application">
    <header class="mb-auto">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="bi-menu-down"></i>
                </a>
                <button class="navbar-toggler" type="button" @click="toggleMenu">
                    <i class="bi-menu-app"></i>
                </button>
                <div class="collapse navbar-collapse justify-content-end" :class="{ 'show': isMenuOpen }">
                    <ul class="navbar-nav ml-auto" :class="{ 'active': isMenuOpen }">
                        @guest

                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/app') }}"><i
                                        class="bi-house"></i> {{ __('Dashboard') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/app/my-passport') }}"><i
                                        class="bi-shield-lock"></i> {{ __('My Passport') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit(); sessionStorage.removeItem('SystemPersistedState')">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
