<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <style>
    svg {
    transform: rotate(45deg);
  }

  .gradient {
    animation-iteration-count: infinite;
    animation-duration: 1s;
    fill: url('#gradient-fill');
  }
  .square {
    animation-iteration-count: infinite;
    animation-duration: 2s;
    transition-timing-function: ease-in-out;
  }

  .s1 {
    animation-name: slide-1;
  }

  .s2 {
    animation-name: slide-2;
  }

  .s3 {
    animation-name: slide-3;
  }

  .s4 {
    animation-name: slide-4;
  }

  .s5 {
    animation-name: slide-5;
  }

  .s6 {
    animation-name: slide-6;
  }

  .s7 {
    animation-name: slide-7;
  }

  @keyframes slide-1 {
    37.5% {
      transform: translateX(0px);
    }
    50% {
      transform: translateX(100px);
    }
    100% {
      transform: translateX(100px);
    }
  }

  @keyframes slide-2 {
    25% {
      transform: translateX(0px);
    }
    37.5% {
      transform: translateX(100px);
    }
    100% {
      transform: translateX(100px);
    }
  }

  @keyframes slide-3 {
    12.5% {
      transform: translateY(0px);
    }
    25% {
      transform: translateY(100px);
    }
    100% {
      transform: translateY(100px);
    }
  }

  @keyframes slide-4 {
    50% {
      transform: translateY(0px);
    }
    62.5% {
      transform: translateY(-100px);
    }
    100% {
      transform: translateY(-100px);
    }
  }

  @keyframes slide-5 {
    12.5% {
      transform: translate(-100px, 0px);
    }
    87.5% {
      transform: translate(-100px, 0px);
    }
    100% {
      transform: translate(-100px, 100px);
    }
  }

  @keyframes slide-6 {
    62.5% {
      transform: translateY(0px);
    }
    75% {
      transform: translateY(-100px);
    }
    100% {
      transform: translateY(-100px);
    }
  }

  @keyframes slide-7 {
    75%  {
      transform: translateX(0px);
    }
    87.5% {
      transform: translateX(-100px);
    }
    100% {
      transform: translateX(-100px);
    }
  }
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
