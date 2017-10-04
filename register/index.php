<?php
require('../script/register.php'); // Requires Login Script
if(isset($_SESSION['register_user']))header("location: ../profile");
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/vote_logo.png">
    <link rel="canonical" href="http://html5-templates.com/" />
    <title>Voting Management System</title>
    <meta name="description" content="Home Page for Voting Management System.">
    <link href="../css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<header id = "pageContent">
<div id="logo"><a href="../"><img src="../img/vote_logo.png"></a>SU Voting</div>
    <nav>
        <ul>
            <li><a href="../candidate">CANDIDATE</a></li>
            <li><a href="../student">STUDENT</a></li>
            <li><a href="../vote">VOTE</a></li>
            <li><a href="../login">ADMIN</a></li>
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
                <a href="../login" class ="reg">Login</a>
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