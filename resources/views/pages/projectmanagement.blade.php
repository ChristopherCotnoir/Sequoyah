@extends('layouts.plain')
@section('content')
<main>
	
	
	<table id='syllabary-grid'>
		<th style="text-align:center">
			My Projects
		</th>
		<tr>
			<td>
				<a style="padding-left:15px" href='{{ action('SyllabaryController@ShowGrid') }}' title='Syllabary Editor'>Sequoyah</a>
				<p style = "padding-left: 15px; font-size:25px;color:rgb(100,100,100);">Administrator</p>
				<p style="font-size:20px;font-style: italic;padding-left:15px;color:rgb(200,200,200)">Last Edited: Earlier today</p>
			</td>

		</tr>
		
		<tr>
			<td>
				<a style="padding-left:15px" href='{{ action('SyllabaryController@ShowGrid') }}' title='Syllabary Editor'>Klingon</a>
				<p style = "padding-left: 15px; font-size:25px;color:rgb(100,100,100);">Administrator</p>
				<p style="font-size:20px;font-style: italic;padding-left:15px;color:rgb(200,200,200)">Last Edited: Yesterday</p>
			</td>
		</tr>
		
		<tr>
			<td>
				<a style="padding-left:15px" href='{{ action('SyllabaryController@ShowGrid') }}' title='Syllabary Editor'>Dothraki</a>
				<p style = "padding-left: 15px; font-size:25px;color:rgb(100,100,100);">Write</p>
				<p style="font-size:20px;font-style: italic;padding-left:15px;color:rgb(200,200,200)">Last Edited: 3 days ago</p>
			</td>
		</tr>
		
	</table>
	
	
</main>

@stop