<?php
$host = 'localhost';
$dbname = 'fazbear';
$username = 'bit_academy'; // change if needed
$password = 'bit_academy'; // change if needed

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}