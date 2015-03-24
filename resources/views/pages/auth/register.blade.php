@extends('layouts.plain')
@section('content')
<main>
<form action='{{ action('Auth\AuthController@DoRegister') }}' method='post'>
	<input type='hidden' id='csrf' name='_token' value='{{ csrf_token() }}'>
	
	<h1>Create an account <a href='{{ action('Auth\AuthController@ShowLogin') }}' class='hint float-right'>(Or Login)</a></h1><hr>
	
	<label for='username'>Username</label>
	@if ($errors->has('username'))
		<output class='error'>{{ $errors->first('username') }}</output>
	@endif
	<input type='text' name='username' value='{{ old('username') }}'>
	
	<label for='password'>Password</label>
	@if ($errors->has('password'))
		<output class='error'>{{ $errors->first('password') }}</output>
	@endif
	<input type='password' name='password' value=''>
	
	<label for='password_confirmation'>Password <span class='hint'>(Confirm)</span></label>
	@if ($errors->has('password'))
		<output class='error'>{{ $errors->first('password') }}</output>
	@endif
	<input type='password' name='password_confirmation' value=''>
	
	<hr>
	
	<label for='name'>Full Name</label>
	@if ($errors->has('name'))
		<output class='error'>{{ $errors->first('name') }}</output>
	@endif
	<input type='text' name='name' value='{{ old('name') }}'>
	
	<input type='submit' value='Create Account'>
</form>
</main>
@stop
