<?php namespace Sequoyah\Http\Controllers;

use Sequoyah\Models\ProjectMembers;

class AccountController extends Controller
{
    /** 
      * Create a new controller instance
      *
      * @return void
      */

    public function __construct()
    {
        //$this->middleware('auth');
    }

    /*
        Passes data to the Settings page
        
        Expeced data
        
        $UserIndex
        $UserRole
        
        $Projects    array
        $Project[index]->Name
        $Projects[index]
        
        $Users       array
        $Users[index]->UserIndex
        $Users[index]->Name
        
    */
    public function ShowPage()
    {
        return view('pages.settings');
    }

    public function GetUserAccessPermissions($projectId, $userId)
    {
        //database: sequoyah
        //table: project_members
        //fields                    Type                                             NULL                    Default
        //user_id                bigint(20) unsigned            Not NULL          NULL
        //project_id         bigint(20) unsigned            Not NULL          NULL
        // access                 smallin(6)	                            Not NULL 	    0

        $projectMember = ProjectMembers::where('project_id','=',$projectId)->
                                                    where('user_id','=',$userId)->get();

        if($projectMember == false)
        {
            return '<b>Project member not found!</b>';
        }
        else
        {
            return $projectMember->access;
        }
    }
}
