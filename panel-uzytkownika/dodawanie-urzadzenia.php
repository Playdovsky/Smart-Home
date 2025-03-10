<?php
    session_start();
    include('../db_connection.php');
    include('../user_check.php');

    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['deviceName']) && isset($_POST['deviceNumber'])) {
            $device_name = $_POST['deviceName'];
            $device_number = $_POST['deviceNumber'];

            echo "Device Name: $device_name<br>";
            echo "Device Number: $device_number<br>";

            $stmt_device = $conn->prepare("SELECT ID_SprzetSmart FROM tbl_SprzetSmart WHERE Nazwa = ?");
            $stmt_device->bind_param("s", $device_name);
            $stmt_device->execute();
            $result_device = $stmt_device->get_result();
            
            if ($result_device->num_rows > 0) {
                $row_device = $result_device->fetch_assoc();
                $device_id = $row_device['ID_SprzetSmart'];
                
                echo "Device ID: $device_id<br>";

                $stmt_insert_device = $conn->prepare("INSERT INTO tbl_SprzetUzytkownikow (ID_SprzetSmart, ID_Uzytkownika) VALUES (?, ?)");
                $stmt_insert_device->bind_param("ii", $device_id, $user_id);
                $stmt_insert_device->execute();

                $stmt_inserted_device_id = $conn->prepare("SELECT ID_SprzetUzytkownika FROM tbl_SprzetUzytkownikow WHERE ID_SprzetSmart = ? AND ID_Uzytkownika = ? ORDER BY ID_SprzetUzytkownika DESC LIMIT 1");
                $stmt_inserted_device_id->bind_param("ii", $device_id, $user_id);
                $stmt_inserted_device_id->execute();
                $result_inserted_device_id = $stmt_inserted_device_id->get_result();

                if ($result_inserted_device_id->num_rows > 0) {
                    $row_inserted_device_id = $result_inserted_device_id->fetch_assoc();
                    $last_inserted_device_id = $row_inserted_device_id['ID_SprzetUzytkownika'];

                    echo "Last Inserted Device User ID: $last_inserted_device_id<br>";

                    $stmt_settings = $conn->prepare("SELECT Nazwa, WartoscLiczbowa, KolorPodswietlenia FROM tbl_DomyslneUstawieniaSprzetu WHERE ID_SprzetSmart = ?");
                    $stmt_settings->bind_param("i", $device_id);
                    $stmt_settings->execute();
                    $result_settings = $stmt_settings->get_result();

                    while ($row_settings = $result_settings->fetch_assoc()) {
                        $setting_name = $row_settings['Nazwa'];
                        $setting_value = $row_settings['WartoscLiczbowa'];
                        $setting_color = $row_settings['KolorPodswietlenia'];

                        echo "Inserting setting: $setting_name, $setting_value, $setting_color<br>";

                        $stmt_insert_settings = $conn->prepare("INSERT INTO tbl_UstawieniaSprzetu (ID_SprzetUzytkownika, Nazwa, WartoscLiczbowa, KolorPodswietlenia) VALUES (?, ?, ?, ?)");
                        $stmt_insert_settings->bind_param("isss", $last_inserted_device_id, $setting_name, $setting_value, $setting_color);
                        $stmt_insert_settings->execute();
                        $stmt_insert_settings->close();
                    }

                    $stmt_settings->close();
                } else {
                    echo "Error: Unable to retrieve the last inserted device user ID.";
                }

                $stmt_inserted_device_id->close();
                $stmt_insert_device->close();
            } else {
                echo "Error: Device not found.";
            }

            $stmt_device->close();
        } else {
            echo "Error: 'deviceName' or 'deviceNumber' not set in POST data.";
        }
    } else {
        echo "Error: Invalid request method.";
    }

    $conn->close();

    header("Location: panel-uzytkownika.php");
    exit();
?>
