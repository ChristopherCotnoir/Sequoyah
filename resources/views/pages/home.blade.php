@extends('layouts.plain')
@section('content')


<div class="homeContent">
	<div id="home-login">
		<form id= "login-home" action='{{ action('Auth\AuthController@DoLogin') }}' method='post'>
		<input type='hidden' id='csrf' name='_token' value='{{ csrf_token() }}'>
			
			<h1 id="white-text">Login <a href='' class='hint float-right'>(Forgot your password?)</a></h1><hr>
	
			
			<label for='username' id = "white-text">Username</label>
			@if ($errors->has('username'))
				<output class='error'>{{ $errors->first('username') }}</output>
			@endif
			<input type='text' name='username' value='{{ old('username') }}'>
	
			
			<label for='password' id = "white-text">Password</label>
			@if ($errors->has('password'))
				<output class='error'>{{ $errors->first('password') }}</output>
			@endif
			<input type='password' name='password' value=''>
	
			<div>
				<label for='remember' id = "white-text">Remember Me?</label>
				<input type='checkbox' name='remember' value='{{ old('remember') }}'>
			</div>
	
			<input type='submit' value='Login'>
		</form>
		
	</div>
</div>



<br />
<br />

<div class="tiles">
			<div class="tile">
				<h2><a href="/docs/homestead">About Sequoyah</a></h2>
				<p>Sequoyah is a syllabary creation tool focused on providing endangered language groups the ability to
			    		generate a written alphabet for their spoken language.</p>
			</div>
			<div class="tile">
				<h2>Feasibility</h2>
					<p>
				    	Based on the requirements of this project, it is certainly feasible. First, the requirements are the 						following:
					</p>
		
				    <ul>
				    <li>
						Allow the creation of a <a class='link' href='http://en.wikipedia.org/wiki/Syllabary'  						target="_blank">syllabary</a> for the language
					</li>
				    <li>
						Allow assigning custom characters to syllables of the language
					</li>
				    <li>Provide the ability to download a <a class='link' href='http://en.wikipedia.org/wiki/TrueType'  						target="_blank">TrueType font</a> of the generated written language to allow typing in the language
					</li> 
				    </ul>

				    All of these requirements can be fulfilled by creating a web application using PHP and JavaScript.
				    Creating a web application will allow for increased availability of the application and ease of use.</p>
			</div>
			<div class="tile">
				<h2>Competition</h2>
				<p>
			    	Based on our current research, we have found that this project is very unique. We have yet to find any projects 					that
			    	are designed to generate written languages based on customized syllabaries.
				</p>
			</div>
</div>



@stop