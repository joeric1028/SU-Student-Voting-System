<?php
require '../script/session.php'; // Includes Login Script
$error = '';
if(isset($_POST['logout_voter_id']))
{
    if(session_destroy()) // Destroying All Sessions
    {
        $error = "Successfully Logout! Please come back soon!";
        header('Refresh: 1; URL=../');
    }else{
        $error = "Already Logout! Please come back soon!";
        header('Refresh: 1; URL=../');
    }
}else{
    if(!isset($_SESSION['login_voter_id']))
    {
        $_SESSION['Error'] = "Please Login First!";
        header('location: ../voter');
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
    <div id="logo"><a href="../"><img src="../img/vote_logo.png"></a>SU VOTING</div>
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
                if(empty($error2)){
                }else{
                    echo $error2;
                }
            }else if(isset($_SESSION['login_voter_id']))
            {
                echo "Voter: ".$row['fullname'].'<form action="index.php" method="post">
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
                    <h1></h1>
                </article>
                
            </main>
            <aside>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div> 
            </aside>
        </section>
    </body>
        <footer>
            <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
            <address>
            Contact: <a href="mailto:josepricardo%40su.edu.ph">Mail me</a>
		</address>
        </footer>
</html>