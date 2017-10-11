<?php
$host="localhost";
$port=3306;
$user="joseric_pclient";
$password="defaultricardo";
$dbname="joseric_votingsystem";

$dbh = new PDO('mysql:host=$host;dbname=$dbname', $user, $pass, array(PDO::ATTR_PERSISTENT => TRUE));
$con = new mysqli($host, $user, $password, $dbname, $port);
if (mysqli_connect_error())die ('Could not connect to the database server'. mysqli_connect_error());
mysqli_set_charset($con,"UTF-8");
?>