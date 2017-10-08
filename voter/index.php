<?php
require '../script/login.php'; // Require Login Script
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
                <?php
                    if(isset($_SESSION['login_admin']))echo "<li><a href='../candidate'>CANDIDATE</a></li>
                                                <li><a href='../student'>STUDENT</a></li>";
                ?>
                <li><a href="../voter">VOTER</a></li>
                <li><a href="../admin">ADMIN</a></li>
            </ul>
        </nav>
        </header>
        <section>
            <strong>
            </strong>
        </section>
        <section id="pageContentCenter">
            
                <div class="w3-container w3-center w3-round-xxlarge w3-blue w3-padding-16">
                    <h2>Vote Login</h2>
                </div>
                <div class = "w3-container">
                    <form class="w3-container" method="post" action="index.php">
                        <label class="w3-container w3-text-teal"><b>ID Number :</b></label>
                        <input class="w3-container w3-input w3-light-grey w3-border w3-padding" type="text" name="idnum" placeholder="Enter ID Number" required>
                        <label class="w3-container w3-text-teal"><b>PIN :</b></label>
                        <input class="w3-container w3-input w3-light-grey w3-border w3-padding" type="password" name="pin" placeholder="Enter PIN" required>
                        <br><br>
                        <?php
                            if(isset($_SESSION['Error'])){
                            echo "<label class = 'w3-container w3-text-red'>{$_SESSION['Error']}</label><br>";
                            unset($_SESSION['Error']);
                            }else unset($_SESSION['Error']);
                        ?>
                        <input class="w3-container w3-button w3-round-xxlarge w3-blue" name="studentSubmit" type="submit" value="Submit">    
                    </form>
                <br>
                </div>
                <div class="w3-container w3-center w3-round-xxlarge w3-blue w3-padding-16"></div>
                <br>
        </section> 
        <footer>
            <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
            <address>
                Contact: <a href="mailto:josepricardo%40su.edu.ph">Mail me</a> 
		    </address>
        </footer>
    </body>
</html>