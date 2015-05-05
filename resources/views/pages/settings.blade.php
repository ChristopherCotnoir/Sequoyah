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
        <select id="Users-{{{ $ProjectIndex }}}">
        @foreach($AllUsers as $UserIndex => $User)
            <?php
                $found = false;
                foreach($Project['Users'] as $ProjectUser)
                {
                    if($ProjectUser['Id']==$User['Id'])
                    {
                        $found = true;
                    }
                }
                if(!$found&&$User['Id']!=Auth::user()->id)
                {
            ?>
                    <option value="{{{ $User['Id'] }}}">{{{ $User['Name'] }}}</option>
            <?php
                }
            ?>
        @endforeach
        </select>
        <button type="button" onclick="addUser({{{ $ProjectIndex }}}, '{{{ $Project['Id'] }}}')">Add User to Project</button>
        <br>
        <select id="CurrentUsersRemove-{{{ $ProjectIndex }}}">
        @foreach($Project['Users'] as $UserIndex => $User)
            <option value="{{{ $User['Id'] }}}">{{{ $User['Name'] }}}</option>
        @endforeach
        </select>
        <button type="button" onclick="removeUser({{{ $ProjectIndex }}}, '{{{ $Project['Id'] }}}')">Remove User from Project</button>
        <br>
        <select id="CurrentUsersChange-{{{ $ProjectIndex }}}">
        @foreach($Project['Users'] as $UserIndex => $User)
            <option value="{{{ $User['Id'] }}}">{{{ $User['Name'] }}}</option>
        @endforeach
        </select>
        <select id="Roles">
        <option value=3>Admin</option>
        <option value=2>Write</option>
        <option value=1>Read</option>
        </select>
        <button type="button" onclick="changeRole({{{ $ProjectIndex }}}, '{{{ $Project['Id'] }}}')">Change User's Role</button>
        <br>
        <input type="text" size="10" id="NewSyllabary">
        <button type="button" onclick="newSyllabary('{{{ $Project['Id'] }}}')">Create New Syllabary</button>
        <br>
    @endif
    <select id="Syllabaries-{{{ $ProjectIndex }}}">
    @foreach($Project['Syllabaries'] as $Syllabary)
        <option value="{{{ $Syllabary['Id'] }}}">{{{ $Syllabary['Name'] }}}</option>
    @endforeach
    </select>
    <button type="button" onclick="loadSyllabary({{{ $ProjectIndex }}})">Go to Syllabary</button>
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
    
    function reload()
    {
        location.reload();
    }
    
    function createProject()
    {
        var name = document.getElementById("Create").value;
        $.post("/projects/create/" + name, function() {
            reload();
        });
    }
    
    function addUser(index, id)
    {
        var dropdown = document.getElementById("Users-" + index);
        var user = dropdown.options[dropdown.selectedIndex].value;
        $.post("/projects/" + id + "/add/user/" + user, function() {
            reload();
        });
    }
    
    function removeUser(index, id)
    {
        var dropdown = document.getElementById("CurrentUsersRemove-" + index);
        var user = dropdown.options[dropdown.selectedIndex].value;
        $.post("/projects/" + id + "/remove/user/" + user, function() {
            reload();
        });
    }
    
    function changeRole(index, id)
    {
        var dropdown = document.getElementById("CurrentUsersChange-" + index);
        var user = dropdown.options[dropdown.selectedIndex].value;
        var dropdown2 = document.getElementById("Roles");
        var role = dropdown2.options[dropdown2.selectedIndex].value;
        $.post("/projects/" + id + "/change/user/" + user + "/role/" + role, function() {
            reload();
        });
    }

    function newSyllabary(id)
    {
        var name = document.getElementById("NewSyllabary").value;
        $.post("/projects/" + id + "/create/syllabary/" + name, function() {
            reload();
        });
    }

    function loadSyllabary(index)
    {
        var dropdown = document.getElementById("Syllabaries-" + index);
        var syllabary = dropdown.options[dropdown.selectedIndex].value;
        window.location = '/syllabary/' + syllabary;
    }
</script>
</main>
@stop

