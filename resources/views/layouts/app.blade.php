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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Other CSS -->
	@stack('css')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    {{-- Scripts --}}
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>

<body>
    <div id="app">

        @include('layouts.navbar')

        <main role="main">

            <div id="status-messages" class="fixed-top col-8 offset-2 mt-2">
        		@if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
        		@endif
                @if (session('success'))
                <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                </div>
                @endif
                @if (session('info'))
                <div class="alert alert-info" role="alert">
                        {{ session('info') }}
                </div>
                @endif
            </div>

            <div class="container">
                @yield('content')
            </div>
        </main>

        <footer class="navbar navbar-expand fixed-bottom navbar-light">
		    <div class="col-12 align-self-center">
    		    <p class="m-0 text-center">ALVÓKAPSZULA DIAGNOSZTIKA</p>
    		</div>
    	</footer>

    </div>
    <script src="{{ asset('js/app.js')}}" type="text/javascript"></script>></script>
    <script>$('div.alert').not('.alert-danger').delay(3000).fadeOut(250);</script>
    @stack('scripts')
</body>
</html>
