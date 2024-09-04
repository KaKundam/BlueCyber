<?php
$host="localhost";
$username="root";
$password= "";
$dbname= "challenge11";

$conn = new mysqli($host,$username,$password,$dbname);
if ($conn->connect_error) {
    die("Conection error". $conn->connect_error);
}
?>