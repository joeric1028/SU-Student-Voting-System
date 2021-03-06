<?php
    if ($_SERVER['HTTPS'] != "on") {
        $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        header("Location: $url");
        exit;
    }
    require '../script/login.php'; // Require Login Script
    if(isset($_SESSION['login_voter']))
    {
        $_SESSION['error3'] = "Not Allowed";
        header("location: ../");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>SU VOTING</title>
        <link rel="shortcut icon" type="image/png" href="../img/vote_logo.png">
        <meta name="description" content="Home Page for Voting Management System.">
        <link href="../css/w3.css" rel="stylesheet" type="text/css">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <script src='https://www.google.com/recaptcha/api.js'></script>
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
            </strong>
        </section>
        <section id="pageContentCenter">
            
                <div class="w3-container w3-center w3-round-xxlarge w3-blue w3-padding-16">
                    <h2>Admin Login</h2>
                </div>
                <div class = "w3-container">
                    <form class="w3-container" method="post" action="index.php">
                        <label class="w3-container w3-text-teal"><b>ID Number :</b></label>
                        <input class="w3-container w3-input w3-light-grey w3-border w3-padding" type="text" name="idnum" placeholder="Enter your ID Number" required>
                        <label class="w3-container w3-text-teal"><b>Password :</b></label>
                        <input class="w3-container w3-input w3-light-grey w3-border w3-padding" type="password" name="password" placeholder="Enter your password" required>
                        <br><br>
                        <?php
                            if(isset($_SESSION['Error'])){
                            echo "<label class = 'w3-container w3-text-red'>{$_SESSION['Error']}</label><br>";
                            unset($_SESSION['Error']);
                            }else unset($_SESSION['Error']);
                        ?>
                        <div class="g-recaptcha w3-container" data-sitekey="6Le7JzcUAAAAAAAwxxr1QX5XEGOcVVBV3fUfFzel"></div>
                        <input class="w3-container w3-button w3-round-xxlarge w3-blue w3-padding" name="Submit" type="submit" value="Submit">    
                    </form>  
                <br>
                </div>
                <div class="w3-display-container w3-center w3-round-xxlarge w3-blue w3-padding-16"></div>
                <br>
        </section> 
        <footer>
            <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
            <address>
                Contact: <a href="mailto:josepricardo%40su.edu.ph">Mail me</a> 
		    </address>
        </footer>
    </body>
    <?php mysqli_close($con); // Closing Connection?> 
</html>