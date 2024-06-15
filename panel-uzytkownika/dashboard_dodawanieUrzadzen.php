<?php
session_start();
include('../admin_check.php');
include('../db_connection.php');
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $typ = $_POST['typ'];
    $nazwa = $_POST['nazwa'];
    $wartosc_liczbowa = $_POST['wartosc_liczbowa'];
    $kolor_podswietlenia = $_POST['kolor_podswietlenia'];
    $nazwa_wartosci = $_POST['nazwa_wartosci'];
    $typ_wartosci = $_POST['typ_wartosci'];
 
    // Sprawdzenie i zapisanie pliku zdjęcia
    $target_dir = "../images/";
    $target_file = $target_dir . basename($_FILES["zdjecie"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;
 
    // Sprawdzenie, czy plik jest obrazem
    $check = getimagesize($_FILES["zdjecie"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "Plik nie jest obrazem.";
        $uploadOk = 0;
    }
 
    // Sprawdzenie rozmiaru pliku
    if ($_FILES["zdjecie"]["size"] > 5000000) { // 5MB limit
        echo "Plik jest za duży.";
        $uploadOk = 0;
    }
 
    // Zezwolenie tylko na określone formaty plików
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Dozwolone są tylko pliki JPG, JPEG i PNG.";
        $uploadOk = 0;
    }
 
    // Sprawdzenie, czy $uploadOk jest ustawione na 0 przez błąd
    if ($uploadOk == 0) {
        echo "Plik nie został przesłany.";
    } else {
        if (move_uploaded_file($_FILES["zdjecie"]["tmp_name"], $target_file)) {
            echo "Plik ". basename($_FILES["zdjecie"]["name"]). " został przesłany.";
 
            // Rozpoczęcie transakcji
            mysqli_begin_transaction($conn);
 
            try {
                // Wstawienie danych do tabeli tbl_SprzetSmart
                $sciezka = basename($_FILES["zdjecie"]["name"]);
                $sql = "INSERT INTO tbl_SprzetSmart (Typ, Nazwa, Sciezka) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sss", $typ, $nazwa, $sciezka);
                mysqli_stmt_execute($stmt);
                $last_id = mysqli_insert_id($conn); // Pobranie ID nowo dodanego sprzętu
 
                // Wstawienie danych do tabeli tbl_WartoscSprzetSmart
                $sql3 = "INSERT INTO tbl_WartoscSprzetSmart (ID_SprzetSmart, NazwaWartosci, Typ) VALUES (?, ?, ?)";
                $stmt3 = mysqli_prepare($conn, $sql3);
                mysqli_stmt_bind_param($stmt3, "iss", $last_id, $nazwa_wartosci, $typ_wartosci);
                mysqli_stmt_execute($stmt3);
 
                // Wstawienie danych do tabeli tbl_DomyslneUstawieniaSprzetu
                $sql2 = "INSERT INTO tbl_DomyslneUstawieniaSprzetu (ID_SprzetSmart, Nazwa, WartoscLiczbowa, KolorPodswietlenia) VALUES (?, ?, ?, ?)";
                $stmt2 = mysqli_prepare($conn, $sql2);
                mysqli_stmt_bind_param($stmt2, "isds", $last_id, $nazwa, $wartosc_liczbowa, $kolor_podswietlenia);
                mysqli_stmt_execute($stmt2);
 
                // Zakończenie transakcji
                mysqli_commit($conn);
 
                echo "Sprzęt został pomyślnie dodany.";
            } catch (Exception $e) {
                mysqli_rollback($conn);
                echo "Błąd: " . $e->getMessage();
            } finally {
                mysqli_stmt_close($stmt);
                mysqli_stmt_close($stmt2);
                mysqli_stmt_close($stmt3);
            }
        } else {
            echo "Wystąpił błąd podczas przesyłania pliku.";
        }
    }
}
?>
 
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="keywords" content="Smart Home, Future, Device, Devices, Dashboard" />
    <meta name="description" content="Smart Home internet application" />
    <meta name="author" content="Bartosz Majczyk, Mateusz Pałka" />
    <title>Smart Future</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="icon" href="../images/fevicon.png" type="image/gif" />
    <link href="../css/font-awesome.min.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
    <link href="../css/responsive.css?v=1.0" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/profil.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5 ms-xl-2">
            <a href="panel-uzytkownika.php"><img src="../images/fevicon.png" id="logo-image" class="img-fluid"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-2">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="panel-uzytkownika.php"><b>Widok użytkownika</b></a></li>
            </ul>
        </div>
        <div class="mx-md-5">
            <form method="post">
                <input type="submit" id="wylogowanie" value="Wyloguj się" name="logout">
            </form>
            <?php
                if(isset($_POST['logout'])) {
                    $_SESSION = array();
                    session_destroy();
                    header("Location: ../index.php");
                    exit();
                }
            ?>
        </div>
    </nav>
    <header class="py-2" style="background-color: rgb(192, 192, 192);">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center">
                <h1 class="display-4 fw-bolder text-black">Dodawanie nowego sprzętu</h1>
            </div>
        </div>
    </header>
 
    <section class="py-5">
        <div class="container mt-5">
        <a class="nav-link active mb-3" aria-current="page" href="dashboard_urzadzenia.php"><b>< Cofnij</b></a>
 
        <h2>Dodaj Nowy Sprzęt</h2>
        <form id="addDeviceForm" method="POST" enctype="multipart/form-data" action="">
            <div class="mb-3">
                <label class="form-label">Typ:</label>
                <input type="text" class="form-control" name="typ" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nazwa:</label>
                <input type="text" class="form-control" name="nazwa" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Zdjęcie:</label>
                <input type="file" class="form-control" name="zdjecie" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Wartość Liczbowa:</label>
                <input type="number" class="form-control" name="wartosc_liczbowa" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kolor Podświetlenia:</label>
                <input type="text" class="form-control" name="kolor_podswietlenia" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nazwa Wartości (Wartość Sprzęt Smart):</label>
                <input type="text" class="form-control" name="nazwa_wartosci" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Typ:</label>
                <select class="form-control" name="typ_wartosci" required>
                    <option value="slider">Slider</option>
                    <option value="text">Text</option>
                    <option value="checkbox">Checkbox</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Dodaj Sprzęt</button>
        </form>
        </div>
    </section>
</body>
</html>