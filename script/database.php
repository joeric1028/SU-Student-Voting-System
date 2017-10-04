<?php
$host="localhost";
$port=3306;
$user="josepric_pclient";
$password="defaultricardo";
$dbname="josepric_votingsystem";

$con = new mysqli($host, $user, $password, $dbname, $port);
if (mysqli_connect_error())die ('Could not connect to the database server'. mysqli_connect_error());
mysqli_set_charset($con,"UTF-8");
?>