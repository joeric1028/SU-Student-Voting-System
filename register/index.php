<?php
require '../script/register.php'; // Requires Login Script
require '../script/session.php';
if(!isset($_SESSION['login_admin_id']))
{
    $_SESSION['Error'] = "Please Login First!";
    header('location: ../admin');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/vote_logo.png">
    <link rel="canonical" href="http://html5-templates.com/">
    <title>Voting Management System</title>
    <meta name="description" content="Home Page for Voting Management System.">
    <link href="../css/style.css" rel="stylesheet" type="text/css">
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
        <!-- Register form -->
        <form method="post" action="">
                <legend>Register</legend>
                <div id="login">
                <h2>Registration Form</h2>
                <form action="../register" method="post">
                <label>ID Number      :</label>
                <input id="idnum" name="idnum" type="text">
                <label>PIN            :</label>
                <input id="pin" name="pin" type="password">
                <label>First Name     :</label>
                <input id="firstname" name="firstname" type="text">
                <label>Middle Initial :</label>
                <input id="middleinitial" name="middleinitial" type="text">
                <label>Last Name      :</label>
                <input id="lastname" name="lastname" type="text">
                <label>Year Level     :</label>
                <input id="yearlevel" name="yearlevel" type="text">
                <a href="../admin" class ="reg">Login</a>
                <input name="submit" type="submit" value=" Register ">
                <span><?php echo $error; ?></span>
                </form>
            </div>
    </section>
    <footer>
        <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
        <address>
            Contact: <a href="mailto:josepricardo%40su.edu.ph">Mail me</a>
            
		</address>
    </footer>
</body>

</html>