<?php
require_once 'database.php';
session_start(); // Starting Session

$error ='';
if (isset($_POST['registerSubmit']))
{
    $idnum=$_POST['idnum'];
    $pin=$_POST['password'];
    $admintype=$_POST['admintype'];
    $firstname=$_POST['firstname'];
    $middleinitial=$_POST['middleinitial'];
    $lastname=$_POST['lastname'];
    $contactno = $_POST['contactno'];
    $citizenship = $_POST['citizenship'];
    $civilstatus = $_POST['civilstatus'];
    $birthplace = $_POST['birthplace'];
    $birthday = $_POST['birthday'];
    $course=$_POST['course'];
    $yearlevel=$_POST['yearlevel'];
    $sex=$_POST['sex'];

    // To protect MySQL injection for Security purpose
    $idnum = stripslashes($idnum);
    $password = stripslashes($password);
    $admintype = stripslashes($admintype);
    $firstname = stripslashes($firstname);
    $middleinitial = stripslashes($middleinitial);
    $lastname = stripslashes($lastname);
    $contactno = stripslashes($contactno);
    $citizenship = stripslashes($citizenship);
    $civilstatus = stripslashes ($civilstatus);
    $birthplace = stripslashes($birthplace);
    $birthday = stripslashes($birthday);
    $course = stripslashes($course);
    $yearlevel = stripslashes($yearlevel);
    $sex = stripslashes($sex);

    $idnum = mysqli_real_escape_string($con, $idnum);
    $password = mysqli_real_escape_string($con, $password);
    $admintype = mysqli_real_escape_string($con, $admintype);
    $firstname = mysqli_real_escape_string($con, $firstname);
    $middleinitial = mysqli_real_escape_string($con, $middleinitial);
    $lastname = mysqli_real_escape_string($con, $lastname);
    $contactno = mysqli_real_escape_string($con, $contactno);
    $citizenship = mysqli_real_escape_string($con, $citizenship);
    $civilstatus = mysqli_real_escape_string($con, $civilstatus);
    $birthplace = mysqli_real_escape_string($con, $birthplace);
    $birthday = mysqli_real_escape_string($con, $birthday);
    $course = mysqli_real_escape_string($con, $course);
    $yearlevel = mysqli_real_escape_string($con, $yearlevel);
    $sex = mysqli_real_escape_string($con, $sex);
    // SQL query to fetch information of registerd users and finds user match.

    $result = mysqli_query($con, "SELECT * FROM user WHERE idnum='$idnum';");
    $rows = mysqli_num_rows($result);
    if($rows == 1)
    {
        $error = "Registration Failed! It has been used! Please Try Again!";
        mysqli_close($con); // Closing Connection
    }
    else if ($rows == 0)
        {
            $error = "Registration Sucessful!";
            mysqli_query($con,"INSERT INTO user (idnum, password,admintype, firstname, middleinitial, lastname, contactno, citizenship, civilstatus, birthplace, birthday, course_idcourse, yearlevel, sex)
                                            VALUES ('$idnum', '$password', '$admintype', '$firstname', '$middleinitial', '$lastname', '$contactno', '$citizenship', '$civilstatus', '$birthplace', '$birthday', '$course', '$yearlevel', '$sex');");
            header("Refresh:1; URL=../"); // Redirecting To Other Page
        }
        mysqli_close($con); // Closing Connection
    }

?>
