<?php
require 'database.php';
session_start();

$user_check=$_SESSION['login_user'];

$ses_sql=mysqli_query($con,"SELECT * FROM listofstudents WHERE idnum='$user_check'");
$row = mysqli_fetch_assoc($ses_sql);
$login_session = $row['fullname'];
if(!isset($login_session)){
    unset($login_session);
    mysqli_close($con); // Closing Connection
    header("location: ../"); // Redirecting To Other Page
}
?>