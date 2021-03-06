<?php
    if ($_SERVER['HTTPS'] != "on") {
        $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        header("Location: $url");
        exit;
    }
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
                            echo "Admin: ".$row['fullname'].'<form action="index.php" method="post">
                            <input type="submit" value="LOGOUT" class = "w3-button" name = "logout_user">
                            </form>'; 
                            if(!empty($error2))echo $error2;
                            if(isset($_SESSION['error3'])) {
                                echo $_SESSION['error3'];
                            }else unset($_SESSION['error3']);
                            
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
                                    </tr>
                                </thead>';
                        $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Governor' AND college ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                        if($result != FALSE)
                        {
                            if(mysqli_num_rows($result) != 0)
                            {
                                while($row = mysqli_fetch_assoc($result))
                                {
                                    $result2 = mysqli_query($con, "SELECT * FROM listofstudents WHERE college ='{$row['college']}';");
                                    $result3 = mysqli_query($con, "SELECT * FROM vote WHERE governor ='{$row['idnum']}';");
                                    $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                    $percent = number_format($percent,2);
                                    echo "<tr>
                                            <td>{$row['idnum']}</td>
                                            <td>{$row['fullname']}</td>
                                            <td class ='w3-center'>{$row['yearlevel']}</td>
                                            <td class ='w3-center'>{$row['collegecode']}</td>
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
                                </tr>
                            </thead>';
                    $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Vice Governor' AND college ='{$_SESSION['college']}' AND candidateyear ='$currentyear';");
                    if($result != FALSE)
                    {
                        if(mysqli_num_rows($result) != 0) {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $result2 = mysqli_query($con, "SELECT * FROM listofstudents WHERE college ='{$row['college']}';");
                                $result3 = mysqli_query($con, "SELECT * FROM vote WHERE vicegovernor ='{$row['idnum']}';");
                                $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                                $percent = number_format($percent,2);
                                echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['fullname']}</td>
                                        <td class ='w3-center'>{$row['yearlevel']}</td>
                                        <td class ='w3-center'>{$row['collegecode']}</td>
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
        </section>
    </body>
    
    <footer>
        <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
        <address>
            Contact: <a href="mailto:josepricardo%40su.edu.ph">Mail me</a>
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
                document.getElementById("get5yrmayor").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
                document.getElementById("get5yrvicemayor").innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
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