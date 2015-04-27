<?php namespace Sequoyah\Http\Controllers;

use Auth;
use Redirect;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function ShowIndex()
	{
		//if (Auth::check())
		//	return Redirect::action('SettingsController@ShowIndex');

		return view('pages.home');
	}
}
