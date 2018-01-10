<?php
$db = mysqli_connect("localhost","root","","DbName"); //keep your db name
$image = addslashes(file_get_contents($_FILES['images']['tmp_name']));
//you keep your column name setting for insertion. I keep image type Blob.
$query = "INSERT INTO products (id,image) VALUES('','$image')";  
$qry = mysqli_query($db, $query);
?>