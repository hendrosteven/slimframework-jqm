<?php

function getConn() {
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "admin";
    $dbDatabase = "dbhotel";
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbDatabase", $dbUser, $dbPass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}
