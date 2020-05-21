<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FantasyClass') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/90342cb187.js" crossorigin="anonymous"></script>

    <!-- Mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <script src="/js/pace.min.js"></script>

</head>
    <body class="has-background-white-bis">
    <div id="app">
        @auth
            <nav class="navbar card-shadow-s" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                    <a href="/classroom" class="is-flex align-items-center" style="text-decoration: none">
                        <img src="/img/logo.png" width="36px" height="38px" class="has-margin-left-3">
                        <label class="label-title has-padding-left-2">
                            @yield('title','FantasyClass')
                        </label>
                    </a>
                <a role="button" class="navbar-burger burger" @click="showNav = !showNav" :class="{ 'is-active': showNav }" aria-label="menu" aria-expanded="false" data-target="navbar">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbar" class="navbar-menu" :class="{ 'is-active': showNav }">
                @if(isset($class))
                <div class="navbar-start">
                        <a href="/classroom/{{ $class->code }}" class="navbar-item">
                            <i class="fad fa-users has-margin-right-2"></i> {{ __('menu.users') }}
                        </a>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link">
                                <i class="fad fa-treasure-chest has-margin-right-2"></i> {{ __('menu.rewards') }}
                            </a>

                            <div class="navbar-dropdown">
                                <a href="/classroom/{{ $class->code }}/cards" class="navbar-item">
                                    <i class="fad fa-club has-margin-right-2"></i> {{ __('menu.cards') }}
                                </a>
                                <a href="/classroom/{{ $class->code }}/behaviours" class="navbar-item">
                                    <i class="fad fa-heart has-margin-right-2"></i> {{ __('menu.behaviours') }}
                                </a>
                            </div>
                        </div>
                        <a class="navbar-item">
                            <i class="fad fa-map-marked-alt has-margin-right-2"></i> {{ __('menu.map') }}
                        </a>
                        <a class="navbar-item">
                            <i class="fad fa-tasks has-margin-right-2"></i> {{ __('menu.goals') }}
                        </a>
                        <a class="navbar-item">
                            <i class="fad fa-pen-fancy has-margin-right-2"></i> {{ __('menu.stories') }}
                        </a>
                        <a class="navbar-item">
                            <i class="fad fa-store has-margin-right-2"></i> {{ __('menu.shop') }}
                        </a>
                        <a class="navbar-item">
                            <i class="fad fa-pencil-ruler has-margin-right-2"></i> {{ __('menu.rules') }}
                        </a>
                        <a class="navbar-item">
                            <i class="fad fa-file-alt has-margin-right-2"></i> {{ __('menu.log') }}
                        </a>
                        <a class="navbar-item">
                            <i class="fad fa-sliders-v-square has-margin-right-2"></i> {{ __('menu.settings') }}
                        </a>

                        <!-- <a href="/classroom/{{ $class->code }}/map" class="has-padding-x-4 pl-1"><i class="fad fa-map-marked-alt"></i></a>
        <a href="/classroom/{{ $class->code }}/stories" class="has-padding-x-4"><i class="fad fa-pen-fancy"></i></a>
        <a href="/classroom/{{ $class->code }}/missions" class="has-padding-x-4"><i class="fad fa-tasks"></i></a>
        <a href="/classroom/{{ $class->code }}/store" class="has-padding-x-4"><i class="fad fa-store"></i></a>
        <a href="/classroom/{{ $class->code }}/rules" class="has-padding-x-4"><i class="fad fa-pencil-ruler"></i></a>
        <a href="/classroom/{{ $class->code }}/log" class="has-padding-x-4"><i class="fad fa-file-alt"></i></a>
        <a href="/classroom/{{ $class->code }}/settings" class="has-padding-x-4"><i class="fad fa-sliders-v-square"></i></a> -->
                </div>
                @endif

                <div class="navbar-end has-text-right">
                    <div class="navbar-item">
                        <div class="dropdown is-right is-hoverable">
                            <div class="dropdown-trigger">
                                <button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
                                <span>
                                    <i class="fas fa-user-graduate"></i> 
                                    <span class="pl-2 text-light cursor-default">
                                        {{ Str::limit(Auth::user()->username, 8, $end='...') }}
                                    </span>
                                </span>
                                <span class="icon is-small">
                                    <i class="fas fa-angle-down" aria-hidden="true"></i>
                                </span>
                                </button>
                            </div>
                            <div class="dropdown-menu has-text-left" id="dropdown-menu" role="menu">
                                <div class="dropdown-content">
                                    <span href="#" class="dropdown-item">
                                        {{ Auth::user()->username }}
                                    </span>
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="/preferences/edit">
                                        <i class="fal fa-cog"></i> {{ __('menu.profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fal fa-sign-out"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                            </div>
                    </div>
                </div>
            </div>
            </nav>

        <!-- <nav class="menu-labels card-shadow-s">
            <div class="is-flex align-items-center h-100">
                <a href="/classroom" class="is-flex align-items-center" style="text-decoration: none">
                    <img src="/img/logo.png" width="36px" height="38px" class="has-margin-left-3">
                    <label class="label-title has-padding-left-2 has-margin-0">
                        @yield('title','FantasyClass')
                    </label>
                </a>
                @if(isset($class)) 
                    @yield('menu')
                @endif-->

            <!-- </div>
            <div class="right-menu-bar">
                    <div class="helpMenu flex-center"  data-toggle="popovermenu"  data-tippy-content="Follow">
                        <a href="https://twitter.com/GamificaOnline" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                    <div class="telegramMenu flex-center" data-toggle="popovermenu"  data-tippy-content="Telegram">
                        <a href="https://t.me/fantasyclass" target="_blank"><i class="fab fa-telegram"></i></a>
                    </div>
                    <div class="patreonMenu flex-center" data-toggle="popovermenu"  data-tippy-content="">
                        <a href="#" onclick=""><i class="fas fa-hand-holding-heart"></i></a>
                    </div>
                    <div class="flex-center settings-menu">
                        <div class="ml-2 flex-center" id="barNotif">

                        </div>

                        <div class="dropdown is-hoverable is-right has-margin-x-4">
                            <div class="dropdown-trigger">
                                <i class="fas fa-user-graduate"></i> <span class="pl-2 text-light cursor-default" title="{{ Auth::user()->username }}">{{ Str::limit(Auth::user()->username, 8, $end='...') }}</span><span class="caret"></span>
                                <span class="icon is-small">
                                    <i class="fas fa-angle-down" aria-hidden="true"></i>
                                </span>
                            </div>
                            <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                <div class="dropdown-content">
                                    <span class="dropdown-item cursor-default">
                                        {{ Auth::user()->name }}
                                    </span>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-dark py-2" href="/preferences/edit">
                                        <i class="fal fa-cog"></i> {{ __('menu.profile') }}
                                    </a>
                                    <a class="dropdown-item text-dark py-2" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fal fa-sign-out"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                            </div>
                    </div>
              </div>
        </nav> -->
        @endauth

        <main class="main-content has-padding-3">
            @yield('content')
        </main>
    </div>
    @include('popper::assets')
</body>
</html>
