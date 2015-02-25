@extends('layouts.plain')
@section('content')
<main>
<form action='{{ action('Auth\AuthController@DoLogin') }}' method='post'>
	<input type='hidden' id='csrf' name='csrf' value='{{ csrf_token() }}'>
	
	<h1>Login <a href='' class='hint float-right'>(Forgot your password?)</a></h1><hr>
	
	<label for='username'>Username</label>
	<input type='text' name='username' value=''>
	
	<label for='password'>Password</label>
	<input type='password' name='password' value=''>
	
	<input type='submit' value='Login'>
</form>
</main>
@stop
