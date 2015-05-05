<?php namespace Sequoyah\Http\Controllers;

use Sequoyah\Models\ProjectMembers;
use Sequoyah\Models\Project;
use Sequoyah\Models\Syllabary;
use Sequoyah\Models\User;
use Auth;

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
    public function ShowIndex()
    {
        $UserId = 1; //Temporary placeholder until there is a way to get the current user.
        //$UserId = Auth::user()->id;
        $UserProjects = array();
        $Projects = ProjectMembers::where('user_id','=',$UserId)->get(); 
        foreach($Projects as $project)
        {
            $UserProject['Name'] = Project::where('project_id','=',$project['project_id'])->firstOrFail()['name'];
            $UserProject['Role'] = $project['access'];
            $Syllabaries = Project::where('project_id','=',$project['project_id'])->get();
            $UserProject['Syllabaries'] = array();
            foreach($Syllabaries as $syllabary)
            {
                $SyllabaryName = Syllabary::where('id','=',$syllabary['syllabary_id'])->firstOrFail()['name'];
                $SyllabaryId = $syllabary['syllabary_id'];
                $currentSyllabary['Name'] = $SyllabaryName;
                $currentSyllabary['Id'] = $SyllabaryId;
                array_push($UserProject['Syllabaries'], $currentSyllabary);
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

    public function CreateProject($name)
    {
        $syllabary = Syllabary::create(array(
        'name' => "Default",
        ));

        $Projects = Project::all();
        $maxID = 1;
        foreach($Projects as $project)
        {
            if($project['project_id']>$maxID)
            {
                $maxID = $project['project_id'];
            }
        }

        $project = Project::create(array(
        'project_id' => $maxID+1,
        'name' => $name,
        'syllabary_id' => $syllabary->id,
        ));

        ProjectMembers::create(array(
        'user_id' => 1, //Temporary placeholder until there is a way to get the current user.
        //'user_id' =>  Auth::user()->id,
        'project_id' => $project->project_id,
        'access' => 3,
        ));
    }
    
    public function AddUser($project, $user)
    {
        $user_id = User::where('name','=',$user)->firstOrFail()['id'];
        $project_id = Project::where('name','=',$project)->firstOrFail()['project_id'];
        ProjectMembers::create(array(
        'user_id' => $user_id,
        'project_id' => $project_id,
        'access' => 1,
        ));
    }
    
    public function RemoveUser($project, $user)
    {
        $user_id = User::where('name','=',$user)->firstOrFail()['id'];
        $project_id = Project::where('name','=',$project)->firstOrFail()['project_id'];
        $entry = ProjectMembers::where('project_id','=',$project_id)->where('user_id','=',$user_id)->firstOrFail();
        $entry->delete();
    }
    
    public function ChangeRole($project, $user, $role)
    {
        $user_id = User::where('name','=',$user)->firstOrFail()['id'];
        $project_id = Project::where('name','=',$project)->firstOrFail()['project_id'];
        $entry = ProjectMembers::where('project_id','=',$project_id)->where('user_id','=',$user_id)->firstOrFail();
        if($role=="Admin")
            $access = 3;
        elseif($role=="Write")
            $access = 2;
        else
            $access = 1;
        
        $entry['access'] = $access;
        $entry->save();
    }
}
