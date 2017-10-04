<?php
require 'database.php';
session_start(); // Starting Session
$error = $nameErr = $emailErr = $genderErr = $websiteErr = $firstname = $middleinitial = $lastname = $idnum = $email = $gender = $comment = $website = '';

function test_input($data)
{
    $data = stripslashes($data);
    $data = mysql_real_escape_string($con,$data);
    return $data;
}

if($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (empty($_POST["firstname"]))$nameErr = "First Name is required";
    else $firstname = test_input($_POST["firstname"]);

    if(empty($_POST["email"])) $emailErr = "Email is required";
    else $email = test_input($_POST["email"]);

    if (empty($_POST["website"]))$website = "";
    else $website = test_input($_POST["website"]);

    if (empty($_POST["comment"]))$comment = "";
    else $comment = test_input($_POST["comment"]);
    if (empty($_POST["gender"]))$genderErr = "Gender is required";
    else $gender = test_input($_POST["gender"]);
}



if (isset($_POST['submit'])) 
{
    if (empty($_POST['idnum']) || empty($_POST['pin'])) 
    {
        $error = "ID Number or PIN is empty!";
    }
    else
    {
        $idnum=$_POST['idnum'];
        $pin=$_POST['pin'];

        // To protect MySQL injection for Security purpose
        $idnum = stripslashes($idnum);
        $pin = stripslashes($pin);
        $idnum = mysqli_real_escape_string($con, $idnum);
        $pin = mysqli_real_escape_string($con, $pin);
        // SQL query to fetch information of registerd users and finds user match.
        $query = mysqli_query($con,"select * from login where idnum='$idnum';");

        $rows = mysqli_num_rows($query);
        if ($rows == 1) 
        {
            $error = "Registration Failed! It has been used! Please Try Again!";
        }else if ($rows == 0) 
        {
            $error = "Registration Sucessful!";
            mysqli_query($con,"insert into user (idnum, PIN) values ('$idnum','$pin');");
            $_SESSION['login_user']=$idnum; // Initializing Session
            header("location: ../"); // Redirecting To Other Page
        }
        mysqli_close($con); // Closing Connection
    }
}
?>