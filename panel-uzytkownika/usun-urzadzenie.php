<?php
    session_start();
    include('../db_connection.php');
    include('../user_check.php');

    if (!isset($_SESSION['user_id'])) {
        die("Użytkownik nie jest zalogowany.");
    }

    if (!isset($_POST['device_id'])) {
        die("Brak ID urządzenia.");
    }

    $device_id = $_POST['device_id'];

    $user_id = $_SESSION['user_id'];

    $sql_delete_settings = "DELETE FROM tbl_UstawieniaSprzetu WHERE ID_SprzetUzytkownika = ?";
    $stmt_delete_settings = $conn->prepare($sql_delete_settings);
    $stmt_delete_settings->bind_param("i", $device_id);
    $stmt_delete_settings->execute();

    $sql_delete_device = "DELETE FROM tbl_SprzetUzytkownikow WHERE ID_SprzetUzytkownika = ?";
    $stmt_delete_device = $conn->prepare($sql_delete_device);
    $stmt_delete_device->bind_param("i", $device_id);
    $stmt_delete_device->execute();

    if ($stmt_delete_device->affected_rows > 0) {
        echo "Urządzenie zostało pomyślnie usunięte.";
    } else {
        echo "Nie udało się usunąć urządzenia.";
    }

    $stmt_delete_settings->close();
    $stmt_delete_device->close();
    $conn->close();
        
    exit();
?>
