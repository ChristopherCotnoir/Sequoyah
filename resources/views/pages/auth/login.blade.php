@extends('layouts.plain')
@section('content')
<main>
<form action='{{ action('Auth\AuthController@DoLogin') }}' method='post'>
	<input type='hidden' id='csrf' name='_token' value='{{ csrf_token() }}'>
	
	<h1>Login <a href='' class='hint float-right'>(Forgot your password?)</a></h1><hr>
	
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
	
	<div>
		<label for='remember'>Remember Me?</label>
		<input type='checkbox' name='remember' value='{{ old('remember') }}'>
	</div>
	
	<input type='submit' value='Login'>
</form>
</main>
@stop
