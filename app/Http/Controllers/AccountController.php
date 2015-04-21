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
        
        $Projects    
        $Projects[index]->Name
        $Projects[index]-?ProjectIndex
        $Projects[Syllabaries]
        $Projects[Syllabaries]->index
        $Projects[Syllabaries]-name
        
                
        $Users       
        $Users[index]->UserIndex
        $Users[index]->Name
        
    */
    public function ShowPage($UserId)
    {
        $Projects = ProjectMembers::where('user_id','=',$userId)->get();
        foreach ($Projects as $project)
        {
            $project['Name'] = Projects::where('prject_id', '=',$project['id'])->firstOrFail();;
            $project['Syllabaries'] = array(); // Project Model only supports one syllabary
            $project['Users'] = ProjectMembers::where('project_id','=',$projectId)->get(); //I think this is the best way to handle users
                
        }
        return view('pages.settings', array(
            'UserProjects' => $Projects
            
        ));
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
