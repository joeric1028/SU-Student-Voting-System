<?php
    // if ($_SERVER['HTTPS'] != "on") {
    //     $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    //     header("Location: $url");
    //     exit;
    // }
    require_once 'script/session.php'; // Includes Login Script
    $error2 = '';
    $currentyear = strftime("%Y");
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
    $login_college = '';
    if(!isset($_SESSION['login_admin_id'])&&!isset($_SESSION['login_voter_id']))
    {
    }else{
        $login_college = $_SESSION['college'];
    }

?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SU VOTING</title>
        <link rel="shortcut icon" href="../img/vote_logo.png">
        <meta name="description" content="Home Page for Voting Management System.">
        <link rel="stylesheet" href="../css/w3.css">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>

    <header id = "pageContent">
        <div id="logo"><a href="../" style="text-decoration:none"><img src="../img/vote_logo.png">SU VOTING</a></div>
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
    <body>
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
                            if(!empty($error2))echo $error2;
                            if(isset($_SESSION['error3'])) {
                                echo $_SESSION['error3'];
                                unset($_SESSION['error3']);
                            }else unset($_SESSION['error3']);

                        }else if(isset($_SESSION['login_voter_id']))
                        {
                            echo "Voter: ".$row['firstname'].' '.$row['middleinitial'].' '.$row['lastname'].'<form action="index.php" method="post">
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
            <div id="time"></div>
        </section>
        <section>
            <article>
                <h1>Candidates</h1>
                    <?php
                        if(!empty($login_college))echo "($login_college)</h1>";
                        else
                        {
                            echo "</h1><select class='w3-right' onchange='showCandidates(this.value)'><option value=''>Select College</option>";
                            $result = mysqli_query($con, "SELECT * FROM college ORDER BY name;");
                            while($row = mysqli_fetch_assoc($result))
                            {
                                echo "<option value='{$row['idcollege']}'>{$row['name']}</option>";
                            }
                            echo "</select>";
                        }
                    ?>
                <p>For <?php echo $currentyear;?></p>
            </article>
            <article>
                <h2>Governor</h2>
                <p>
                <?php
                    if(!empty($login_college))
                    {
                        echo'<table class="w3-table-all w3-hoverable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                        <th>Year Level</th>
                                        <th class="w3-center">College</th>
                                        <th class="w3-center">Vote Count</th>
                                        <th class="w3-center">Vote Percentage</th>
                                    </tr>
                                </thead>';
                        $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Governor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                        if($result != FALSE)
                        {
                            if(mysqli_num_rows($result) != 0)
                            {
                                while($row = mysqli_fetch_assoc($result))
                                {
                                    $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                    $result3 = mysqli_query($con, "SELECT * FROM vote WHERE governor ='{$row['idnum']}';");
                                    $count = (mysqli_num_rows($result3));
                                    $countall = (mysqli_num_rows($result2));
                                    $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                    $percent = number_format($percent,2);
                                    echo "<tr>
                                            <td>{$row['idnum']}</td>
                                            <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                            <td class ='w3-center'>{$row['yearlevel']}</td>
                                            <td class ='w3-center'>{$row['collegecode']}</td>
                                            <td class='w3-center'>{$count}/{$countall}</td>
                                            <td class='w3-right'>{$percent}%</td>
                                        </tr>\n";
                                }
                                echo "</table>";
                            } else echo "</table>No Candidate Yet";
                        } else echo "</table>Error Retrieving Candidate Data";
                    } else echo "<div id='getgovernor'><b class='w3-container'>Person info will be listed here...</b></div>";
                ?>
            <br>
        </p>
    </article>
    <article>
        <h2>Vice Governor</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Count</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Vice Governor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE vicegovernor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='getvicegovernor'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>Secretary</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Secretary' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE secretary ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='getsecretary'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>Assistant Secretary</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Assistant Secretary' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE assistantsecretary ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='getassistantsecretary'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>Treasurer</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Treasurer' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE treasurer ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='gettreasurer'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>Auditor</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Auditor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE auditor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='getauditor'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>5th Year Mayor</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='5Yr Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 5yrmayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='get5yrmayor'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>5th Year Vice Mayor</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='5Yr Vice Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 5yrvicemayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='get5yrvicemayor'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>4th Year Mayor</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='4Yr Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 4yrmayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='get4yrmayor'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>4th Year Vice Mayor</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='4Yr Vice Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 4yrvicemayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='get4yrvicemayor'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>3rd Year Mayor</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='3Yr Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 3yrmayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='get3yrmayor'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>3rd Year Vice Mayor</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='3Yr Vice Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 3yrvicemayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='get3yrvicemayor'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>2nd Year Mayor</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='2Yr Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 2yrmayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='get2yrmayor'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>2nd Year Vice Mayor</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-cemter">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='2Yr Vice Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 2yrvicemayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='get2yrvicemayor'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>1st Year Mayor</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='1Yr Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 1yrmayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='get1yrmayor'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>1st Year Vice Mayor</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='1Yr Vice Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 1yrvicemayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='get1yrvicemayor'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>Architecture Representative</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Architecture Representative' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE archirep ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='getarchirep'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>Civil Engineeing Representative</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Civil Engineering Representative' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE cerep ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='getcerep'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>Computer Engineering Representative</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Computer Engineering Representative' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE cperep ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='getcperep'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>Electrical Engineering Representative</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Electrical Engineering Representative' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE eerep ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='geteerep'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
    <article>
        <h2>Mechanical Engineering Representative</h2>
        <p>
            <?php
                if(!empty($login_college))
                {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Mechanical Engineering Representative' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE merep ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
                                        <td class='w3-center'>{$count}/{$countall}</td>
                                        <td class='w3-right'>{$percent}%</td>
                                    </tr>\n";
                            }
                            echo "</table>";
                        } else echo "</table>No Candidate Yet";
                    } else echo "</table>Error Retrieving Candidate Data";
                } else echo "<div id='getmerep'><b class='w3-container'>Person info will be listed here...</b></div>";
            ?>
            <br>
        </p>
    </article>
        </section>
    </body>

    <footer>
        <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
        <address>
            Contact: <a href="mailto:josepricardo%40su.edu.ph">Mail Me</a>
		</address>
    </footer><?php mysqli_close($con); // Closing Connection?>
    <script>
        function showCandidates(str)
        {
            var xhttp;
            if (str == "")
            {
                document.getElementById("getgovernor").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("getvicegovernor").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("getsecretary").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("getassistantsecretary").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("gettreasurer").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("getauditor").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("get5yrmayor").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("get5yrvicemayor").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("get4yrmayor").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("get4yrvicemayor").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("get3yrmayor").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("get3yrvicemayor").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("get2yrmayor").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("get2yrvicemayor").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("get1yrmayor").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("get1yrvicemayor").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("getarchirep").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("getcerep").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("getcperep").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("geteerep").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("getmerep").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                return;
            }

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("getgovernor").innerHTML="";
                document.getElementById("getgovernor").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("getgovernor").className="";
                    document.getElementById("getgovernor").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvotegovernor.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("getvicegovernor").innerHTML="";
                document.getElementById("getvicegovernor").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("getvicegovernor").className="";
                    document.getElementById("getvicegovernor").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvotevicegovernor.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("getsecretary").innerHTML="";
                document.getElementById("getsecretary").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("getsecretary").className="";
                    document.getElementById("getsecretary").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvotesecretary.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("getassistantsecretary").innerHTML="";
                document.getElementById("getassistantsecretary").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("getassistantsecretary").className="";
                    document.getElementById("getassistantsecretary").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvoteassistantsecretary.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("gettreasurer").innerHTML="";
                document.getElementById("gettreasurer").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("gettreasurer").className="";
                    document.getElementById("gettreasurer").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvotetreasurer.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("getauditor").innerHTML="";
                document.getElementById("getauditor").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("getauditor").className="";
                    document.getElementById("getauditor").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvoteauditor.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("get5yrmayor").innerHTML="";
                document.getElementById("get5yrmayor").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("get5yrmayor").className="";
                    document.getElementById("get5yrmayor").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvote5yrmayor.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("get5yrvicemayor").innerHTML="";
                document.getElementById("get5yrvicemayor").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("get5yrvicemayor").className="";
                    document.getElementById("get5yrvicemayor").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvote5yrvicemayor.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("get4yrmayor").innerHTML="";
                document.getElementById("get4yrmayor").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("get4yrmayor").className="";
                    document.getElementById("get4yrmayor").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvote4yrmayor.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("get4yrvicemayor").innerHTML="";
                document.getElementById("get4yrvicemayor").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("get4yrvicemayor").className="";
                    document.getElementById("get4yrvicemayor").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvote4yrvicemayor.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("get3yrmayor").innerHTML="";
                document.getElementById("get3yrmayor").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("get3yrmayor").className="";
                    document.getElementById("get3yrmayor").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvote3yrmayor.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("get3yrvicemayor").innerHTML="";
                document.getElementById("get3yrvicemayor").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("get3yrvicemayor").className="";
                    document.getElementById("get3yrvicemayor").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvote3yrvicemayor.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("get2yrmayor").innerHTML="";
                document.getElementById("get2yrmayor").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("get2yrmayor").className="";
                    document.getElementById("get2yrmayor").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvote2yrmayor.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("get2yrvicemayor").innerHTML="";
                document.getElementById("get2yrvicemayor").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("get2yrvicemayor").className="";
                    document.getElementById("get2yrvicemayor").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvote2yrvicemayor.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("get1yrmayor").innerHTML="";
                document.getElementById("get1yrmayor").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("get1yrmayor").className="";
                    document.getElementById("get1yrmayor").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvote1yrmayor.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("get1yrvicemayor").innerHTML="";
                document.getElementById("get1yrvicemayor").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("get1yrvicemayor").className="";
                    document.getElementById("get1yrvicemayor").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvote1yrvicemayor.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("getarchirep").innerHTML="";
                document.getElementById("getarchirep").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("getarchirep").className="";
                    document.getElementById("getarchirep").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvotearchirep.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("getcerep").innerHTML="";
                document.getElementById("getcerep").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("getcerep").className="";
                    document.getElementById("getcerep").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvotecerep.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("getcperep").innerHTML="";
                document.getElementById("getcperep").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("getcperep").className="";
                    document.getElementById("getcperep").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvotecperep.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("geteerep").innerHTML="";
                document.getElementById("geteerep").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("geteerep").className="";
                    document.getElementById("geteerep").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvoteeerep.php?q="+str, true);
            xhttp.send();

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                document.getElementById("getmerep").innerHTML="";
                document.getElementById("getmerep").className="loader";
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("getmerep").className="";
                    document.getElementById("getmerep").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvotemerep.php?q="+str, true);
            xhttp.send();
        }
        myTimer();
        setInterval(myTimer, 1000);

        function myTimer()
        {
            var d = new Date();
            document.getElementById("time").innerHTML = d.toLocaleTimeString();
        }
    </script>
</html>
