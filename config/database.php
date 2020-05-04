<?php
include 'default.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
}
catch(PDOException $e){
	echo "Connection failed: " . $e->getMessage();
}