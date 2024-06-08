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

    $sql = "SELECT 
            su.ID_SprzetUzytkownika,
            u.Nazwa,
            w.NazwaWartosci,
            u.WartoscLiczbowa AS WartoscLiczbowa,
            u.KolorPodswietlenia AS KolorPodswietlenia,
            w.Typ AS TypWartosci

        FROM 
            tbl_SprzetUzytkownikow su
        INNER JOIN 
            tbl_UstawieniaSprzetu u ON su.ID_SprzetUzytkownika = u.ID_SprzetUzytkownika
        INNER JOIN 
            tbl_SprzetSmart s ON su.ID_SprzetSmart = s.ID_SprzetSmart
        LEFT JOIN 
            tbl_WartoscSprzetSmart w ON s.ID_SprzetSmart = w.ID_SprzetSmart
        WHERE 
            su.ID_SprzetUzytkownika = ?
        ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $device_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="mb-3">';
            echo '<label for="settingName_' . $row['ID_SprzetUzytkownika'] . '" class="form-label">Nazwa</label>';
            echo '<input type="text" class="form-control" id="settingName_' . $row['ID_SprzetUzytkownika'] . '" name="settingName" value="' . htmlspecialchars($row['Nazwa']) . '">';
            echo '</div>';
            
            if ($row['TypWartosci'] == "slider") {
                echo '<div class="mb-3">';
                echo '<label for="settingValue_' . $row['ID_SprzetUzytkownika'] . '" class="form-label">' . $row['NazwaWartosci'] . '</label>';
                echo '<div class="d-flex justify-content-between align-items-center">';
                echo '<span>10 </span>';
                echo '<input type="range" min="10" max="100" class="form-control-range" id="settingValue_' . $row['ID_SprzetUzytkownika'] . '" name="settingValue" value="' . htmlspecialchars($row['WartoscLiczbowa']) . '">';
                echo '<span> 100</span>';
                echo '</div>';
                echo '</div>';            
            } elseif ($row['TypWartosci'] == "checkbox") {
                echo '<div class="mb-3 form-check">';
                echo '<label class="form-check-label" for="settingValue_' . $row['ID_SprzetUzytkownika'] . '">' . $row['NazwaWartosci'] . '</label>';
                echo '<input type="checkbox" class="form-check-input" id="settingValue_' . $row['ID_SprzetUzytkownika'] . '" name="settingValue" value="1" ' . ($row['WartoscLiczbowa'] == 1 ? 'checked' : '') . '>';
                echo '</div>';
            } else{
                echo '<div class="mb-3">';
                echo '<label for="settingValue_' . $row['ID_SprzetUzytkownika'] . '" class="form-label">' . $row['NazwaWartosci'] . '</label>';
                echo '<input type="text" class="form-control" id="settingValue_' . $row['ID_SprzetUzytkownika'] . '" name="settingValue" value="' . htmlspecialchars($row['WartoscLiczbowa']) . '">';
                echo '</div>';
            }
            
            echo '<div class="mb-3">';
            echo '<label for="settingColor_' . $row['ID_SprzetUzytkownika'] . '" class="form-label">Kolor podświetlenia</label>';
            echo '<input type="text" class="form-control" id="settingColor_' . $row['ID_SprzetUzytkownika'] . '" name="settingColor" value="' . htmlspecialchars($row['KolorPodswietlenia']) . '">';
            echo '</div>';
        }
    } else {
        echo '<p>Brak ustawień dla tego urządzenia.</p>';
    }    

    $stmt->close();
    $conn->close();

    exit();
?>
