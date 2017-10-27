<?php
require '../script/register.php'; // Requires Login Script
if(!isset($_SESSION['login_admin_id']))
{
    $_SESSION['Error'] = "Please Login First!";
    header('location: ../admin');
}
?>
<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SU Voting</title>
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
                <h1>Register</h1>
            </strong>    
        </section>
        <section>
            <form class="w3-container w3-card2" method="post" action="index.php">
                <div class="w3-container">
                    <h2>Registration Form</h2>
                    <div class="w3-container w3-center">
                        <div class="w3-container w3-margin">
                            <label class="w3-left">ID Number :</label>
                            <input class="w3-right" name="idnum" type="text" placeholder="Enter ID (XX-X-XXXXX)" required>
                        </div>
                        <div class="w3-container w3-margin">
                            <label class="w3-left">PIN :</label>
                            <input class="w3-right" name="pin" type="password" placeholder="Enter PIN (MAX = 6 digits)" required>
                        </div>
                        <div class="w3-container w3-margin">
                            <label class="w3-left">First Name :</label>
                            <input class="w3-right" name="firstname" type="text" placeholder="Enter First Name" required>
                        </div>
                        <div class="w3-container w3-margin">
                            <label class="w3-left">Middle Initial :</label>
                            <input class="w3-right" name="middleinitial" type="text" placeholder="Enter M.I." required>
                        </div>
                        <div class="w3-container w3-margin">
                            <label class="w3-left">Last Name :</label>
                            <input class="w3-right" name="lastname" type="text" placeholder="Enter Last Name" required>
                        </div>
                        <div class="w3-container w3-margin">
                            <label class="w3-left">Course :</label>
                            <select class="w3-right" name="course" required>
                                <option value="">Select Course</option>
                                <?php
                                    $result = mysqli_query($con, "SELECT * FROM course;");
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<option value='".$row['idcourse']."'>".$row['name']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                          
                        <div class="w3-container w3-margin">
                            <label class="w3-left">Year Level :</label>
                            <input name="yearlevel" type="radio" value="1" required><label>&nbspI</label>
                            <input name="yearlevel" type="radio" value="2" required><label>&nbspII</label>
                            <input name="yearlevel" type="radio" value="3" required><label>&nbspIII</label>
                            <input name="yearlevel" type="radio" value="4" required><label>&nbspIV</label>
                            <input name="yearlevel" type="radio" value="5" required><label>&nbspV</label>
                            <input name="yearlevel" type="radio" value="6" required><label>&nbspVI</label>
                        </div>
                        <div class="w3-container w3-margin">
                            <label class="w3-left">Gender :</label>
                            <input name="sex" type="radio" value="Male" required><label>&nbspMale</label>
                            <input name="sex" type="radio" value="Female" required><label>&nbspFemale</label>
                            <span><?php echo $error; ?></span>
                        </div>
                        <input class="w3-container w3-left w3-button w3-round-xxlarge w3-blue" name="registerSubmit" type="submit" value="Register">
                    </div>
                </div>
            </form>   
        </section>
    <footer>
        <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
        <address>
            Contact: <a href="mailto:josepricardo%40su.edu.ph">Mail me</a>
            
		</address>
    </footer>
</body>
<?php mysqli_close($con); // Closing Connection?> 
</html>