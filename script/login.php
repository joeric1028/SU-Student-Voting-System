<?php
    require_once 'database.php';

    session_start();

    if (isset($_POST['Submit'])) {
        
        if (empty($_POST['idnum']) || empty($_POST['password'])) $error = "ID Number or Password is empty!";
        else {
            $pdo = Database::connect();
            $idnum = $_POST['idnum'];
            $password = $_POST['password'];

            // To protect SQL injection for Security purpose
            $idnum = stripslashes($idnum);
            $password = stripslashes($password);

            // SQL query to fetch information of registerd users and finds user match.
            $sql = "SELECT COUNT(*) FROM user WHERE password=? AND idnum=? AND candidatetype='none' AND (admintype='Administrator' OR admintype='Polling Officer');";
            $result = $pdo->prepare($sql)->execute(array($idnum,$password));
            if ($result == 1) {
                $_SESSION['login_admin'] = $idnum; // Initializing Session
                $_SESSION['Error'] = "Successfully Login!";
                header('Refresh: 1; URL=../'); // Redirecting To Other Page
            } else $_SESSION['Error'] = "ID Number or password is incorrect";
            Database::disconnect();
        }
        
    } else if (isset($_POST['studentSubmit'])) {
        if (empty($_POST['idnum']) || empty($_POST['password'])) $error = "ID Number or Password is empty!";
        else {
            $pdo = Database::connect();
            $idnum = $_POST['idnum'];
            $pin = $_POST['password'];

            // To protect SQL injection for Security purpose
            $idnum = stripslashes($idnum);
            $pin = stripslashes($pin);

            // SQL query to fetch information of registerd users and finds user match.
            $sql = "SELECT COUNT(*) FROM user WHERE password='$pin' AND idnum='$idnum' AND admintype='Student';";
            $pdo->prepare($sql)->execute(array($idnum,$password));
            if ($result == 1) {
                $_SESSION['login_voter'] = $idnum; // Initializing Session
                $_SESSION['Error'] = "Successfully Login!";
                header("Refresh:2; URL:../voterprofile"); // Redirecting To Other Page
            } else $_SESSION['Error'] = "ID Number or PIN is invalid";
            Database::disconnect();
        }
    }
?>
