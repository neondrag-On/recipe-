<?php
$dbserver="localhost";
$dbuser="root";
$dbpass="";
$dbname="login";
$conn="";
try{ 
    mysqli_report(MYSQLI_REPORT_ERROR|MYSQLI_REPORT_STRICT);
$conn=mysqli_connect($dbserver,$dbuser,$dbpass,$dbname);
if(!$conn){
    throw new Exception("connection failed". mysqli_connect_error());
}
}
catch(Exception $e){
    echo"connection failed".$e->getMessage();
} 
?>