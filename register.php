<?php
include('script\register.php'); // Includes Login Script
if(isset($_SESSION['register_user'])){
header("location: profile.php");
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="http://html5-templates.com/logo.png">
    <link rel="canonical" href="http://html5-templates.com/" />
    <title>Voting Management System</title>
    <meta name="description" content="Home Page for Voting Management System.">
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <header>
        <div id="logo"><img src="http://html5-templates.com/logo.png">Welcome</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </nav>
    </header>
        <section>
        <!-- Register form -->
        <form method="post" action="">
                <legend>Register</legend>
                <div id="login">
                <h2>Registration Form</h2>
                <form action="register.php" method="post">
                <label>Username :</label>
                <input id="name" name="username" type="text">
                <label>Password :</label>
                <input id="password" name="password" type="password">
                <a href="login.php" class ="reg">Login</a>
                <input name="submit" type="submit" value=" Register ">
                <span><?php echo $error; ?></span>
                </form>
            </div>
    </section>
    <footer>
        <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
        <address>
			Contact: <a href="joeric1028@icloud.com">Mail me</a>
		</address>
    </footer>
</body>

</html>