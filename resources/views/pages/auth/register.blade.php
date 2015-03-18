@extends('layouts.plain')
@section('content')
<main>
<form action='{{ action('Auth\AuthController@DoRegister') }}' method='post'>
	<input type='hidden' id='csrf' name='_token' value='{{ csrf_token() }}'>
	
	<h1>Create an account <a href='{{ action('Auth\AuthController@ShowLogin') }}' class='hint float-right'>(Or Login)</a></h1><hr>
	
	@if ($errors->has('username'))
		<output class='error'>{{ $errors->get('username') }}</output>
	@endif
	<label for='username'>Username</label>
	<input type='text' name='username' value='{{ old('username') }}'>
	
	@if ($errors->has('password'))
		<output class='error'>{{ $errors->get('password') }}</output>
	@endif
	<label for='password'>Password</label>
	<input type='password' name='password' value=''>
	
	@if ($errors->has('password'))
		<output class='error'>{{ $errors->get('password') }}</output>
	@endif
	<label for='password_confirmation'>Password <span class='hint'>(Confirm)</span></label>
	<input type='password' name='password_confirmation' value=''>
	
	<input type='submit' value='Create Account'>
</form>
</main>
@stop
