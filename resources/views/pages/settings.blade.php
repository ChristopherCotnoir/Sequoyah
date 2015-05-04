@extends('layouts.plain')
@section('content')
<main>
<!-- $UserProjects is a list of the projects the User accessing this page has access to. Each Project has a Name, a Role for the current User, a list of Syllabary Names, and a list of User Names.
$AllUsers is a list of the names of all users in the database.-->
<!-- Code has not been fully tested. Layout is preliminary. -->

@if(count($UserProjects)>1)
    <select id="Projects">
    @foreach($UserProjects as $ProjectIndex => $Project)
        <option value="{{{ $ProjectIndex }}}">{{{ $Project['Name'] }}}</option>
    @endforeach
    </select>
    <button type="button" onclick="showProject(true)">Choose Project</button>
    <br>
@endif

<input type="text" size="10" id="Create">
<button type="button" onclick="createProject()">Create Project</button>

@foreach($UserProjects as $ProjectIndex => $Project)
    @if(count($UserProjects)==1)
        <div id="Project-{{{ $ProjectIndex }}}" class="Project">
    @else
        <div id="Project-{{{ $ProjectIndex }}}" class="Project" style="display:none">
    @endif
    {{{ $Project['Name'] }}}
    <br>
    @if($Project['Role']==3)
        <select id="Users">
        @foreach($AllUsers as $UserIndex => $User)
            <?php
                $found = false;
                foreach($Project['Users'] as $ProjectUser)
                {
                    if($ProjectUser==$User)
                    {
                        $found = true;
                    }
                }
                if(!$found)
                {
            ?>
                    <option value="{{{ $UserIndex }}}">{{{ $User }}}</option>
            <?php
                }
            ?>
        @endforeach
        </select>
        <button type="button" onclick="addUser()">Add User to Project</button>
        <br>
        <select id="CurrentUsersRemove">
        @foreach($Project['Users'] as $UserIndex => $User)
            <option value="{{{ $UserIndex }}}">{{{ $User }}}</option>
        @endforeach
        </select>
        <button type="button" onclick="removeUser()">Remove User from Project</button>
        <br>
        <select id="CurrentUsersChange">   
        @foreach($Project['Users'] as $UserIndex => $User)
            <option value="{{{ $UserIndex }}}">{{{ $User }}}</option>
        @endforeach
        </select>
        <select id="Roles">
        <option value="Admin">Admin</option>
        <option value="Write">Write</option>
        <option value="Read">Read</option>
        </select>
        <button type="button" onclick="changeRole()">Change User's Role</button>
        <br>
    @endif
    <select id="Syllabaries">
    @foreach($Project['Syllabaries'] as $SyllabaryIndex => $Syllabary)
        t
        <option value="{{{ $SyllabaryIndex }}}">{{{ $Syllabary }}}</option>
    @endforeach
    </select>
    <button type="button" onclick="loadSyllabary()">Go to Syllabary</button>
    </div>
@endforeach

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type='text/javascript'>
    function showProject(isSelected)
    {
        var index = 0;
        if(isSelected)
        {
            var dropdown = document.getElementById("Projects");
            index = dropdown.options[dropdown.selectedIndex].value;
        }
        var all = document.getElementsByClassName('Project');
        for (var i = 0; i < all.length; i++)
        {
            all[i].style.display = 'none';
        }
        document.getElementById("Project-" + index).style.display = 'block';
    }
    
    function createProject()
    {
        var name = document.getElementById("Create").value;
        $.post("/projects/create/" + name);
    }
    
    function addUser()
    {
        var dropdown = document.getElementById("Users");
        var index = dropdown.options[dropdown.selectedIndex].value;
        $.post("/projects/add/user/" + index);
    }
    
    function removeUser()
    {
        var dropdown = document.getElementById("CurrentUsersRemove");
        var index = dropdown.options[dropdown.selectedIndex].value;
        $.post("/projects/remove/user/" + index);
    }
    
    function changeRole()
    {
        var dropdown = document.getElementById("CurrentUsersChange");
        var index = dropdown.options[dropdown.selectedIndex].value;
        var dropdown2 = document.getElementById("Roles");
        var role = dropdown.options[dropdown.selectedIndex].value;
        $.post("/projects/change/user/" + index + "/role/" + role);
    }
    
    function loadSyllabary()
    {
        var dropdown = document.getElementById("Syllabaries");
        var index = dropdown.options[dropdown.selectedIndex].value;
        $.post("/projects/load/syllabary/" + index);
    }
</script>
</main>
@stop

