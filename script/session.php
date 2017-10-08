<?php
    require 'database.php';
    session_start();
    if(!empty($_SESSION['login_admin']))
    {
        $user_check = $_SESSION['login_admin'];
        
        $ses_sql = mysqli_query($con,"SELECT * FROM listofstudents WHERE idnum='$user_check';");
        $row = mysqli_fetch_assoc($ses_sql);
        $_SESSION['login_admin_id'] = $row['idnum'];
        if(!isset($_SESSION['login_admin_id'])){
            unset($_SESSION['login_admin_id']);
            mysqli_close($con); // Closing Connection
            header("location: ../"); // Redirecting To Other Page
        }
    }
    if(!empty($_SESSION['login_voter']))
    {
        $user_check = $_SESSION['login_voter'];
        
        $ses_sql = mysqli_query($con,"SELECT * FROM listofstudents WHERE idnum='$user_check';");
        $row = mysqli_fetch_assoc($ses_sql);
        $_SESSION['login_voter_id'] = $row['idnum'];
        if(!isset($_SESSION['login_voter_id'])){
            unset($_SESSION['login_voter_id']);
            mysqli_close($con); // Closing Connection
            header("location:../vote"); // Redirecting To Other Page
        }
    }
?>