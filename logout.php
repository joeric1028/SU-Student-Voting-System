<?php 
session_start();
$error = '';
if(session_destroy()) // Destroying All Sessions
{
    echo $error = "Successfully Logout! Please come back soon!";
    //header("Location: index.php"); // Redirecting To Home Page
}
?>