<?php
require_once 'database.php';

session_start();

if(isset($_POST['Submit'])) 
{
        $idnum = $_POST['idnum'];
        $pin = $_POST['pin'];

        // To protect MySQL injection for Security purpose
        $idnum = stripslashes($idnum);
        $pin = stripslashes($pin);
        $idnum = mysqli_real_escape_string($con,$idnum);
        $pin = mysqli_real_escape_string($con,$pin);

        // SQL query to fetch information of registerd users and finds user match.
        $query = mysqli_query($con,"SELECT * FROM student WHERE pin='$pin' AND idnum='$idnum' AND admintype='Yes';");
        $rows = mysqli_num_rows($query);
        if ($rows == 1) {
            $_SESSION['login_admin'] = $idnum; // Initializing Session
            $_SESSION['Error'] = "Successfully Login!";
            header('Refresh: 1; URL=../'); // Redirecting To Other Page
        }else $_SESSION['Error'] = "ID Number or password is incorrect";
        mysqli_close($con); // Closing Connection
}else if (isset($_POST['studentSubmit'])) 
{
    if (empty($_POST['idnum']) || empty($_POST['pin']))
    {
        $error = "ID Number or PIN is empty!";
    }else{
        $idnum=$_POST['idnum'];
        $pin=$_POST['pin'];

        // To protect MySQL injection for Security purpose
        $idnum = stripslashes($idnum);
        $pin = stripslashes($pin);
        $idnum = mysqli_real_escape_string($con,$idnum);
        $pin = mysqli_real_escape_string($con,$pin);

        // SQL query to fetch information of registerd users and finds user match.
        $query = mysqli_query($con,"SELECT * FROM student WHERE pin='$pin' AND idnum='$idnum';");
        $rows = mysqli_num_rows($query);
    if ($rows == 1)
    {
        $_SESSION['login_voter'] = $idnum; // Initializing Session
        $_SESSION['Error'] = "Successfully Login!";
        header("Refresh: 1; URL:../voterprofile"); // Redirecting To Other Page
    }else{
        $_SESSION['Error'] = "ID Number or PIN is invalid";
    }
    mysqli_close($con); // Closing Connection
    }
}
?>