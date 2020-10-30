<?php
$host = "localhost";
$db = "sirevi";
$username = "neko";
$password = "Kvantifikator1";

$conn = new mysqli($host, $username, $password, $db);

if ($conn->connect_errno) {
    exit("Konekcija sa bazom je neuspjesna: " . $conn->connect_errno);
}