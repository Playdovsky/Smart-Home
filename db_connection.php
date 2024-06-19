<?php
    // Dane dostępu do bazy danych
    $servername = "localhost";
    $username = "2025_mpalka21";
    $password = "palka_majczyk";
    $dbname = "2025_mpalka21";

    $prefix = "tbl";

    $base_url = "https://www.manticore.uni.lodz.pl";
    $nazwa_aplikacji = "Smart-Home";
    $data_powstania = ""; //dzisiejsza
    $brand = "Smart-Future";
    $adres = "Rewolucji 1905 r.";
    $adres2 = "Łódź, 90-221";
    $phone = "742325752";

    // Nawiązanie połączenia z bazą danych
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Sprawdzenie połączenia
    if ($conn->connect_error) {
        die("Połączenie nieudane: " . $conn->connect_error);
    }
?>