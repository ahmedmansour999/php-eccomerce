<?php

$db = 'mysql:host=localhost;dbname=shop';
$user = "root";
$password = "";


$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',

);

try {

    $con = new PDO($db, $user, $password, $options);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

    echo "Failed Connection: " . $e->getMessage();
}
