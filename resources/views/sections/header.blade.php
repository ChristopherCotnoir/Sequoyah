<header>
	<div id='login'>
		<div>
			@if (Auth::check())
				<a href='{{ action('Auth\AuthController@DoLogout') }}'>Login <i class='fa fa-sign-in'></i></a>
			@else
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
		<a class='nav active' href='{{ action('HomeController@ShowIndex') }}' title='Home'>Home</a>
		<a class='nav' href='{{ action('SyllabaryController@ShowGrid') }}' title='Syllabary Editor'>Syllabary Editor</a>
		<a class='nav' target='_blank' href='https://bitbucket.org/411blacks15/sequoyah' title='Bitbucket (External Link)'><i class='fa fa-bitbucket'></i> Bitbucket</a>
	</nav>
</header>
