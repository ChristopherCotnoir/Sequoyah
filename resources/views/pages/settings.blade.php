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
@elseif(count($UserProjects)==1)
    <script type='text/javascript'>
        showProject(false);
    </script>
@endif

<button type="button" onclick="createProject()">Create Project</button>

@foreach($UserProjects as $ProjectIndex => $Project)
    <div id="Project-{{{ $ProjectIndex }}}" class="Project" style="display:none">
    {{{ $Project['Name'] }}}
    <br>
    @if($Project['Role']==3)
        <select id="Users">
        @foreach($AllUsers as $UserIndex => $User)
            <option value="{{{ $UserIndex }}}">{{{ $User }}}</option>
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
        <option value="{{{ $SyllabaryIndex }}}">{{{ $Syllabary }}}</option>
    @endforeach
    </select>
    <button type="button" onclick="loadSyllabary()">Go to Syllabary</button>
    </div>
@endforeach

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
    <!-- function to create a new Project here -->
    }
    
    function addUser()
    {
        var dropdown = document.getElementById("Users");
        var index = dropdown.options[dropdown.selectedIndex].value;
        <!-- function to add user $AllUsers[index] to project -->
    }
    
    function removeUser()
    {
        var dropdown = document.getElementById("CurrentUsersRemove");
        var index = dropdown.options[dropdown.selectedIndex].value;
        <!-- function to remove user $Project['Users'][index] from project -->
    }
    
    function changeRole()
    {
        var dropdown = document.getElementById("CurrentUsersChange");
        var index = dropdown.options[dropdown.selectedIndex].value;
        var dropdown2 = document.getElementById("Roles");
        var role = dropdown.options[dropdown.selectedIndex].value;
        <!-- function to change role of user $Project['Users'][index] to role -->
    }
    
    function loadSyllabary()
    {
        var dropdown = document.getElementById("Syllabaries");
        var index = dropdown.options[dropdown.selectedIndex].value;
        <!-- function to load syllabary $Project['Syllabaries'][index] -->
    }
</script>
</main>
@stop