<?php
    if ($_SERVER['HTTPS'] != "on") {
        $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        header("Location: $url");
        exit;
    }
    require_once '../script/session.php';
    require_once '../script/vote.php';
    $error2 = '';
    if (isset($_POST['logout_user'])) {
        if (session_destroy()) $error2 = "Successfully Logout! Please come back soon!";
        else $error2 = "Already Logout! Please come back soon!";
        header('Refresh: 1; URL=../');
    } else {
        if (!isset($_SESSION['login_voter_id'])) {
            $_SESSION['Error'] = "Please Login First!";
            header('location: ../voter');
        }
        $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
        if (mysqli_num_rows($result1) != 0) $_SESSION['error3'] ="Already voted!";
        if (isset($_SESSION['login_admin_id'])) {
            $_SESSION['error3'] = "Not Allowed!";
            header('location: ../?');
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
        <link href="../css/w3.css" rel="stylesheet" type="text/css">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>
    <body>
    <header id = "pageContent">
    <div id="logo"><a href="../" style="text-decoration:none"><img src="../img/vote_logo.png">SU VOTING</a></div>
        <nav><ul>
                <?php
                    if (isset($_SESSION['login_admin_id'])) echo "<li><a href='../candidate'>CANDIDATE</a></li>
                                                            <li><a href='../student'>STUDENT</a></li>
                                                            <li><a href='../profile'>MY PROFILE</a></li>";
                    else if (isset($_SESSION['login_voter_id']))
                        echo '<li><a href="../vote">VOTE</a></li>
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
                            echo "Admin: ".$row['firstname'].' '.$row['middleinitial'].' '.$row['lastname'].'<form action="index.php" method="post">
                            <input type="submit" value="LOGOUT" class = "w3-button" name = "logout_user">
                            </form>';
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
                    ?></b>
                </div>
            </strong>
        </section>
        <section>
                <form class="w3-container" method="post" action="index.php">
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>Governor:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                    <?php
                                        $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                        if (mysqli_num_rows($result1) == 0) {
                                            $row1 = mysqli_fetch_assoc($result1);
                                            $_SESSION['voterid'] = $row1['iduser'];
                                            $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Governor' AND candidateyear='$currentyear';");
                                            if (mysqli_num_rows($result) != 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="governor" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                            } else $_SESSION['error3'] = "Voting Session is not yet started";
                                        } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>Vice Governor:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Vice Governor' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="vicegovernor" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                            }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>Secretary:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Secretary' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="secretary" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                            }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>Assistant Secretary:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Assistant Secretary' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE){
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="assistantsecretary" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>Treasurer:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Treasurer' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="treasurer" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>Auditor:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Auditor' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="auditor" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>5th Yr Mayor:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='5Yr Mayor' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="5mayor" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>5th Yr Vice Mayor:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='5Yr Vice Mayor' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="5vicemayor" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>4th Yr Mayor:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if(mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='4Yr Mayor' AND candidateyear='$currentyear';");
                                        if( mysqli_num_rows($result) != FALSE){
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="4mayor" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>4th Yr Vice Mayor:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if(mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='4Yr Vice Mayor' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="4vicemayor" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>3rd Yr Mayor:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='3Yr Mayor' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="3mayor" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>3rd Yr Vice Mayor:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='3Yr Vice Mayor' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="3vicemayor" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>2nd Yr Mayor:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='2Yr Mayor' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="2mayor" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>2nd Yr Vice Mayor:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='2Yr Vice Mayor' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="2vicemayor" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>1st Yr Mayor:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='1Yr Mayor' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="1mayor" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>1st Yr Vice Mayor:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='1Yr Vice Mayor' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="1vicemayor" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>Architecture Representative:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Architecture Representative' AND candidateyear='$currentyear';");
                                    if (mysqli_num_rows($result) != FALSE) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="archirep" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                    } else $_SESSION['error3'] = "Voting Session is not yet started";
                                } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>Civil Engineering Representative:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Civil Engineering Representative' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="cerep" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>Computer Engineering Representative:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if(mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Computer Engineering Representative' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="cperep" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>Electrical Engineering Representative:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Electrical Engineering Representative' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="eerep" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        }else $_SESSION['error3'] = "Voting Session is not yet started";
                                    }else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article>
                        <div class="w3-container">
                            <div class="w3-container">
                                <h1>Mechanical Engineering Representative:</h1>
                                <div class="w3-container w3-center w3-padding-16">
                                <?php
                                    $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                                    if (mysqli_num_rows($result1) == 0) {
                                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Mechanical Engineering Representative' AND candidateyear='$currentyear';");
                                        if (mysqli_num_rows($result) != FALSE) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<div class="w3-container w3-left">';
                                                    if (empty($row['picture'])) {
                                                        if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                                        else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                                                    } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                                                    echo '<br><br><input name="merep" type="radio" value="'.$row['idnum'].'" required><label>&nbsp'.$row['fullname'].'</label></div>';
                                                }
                                        } else $_SESSION['error3'] = "Voting Session is not yet started";
                                    } else $_SESSION['error3'] = "Error retrieving Candidate Data";
                                ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php
                        $result1 = mysqli_query($con,"SELECT * FROM user INNER JOIN vote ON user.idnum = vote.idnum WHERE voted ='Yes' AND vote.idnum='{$_SESSION['login_voter_id']}';");
                        if (mysqli_num_rows($result1) == 0) echo '<input class="w3-container w3-button w3-round-xxlarge w3-blue" name="voteSubmit" type="submit" value="Submit">';
                        else $_SESSION['error3'] = "Error retrieving Candidate Data";
                    ?>
                </form>
        </section>
    </body>
        <footer>
            <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
            <address>
            Contact: <a href="mailto:josepricardo%40su.edu.ph">Mail Me</a>
		</address>
        </footer>
        <?php mysqli_close($con); // Closing Connection?>
</html>
