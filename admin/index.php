<?php
require '../script/login.php'; // Require Login Script
if(isset($_SESSION['login_user']))header('location: ../profile');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Voting Management System</title>
        <link rel="shortcut icon" type="image/png" href="../img/vote_logo.png">
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
            <li><a href="../candidate">CANDIDATE</a></li>
            <li><a href="../student">STUDENT</a></li>
            <li><a href="../vote">VOTE</a></li>
            <li><a href="../admin">ADMIN</a></li>
        </ul>
    </nav>
</header>
    <section id="pageContent">
        <main role="main">
        <div class="w3-container w3-blue">
            <h2>Login</h2>
        </div>
        <form class="w3-container" method="post" action="index.php">
            <label class="w3-text-teal"><b>ID Number :</b></label>
            <input class="w3-input w3-border w3-light-grey" type="text" name="idnum">
            <label class="w3-text-teal"><b>Password :</b></label>
            <input class="w3-input w3-border w3-light-grey" type="password" name="pin">
            <a href="../register" class ="reg">Register</a>
            <br><?php
                    if(isset($_SESSION['Error']))echo "<label>{$_SESSION['Error']}</label><br>";
                    else unset($_SESSION['Error']);
                ?>
            <input class="w3-btnw3-blue-grey" name="Submit" type="submit" value="Submit">      
        </form>
        </main>
    </section> 
    <footer>
        <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
        <address>
            Contact: <a href="mailto:josepricardo%40su.edu.ph">Mail me</a> 
		</address>
    </footer>
</body>

</html>