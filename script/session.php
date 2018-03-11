<?php
    require_once 'database.php';
    session_start();
    if(!empty($_SESSION['login_admin'])) {
        $user_check = $_SESSION['login_admin'];
        $ses_sql = mysqli_query($con,"SELECT yearlevel, idnum, college.name AS collegename, course.name AS coursename, firstname, middleinitial, lastname, sex, contactno, birthday, birthplace, citizenship, civilstatus, picture FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE idnum='$user_check';");
        $row = mysqli_fetch_assoc($ses_sql);
        $_SESSION['login_admin_id'] = $row['idnum'];
        $_SESSION['college'] = $row['collegename'];
        if (!isset($_SESSION['login_admin_id'])) {
            unset($_SESSION['login_admin_id']);
            mysqli_close($con); // Closing Connection
            header("location: ../"); // Redirecting To Other Page
        }
    }
    if (!empty($_SESSION['login_voter'])) {
        $user_check = $_SESSION['login_voter'];
        $ses_sql = mysqli_query($con,"SELECT yearlevel, idnum, college.name AS collegename, course.name AS coursename, firstname, middleinitial, lastname, sex, contactno, birthday, birthplace, citizenship, civilstatus, picture FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE idnum='$user_check';");
        $row = mysqli_fetch_assoc($ses_sql);
        $_SESSION['login_voter_id'] = $row['idnum'];
        $_SESSION['college'] = $row['collegename'];
        if(!isset($_SESSION['login_voter_id'])){
            unset($_SESSION['login_voter_id']);
            mysqli_close($con); // Closing Connection
            header("location:../vote"); // Redirecting To Other Page
        }
    }
?>
