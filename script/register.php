<?php
require 'database.php';
session_start(); // Starting Session

$error ='';
if (isset($_POST['registerSubmit'])) 
{
    $idnum=$_POST['idnum'];
    $pin=$_POST['pin'];
    $firstname=$_POST['firstname'];
    $middleinitial=$_POST['middleinitial'];
    $lastname=$_POST['lastname'];
    $course=$_POST['course'];
    $yearlevel=$_POST['yearlevel'];
    $sex=$_POST['sex'];

    // To protect MySQL injection for Security purpose
    $idnum = stripslashes($idnum);
    $pin = stripslashes($pin);
    $firstname = stripslashes($firstname);
    $middleinitial = stripslashes($middleinitial);
    $lastname = stripslashes($lastname);
    $course = stripslashes($course);
    $yearlevel = stripslashes($yearlevel);
    $sex = stripslashes($sex);

    $idnum = mysqli_real_escape_string($con, $idnum);
    $pin = mysqli_real_escape_string($con, $pin);
    $firstname = mysqli_real_escape_string($con, $firstname);
    $middleinitial = mysqli_real_escape_string($con, $middleinitial);
    $lastname = mysqli_real_escape_string($con, $lastname);
    $course = mysqli_real_escape_string($con, $course);
    $yearlevel = mysqli_real_escape_string($con, $yearlevel);
    $sex = mysqli_real_escape_string($con, $sex);
    // SQL query to fetch information of registerd users and finds user match.

    $result = mysqli_query($con, "SELECT * FROM student WHERE idnum='$idnum';");
    $rows = mysqli_num_rows($result);
    if($rows == 1)
    {
        $error = "Registration Failed! It has been used! Please Try Again!";
        mysqli_close($con); // Closing Connection
    }
    else if ($rows == 0) 
        {
            $error = "Registration Sucessful!";
            mysqli_query($con,"INSERT INTO student (idnum, pin, firstname, middleinitial, lastname, course_idcourse, yearlevel, sex)
                                            VALUES ('$idnum','$pin' ,'$firstname', '$middleinitial', '$lastname', '$course', '$yearlevel', '$sex');");
            header("Refresh:1; URL=../"); // Redirecting To Other Page
        }
        mysqli_close($con); // Closing Connection
    }

?>