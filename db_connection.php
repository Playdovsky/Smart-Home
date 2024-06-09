<?php
// Dane dostępu do bazy danych
$servername = "localhost";
$username = "2025_mpalka21";
$password = "palka_majczyk";
$dbname = "2025_mpalka21";

// Nawiązanie połączenia z bazą danych
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Połączenie nieudane: " . $conn->connect_error);
}
?>



