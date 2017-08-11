<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/mypipefy_favicon.png') }}"/>

    <!-- Styles -->
    @stack('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">

                <div class="navbar-header mobile-header">
                  <img class="img-responsive logo" src="{{ asset('img/mypipefy.png') }}" alt="MyPipefy">
                  <a class="navbar-brand" href="{{ url('/dashboard') }}">
                      <span class="text-primary">{{ config('app.name', 'Laravel') }}</span>
                  </a>
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                      <span class="sr-only">Toggle Navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
                  @if (isset($me))
                    <img src="{{$me->avatar_url}}" title="{{$me->name}}" class="avatar img-responsive img-thumbnail">
                  @endif
                    <!-- Collapsed Hamburger -->

                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                  <ul class="nav navbar-nav">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('dashboard.team') }}">Team</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                  </ul>

                </div>
                <div class="collapse navbar-collapse">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <!-- Branding Image -->
                      <img class="img-responsive logo" src="{{ asset('img/mypipefy.png') }}" alt="MyPipefy">
                      <a class="navbar-brand" href="{{ url('/dashboard') }}">
                          <span class="text-primary">{{ config('app.name', 'Laravel') }}</span>
                      </a>
                      <!-- Left Side Of Navbar -->
                      <ul class="nav navbar-nav">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('dashboard.team') }}">Team</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                      </ul>

                    </div>
                    <!-- Right Side Of Navbar -->
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="user-name">
                          @if (isset($me))
                              | {{$me->name}} <img src="{{$me->avatar_url}}" title="{{$me->name}}" class="avatar img-responsive img-thumbnail pull-left">
                          @endif
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
    <script src="{{ asset('js/functions.js') }}"></script>
</body>
</html>
