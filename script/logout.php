<?php 
    session_start();
    
    $error = '';
    
    if  (session_destroy()) {
        echo $error = "Successfully Logout! Please come back soon!";
    }
?>
