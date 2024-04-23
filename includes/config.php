<?php
$host = '127.0.0.1:3306';
$dbname = 'classroom_reservation';
$username = 'root';
$password = 'Bujjemm@0328';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
