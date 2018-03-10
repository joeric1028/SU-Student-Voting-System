<?php
    require '../script/session.php'; // Includes Login Script
    if(isset($_SESSION['login_voter_id']))
    {
        $_SESSION['error3'] = "Not Allowed!";
        header('location:../');
    }else if(!isset($_SESSION['login_admin_id']))
    {
        $_SESSION['Error'] = "Please Login First!";
        header('location: ../admin');
    }
    if(isset($_POST['logout_user']))
    {
        if(session_destroy()) // Destroying All Sessions
        {
            $error2 = "Successfully Logout! Please come back soon!";
            header('Refresh: 1; URL=../');
        }else{
            $error2 = "Already Logout! Please come back soon!";
            header('Refresh: 1; URL=../');
        }
    }
    $error = 'No Candidate Yet';
    $currentyear = strftime("%Y");
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>SU Voting</title>
        <link rel="shortcut icon" href="../img/vote_logo.png">
        <meta name="description" content="Home Page for Voting Management System.">
        <link href="../css/w3.css" rel="stylesheet" type="text/css">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>
    <body>
    <header id = "pageContent">
    <div id="logo"><a href="../" style="text-decoration:none"><img src="../img/vote_logo.png">SU VOTING</a></div>
        <nav>
            <ul>
                <?php
                    if(isset($_SESSION['login_admin_id']))echo "<li><a href='../candidate'>CANDIDATE</a></li>
                                                            <li><a href='../student'>STUDENT</a></li>
                                                            <li><a href='../profile'>MY PROFILE</a></li>
                                                            <li><a href='../register'>REGISTER</a></li>";
                    else if(isset($_SESSION['login_voter_id']))
                    {
                        echo '<li><a href="../vote">VOTE</a></li>
                            <li><a href="../voterprofile">MY PROFILE</a></li>';
                    }else echo '<li><a href="../voter">VOTER</a></li>
                            <li><a href="../admin">ADMIN</a></li>';
                ?>
            </ul>
        </nav>
</header>
<section>
<strong>
    <div id="profile">
        <b id="welcome">Welcome
        <?php
            if(isset($_SESSION['login_admin_id']))
            {
                echo "Admin: ".$row['firstname'].' '.$row['middleinitial'].' '.$row['lastname'].'<form action="index.php" method="post">
                <input type="submit" value="LOGOUT" class = "w3-button" name = "logout_user">
                </form>';
                if(empty($error2)){
                }else{
                    echo $error2;
                }
            }else if(isset($_SESSION['login_voter_id']))
            {
                echo "Voter: ".$row['firstname'].' '.$row['middleinitial'].' '.$row['lastname'].'<form action="index.php" method="post">
                <input type="submit" value="LOGOUT" class = "w3-button" name = "logout_user">
                </form>';
                if(empty($error2)){
                }else{
                    echo $error2;
                }
            }else{
                echo "Guest:";
            }
        ?>
        </b>
    </div>
</strong>
</section>
        <section id="pageContent">
            <main role="main">
                <article>
                    <h1>Candidates</h1>
                </article>
                <article>
                    <h2>Governor</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Governor' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>Vice Governor</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Vice Governor' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>Secretary</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Secretary' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>Assistant Secretary</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Assistant Secretary' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>Treasurer</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Treasurer' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>Auditor</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Auditor' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>5th Year Mayor</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='5Yr Mayor' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>5th Year Vice Mayor</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='5Yr Vice Mayor' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>4th Year Mayor</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='4Yr Mayor' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>4th Year Vice Mayor</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='4Yr Vice Mayor' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>3rd Year Mayor</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='3Yr Mayor' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>3rd Year Vice Mayor</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype = '3Yr Vice Mayor' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>2nd Year Mayor</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='2Yr Mayor' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>2nd Year Vice Mayor</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='2Yr Vice Mayor' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>1st Year Mayor</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='1Yr Mayor' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>1st Year Vice Mayor</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype = '1Yr Vice Mayor' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>Architecture Representative</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Architecture Representative' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>Civil Engineering Representative</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype = 'Civil Engineering Representative' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>Computer Engineering Representative</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Computer Engineering Representative' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>Electrical Engineering Representative</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype = 'Electrical Engineering Representative' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
                <article>
                    <h2>Mechanical Engineering Representative</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype = 'Mechanical Engineering Representative' AND candidateyear = '$currentyear';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
                                        </tr>\n";
                                    }
                                }else{
                                    echo "</table>$error";
                                }
                            ?>
                        </table>
                        <br>
                    </p>
                </article>
            </main>
            <aside>
                <div><img src="../img/vote_logo.png" class="w3-container w3-circle" style ="width:50%"></div>
                <!-- <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div> -->
            </aside>
        </section>
    </body>
        <footer>
            <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
            <address>
            Contact: <a href="mailto:josepricardo%40su.edu.ph">Mail me</a>
		</address>
        </footer>
        <?php mysqli_close($con); // Closing Connection?>
</html>
