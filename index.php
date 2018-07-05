<?php
    if ($_SERVER['HTTPS'] != "on") {
        $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        header("Location: $url");
        exit;
    }
    require_once 'script/session.php';
    $error2 = '';
    $currentyear = strftime("%Y");
    if (!isset($_SESSION['login_admin_id']) && !isset($_SESSION['login_voter_id'])) $login_college = '';
    else $login_college = $_SESSION['college'];
    $pdo = Database::connect();
?>
<!DOCTYPE html>
<html lang="en-PH">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SU VOTING</title>
        <link href="../img/vote_logo.png" type="image/png" rel="shortcut icon">
        <meta name="description" content="Home Page for Voting Management System.">
        <link rel="stylesheet" href="../css/w3.css">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>
    <header id = "pageContent">
        <div id="logo"><a href="../" style="text-decoration:none"><img src="../img/vote_logo.png">SU VOTING</a></div>
            <nav><ul>
                    <?php
                        if (isset($_SESSION['login_admin_id'])) echo "<li><a href='../candidate'>CANDIDATE</a></li>
                                                                <li><a href='../student'>STUDENT</a></li>
                                                                <li><a href='../profile'>MY PROFILE</a></li>
                                                                <li><a href='../register'>REGISTER</a></li>";
                        else if (isset($_SESSION['login_voter_id'])) echo '<li><a href="../vote">VOTE</a></li>
                                    <li><a href="../voterprofile">MY PROFILE</a></li>';
                        else echo '<li><a href="../voter">VOTER</a></li>
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
                            if (isset($_SESSION['error3'])) echo $_SESSION['error3'];
                            unset($_SESSION['error3']);
                        } else if (isset($_SESSION['login_voter_id'])) {
                            echo "Voter: ".$row['firstname'].' '.$row['middleinitial'].' '.$row['lastname'].'
                                <button class="w3-button" onclick="logout()">LOGOUT</button>
                                <div id="logoutsuccess"></div>';
                            if (!empty($error2)) echo $error2;
                            if (isset($_SESSION['error3'])) echo $_SESSION['error3'];
                            unset($_SESSION['error3']);
                        } else echo "Guest:";
                    ?>
                    </b>
                </div>
            </strong>
            <div id="time"></div>
        </section>
        <section>
            <article>
                <h1>Candidates</h1>
                    <?php
                        if (!empty($login_college)) echo "($login_college)";
                        else {
                            echo "<select class='w3-right' onchange='showCandidates(this.value)'><option value=''>Select College</option>";
                            $sql = "SELECT idcollege, name FROM college ORDER BY name;";
                            foreach ($pdo->query($sql) as $row) echo "<option value='{$row['idcollege']}'>{$row['name']}</option>";
                            echo "</select>";
                        }
                    ?>
                <p>For <?php echo $currentyear;?></p>
            </article>
            <article>
                <h2 class = "w3-center">Governor</h2>
                <div class="w3-container w3-responsive">
                    <?php
                        if (!empty($login_college)) echo "<div id='getgovernor'></div>";
                        else echo "<div id='getgovernor'><b class='w3-container'>Person info will be listed here...</b></div>";
                    ?>
                </div><br>
            </article>
            <article>
                <h2 class = "w3-center">Vice Governor</h2>
                <div class="w3-container w3-responsive">
                    <?php
                        if (!empty($login_college)) echo "<div id='getvicegovernor'></div>";
                        else echo "<div id='getvicegovernor'><b class='w3-container'>Person info will be listed here...</b></div>";
                    ?>
                </div><br>
            </article>
            <article>
                <h2 class = "w3-center">Secretary</h2>
                <div class="w3-container w3-responsive">
                <?php
                    if(!empty($login_college)) echo "<div id='getsecretary'></div>";
                    else echo "<div id='getsecretary'><b class='w3-container'>Person info will be listed here...</b></div>";
                ?>
                </div><br>
            </article>
            <article>
                <h2 class = "w3-center">Assistant Secretary</h2>
                <div class="w3-container w3-responsive">
                <?php
                    if (!empty($login_college)) echo "<div id='getassistantsecretary'></div>";
                    else echo "<div id='getassistantsecretary'><b class='w3-container'>Person info will be listed here...</b></div>";
                ?>
                </div><br>
            </article>
            <article>
                <h2 class = "w3-center">Treasurer</h2>
                <div class="w3-container w3-responsive">
                    <?php
                        if (!empty($login_college)) {
                            echo "<div id='gettreasurer'></div>";
                        } else echo "<div id='gettreasurer'><b class='w3-container'>Person info will be listed here...</b></div>";
                    ?>
                    </div><br>
            </article>
            <article>
                <h2 class = "w3-center">Auditor</h2>
                <div class="w3-container w3-responsive">
                    <?php
                        if (!empty($login_college)) {
                            echo "<div id='getauditor'></div>";
                        } else echo "<div id='getauditor'><b class='w3-container'>Person info will be listed here...</b></div>";
                    ?>
                    </div><br>
            </article>
            <article>
                <h2 class = "w3-center">5th Year Mayor</h2>
                <div class="w3-container w3-responsive">
                <?php
                    if (!empty($login_college)) {
                        echo "<div id='getmayor5yr'></div>";
                    } else echo "<div id='getmayor5yr'><b class='w3-container'>Person info will be listed here...</b></div>";
                ?>
                </div><br>
    </article>
    <article>
        <h2 class = "w3-center">5th Year Vice Mayor</h2>
                <div class="w3-container w3-responsive">
            <?php
                if (!empty($login_college)) {
                    echo "<div id='getvicemayor5yr'></div>";
                } else echo "<div id='getvicemayor5yr'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
                </div><br>
    </article>
    <article>
        <h2 class = "w3-center">4th Year Mayor</h2>
                <div class="w3-container w3-responsive">
            <?php
                if (!empty($login_college)) {
                    echo "<div id='getmayor4yr'></div>";
                } else echo "<div id='getmayor4yr'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            </div><br>
    </article>
    <article>
        <h2 class = "w3-center">4th Year Vice Mayor</h2>
                <div class="w3-container w3-responsive">
            <?php
                if (!empty($login_college)) {
                    echo "<div id='getvicemayor4yr'></div>";
                } else echo "<div id='getvicemayor4yr'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
           </div><br>
    </article>
    <article>
        <h2 class = "w3-center">3rd Year Mayor</h2>
                <div class="w3-container w3-responsive">
            <?php
                if (!empty($login_college)) {
                    echo "<div id='getmayor3yr'></div>";
                } else echo "<div id='getmayor3yr'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            </div><br>
    </article>
    <article>
        <h2 class = "w3-center">3rd Year Vice Mayor</h2>
        <div class="w3-container w3-responsive">
            <?php
                if (!empty($login_college)) {
                    echo "<div id='getvicemayor3yr'></div>";
                } else echo "<div id='getvicemayor3yr'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            </div><br>
    </article>
    <article>
        <h2 class = "w3-center">2nd Year Mayor</h2>
        <div class="w3-container w3-responsive">
            <?php
                if (!empty($login_college)) {
                    echo "<div id='getmayor2yr'></div>";
                } else echo "<div id='getmayor2yr'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            </div><br>
    </article>
    <article>
        <h2 class = "w3-center">2nd Year Vice Mayor</h2>
        <div class="w3-container w3-responsive">
            <?php
                if (!empty($login_college)) {
                    echo "<div id='getvicemayor2yr'></div>";
                } else echo "<div id='getvicemayor2yr'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            </div><br>
    </article>
    <article>
        <h2 class = "w3-center">1st Year Mayor</h2>
        <div class="w3-container w3-responsive">
            <?php
                if (!empty($login_college)) {
                    echo "<div id='getmayor1yr'></div>";
                } else echo "<div id='getmayor1yr'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            </div><br>
    </article>
    <article>
        <h2 class = "w3-center">1st Year Vice Mayor</h2>
        <div class="w3-container w3-responsive">
            <?php
                if (!empty($login_college)) {
                    echo "<div id='getvicemayor1yr'></div>";
                } else echo "<div id='getvicemayor1yr'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            </div><br>
    </article>
    <article>
        <h2 class = "w3-center">Architecture Representative</h2>
        <div class="w3-container w3-responsive">
            <?php
                if (!empty($login_college)) {
                    echo "<div id='getarchirep'></div>";
                } else echo "<div id='getarchirep'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            </div><br>
    </article>
    <article>
        <h2 class = "w3-center">Civil Engineeing Representative</h2>
        <div class="w3-container w3-responsive">
            <?php
                if (!empty($login_college)) {
                    echo "<div id='getcerep'></div>"; 
                } else echo "<div id='getcerep'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            </div><br>
    </article>
    <article>
        <h2 class = "w3-center">Computer Engineering Representative</h2>
        <div class="w3-container w3-responsive">
            <?php
                if (!empty($login_college)) {
                    echo "<div id='getcperep'></div>";
                } else echo "<div id='getcperep'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            </div><br>
    </article>
    <article>
        <h2 class = "w3-center">Electrical Engineering Representative</h2>
        <div class="w3-container w3-responsive">
            <?php
                if (!empty($login_college)) echo "<div id='geteerep'></div>";
                else echo "<div id='geteerep'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            </div><br>
    </article>
    <article>
        <h2 class = "w3-center">Mechanical Engineering Representative</h2>
        <div class="w3-container w3-responsive">
            <?php
                if (!empty($login_college)) echo "<div id='getmerep'></div>";
                else echo "<div id='getmerep'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            </div><br>
    </article>
        </section>
        <footer>
        <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
        <address>Contact: <a href="mailto:josepricardo%40su.edu.ph">Mail Me</a></address>
    </footer>
    <script type="text/javascript" src="../script/common.js"></script>
    <script>
        setInterval(myTimer, 1000);
        <?php if (!empty($login_college)) echo "showCandidates({$_SESSION['idcollege']});";?>
    </script>
    <?php Database::disconnect(); ?>
</html>
