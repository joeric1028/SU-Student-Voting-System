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
            $error = "Already Logouadobet! Please come back soon!";
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
                    <h1>My Voter Profile</h1>
                </article>
                <article>
                    <div class="w3-container w3-center">
                        <?php
                            if(empty($row['picture']))
                            {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="200" height="200" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="200" height="200" class="w3-circle">';
                            }else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="200" height="200" class="w3-circle w3-card-2">';
                        ?>
                        <h2><?php echo $row['fullname'];?></h2>
                    </div>
                    <div class="w3-panel w3-border w3-round-xxlarge">
                        <h1>Basic Information</h1>
                    </div>
                    <p>
                        <div class = "w3-container">
                            <table class="w3-table-all w3-hoverable">
                                <tr>
                                    <td>Current Level :</td>
                                    <td><?php echo $row['yearlevel'];?></td>
                                </tr>
                                <tr>
                                    <td>Gender :</td>
                                    <td><?php echo $row['sex'];?></td>
                                </tr>
                                <tr>
                                    <td>College :</td>
                                    <td><?php echo $row['college'];?></td>
                                </tr>
                                <tr>
                                    <td>Course :</td>
                                    <td><?php echo $row['course'];?></td>
                                </tr>
                            </table>
                        </div>
                        <br>
                    </p>
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
