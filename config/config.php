<?php
$dbMechine="localhost";
$userName="root";
$pass="";
$dbName="crud";
$con="";

try{
    $con=mysqli_connect($dbMechine, $userName, $pass, $dbName);
    echo "Database is connected";
}catch(mysqli_sql_exception){
    echo "database is not connected";
}

?>