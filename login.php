<?php
include('script\login.php'); // Includes Login Script
if(isset($_SESSION['login_user'])){
    header("location: profile.php");
}else{
    
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
        <form method="post" action="">
            <legend>Log in</legend>
            <div id="login">
                <h2>Login Form</h2>
                <form action="login.php" method="post">
                <label>Username :</label>
                <input id="name" name="username" type="text">
                <label>Password :</label>
                <input id="password" name="password" type="password">
                <a href="register.php" class ="reg">Register</a>
                <input name="submit" type="submit" value=" Login ">
                <span>
                    <?php echo $error;?>
                </span>
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