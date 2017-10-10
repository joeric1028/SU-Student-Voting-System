<?php
    require '../script/session.php'; // Includes Login Script
    $result = mysqli_query($con,"SELECT * FROM listofstudents;");
    if(isset($_SESSION['login_voter_id']))
    {
        $_SESSION['error3'] = "Not Allowed!";
        header('location:../');
    }else if(!isset($_SESSION['login_admin_id']))
    {
        $_SESSION['Error'] = "Please Login First!";
        header('location: ../admin');
    }
    if(isset($_POST['logout_user']))
    {
        if(session_destroy()) // Destroying All Sessions
        {
            $error2 = "Successfully Logout! Please come back soon!";
            header('Refresh: 1; URL=../');
        }else{
            $error2 = "Already Logout! Please come back soon!";
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
        <link rel="icon" href="../img/vote_logo.png">
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
                    if(isset($_SESSION['login_admin_id']))echo "<li><a href='../candidate'>CANDIDATE</a></li>
                                                            <li><a href='../student'>STUDENT</a></li>
                                                            <li><a href='../profile'>MY PROFILE</a></li>
                                                            <li><a href='../register'>REGISTER</a></li>";
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
            }else{
                echo "Guest:";
            }
        ?>
        </b>
    </div>
</strong>
</section>
        <section id="pageContent">
                <article>
                    <h1>List of Students</h1>
                    <h4 class=w3-container><br>
                    <?php
                        $ro = mysqli_num_rows($result);
                        echo "Number of Students: $ro";
                    ?>
                    </h4>
                </article>
                <article>
                    <p>
                    <table class="w3-table-all w3-hoverable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Year Level</th>
                                <th>College</th>
                                <th>Course</th>
                            </tr>
                      </thead>
                        <?php
                            if(mysqli_num_rows($result) != 0){
                                while($row = mysqli_fetch_assoc($result))
                                {
                                    echo "<tr>
                                    <td>{$row['idnum']}</td>
                                    <td>{$row['fullname']}</td>
                                    <td>{$row['yearlevel']}</td>
                                    <td>{$row['collegecode']}</td>
                                    <td>{$row['course']}</td>
                                    </tr>\n";
                                }
                            }
                        ?>
                        </table>
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
        <?php mysqli_close($con); // Closing Connection?> 
</html>