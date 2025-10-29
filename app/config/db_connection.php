<?php
// db_connection.php

$serverName = "localhost\\SQLEXPRESS"; 
$database = "ClinicProject";
$username = "admin2";
$password = "12345";
$connectionOptions = [
    "Database" => $database,
    "Uid" => $username,
    "PWD" => $password,
    "TrustServerCertificate" => true
];

// Create connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Check connection
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>