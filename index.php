<?php
    require_once 'script/session.php';
    $error2 = '';
    $currentyear = strftime("%Y");
    if (isset($_POST['logout_user'])) {
        if (session_destroy()) $error2 = "Successfully Logout! Please come back soon!";
        else $error2 = "Already Logout! Please come back soon!";
        header('Refresh: 1; URL=../');
    }
    if (!isset($_SESSION['login_admin_id']) && !isset($_SESSION['login_voter_id'])) $login_college = '';
    else $login_college = $_SESSION['college'];
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
            <nav><ul>
                    <?php
                        if(isset($_SESSION['login_admin_id'])) echo "<li><a href='../candidate'>CANDIDATE</a></li>
                                                                <li><a href='../student'>STUDENT</a></li>
                                                                <li><a href='../profile'>MY PROFILE</a></li>
                                                                <li><a href='../register'>REGISTER</a></li>";
                        else if(isset($_SESSION['login_voter_id'])) echo '<li><a href="../vote">VOTE</a></li>
                                    <li><a href="../voterprofile">MY PROFILE</a></li>';
                        else echo '<li><a href="../voter">VOTER</a></li>
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
                        if(isset($_SESSION['login_admin_id'])) {
                            echo "Admin: ".$row['firstname'].' '.$row['middleinitial'].' '.$row['lastname'].'<form action="index.php" method="post">
                                <input type="submit" value="LOGOUT" class = "w3-button" name = "logout_user"></form>';
                            if (!empty($error2)) echo $error2;
                            if (isset($_SESSION['error3'])) echo $_SESSION['error3'];
                            unset($_SESSION['error3']);
                        } else if(isset($_SESSION['login_voter_id'])) {
                            echo "Voter: ".$row['firstname'].' '.$row['middleinitial'].' '.$row['lastname'].'<form action="index.php" method="post">
                            <input type="submit" value="LOGOUT" class = "w3-button" name = "logout_user">
                            </form>';
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
                        if (!empty($login_college)) echo "($login_college)</h1>";
                        else {
                            echo "</h1><select class='w3-right' onchange='showCandidates(this.value)'><option value=''>Select College</option>";
                            $result = mysqli_query($con, "SELECT * FROM college ORDER BY name;");
                            while ($row = mysqli_fetch_assoc($result)) echo "<option value='{$row['idcollege']}'>{$row['name']}</option>";
                            echo "</select>";
                        }
                    ?>
                <p>For <?php echo $currentyear;?></p>
            </article>
            <article>
                <h2 class = "w3-center">Governor</h2>
                <p>
                <?php
                    if (!empty($login_college)) {
                        echo'<table class="w3-table-all w3-hoverable">
                                <thead>
                                    <tr><th></th><th>ID</th>
                                        <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                        <th>Year Level</th>
                                        <th class="w3-center">College</th>
                                        <th class="w3-center">Vote Count</th>
                                        <th class="w3-center">Vote Percentage</th>
                                    </tr>
                                </thead>';
                        $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Governor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                        if ($result != FALSE) {
                            if (mysqli_num_rows($result) != 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND admintype = 'Student';");
                                    $result3 = mysqli_query($con, "SELECT * FROM vote WHERE governor ='{$row['idnum']}';");
                                    $count = (mysqli_num_rows($result3));
                                    $countall = (mysqli_num_rows($result2));
                                    $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                    $percent = number_format($percent,2);
                                    echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
                            </tr>\n";
                                }
                                echo "</table>";
                            } else echo "</table>No Candidate Yet";
                        } else echo "</table>Error Retrieving Candidate Data";
                    } else echo "<div id='getgovernor'><b class='w3-container'>Person info will be listed here...</b></div>";
                ?><br>
        </p>
    </article>
    <article>
        <h2 class = "w3-center">Vice Governor</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Count</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Vice Governor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND admintype = 'Student';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE vicegovernor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">Secretary</h2>
        <p>
            <?php
                if(!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Secretary' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND admintype = 'Student';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE secretary ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">Assistant Secretary</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Assistant Secretary' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND admintype = 'Student';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE assistantsecretary ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">Treasurer</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Treasurer' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND admintype = 'Student';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE treasurer ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">Auditor</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Auditor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND admintype = 'Student';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE auditor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">5th Year Mayor</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='5Yr Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND yearlevel = '5' AND admintype = 'Student';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 5yrmayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">5th Year Vice Mayor</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='5Yr Vice Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND yearlevel = '5' AND admintype = 'Student';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 5yrvicemayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">4th Year Mayor</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='4Yr Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND yearlevel = '4' AND admintype = 'Student';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 4yrmayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">4th Year Vice Mayor</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='4Yr Vice Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND yearlevel = '4' AND admintype = 'Student';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 4yrvicemayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">3rd Year Mayor</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='3Yr Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND yearlevel = '3' AND admintype = 'Student';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 3yrmayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">3rd Year Vice Mayor</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='3Yr Vice Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND yearlevel = '3' AND admintype = 'Student';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 3yrvicemayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">2nd Year Mayor</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='2Yr Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND yearlevel = '2' AND admintype = 'Student';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 2yrmayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">2nd Year Vice Mayor</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-cemter">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='2Yr Vice Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND yearlevel = '2' AND admintype = 'Student';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 2yrvicemayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">1st Year Mayor</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='1Yr Mayor' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND yearlevel = '1' AND admintype = 'Student';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 1yrmayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">1st Year Vice Mayor</h2>
        <p>
            <?php
                if (!empty($login_college)) {
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
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND yearlevel = '1' AND admintype = 'Student';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE 1yrvicemayor ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">Architecture Representative</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Architecture Representative' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND course.name = 'Bachelor of Science in Architecture';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE archirep ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">Civil Engineeing Representative</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Civil Engineering Representative' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND course.name = 'Bachelor of Science in Civil Engineering';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE cerep ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">Computer Engineering Representative</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Computer Engineering Representative' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND course.name = 'Bachelor of Science in Computer Engineering';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE cperep ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">Electrical Engineering Representative</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Electrical Engineering Representative' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND course.name = 'Bachelor of Science in Computer Engineering';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE eerep ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        <h2 class = "w3-center">Mechanical Engineering Representative</h2>
        <p>
            <?php
                if (!empty($login_college)) {
                    echo'<table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr><th></th>
                                    <th>ID</th>
                                    <th class = "w3-center" style="min-width: 20px; max-width: 30px;">Name</th>
                                    <th>Year Level</th>
                                    <th class="w3-center">College</th>
                                    <th class="w3-center">Vote Count</th>
                                    <th class="w3-center">Vote Percentage</th>
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Mechanical Engineering Representative' AND college.name ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if ($result != FALSE) {
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND course.name = 'Bachelor of Science in Mechanical Engineering';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE merep ='{$row['idnum']}';");
                                $count = (mysqli_num_rows($result3));
                                $countall = (mysqli_num_rows($result2));
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
        myTimer();
        setInterval(myTimer, 1000);
        
        function showCandidatesTable(Id, str) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                document.getElementById("get" + Id).innerHTML = "";
                document.getElementById("get" + Id).className = "loader";
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("get"  + Id).className = "";
                    document.getElementById("get"  + Id).innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "../script/getvote" + Id + ".php?q="+ str, true);
            xhttp.send();
        }

        function showCandidates(str) {
            var i, get = ["governor", "vicegovernor", "secretary", "assistantsecretary", "treasurer",
            "auditor", "5yrmayor", "5yrvicemayor", "4yrmayor", "4yrvicemayor", "3yrmayor",
            "3yrvicemayor", "2yrmayor", "2yrvicemayor", "1yrmayor", "1yrvicemayor", "archirep",
            "cerep", "cperep", "eerep", "merep"];
            if (str == "") {
                for (i = 0; i < get.length; i++)
                    document.getElementById("get" + get[i]).innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                return;
            }
            for (i = 0; i < get.length; i++) showCandidatesTable(get[i], str);
        }

        function myTimer() {
            var d = new Date();
            document.getElementById("time").innerHTML = d.toLocaleTimeString();
        }
    </script>
</html>
