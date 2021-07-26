<nav id="navbar" class="navbar navbar-expand-lg fixed-top navbar-light">
	<a class="navbar-brand" href="{{ url('/') }}">
		<img id="logo" src="{{ asset('img/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}">
	</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
		aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('nav.toggle-navigation') }}">
		<span class="navbar-toggler-icon"></span>
	</button>

    <div class="navbar-collapse collapse" id="navbarSupportedContent">

			<ul class="nav navbar-nav mx-auto">
				<li class="nav-item">
					<a class="nav-link {{ Request::segment(1) === 'patients' ? 'active' : '' }}" href="/patients">{{ __('nav.links.patients') }}</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ Request::segment(1) === 'shields' ? 'active' : '' }}" href="/shields">{{ __('nav.links.shields') }}</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ Request::segment(1) === 'exams' ? 'active' : '' }}" href="/exams">{{ __('nav.links.exams') }}</a>
				</li>
			</ul>

            <ul class="nav navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="nav-dropdown-actions" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent"
                    title="{{ Auth::user()->name }}">
                    <i class="material-icons">person</i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="nav-dropdown-actions">
                  <a class="dropdown-item" href="/users/{{ Auth::user()->id }}">{{__('nav.links.profile')}}</a>
                  <a class="dropdown-item" href="/settings">{{__('nav.links.settings')}}</a>
                  <a class="dropdown-item" href="/users">{{__('nav.links.users')}}</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">{{ __('nav.links.logout') }}</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>


	</div>
</nav>
