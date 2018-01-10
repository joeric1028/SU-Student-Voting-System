<?php
require '../script/session.php'; // Includes Login Script
require '../script/vote.php';
$error2 = '';
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
}else{
    
    if(!isset($_SESSION['login_voter_id']))
    {
        $_SESSION['Error'] = "Please Login First!";
        header('location: ../voter');
    }
    $result1 = mysqli_query($con,"SELECT * FROM student INNER JOIN vote ON idstudent = idvote WHERE voted ='No' AND idnum='{$_SESSION['login_voter_id']}';");
    if(mysqli_num_rows($result1) != 1) 
    {
        $_SESSION['error3'] ="Already voted!";
    }
    if(isset($_SESSION['login_admin_id']))
    {
        $_SESSION['error3'] = "Not Allowed!";
        header('location: ../?');
    } 
}
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
                                                            <li><a href='../profile'>MY PROFILE</a></li>";
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
                            echo "Admin: ".$row['fullname'].'<form action="index.php" method="post">
                            <input type="submit" value="LOGOUT" class = "w3-button" name = "logout_user">
                            </form>'; 
                            if(!empty($error2))echo $error2;
                            if(isset($_SESSION['error3'])){
                                echo $_SESSION['error3'];
                                unset($_SESSION['error3']);
                            }else unset($_SESSION['error3']);
                        }else if(isset($_SESSION['login_voter_id']))
                        {
                            echo "Voter: ".$row['fullname'].'<form action="index.php" method="post">
                            <input type="submit" value="LOGOUT" class = "w3-button" name = "logout_user">
                            </form>'; 
                            if(!empty($error2))echo $error2;
                            if(isset($_SESSION['error3'])){
                                echo $_SESSION['error3'];
                                unset($_SESSION['error3']);
                            }else unset($_SESSION['error3']);
                        }else echo "Guest:";
                    ?>
                    </b>
                </div>
            </strong>
        </section>
        <section>
                <form class="w3-container" method="post" action="index.php">
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>Governor:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                    <?php
                                        $result1 = mysqli_query($con,"SELECT * FROM student INNER JOIN vote ON idstudent = idvote WHERE voted ='No' AND idnum='{$_SESSION['login_voter_id']}';");
                                        if(mysqli_num_rows($result1) == 1) 
                                        {
                                            $row1 = mysqli_fetch_assoc($result1);
                                            $_SESSION['voterid'] = $row1['idstudent'];
                                            $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Governor' AND candidateyear='$currentyear';");
                                            if(mysqli_num_rows($result) != 0){
                                                while($row = mysqli_fetch_assoc($result))
                                                {
                                                    echo '<div class="w3-container w3-left">
                                                    <input name="governor" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                            }else{
                                                 $_SESSION['error3'] = "Voting Session is not yet started";
                                            }
                                        }else{
                                            $_SESSION['error3'] = "Error retrieving Candidate Data";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>Vice Governor:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                $result1 = mysqli_query($con,"SELECT * FROM student INNER JOIN vote ON idstudent = idvote WHERE voted ='No' AND idnum='{$_SESSION['login_voter_id']}';");
                                if(mysqli_num_rows($result1) == 1)
                                {
                                    $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Vice Governor' AND candidateyear='$currentyear';");
                                    if(mysqli_num_rows($result) != FALSE){
                                        while($row = mysqli_fetch_assoc($result))
                                        {
                                            echo '<div class="w3-container w3-left">
                                            <input name="vicegovernor" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                        }
                                    }else{
                                         $_SESSION['error3'] = "Voting Session is not yet started";
                                    }
                                }else{
                                    $_SESSION['error3'] = "Error retrieving Candidate Data";
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php
                    $result1 = mysqli_query($con,"SELECT * FROM student INNER JOIN vote ON idstudent = idvote WHERE voted ='No' AND idnum='{$_SESSION['login_voter_id']}';");
                        if(mysqli_num_rows($result1) == 1)
                        {
                            echo '<input class="w3-container w3-button w3-round-xxlarge w3-blue" name="voteSubmit" type="submit" value="Submit">';
                        }else $_SESSION['error3'] = "Error retrieving Candidate Data";
                    ?>
                </form>
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