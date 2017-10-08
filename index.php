<?php
    require 'script/session.php'; // Includes Login Script
    $error = 'No Candidate Yet';
    $error2 = '';
    $currentyear = strftime("%Y");
    if(isset($_POST['logout_user']))
    {
        if(session_destroy()) // Destroying All Sessions
        {
            $error2 = "Successfully Logout! Please come back soon!";
            header('Refresh: 1; URL=../');
        }else{
            $error2 = "Already Logouadobet! Please come back soon!";
            header('Refresh: 1; URL=../');
        }
    }
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
    <body>
        <section>
            <strong>
                <div id="profile">
                    <b id="welcome">Welcome
                    <?php 
                        if(isset($_SESSION['login_admin_id']))
                        {
                            echo "Admin: ".$row['fullname'].'<form action="index.php" method="post">
                            <input type="submit" value="LOGOUT" class = "w3-button" name = "logout_user">
                            </form>'; 
                            if(empty($error2)){
                            }else{
                                echo $error2;
                            }
                            
                        }else if(isset($_SESSION['login_voter_id']))
                        {
                            echo "Voter: ".$row['fullname'].'<form action="index.php" method="post">
                            <input type="submit" value="LOGOUT" class = "w3-button" name = "logout_user">
                            </form>'; 
                            if(empty($error2)){
                            }else{
                                echo $error2;
                            }
                            if(isset($_SESSION['error3'])){
                                echo $_SESSION['error3'];
                                unset($_SESSION['error3']);
                            }else{
                                unset($_SESSION['error3']);
                            }
                        }else{
                            echo "Guest:";
                        }
                    ?>
                    </b>
                </div>
            </strong>
        </section>
        <section>
            <article>
                <h1>Candidates</h1>
                <p>For <?php echo $currentyear;?></p>  
            </article>
            <article>
                <h2>Governor</h2>
                <p>
                    <table class="w3-table-all w3-hoverable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class = 'w3-center' style="min-width: 20px; max-width: 30px;">Name</th>
                                <th>Year Level</th>
                                <th class='w3-center'>College</th>
                                <th class='w3-right'>Vote Count</th>
                            </tr>
                        </thead>
                <?php
                    $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Governor' AND candidateyear ='$currentyear';");
                    if($result != true  ){
                        while($row = mysqli_fetch_assoc($result))
                        {
                            $governor = $row['idnum'];
                            $college = $row['college'];
                            $result2 = mysqli_query($con, "SELECT * FROM listofstudents WHERE college ='$college';");
                            $result3 = mysqli_query($con, "SELECT * FROM votedetails WHERE governor ='$governor';");
                            $row2 = mysqli_num_rows($result2);
                            $row3 = mysqli_num_rows($result3);
                            $percent = $row3/$row2;
                            echo "<tr>
                            <td>{$row['idnum']}</td>
                            <td>{$row['fullname']}</td>
                            <td class ='w3-center'>{$row['yearlevel']}</td>
                            <td class ='w3-center'>{$row['collegecode']}</td>
                            <td class='w3-right'>{$percent}%</td>
                            </tr>\n";
                        }
                    }else{
                        echo "</table>$error";
                    }
                ?>
            </table>
            <br>
        </p>
    </article>
    <article>
    <h2>Vice Governor</h2>
    <p>
        <table class="w3-table-all w3-hoverable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class='w3-center' style="min-width: 20px; max-width: 30px;">Name</th>
                    <th>Year Level</th>
                    <th class='w3-center'>College</th>
                    <th class='w3-right'>Vote Count</th>
                </tr>
            </thead>
            <?php
                $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Vice Governor' AND candidateyear ='$currentyear';");
                if($result != true){
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $vicegovernor = $row['idnum'];
                        $college = $row['college'];
                        $result2 = mysqli_query($con, "SELECT * FROM listofstudents WHERE college ='$college';");
                        $result3 = mysqli_query($con, "SELECT * FROM votedetails WHERE governor ='$vicegovernor';");
                        $row2 = mysqli_num_rows($result2);
                        $row3 = mysqli_num_rows($result3);
                        $percent = $row3/$row2;
                        echo "<tr>
                        <td>{$row['idnum']}</td>
                        <td>{$row['fullname']}</td>
                        <td class ='w3-center'>{$row['yearlevel']}</td>
                        <td class ='w3-center'>{$row['collegecode']}</td>
                        <td class ='w3-right'>{$percent}%</td>
                        </tr>\n";
                    }
                }else{
                    echo "</table>$error";
                }
            ?>
        </table>
        <br>
    </p>
</article>
        </section>
    </body>
    
    <footer>
        <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
        <address>
            Contact: <a href="mailto:josepricardo%40su.edu.ph">Mail me</a>
		</address>
    </footer> 
</html>