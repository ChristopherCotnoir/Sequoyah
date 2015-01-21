<header>
	<div id='login'>
		<div>
				<a href='login.php'>Login <i class='fa fa-sign-in'></i></a>
		</div>
	</div>
	<h1 id='logos'>
		<a id='logo' class='no-link' href='index.php' title='Sequoyah'>Sequoyah</a>
		<span id='sublogo' class='hint'>
			<!--A CS 411 Project at 
			<a href='http://www.cs.odu.edu/'>ODU</a>-->
			Never coming
		</span>
	</h1>
	<nav>
		<a class='nav active' href='{{ action('HomeController@ShowIndex') }} title='Home'>Home</a>
		<a class='nav' target='_blank' href='https://bitbucket.org/411blacks15/sequoyah' title='Bitbucket (External Link)'><i class='fa fa-bitbucket'></i> Bitbucket</a>
	</nav>
</header>