<form {{ isset($form_id) ? "id='$form_id'" : '' }} action='{{ action('Auth\AuthController@DoLogin') }}' method='post'>
	<input type='hidden' id='csrf' name='_token' value='{{ csrf_token() }}'>
	
	<h1>Login <a href='' class='hint float-right'>(Forgot your password?)</a></h1><hr>
	
	<label for='username'>Username</label>
	@if ($errors->has('username'))
		<output class='error'>{{ $errors->first('username') }}</output>
	@endif
	<input type='text' style='width:100%' name='username' value='{{ old('username') }}'>
	
	<label for='password'>Password</label>
	@if ($errors->has('password'))
		<output class='error'>{{ $errors->first('password') }}</output>
	@endif
	<input type='password' style='width:100%' name='password' value=''>
	
	<div>
		<label for='remember'>Remember Me?</label>
		<input type='checkbox' name='remember' value='{{ old('remember') }}'>
	</div>
	
	<input type='submit' value='Login'>
</form>