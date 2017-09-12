<?php
require 'database.php';
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) 
{
    if (empty($_POST['username']) || empty($_POST['password'])) 
    {
        $error = "Username or Password is empty!";
    }
    else
    {
        // Define $username and $password
        $username=$_POST['username'];
        $password=$_POST['password'];

        // To protect MySQL injection for Security purpose
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysqli_real_escape_string($con, $username);
        $password = mysqli_real_escape_string($con, $password);
        // SQL query to fetch information of registerd users and finds user match.
        $query = mysqli_query($con,"select * from login where username='$username'");

        $rows = mysqli_num_rows($query);
        if ($rows == 1) 
        {
            $error = "Registration Failed! It has been used! Please Try Again!";
        }else if ($rows == 0) 
        {
            $error = "Registration Sucessful!";
            mysqli_query($con,"insert into user (username, password) values ('$username','$password')");
            $_SESSION['login_user']=$username; // Initializing Session
            header("location: index.php"); // Redirecting To Other Page
        }
        mysqli_close($con); // Closing Connection
    }
}
?>