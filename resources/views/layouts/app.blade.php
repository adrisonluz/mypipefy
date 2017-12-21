<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <base href="{{ url('') }}/">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('img/mypipefy_favicon.png') }}"/>

  <!-- Styles -->
  <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  @stack('styles')
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/default.css') }}" rel="stylesheet">
  <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
</head>
<body class="rodando">
  <div class="loader">
    <div class="load-pages">
      <p class="navbar-brand">
        <img class="img-responsive logo" src="{{ asset('img/mypipefy_logo_extenso.png') }}" alt="MyPipefy">
      </p>
      <div class="gif-loader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  @include('modal')
  <div id="app">
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">

        <div class="navbar-header mobile-header hidden-lg hidden-md hidden-sm">
          <a class="navbar-brand" href="{{ url('/dashboard') }}">
            <img class="img-responsive logo" src="{{ asset('img/mypipefy.png') }}" alt="MyPipefy">
            <span class="text-primary">{{ config('app.name', 'Laravel') }}</span>
          </a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="mobile-menu-perfil">

            @if (isset($me))
            <img src="{{ $me->avatar() }}" title="{{$me->name}}" class="avatar img-responsive img-thumbnail">
            @endif
            <div class="menu-perfil-mobile">
              <ul>
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
          </div>
        </div>
        @if(isset($invites) and count($invites) > 0)
        <div class="pull-left notification-mobile">
          <div class="notifications dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
            <i class="fa fa-bell-o"></i>
            <span class="badge">{{ count($invites) }}</span>
          </div>
          <ul class="dropdown-menu invites pull-right">
            @foreach($invites as $invite)
            <li class="dropdown">
              <strong>{{'@'.$invite->user->pipefyUser->username}}</strong> convidou você para o time dele.
              <div class="buttons" data-teamid="{{$invite->id}}" data-route="{{ route('config.changeInvite') }}">
                <div class="decline">
                  <!-- <i class="fa fa-times-circle-o text-danger"></i> -->
                  Recusar
                </div>
                <div class="accept">
                  <!-- <i class="fa fa-check-circle-o text-success"></i> -->
                  Aceitar
                </div>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
        @endif
        <!-- Collapsed Hamburger -->

      </div>
      <div class="collapse navbar-collapse hidden-lg hidden-md hidden-sm" id="app-navbar-collapse">
        <ul class="nav navbar-nav hidden-lg hidden-md hidden-sm">
          <!-- Authentication Links -->
          @if (Auth::guest())
          <li><a href="{{ route('login') }}">Login</a></li>
          <li><a href="{{ route('register') }}">Cadastro</a></li>
          @else
          <li><a href="{{ route('dashboard') }}">Minha Dashboard</a></li>
          @can ('is-manager')
            <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Meu time <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('dashboard.team') }}">Pautas</a></li>
                <li><a href="{{ route('dashboard.general') }}">Pauta Geral</a></li>
              </ul>
            </li>
          @endcan
          <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Configurações<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="{{ route('config.team') }}">Time</a></li>
              <li><a href="{{ route('config.pipes') }}">Dashboard</a></li>
            </ul>
          </li>
          <li class="divider"></li>
          <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
          </li>
          @endif
        </ul>
        <div class="collapse navbar-collapse">
          <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/dashboard') }}">
              <img class="img-responsive logo" src="{{ asset('img/mypipefy.png') }}" alt="MyPipefy">
              <span class="text-primary">{{ config('app.name', 'Laravel') }}</span>
            </a>
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
              <!-- Authentication Links -->
              @if (Auth::guest())
              <li><a href="{{ route('login') }}">Login</a></li>
              <li><a href="{{ route('register') }}">Cadastro</a></li>
              @else
              <li><a href="{{ route('dashboard') }}">Minha Dashboard</a></li>
              @can ('is-manager')
                <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Meu time <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ route('dashboard.team') }}">Pautas</a></li>
                    <li><a href="{{ route('dashboard.general') }}">Pauta Geral</a></li>
                  </ul>
                </li>
              @endcan
              <li><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Configurações <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="{{ route('config.team') }}">Time</a></li>
                  <li><a href="{{ route('config.pipes') }}">Dashboard</a></li>
                </ul>
              </li>
              @endif
            </ul>

          </div>
          <!-- Right Side Of Navbar -->
          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
            <div class="user-name">
              @if (isset($me))
              {{FirstAndLastName($me->name)}}

              @if(count($invites) > 0)
              <div class="pull-left">
                <div class="notifications dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
                  <i class="fa fa-bell-o"></i>
                  <span class="badge">{{ count($invites) }}</span>
                </div>
                <ul class="dropdown-menu invites pull-right">
                  @foreach($invites as $invite)
                  <li class="dropdown">
                    <strong>{{'@'.$invite->user->pipefyUser->username}}</strong> convidou você para o time dele.
                    <div class="buttons" data-teamid="{{$invite->id}}" data-route="{{ route('config.changeInvite') }}">
                      <div class="decline">
                        Recusar
                      </div>
                      <div class="accept">
                        Aceitar
                      </div>
                    </div>
                  </li>
                  @endforeach
                </ul>
              </div>
              @endif

              <img src="{{ $me->avatar() }}" title="{{$me->name}}" class="avatar img-responsive img-thumbnail pull-left">

              <ul class="nav navbar-nav" style="float:right;">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="caret"></span>
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
            </ul>
            @endif
          </div>
        </div>
      </div>
    </div>
  </nav>

  @yield('content')
</div>
<div class="click-to-top">
  <a href="javascript:void(0)"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i></a>
</div>
<footer>
  <div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
      <img class="img-responsive logo" src="{{ asset('img/mypipefy_logo_extenso_inverso.png') }}" alt="MyPipefy">
    </div>
  </div>
</footer>
<!-- Scripts -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@stack('scripts')
<script src="//cdn.rawgit.com/namuol/cheet.js/master/cheet.min.js" type="text/javascript"></script>
<script src="{{ asset('js/functions.js') }}"></script>
</body>
</html>
