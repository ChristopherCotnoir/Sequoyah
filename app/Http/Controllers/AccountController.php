<?php namespace Sequoyah\Http\Controllers;

use Sequoyah\Models\ProjectMembers;
use 

class AccountController extends Controller
{
    /** 
      * Create a new controller instance
      *
      * @return void
      */

    public function_construct()
    {
        //$this->middleware('auth');
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
            retrun $projectMember->access;
        }
    }
