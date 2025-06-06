<?php
    session_start();
    include('../db_connection.php');
    include('../user_check.php');

    if (!isset($_POST['device_id'])) {
        die("Brak ID urządzenia.");
    }

    $device_id = $_POST['device_id'];
    $nazwa = $_POST['settingName'] ?? '';
    $wartosc = $_POST['settingValue'] ?? '';
    $kolor = $_POST['settingColor'] ?? '';

    $sql_update = "UPDATE tbl_UstawieniaSprzetu SET Nazwa = ?, WartoscLiczbowa = ?, KolorPodswietlenia = ? WHERE ID_SprzetUzytkownika = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssi", $nazwa, $wartosc, $kolor, $device_id);
    $stmt_update->execute();

    if ($stmt_update->affected_rows > 0) {
        echo "Zmiany zostały zapisane.";
    } else {
        http_response_code(400);
        echo "Nie udało się zapisać zmian.";
    }

    $stmt_update->close();
    $conn->close();
    
    header("Location: profil-uzytkownika.php");
    exit();
?>
