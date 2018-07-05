<?php
    require_once '../script/session.php';
    if (isset($_SESSION['login_voter_id'])) {
        $_SESSION['error3'] = "Not Allowed!";
        header('location:../');
    } else if(!isset($_SESSION['login_admin_id'])) {
        $_SESSION['Error'] = "Please Login First!";
        header('location: ../admin');
    }
    if (isset($_POST['logout_user'])) {
        if (session_destroy()) $error2 = "Successfully Logout! Please come back soon!";
        else $error2 = "Already Logout! Please come back soon!";
        header('Refresh: 1; URL=../');
    }
    $currentyear = strftime("%Y");
    $pdo = Database::connect();
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
                    if (isset($_SESSION['login_admin_id'])) echo "<li><a href='../candidate'>CANDIDATE</a></li>
                                                            <li><a href='../student'>STUDENT</a></li>
                                                            <li><a href='../profile'>MY PROFILE</a></li>
                                                            <li><a href='../register'>REGISTER</a></li>";
                    else if (isset($_SESSION['login_voter_id'])) {
                        echo '<li><a href="../vote">VOTE</a></li>
                            <li><a href="../voterprofile">MY PROFILE</a></li>';
                    } else echo '<li><a href="../voter">VOTER</a></li>
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
            if (isset($_SESSION['login_admin_id'])) {
                echo "Admin: ".$row['firstname'].' '.$row['middleinitial'].' '.$row['lastname'].'
                <button class="w3-button" onclick="logout()">LOGOUT</button>
                                <div id="logoutsuccess"></div>';
                if (!empty($error2)) echo $error2;
            } else if (isset($_SESSION['login_voter_id'])) {
                echo "Voter: ".$row['firstname'].' '.$row['middleinitial'].' '.$row['lastname'].'
                <button class="w3-button" onclick="logout()">LOGOUT</button>
                                <div id="logoutsuccess"></div>';
                if (!empty($error2)) echo $error2;
            } else echo "Guest:";
        ?>
        </b>
    </div>
</strong>
    <div id="time"></div>
</section>
        <section id="pageContent">
            <main role="main">
                <article><h1>Candidates</h1></article>
                <article>
                    <h2>Governor</h2>
                    <div id='getgovernor'></div>
                </article>
                <article>
                    <h2>Vice Governor</h2>
                    <div id='getvicegovernor'></div>
                </article>
                <article>
                    <h2>Secretary</h2>
                    <div id='getsecretary'></div>
                </article>
                <article>
                    <h2>Assistant Secretary</h2>
                    <div id='getassistansecretary'></div>
                </article>
                <article>
                    <h2>Treasurer</h2>
                    <div id='gettreasurer'></div>
                </article>
                <article>
                    <h2>Auditor</h2>
                    <div id='getauditor'></div>
                </article>
                <article>
                    <h2>5th Year Mayor</h2>
                    <div id='getmayor5yr'></div>
                </article>
                <article>
                    <h2>5th Year Vice Mayor</h2>
                    <div id='getvicemayor5yr'></div>
                </article>
                <article>
                    <h2>4th Year Mayor</h2>
                    <div id='getmayor4yr'></div>
                </article>
                <article>
                    <h2>4th Year Vice Mayor</h2>
                    <div id='getvicemayor4yr'></div>
                </article>
                <article>
                    <h2>3rd Year Mayor</h2>
                    <div id='getmayor3yr'></div>
                </article>
                <article>
                    <h2>3rd Year Vice Mayor</h2>
                    <div id='getvicemayor3yr'></div>
                </article>
                <article>
                    <h2>2nd Year Mayor</h2>
                    <div id='getmayor2yr'></div>
                </article>
                <article>
                    <h2>2nd Year Vice Mayor</h2>
                    <div id='getvicemayor2yr'></div>
                </article>
                <article>
                    <h2>1st Year Mayor</h2>
                    <div id='getmayor1yr'></div>
                </article>
                <article>
                    <h2>1st Year Vice Mayor</h2>
                    <div id='getvicemayor1yr'></div>
                </article>
                <article>
                    <h2>Architecture Representative</h2>
                    <div id='getarchirep'></div>
                </article>
                <article>
                    <h2>Civil Engineering Representative</h2>
                    <div id='getcerep'></div>
                </article>
                <article>
                    <h2>Computer Engineering Representative</h2>
                    <div id='getcperep'></div>
                </article>
                <article>
                    <h2>Electrical Engineering Representative</h2>
                    <div id='geteerep'></div>
                </article>
                <article>
                    <h2>Mechanical Engineering Representative</h2>
                    <div id='getmerep'></div>
                </article>
            </main>
            <aside>
                <div><img src="../img/vote_logo.png" class="w3-container w3-circle" style ="width:50%"></div>
                <!-- <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div> -->
            </aside>
        </section>
    </body>
    <footer>
        <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
        <address>Contact: <a href="mailto:josepricardo%40su.edu.ph">Mail me</a></address>
    </footer>
    <script type="text/javascript" src="../script/common.js"></script>
    <script>
        setInterval(myTimer, 1000);
        showCollegeCandidates(<?php echo $_SESSION['idcollege']?>);
    </script>
    <?php Database::disconnect(); ?>
</html>
