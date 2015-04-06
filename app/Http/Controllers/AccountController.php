<?php namespace Sequoyah\Http\Controllers;

class AccountController extends Controller
{
    /** 
      * Create a new controller instance
      *
      * @return void
      */

    public function_construct()
    {
        //
    }

    public function GetUserAccessPermissions($projectId, $userId)
    {
        //database: sequoyah
        //table: project_members
        //fields                    Type                                             NULL                    Default
        //user_id                bigint(20) unsigned            Not NULL          NULL
        //project_id         bigint(20) unsigned            Not NULL          NULL
        // access                 smallin(6)	                            Not NULL 	    0

        $servername = "localhost";
        $username = "userid";
        $password = "password";
        $dbname = "sequoyah";

       //create connection
       $conn = new mysqli($servername,$username,$password,$dbname);

        //check connection
        if($conn->connect_error)
        {
            die("Connection failed:".$conn->connect_error);
        }

        $mysql = "SELECT access FROM project_members WHERE project_id = '$projectId' and user_id = '$userId'";
        $result = conn->query($mysql);

        if($row = $result->fetch_assoc())
        {
            echo $row['access'];
        }
        else
        {
            echo "An unexpected error has occured.";
        }

        mysql_free_result($result);

        $conn->close();
    }
}
