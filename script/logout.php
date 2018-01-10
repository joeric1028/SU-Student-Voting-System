<?php 
session_start();
$error = '';
if(session_destroy()) // Destroying All Sessions
{
    echo $error = "Successfully Logout! Please come back soon!";
    header('Refresh: 1; URL=../');
}else{
    echo $error = "Already Logout! Please come back soon!";
    header('Refresh: 1; URL=../');
}
?>
