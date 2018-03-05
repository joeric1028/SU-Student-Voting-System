s<?php
    require '../script/session.php'; // Includes Login Script
    $femalestudents = mysqli_query($con,"SELECT * FROM user WHERE sex='Female';");
    $malestudents = mysqli_query($con,"SELECT * FROM user WHERE sex='Male';");
    $voterstudents = mysqli_query($con,"SELECT * FROM user WHERE admintype='Student';");
    $adminstudents = mysqli_query($con,"SELECT * FROM user WHERE admintype='Administrator';");
    $result = mysqli_query($con,"SELECT course.name AS coursename, idnum, firstname, middleinitial, lastname, yearlevel, collegecode FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege;");
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
        <link href="../css/style2.css" rel="stylesheet">
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

          <p>Click on the buttons inside the tabbed menu:</p>
          <div class="tab">
            <button class="tablinks" onclick="openCity(event, 'London')">View List of Student</button>
            <button class="tablinks" onclick="openCity(event, 'Paris')">Delete Student</button>
            <button class="tablinks" onclick="openCity(event, 'Tokyo')">Data</button>
          </div>

          <div id="London" class="tabcontent">
            <article>
                <h1>List of Students</h1>
                <h4 class=w3-container><br>
                <?php
                    $ro = mysqli_num_rows($result);
                    echo "Number of Students: $ro";
                ?>
                </h4>
                <br>
                <input type="text" id="myInputStudent" onkeyup="myFunctionStudent()" placeholder="Search student by name..." title="Type in a name">
            </article>
            <article>
                <p>
                <table id="listStudents" class="w3-table-all w3-hoverable">
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
                                <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                                <td>{$row['yearlevel']}</td>
                                <td>{$row['collegecode']}</td>
                                <td>{$row['coursename']}</td>
                                </tr>\n";
                            }
                        }
                    ?>
                    </table>
                </p>
            </article>
            <script>
            function myFunctionStudent() {
            var input, filter, table, tr, td, i;
              input = document.getElementById("myInputStudent");
              filter = input.value.toUpperCase();
              table = document.getElementById("listStudents");
              tr = table.getElementsByTagName("tr");
              for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                  if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                  } else {
                    tr[i].style.display = "none";
                  }
                }
              }
            }
            </script>
          </div>

          <div id="Paris" class="tabcontent">
            <form method="post">
            <!-- <h3>Delete Student</h3> -->
            <!-- <input type="submit" value="Delete Student"><a href='../student'></a></input> -->
              <label>Delete Registered Student</label>
              <select name="user" onchange="runstudent()" id="student">
                <option disabled.selected>Select Student:</option>
                <?php
                $student = mysqli_query($con, "SELECT * FROM user;");
                foreach ($student as $resultstudent){
                  echo
                  '<option value="'.$resultstudent['iduser'].'">'.$resultstudent['firstname'].' '.$resultstudent['middleinitial'].' '.$resultstudent['lastname'].'</option>';
                }
                ?>
                </select>
                <input type="text" name="student" id="outputstudent">
                  <script>
                    function runstudent() {
                    document.getElementById("outputstudent").value =   document.getElementById("student").value;
                    }
                    </script>
                  <input class="w3-container w3-right w3-button w3-round-xxlarge w3-blue" name="deleteSubmit" type="submit" value="Delete">
                  <?php
                  if (isset($_POST['deleteSubmit']))
                  {
                      $iduser=$_POST['user'];
                      // To protect MySQL injection for Security purpose
                      $iduser = stripslashes($iduser);
                      $iduser = mysqli_real_escape_string($con, $iduser);
                      $error = "Deletion Sucessful!";
                      mysqli_query($con,"DELETE FROM user WHERE iduser = $iduser;");
                    }
                      ?>
            </form>
          </div>

          <div id="Tokyo" class="tabcontent">
            <h3>Data</h3>
            <br>
            <?php
                $ro = mysqli_num_rows($result);
                echo "Number of Registered Students: $ro";
            ?>
            <br><br>
            <?php
                $femalero = mysqli_num_rows($femalestudents);
                echo "Number of Female Students: $femalero";
            ?>
            <br><br>
            <?php
                $malero = mysqli_num_rows($malestudents);
                echo "Number of Male Students: $malero";
            ?>
            <br><br>
            <?php
                $voterro = mysqli_num_rows($voterstudents);
                echo "Number of Voter Students: $voterro";
            ?>
            <br><br>
            <?php
                $adminro = mysqli_num_rows($adminstudents);
                echo "Number of Admin Students: $adminro";
            ?>
          </div>

          <script>
          function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
              tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
              tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
            }
          </script>

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
