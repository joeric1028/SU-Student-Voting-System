<?php
require_once 'database.php';

session_start();

if (isset($_POST['Submit'])) {
    $idnum = $_POST['idnum'];
    $password = $_POST['password'];

    // To protect MySQL injection for Security purpose
    $idnum = stripslashes($idnum);
    $password = stripslashes($password);
    $idnum = mysqli_real_escape_string($con,$idnum);
    $password = mysqli_real_escape_string($con,$password);

    // SQL query to fetch information of registerd users and finds user match.
    $query = mysqli_query($con,"SELECT * FROM user WHERE password='$password' AND idnum='$idnum' AND candidatetype='none' AND (admintype='Administrator' OR admintype='Polling Officer');");
    $rows = mysqli_num_rows($query);
    if ($rows == 1) {
        $_SESSION['login_admin'] = $idnum; // Initializing Session
        $_SESSION['Error'] = "Successfully Login!";
        header('Refresh: 1; URL=../'); // Redirecting To Other Page
    } else $_SESSION['Error'] = "ID Number or password is incorrect";
} else if (isset($_POST['studentSubmit'])) {
    if (empty($_POST['idnum']) || empty($_POST['password'])) $error = "ID Number or Password is empty!";
    else {
        $idnum = $_POST['idnum'];
        $pin = $_POST['password'];

        // To protect MySQL injection for Security purpose
        $idnum = stripslashes($idnum);
        $password = stripslashes($password);
        $idnum = mysqli_real_escape_string($con,$idnum);
        $password = mysqli_real_escape_string($con,$password);

        // SQL query to fetch information of registerd users and finds user match.
        $query = mysqli_query($con,"SELECT * FROM user WHERE password='$password' AND idnum='$idnum' AND admintype='Student';");
        $rows = mysqli_num_rows($query);
        if ($rows == 1) {
            $_SESSION['login_voter'] = $idnum; // Initializing Session
            $_SESSION['Error'] = "Successfully Login!";
            header("Refresh:2; URL:../voterprofile"); // Redirecting To Other Page
        } else $_SESSION['Error'] = "ID Number or PIN is invalid";
    }
}
mysqli_close($con); // Closing Connection
?>
