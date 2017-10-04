<?php
require '../script/session.php';
$error = "";
if(isset($_POST['logout_user']))
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
    if(empty($login_session))header('location: ../'); 
}


?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="canonical" href="http://html5-templates.com/" />
        <title>SU VOTING</title>
        <meta name="description" content="Home Page for Voting Management System.">
        <link rel="stylesheet" href="../css/w3.css"> 
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="../img/vote_logo.png">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>
    <body>
    <header id = "pageContent">
    <div id="logo"><a href="../"><img src="../img/vote_logo.png"></a>SU Voting</div>
        <nav>
            <ul>
                <li><a href="../candidate">CANDIDATE</a></li>
                <li><a href="../student">STUDENT</a></li>
                <li><a href="../vote">VOTE</a></li>
                <li><a href="../admin">ADMIN</a></li>
            </ul>
        </nav>
    </header>
        <section>
            <strong>
                <div id="profile">
                    <b id="welcome">Welcome : <?php echo $login_session; ?></b>
                    <form action="index.php" method="post">
                        <input type="submit" value="LOGOUT" class = "w3-button" name = "logout_user">
                    </form>
                    <?php 
                        if(empty($error)){
                        }else{
                            echo $error;
                        }
                        ?>
                </div>
            </strong>
        </section>
        <section id="pageContent">
            <main role="main">
                <article>
                    <h2></h2>
                    <p></p>
                </article>
                <article>
                    <h2></h2>
                    <p></p>
                </article>
                <article>
                    <h2></h2>
                    <p></p>
                </article>
                <article>
                    <h2></h2>
                    <p>
                    </p>
                </article>
            </main>
            <aside>
                <div></div>
                <div></div>
                <div></div>
            </aside>
        </section>
        <footer>
            <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
            <address>
			Contact: <a href="mailto:josepricardo%40su.edu.ph">Mail me</a>
		</address>
        </footer>
    </body>

    </html>