<?php
    $servername = "localhost";
    $username = "2025_mpalka21";
    $password = "palka_majczyk";
    $dbname = "2025_mpalka21";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $device_id = isset($_GET['device_id']) ? intval($_GET['device_id']) : 0;

    $sql = "SELECT Nazwa, WartoscLiczbowa, KolorPodswietlenia FROM tbl_UstawieniaSprzetu WHERE ID_SprzetUzytkownika = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $device_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="mb-3">';
            echo '<label for="settingName" class="form-label">Nazwa</label>';
            echo '<input type="text" class="form-control" id="settingName" name="settingName" value="' . htmlspecialchars($row['Nazwa']) . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="settingValue" class="form-label">Wartość</label>';
            echo '<input type="text" class="form-control" id="settingValue" name="settingValue" value="' . htmlspecialchars($row['WartoscLiczbowa']) . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="settingColor" class="form-label">Kolor podświetlenia</label>';
            echo '<input type="text" class="form-control" id="settingColor" name="settingColor" value="' . htmlspecialchars($row['KolorPodswietlenia']) . '">';
            echo '</div>';
        }
    } else {
        echo '<p>Brak ustawień dla tego urządzenia.</p>';
    }

    $stmt->close();
    $conn->close();

    exit();

?>