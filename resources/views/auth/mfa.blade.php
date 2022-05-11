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
    <link rel="stylesheet" href="{{ mix('/css/law.css') }}">
</head>

<body>

<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-xxl-3 col-lg-4 col-md-5">
                <div class="auth-full-page-content d-flex p-sm-5 p-4">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4 mb-md-5 text-center">
                                <a href="/" class="d-block auth-logo">
                                    <img src="/assets/images/logo-sm.svg" alt="" height="28"> <span class="logo-txt">{{getAppSetting('app_name')}}</span>
                                </a>
                            </div>
                            <div class="auth-content my-auto">
                                <div class="text-center">
                                    <h5 class="mb-0">{{__('law.password_mfa')}}</h5>
                                    <p class="text-muted mt-2"> {{ __('law.password_mfa_details') }}</p>
                                </div>
                                @include('layouts.partials.formerrors')
                                <form method="POST" action="{{ route('mfa.index') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">{{__('law.code')}}</label>
                                        <input type="text" class="form-control" id="mfa_code" name="mfa_code" placeholder="{{__('law.code')}}">
                                    </div>


                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
                                            {{ __('law.login') }}</button>
                                    </div>
                                </form>
                                <a class="btn btn-light w-100 waves-effect waves-light mt-4" href="{{route('logout')}}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"> {{__('law.back_to')}} {{str(__('law.login'))->lower()}}</a>
                                <form method="POST" id="logout-form" action="{{ route('logout') }}">
                                    @csrf
                                </form>
                                <a href="{{route('mfa.resent')}}" class="btn btn-primary w-100 waves-effect waves-light mt-4 ">{{__('law.resent_code')}}</a>
                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> {{getAppSetting('app_name')}} </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xxl-9 col-lg-8 col-md-7">
                <div class="auth-bg pt-md-5 p-4 d-flex"{!! getAppSetting('login_bg') !== "/" ? ' style="background-image: url('.url("storage/".getAppSetting("login_bg")).'");' : ""!!}>
                    <div class="bg-overlay bg-primary"></div>
                    <ul class="bg-bubbles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>


<script src="/assets/libs/jquery/jquery.min.js"></script>
<script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="/assets/libs/simplebar/simplebar.min.js"></script>
<script src="/assets/libs/node-waves/waves.min.js"></script>
<script src="/assets/libs/feather-icons/feather.min.js"></script>
<script src="/assets/libs/pace-js/pace.min.js"></script>
<script src="/assets/js/pages/pass-addon.init.js"></script>
</body>

</html>
