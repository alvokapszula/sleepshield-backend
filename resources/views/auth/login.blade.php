<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}" >
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">

        <nav id="navbar" class="navbar navbar-expand fixed-top navbar-light">
            <div class="col-12 align-self-center text-center">
    		    <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}">
    		</div>
        </nav>


        <main role="main">
            <div id="loginform" class="container">

                <div class="row justify-content-center">

                    <div class="col-sm-10 col-md-8 col-lg-6">
                        <h5>{{ __('Login') }}</h5>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control-sm form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control-sm form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                            </div>

                            <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-sm login mb-0">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link btn-block mt-0 pt-0" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                            </div>

                        </form>
                    </div>
                </div>

                <div class="row justify-content-center mt-5">
                    <div class="row justify-content-around" >
                        <div class="col-sm-6 col-md-4 mt-3">
                            <div class="card mx-auto login">
                              <img class="card-img-top" src="{{ __('loginpage.card1.img') }}" alt="{{ __('loginpage.card1.alt') }}">
                              <div class="card-footer text-center px-0 py-1">
                                {{ __('loginpage.card1.text') }}
                              </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 mt-3">
                            <div class="card mx-auto login">
                              <img class="card-img-top" src="{{ __('loginpage.card2.img') }}" alt="{{ __('loginpage.card2.alt') }}">
                              <div class="card-footer text-center px-0 py-1">
                                {{ __('loginpage.card2.text') }}
                              </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 mt-3">
                            <div class="card mx-auto login">
                              <img class="card-img-top" src="{{ __('loginpage.card3.img') }}" alt="{{ __('loginpage.card3.alt') }}">
                              <div class="card-footer text-center px-0 py-1">
                                {{ __('loginpage.card3.text') }}
                              </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </main>

        <footer class="navbar navbar-expand fixed-bottom navbar-light">
		    <div class="col-12 align-self-center">
    		    <p class="m-0 text-center">ALVÓKAPSZULA DIAGNOSZTIKA</p>
    		</div>
    	</footer>

    </div>

        <script src="{{ asset('js/app.js')}}" type="text/javascript"></script>
</body>
</html>
