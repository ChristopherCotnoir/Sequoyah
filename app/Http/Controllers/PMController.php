<?php namespace Sequoyah\Http\Controllers;




use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class PMController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function ShowIndex()	{
		
		return view('pages.projectmanagement');
        
    }




}

