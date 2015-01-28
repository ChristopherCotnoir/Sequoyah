<header>
	<div id='login'>
		<div>
				<a href=''>Login <i class='fa fa-sign-in'></i></a>
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
		<a class='nav' target='_blank' href='https://bitbucket.org/411blacks15/sequoyah' title='Bitbucket (External Link)'><i class='fa fa-bitbucket'></i> Bitbucket</a>
	</nav>
</header>
