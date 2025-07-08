{{-- Layout utilizzato dentro l'autentificazione e verifica --}}
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Edu+TAS+Beginner:wght@400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nerko+One&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Raleway:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sometype+Mono:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">
    {{-- titolo fisso con sottotitolo dinamico --}}
    <title>Sicilia e sapori: @yield('title')</title>
    {{-- file css e js di vite --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <header>
          <div id="app">

        {{-- navbar --}}
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                {{-- LINK dashboard con logo --}}
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/dashboard') }}">
                    <div class="logo">
                        <img src="{{ asset('img/logo.svg') }}" alt="">
                    </div>
                    {{-- config('app.name', 'Laravel') --}}
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Lato sinistro  -->
                    <ul class="navbar-nav me-auto">
                        {{-- LINK -> Prodotti --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/products') }}">{{ __('Prodotti') }}</a>
                        </li>
                        {{-- LINK -> Allergeni --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/allergens') }}">{{ __('Allergeni') }}</a>
                        </li>
                        
                        {{-- LINK -> Categorie --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/categories') }}">{{ __('Categorie') }}</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        
                        {{-- se la registrazione è attiva mostrare link --}}
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else


                        {{-- link amministrativi --}}
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('dashboard') }}">{{__('Dashboard')}}</a>
                                <a class="dropdown-item" href="{{ url('profile') }}">{{__('Profile')}}</a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
    </header>
    @yield('content')
    
</body>
</html>