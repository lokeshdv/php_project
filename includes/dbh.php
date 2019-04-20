<?php
$dbserver="localhost";
$dbuser="root";
$dbpassword="";
$dbbase="loginsystem";

$conn=mysqli_connect($dbserver,$dbuser,$dbpassword,$dbbase);
if (!$conn) {
  die("connection failed :". mysqli_connect_error());
}



 ?>
