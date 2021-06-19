<?php

$host = "localhost";
$user = "root";
$password = "";
$name = "sportify";
$con=mysqli_connect($host,$user,$password,$name);


if (!$con)    
{
    die("failed to connect!");
}

?>