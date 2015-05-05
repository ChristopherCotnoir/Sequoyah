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
@stop