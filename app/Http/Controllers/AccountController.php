<?php namespace Sequoyah\Http\Controllers;

use Sequoyah\Models\ProjectMembers;
use Sequoyah\Models\Project;
use Sequoyah\Models\Syllabary;
use Sequoyah\Models\User;

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
        $Projects[Users]
        $Projects[Users]->index
        
    */
    public function ShowPage()
    {
        //$UserId = 1; //Temporary placeholder until there is a way to get the current user.
        $UserId = Auth::user()->id;
        $UserProjects = array();
        foreach($Projects as $project)
        {
            $UserProject['Name'] = Project::where('id','=',$project['project_id'])->firstOrFail()['name'];
            $UserProject['Role'] = $project['access'];
            $Syllabaries = Project::where('id','=',$project['project_id'])->get();
            $UserProject['Syllabaries'] = array();
            foreach($Syllabaries as $syllabary)
            {
                $SyllabaryName = Syllabary::where('id','=',$syllabary['syllabary_id'])->firstOrFail()['name'];
                array_push($UserProject['Syllabaries'], $SyllabaryName);
            }
            $Users = ProjectMembers::where('project_id','=',$project['project_id'])->get();
            $UserProject['Users'] = array();
            foreach($Users as $user)
            {
                $UserName = User::where('id','=',$user['user_id'])->firstOrFail()['name'];
                array_push($UserProject['Users'], $UserName);
            }
            array_push($UserProjects, $UserProject);
        }
        //$Users = User::where('id','=',1)->get(); //I don't know the command to get everything, I'll fix this when I find out. Right now I just put something that lets it compile.
        $Users = User::all();
        $AllUsers = array();
        foreach($Users as $user)
        {
            $UserName = $user['name'];
            array_push($AllUsers, $UserName);
        }
            
        return view('pages.settings', array(
            'UserProjects' => $UserProjects, 'AllUsers' => $AllUsers
        ));
        
        //$Projects = ProjectMembers::where('user_id','=',$uzserId)->get();
        //foreach ($Projects as $project)
        //{
        //    $project['Name'] = Projects::where('prject_id', '=',$project['id'])->firstOrFail();;
        //    $project['Syllabaries'] = array(); // Project Model only supports one syllabary
        //    $project['Users'] = ProjectMembers::where('project_id','=',$projectId)->get(); //I think this is the best way to handle users
        //        
        //}
        //return view('pages.settings', array(
        //    'UserProjects' => $Projects
        //    
        //));
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
