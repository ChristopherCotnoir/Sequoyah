<header>
	<div id='login'>
		<div>
			@if (Auth::check())
				<a href='auth/logout'>Logout <i class='fa fa-sign-out'></i></a>
			@else
				<a href='{{ action('Auth\AuthController@ShowRegister') }}'>Register <i class='fa fa-sign-in'></i></a>
				<a href='{{ action('Auth\AuthController@ShowLogin') }}'>Login <i class='fa fa-sign-in'></i></a>
			@endif
		</div>
	</div>
	<h1 id='logos'>
		<a id='logo' class='no-link' href='{{ action('HomeController@ShowIndex') }}' title='Sequoyah'>Sequoyah</a>
		<span id='sublogo' class='hint'>
			<a href='http://www.cs.odu.edu/'>An ODU CS 411 Project</a>
		</span>
	</h1>
	<nav>
		<a a class= "nav {{ (Request::path() == '/')  ? "active" : "" }}" href='{{ action('HomeController@ShowIndex') }}' title='Home'>Home</a>
		@if (Auth::check())
			<a class= "nav {{ (Request::path() == 'settings')  ? "active" : "" }}" href='{{ action('AccountController@ShowIndex') }}' title='Project &amp; Settings'>Projects &amp; Settings</a>
		@endif
		</nav>
</header>