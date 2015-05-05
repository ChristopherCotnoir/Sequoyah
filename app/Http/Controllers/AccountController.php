<?php namespace Sequoyah\Http\Controllers;

use Sequoyah\Models\ProjectMembers;
use Sequoyah\Models\Project;
use Sequoyah\Models\Syllabary;
use Sequoyah\Models\User;
use Sequoyah\Models\SyllabaryColumnHeader;
use Sequoyah\Models\SyllabaryRowHeader;
use Sequoyah\Models\Symbol;
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
        if(Auth::user()==NULL)
        {
            return redirect('');
        }
        $UserId = Auth::user()->id;
        $UserProjects = array();
        $Projects = ProjectMembers::where('user_id','=',$UserId)->get(); 
        foreach($Projects as $project)
        {
            $UserProject['Id'] = $project['project_id'];
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
                $UserId = $user['user_id'];
                $currentUser['Name'] = $UserName;
                $currentUser['Id'] = $UserId;
                array_push($UserProject['Users'], $currentUser);
            }
            array_push($UserProjects, $UserProject);
        }
        $Users = User::all();
        $AllUsers = array();
        foreach($Users as $user)
        {
            $UserName = $user['name'];
            $UserId = $user['id'];
            $currentUser['Name'] = $UserName;
            $currentUser['Id'] = $UserId;           
            array_push($AllUsers, $currentUser);
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

    public function CreateSyllabary($name)
    {
        $syllabary = Syllabary::create(array(
        'name' => $name,
        ));

        $symbol1 = Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><circle id="svg_18" r="105.621967" cy="256" cx="256" stroke-width="5" stroke="#000000" fill="#000000"/></svg>'
        ));

        $symbol2 = Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><line x1="0" y1="50%" x2="100%" y2="50%" style="stroke:rgb(0,0,0);stroke-width:5"/></svg>'
        ));

        $symbol3 = Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><line x1="0" y1="0" x2="100%" y2="100%" style="stroke:rgb(0,0,0);stroke-width:5"/></svg>'
        ));

        $symbol4 = Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><line x1="100%" y1="0" x2="0" y2="100%" style="stroke:rgb(0,0,0);stroke-width:5"/></svg>'
        ));

        $symbol5 = Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg"><rect xmlns="http://www.w3.org/2000/svg" id="svg_1" height="168" width="392" y="156" x="54" stroke-linecap="null" stroke-linejoin="null" stroke-dasharray="null" stroke-width="null" fill="black"/></svg>'
        ));

        $symbol6 = Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><circle id="svg_18" r="105.621967" cy="256" cx="256" stroke-width="5" stroke="#000000" fill="#000000"/></svg>'
        ));

        $symbol7 = Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><line x1="0" y1="50%" x2="100%" y2="50%" style="stroke:rgb(0,0,0);stroke-width:5"/></svg>'
        ));

        $symbol8 = Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><line x1="0" y1="0" x2="100%" y2="100%" style="stroke:rgb(0,0,0);stroke-width:5"/></svg>'
        ));

        $symbol9 = Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><line x1="100%" y1="0" x2="0" y2="100%" style="stroke:rgb(0,0,0);stroke-width:5"/></svg>'
        ));

        $symbol10 = Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg"><rect xmlns="http://www.w3.org/2000/svg" id="svg_1" height="168" width="392" y="156" x="54" stroke-linecap="null" stroke-linejoin="null" stroke-dasharray="null" stroke-width="null" fill="black"/></svg>'
        ));        

        $column = SyllabaryColumnHeader::create(array(
            'syllabary_id' => $syllabary->id,
            'ipa' => 'a',
            'symbol_id' => $symbol4->id,
            'next_id' => -1,
            'prev_id' => -1,
        ));
        
        $columnId = $column->id;
        $column->next_id = $columnId+1;
        $column->save();
        
        SyllabaryColumnHeader::create(array(
            'syllabary_id' => $syllabary->id,
            'ipa' => 'e',
            'symbol_id' => $symbol3->id,
            'next_id' => $columnId+2,
            'prev_id' => $columnId,
        ));
        SyllabaryColumnHeader::create(array(
            'syllabary_id' => $syllabary->id,
            'ipa' => 'i',
            'symbol_id' => $symbol2->id,
            'next_id' => $columnId+3,
            'prev_id' => $columnId+1,
        ));
        SyllabaryColumnHeader::create(array(
            'syllabary_id' => $syllabary->id,
            'ipa' => 'o',
            'symbol_id' => $symbol1->id,
            'next_id' => $columnId+4,
            'prev_id' => $columnId+2,
        ));
        SyllabaryColumnHeader::create(array(
            'syllabary_id' => $syllabary->id,
            'ipa' => 'u',
            'symbol_id' => $symbol5->id,
            'next_id' => -1,
            'prev_id' => $columnId+3,
        ));        

        $row = SyllabaryRowHeader::create(array(
            'syllabary_id' => $syllabary->id,
            'ipa' => 'b',
            'symbol_id' => $symbol6->id,
            'next_id' => -1,
            'prev_id' => -1,
        ));

        $rowId = $row->id;
        $row->next_id = $rowId+1;
        $row->save();        

        SyllabaryRowHeader::create(array(
            'syllabary_id' => $syllabary->id,
            'ipa' => 'd',
            'symbol_id' => $symbol7->id,
            'next_id' => $rowId+2,
            'prev_id' => $rowId,
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => $syllabary->id,
            'ipa' => 'f',
            'symbol_id' => $symbol8->id,
            'next_id' => $rowId+3,
            'prev_id' => $rowId+1
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => $syllabary->id,
            'ipa' => 'g',
            'symbol_id' => $symbol9->id,
            'next_id' => $rowId+4,
            'prev_id' => $rowId+2,
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => $syllabary->id,
            'ipa' => 'h',
            'symbol_id' => $symbol10->id,
            'next_id' => -1,
            'prev_id' => $rowId+3,
        ));

        return $syllabary;
    }

    public function CreateProject($name)
    {
        $syllabary = $this->CreateSyllabary("Default");

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
        'user_id' =>  Auth::user()->id,
        'project_id' => $project->project_id,
        'access' => 3,
        ));
    }
    
    public function AddUser($project, $user)
    {
        ProjectMembers::create(array(
        'user_id' => $user,
        'project_id' => $project,
        'access' => 1,
        ));
    }
    
    public function RemoveUser($project, $user)
    {
        $entry = ProjectMembers::where('project_id','=',$project)->where('user_id','=',$user)->firstOrFail();
        $entry->delete();
    }
    
    public function ChangeRole($project, $user, $role)
    {
        $entry = ProjectMembers::where('project_id','=',$project)->where('user_id','=',$user)->firstOrFail();
        $entry['access'] = $role;
        $entry->save();
    }
}
