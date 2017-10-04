<?php
require '../script/login.php'; // Includes Login Script
if(isset($_SESSION['login_user']))header("location: ../");
$error = 'No Candidate';
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
    <div id="logo"><a href="../"><img src="../img/vote_logo.png"></a>SU Voting</div>
        <nav>
            <ul>
                <li><a href="../candidate">CANDIDATE</a></li>
                <li><a href="../student">STUDENT</a></li>
                <li><a href="../vote">VOTE</a></li>
                <li><a href="../admin">ADMIN</a></li>
            </ul>
        </nav>
</header>
        <section><br></section>
        <section id="pageContent">
            <main role="main">
                <article>
                    <h1>Candidates</h1>  
                </article>
                <article>
                    <h2>Governor</h2>
                    <p>
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Governor';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['fullname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
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
                                    <th>Name</th>
                                    <th>Year Level</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <?php
                                $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='hello';");
                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<tr>
                                        <td>{$row['idnum']}</td>
                                        <td>{$row['fullname']}</td>
                                        <td>{$row['yearlevel']}</td>
                                        <td>{$row['collegecode']}</td>
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

            </main>
            <aside>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div>
                <div><img src="../img/avatar.png" class="w3-container w3-circle" style ="width:50%"></div> 
            </aside>
        </section>
    </body>
        <footer>
            <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
            <address>
            Contact: <a href="mailto:josepricardo%40su.edu.ph">Mail me</a>
		</address>
        </footer>
</html>