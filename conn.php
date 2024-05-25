<?php

// Datenbankverbindungsparameter
$servername = '185.51.8.78:3307';
$username = 'u232847db2';
$password = 'typrus4ahwii';
$dbname = 'u232847db2';
// Erstellen einer Verbindung zur Datenbank
$conn = new mysqli($servername, $username, $password, $dbname);
// Überprüfung der Verbindung
if ($conn->connect_error) {
 die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Setzen des Zeichensatzes für die Verbindung auf utf8

$conn->set_charset("utf8");

?>