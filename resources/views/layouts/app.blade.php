<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8"/>
    <title>{{getAppSetting('app_name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600&display=swap"
          rel="stylesheet">
    @yield('extracss')
    <link rel="stylesheet" href="{{ mix('/css/law.css') }}">
</head>

<body data-layout-mode="{{auth()->user()->color_mode}}" data-topbar="{{auth()->user()->color_mode}}"
      data-sidebar="{{auth()->user()->color_mode}}">

<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">

                <div class="navbar-brand-box">
                    <a href="/" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="/assets/images/logo-sm.svg" alt="" height="24">
                                </span>
                        <span class="logo-lg">
                                    <img src="/assets/images/logo-sm.svg" alt="" height="24"> <span
                                class="logo-txt">{{getAppSetting('app_name')}}</span>
                                </span>
                    </a>

                    <a href="/" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="/assets/images/logo-sm.svg" alt="" height="24">
                                </span>
                        <span class="logo-lg">
                                    <img src="/assets/images/logo-sm.svg" alt="" height="24"> <span
                                class="logo-txt">{{getAppSetting('app_name')}}</span>
                                </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <form class="app-search d-none d-lg-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="{{__('law.search')}}">
                        <button class="btn btn-primary" type="button"><i class="bx bx-search-alt align-middle"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="d-flex">

                <div class="dropdown d-inline-block d-lg-none ms-2">
                    <button type="button" class="btn header-item" id="page-header-search-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="search" class="icon-lg"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                         aria-labelledby="page-header-search-dropdown">

                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{__('law.search')}} ..."
                                           aria-label="Search Result">

                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="dropdown d-none d-sm-inline-block">
                    <button type="button" class="btn header-item"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img id="header-lang-img" src="/assets/images/flags/{{app()->getLocale()}}.png"
                             alt="Header Language" height="16">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        @foreach(config('languages') as $key => $value)
                            <a href="/lang/{{$key}}" class="dropdown-item notify-item language">
                                <img src="/assets/images/flags/{{$key}}.png" alt="lang-image" class="me-1" height="12">
                                <span class="align-middle">{{$value}}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="dropdown d-none d-sm-inline-block">
                    <a class="btn header-item pt-4 " href="{{route('switch.color')}}">
                        @if(auth()->user()->color_mode === "light")
                            <i data-feather="moon" class="icon-lg"></i>
                        @else
                            <i data-feather="sun" class="icon-lg"></i>
                        @endif
                    </a>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item right-bar-toggle me-2">
                        <i data-feather="settings" class="icon-lg"></i>
                    </button>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item bg-soft-light border-start border-end"
                            id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-none d-xl-inline-block ms-1 fw-medium">{{auth()->user()->fullname}}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                class="mdi mdi-logout font-size-16 align-middle me-1"></i> {{__('law.logout')}}</a>
                        <form method="POST" id="logout-form" action="{{ route('logout') }}">
                            @csrf
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </header>


    <div class="vertical-menu">

        <div data-simplebar class="h-100">

            <div id="sidebar-menu" class="mm-active">
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">{{!is_null(auth()->user()->tenant_id) ? auth()->user()->tenant->name : 'Menu'}}</li>

                    <li>
                        <a href="/" class="{{ Request::is('/') ? 'active' : '' }}">
                            <i data-feather="home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @if(auth()->user()->is_superadmin || auth()->user()->hasAnyPermission(['module.rfa']))
                        <li>
                            <a href="{{route('rfa.index')}}"
                               class="{{ Request::is('rfa*') ? 'active' : '' }}">
                                <i data-feather="list"></i>
                                <span>RFA</span>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->hasAnyPermission(['module.settings']))
                        <li class="menu-title">{{__('law.settings')}}</li>
                        @if(auth()->user()->is_superadmin || auth()->user()->hasAnyPermission(['module.users']))
                            <li>
                                <a href="{{route('users.index')}}"
                                   class="{{ Request::is('users*') ? 'active' : '' }}">
                                    <i data-feather="users"></i>
                                    <span>{{__('law.users')}}</span>
                                </a>
                            </li>
                        @endif
                    @endif
                    @if(auth()->user()->is_superadmin)
                        <li class="menu-title">Super admin</li>
                            <li>
                                <a href="{{route('tenants.index')}}"
                                   class="{{ Request::is('tenants*') ? 'active' : '' }}">
                                    <i data-feather="user-plus"></i>
                                    <span>Tenants</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('appsettings.index')}}"
                                   class="{{ Request::is('appsettings*') ? 'active' : '' }}">
                                    <i data-feather="settings"></i>
                                    <span>{{__('law.settings')}}</span>
                                </a>
                            </li>
                    @endif
                </ul>

            </div>
        </div>
    </div>

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                @yield('content')

            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script>
                        © {{getAppSetting('app_name')}}.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design & Develop by Next Gen ICT
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

</div>


<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center p-3">

            <h5 class="m-0 me-2">Aplicatie Instellingen</h5>

            <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>


    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<script src="{{ mix('/js/law.js') }}" type="text/javascript"></script>
@yield('extrajs')

@include('layouts.partials.flash')
</body>

</html>
