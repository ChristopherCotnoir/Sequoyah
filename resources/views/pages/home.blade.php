@extends('layouts.plain')
@section('content')


<div id='home-jumbo' class='space-bottom'>
	<div class="about">
		<h2>About Sequoyah</h2>
		<p>Sequoyah is a syllabary creation tool focused on providing endangered language groups the ability to generate a written alphabet for their spoken language.</p>
	</div>
	@if (!Auth::check())
		@include('sections.auth.login', [ 'form_id' => 'login-home' ])
	@endif
</div>
<div id="home-tiles">
	<div class="tile">
		<h2>About Sequoyah</h2>
		<p>Sequoyah is a syllabary creation tool focused on providing endangered language groups the ability to generate a written alphabet for their spoken language.</p>
	</div>
	<div class="tile">
		<h2>Feasibility</h2>
		<p>
			Based on the requirements of this project, it is certainly feasible. First, the requirements are the following:
		</p>
		
		<ul>
			<li>
				Allow the creation of a <a class='link' href='http://en.wikipedia.org/wiki/Syllabary' target="_blank">syllabary</a> for the language
			</li>
			<li>
				Allow assigning custom characters to syllables of the language
			</li>
			<li>Provide the ability to download a <a class='link' href='http://en.wikipedia.org/wiki/TrueType' target="_blank">TrueType font</a> of the generated written language to allow typing in the language
			</li> 
		</ul>

		All of these requirements can be fulfilled by creating a web application using PHP and JavaScript.
		Creating a web application will allow for increased availability of the application and ease of use.</p>
	</div>
	<div class="tile">
		<h2>Competition</h2>
		<p>
			Based on our current research, we have found that this project is very unique. We have yet to find any projects that are designed to generate written languages based on customized syllabaries.
		</p>
	</div>
</div>
@stop