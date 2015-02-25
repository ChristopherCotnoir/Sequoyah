<!doctype html>
<html>
<head>
	@section('head')
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>{{ (isset($pageTitle) ? $pageTitle . ' - ' : '') . 'Sequoyah' }}</title>
	
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400'>
	<link rel='stylesheet' type='text/css' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
	<link rel='stylesheet' type='text/css' href='/styles/page.css'>
	
	<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js'></script>
	@show
</head>
@yield('body')
</html>
