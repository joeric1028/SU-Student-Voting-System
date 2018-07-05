<?php
    require_once 'database.php';
    session_start();
    
    if(!empty($_SESSION['login_admin'])) {
        $user_check = $_SESSION['login_admin'];
        $pdo = Database::connect();
        $sql = "SELECT *, college.name AS collegename FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE idnum='$user_check';";
        $row = $pdo->query($sql)->fetch();
        $_SESSION['login_admin_id'] = $row['idnum'];
        $_SESSION['college'] = $row['collegename'];
        $_SESSION['idcollege'] = $row['idcollege'];
        if (!isset($_SESSION['login_admin_id'])) {
            unset($_SESSION['login_admin_id']);
            header("location: ../"); // Redirecting To Other Page
        }
        Database::disconnect();
    } else if (!empty($_SESSION['login_voter'])) {
        $user_check = $_SESSION['login_voter'];
        $pdo = Database::connect();
        $sql = "SELECT *, college.name AS collegename, FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE idnum='$user_check';";
        $row = $pdo->query($sql)->fetch();
        $_SESSION['login_voter_id'] = $row['idnum'];
        $_SESSION['college'] = $row['collegename'];
        $_SESSION['idcollege'] = $row['idcollege'];
        if (!isset($_SESSION['login_voter_id'])){
            unset($_SESSION['login_voter_id']);
            header("location:../vote"); // Redirecting To Other Page
        }
        Database::disconnect();
    }
?>
