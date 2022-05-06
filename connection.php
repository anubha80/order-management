<?php

// DEVELOPER                      DATE                        COMMENTS
// Anubha Dubey(2032178)          2022-04-16            Create connection
// Anubha Dubey(2032178)          2022-04-18            Make db variables and update file
//



$server="localhost" ;   
$username="root";
$password="";
$dbname="database_2032178";

//$connection = mysqli_connect($server, $username, $password, $dbname);
//if(!$connection){
//    die("Error".mysqli_connect_error());
//}

$connection = new PDO("mysql:host=localhost;dbname=database_2032178", 'root', '');
//to raise an exception when there is an error inyour SQL queries
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//to protect my code against SQL injection
$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

?>