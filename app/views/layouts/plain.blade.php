@extends('page')
@section('body')
<body lang='en'>
	@include('sections.header')
	@yield('content')
	@include('sections.footer')
</body>
@stop