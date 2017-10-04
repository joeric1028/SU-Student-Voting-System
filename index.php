<?php
require 'script/database.php'; // Includes Login Script
if(isset($_SESSION['login_user']))header("location: ../");
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
        <link rel="stylesheet" href="../css/w3.css"> 
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>

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

    <body>
        <section>
            <strong><br></strong>
        </section>
        <section id="pageContent">
        
            <main role="main">
            <h2>Votes</h2>
                <article>

                </article>
            </main>
            <aside>
                <div><img src="../img/avatar.png" style ="width:25%"></div>
                <div><img src="../img/avatar.png" style ="width:25%"></div>
                <div><img src="../img/avatar.png" style ="width:25%"></div>
                <div><img src="../img/avatar.png" style ="width:25%"></div>
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