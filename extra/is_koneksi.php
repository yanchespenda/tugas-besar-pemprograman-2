<?php
defined('ISLOADPAGE') OR exit('No direct script access allowed');

$servername = "localhost";
$username = "root";
$password = "";
$dbName = "project_web2";
$conn = null;
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    print_r('Connection failed');
}
