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
	<link rel='icon' type='image/png' href='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3wQWDw4peCNYBgAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAB7ElEQVQ4y4WTMWhTYRDHf/e9NCEtTiLWQSiICHUovpDGUoToC4oIDgoOVhGsi1204ObQgOBoUbDgoGIpiIoIgqKQhJApJnkpOrg4OIgUaSdppJSXnIPvpS9JY286Po7f3f9/9wld8SljnzQq06BHQYZFtAn8UKXkqSxMFNzlcL0EycvR0YGRffEnRrhEn1ClBZpN5ut3egAVJ5E1wlxQKKJvFK1rywyJqCMiqTaI1uVkbnkJIBI8GtHpgKeqs8l8/UGo+e1qJvFQYMbvOwt0AlRlj/jzeGJK3eNverIQtXTSB2z2SKhmbFcQ28e9Xvc2rqSLXxvsECEP7DOCvBXB/NOpayjPPDUvPhZqtSzofwEA5eOJ0xGjjxDZ3+E+/FRY/OOZ++li9VdfAEAxPRKLW7unLPSqIhPBRP52GqrcGC+4j/sCOmHJvUNW86wI10DGg/cmXEzl3OcdgNKxxHCQF6xdq9lisRmGVZzEvBFu+pK+JHPuGLA1XjzGt8EYK4MxVk7JeqrnClutpyFTDrXvp61F9XOQRyyd6QYYw4l2rehqu3YLqvcEmfR1TdUc+7DCB+A3cETgXMjMpW1NrDr2LYS7ggz0/1D6/nsjev5Cubyx7RYqzthBI9Z1VTLAARGiwJoqLrD4Ll9/FT6qvwElspdzH9DxAAAAAElFTkSuQmCC'>
	
	<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js'></script>
	@show

	@section('head-custom')
	@show	
</head>
@yield('body')
</html>
