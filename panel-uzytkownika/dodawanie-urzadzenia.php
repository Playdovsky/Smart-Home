<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    $user_id = $_SESSION['user_id'];

    $servername = "localhost";
    $username = "2025_mpalka21";
    $password = "palka_majczyk";
    $dbname = "2025_mpalka21";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $device_name = $_POST['deviceName'];

    $stmt_device = $conn->prepare("SELECT ID_SprzetSmart FROM tbl_SprzetSmart WHERE Nazwa = ?");
    $stmt_device->bind_param("s", $device_name);
    $stmt_device->execute();
    $result_device = $stmt_device->get_result();
    $row_device = $result_device->fetch_assoc();
    $device_id = $row_device['ID_SprzetSmart'];

    $stmt_insert_device = $conn->prepare("INSERT INTO tbl_SprzetUzytkownikow (ID_SprzetSmart, ID_Uzytkownika) VALUES (?, ?)");
    $stmt_insert_device->bind_param("ii", $device_id, $user_id);
    $stmt_insert_device->execute();

    $stmt_inserted_device_id = $conn->prepare("SELECT ID_SprzetUzytkownika FROM tbl_SprzetUzytkownikow WHERE ID_SprzetSmart = ? AND ID_Uzytkownika = ? ORDER BY ID_SprzetUzytkownika DESC LIMIT 1");
    $stmt_inserted_device_id->bind_param("ii", $device_id, $user_id);
    $stmt_inserted_device_id->execute();
    $result_inserted_device_id = $stmt_inserted_device_id->get_result();
    $row_inserted_device_id = $result_inserted_device_id->fetch_assoc();
    $last_inserted_device_id = $row_inserted_device_id['ID_SprzetUzytkownika'];
    $stmt_inserted_device_id->close();
    
    $stmt_settings = $conn->prepare("SELECT Nazwa, WartoscLiczbowa, KolorPodswietlenia FROM tbl_DomyslneUstawieniaSprzetu WHERE ID_SprzetSmart = ?");
    $stmt_settings->bind_param("i", $device_id);
    $stmt_settings->execute();
    $result_settings = $stmt_settings->get_result();

    while ($row_settings = $result_settings->fetch_assoc()) {
        $setting_name = $row_settings['Nazwa'];
        $setting_value = $row_settings['WartoscLiczbowa'];
        $setting_color = $row_settings['KolorPodswietlenia'];
        
        $stmt_insert_settings = $conn->prepare("INSERT INTO tbl_UstawieniaSprzetu (ID_SprzetUzytkownika, Nazwa, WartoscLiczbowa, KolorPodswietlenia) VALUES (?, ?, ?, ?)");
        $stmt_insert_settings->bind_param("isss", $last_inserted_device_id, $setting_name, $setting_value, $setting_color);
        $stmt_insert_settings->execute();
    }

    $stmt_device->close();
    $stmt_insert_device->close();
    $stmt_settings->close();
    $stmt_insert_settings->close();
    $conn->close();

    header("Location: panel-uzytkownika.php");
    exit();
?>
