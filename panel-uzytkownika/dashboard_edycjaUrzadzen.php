<?php
session_start();
include('../admin_check.php');
include('../db_connection.php');

// Sprawdzenie, czy przekazano ID w parametrze URL
if (!isset($_GET['id'])) {
    die("Nieprawidłowy parametr ID.");
}

$id = $_GET['id'];

// Pobranie istniejących danych sprzętu z bazy danych
$sql = "SELECT s.Typ, s.Nazwa, s.Sciezka, d.WartoscLiczbowa, d.KolorPodswietlenia, w.NazwaWartosci, w.Typ AS TypWartosci 
        FROM tbl_SprzetSmart s
        LEFT JOIN tbl_WartoscSprzetSmart w ON s.ID_SprzetSmart = w.ID_SprzetSmart
        LEFT JOIN tbl_DomyslneUstawieniaSprzetu d ON s.ID_SprzetSmart = d.ID_SprzetSmart
        WHERE s.ID_SprzetSmart = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Błąd w pobieraniu danych sprzętu: " . mysqli_error($conn));
}

// Sprawdzenie, czy pobrano jakiekolwiek dane
if (mysqli_num_rows($result) == 0) {
    die("Nie znaleziono sprzętu o podanym ID.");
}

$row = mysqli_fetch_assoc($result);

$typ = $row['Typ'];
$nazwa = $row['Nazwa'];
$sciezka = $row['Sciezka'];
$wartosc_liczbowa = $row['WartoscLiczbowa'];
$kolor_podswietlenia = $row['KolorPodswietlenia'];
$nazwa_wartosci = $row['NazwaWartosci'];
$typ_wartosci = $row['TypWartosci'];

// Obsługa przesłania formularza
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $typ = $_POST['typ'];
    $nazwa = $_POST['nazwa'];
    $wartosc_liczbowa = $_POST['wartosc_liczbowa'];
    $kolor_podswietlenia = $_POST['kolor_podswietlenia'];
    $nazwa_wartosci = $_POST['nazwa_wartosci'];
    $typ_wartosci = $_POST['typ_wartosci'];

    // Aktualizacja istniejących danych w bazie danych
    $sql_update_sprzet = "UPDATE tbl_SprzetSmart SET Typ = ?, Nazwa = ? WHERE ID_SprzetSmart = ?";
    $stmt_update_sprzet = mysqli_prepare($conn, $sql_update_sprzet);
    mysqli_stmt_bind_param($stmt_update_sprzet, "ssi", $typ, $nazwa, $id);
    mysqli_stmt_execute($stmt_update_sprzet);

    $sql_update_wartosc = "UPDATE tbl_WartoscSprzetSmart SET NazwaWartosci = ?, Typ = ? WHERE ID_SprzetSmart = ?";
    $stmt_update_wartosc = mysqli_prepare($conn, $sql_update_wartosc);
    mysqli_stmt_bind_param($stmt_update_wartosc, "ssi", $nazwa_wartosci, $typ_wartosci, $id);
    mysqli_stmt_execute($stmt_update_wartosc);

    $sql_update_domyslne = "UPDATE tbl_DomyslneUstawieniaSprzetu SET WartoscLiczbowa = ?, KolorPodswietlenia = ? WHERE ID_SprzetSmart = ?";
    $stmt_update_domyslne = mysqli_prepare($conn, $sql_update_domyslne);
    mysqli_stmt_bind_param($stmt_update_domyslne, "dsi", $wartosc_liczbowa, $kolor_podswietlenia, $id);
    mysqli_stmt_execute($stmt_update_domyslne);

    header("Location: dashboard_urzadzenia.php");
    exit();
}

// Zamknięcie zapytań i połączenia z bazą danych
mysqli_stmt_close($stmt);
mysqli_close($conn);
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
                <h1 class="display-4 fw-bolder text-black">Edycja sprzętu</h1>
            </div>
        </div>
    </header>
    <div class="container mt-5">
        <a class="nav-link active mb-3" aria-current="page" href="dashboard_urzadzenia.php"><b>< Powrót</b></a>

        <h2>Edytuj Sprzęt</h2>
        <form id="editDeviceForm" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="typ">Typ:</label>
                <input type="text" class="form-control" id="typ" name="typ" value="<?php echo htmlspecialchars($typ); ?>" required>
            </div>
            <div class="form-group">
                <label for="nazwa">Nazwa:</label>
                <input type="text" class="form-control" id="nazwa" name="nazwa" value="<?php echo htmlspecialchars($nazwa); ?>" required>
            </div>
            <div class="form-group">
                <label for="wartosc_liczbowa">Wartość Liczbowa:</label>
                <input type="number" class="form-control" id="wartosc_liczbowa" name="wartosc_liczbowa" value="<?php echo htmlspecialchars($wartosc_liczbowa); ?>" required>
            </div>
            <div class="form-group">
                <label for="kolor_podswietlenia">Kolor Podświetlenia:</label>
                <input type="text" class="form-control" id="kolor_podswietlenia" name="kolor_podswietlenia" value="<?php echo htmlspecialchars($kolor_podswietlenia); ?>" required>
            </div>
            <div class="form-group">
                <label for="nazwa_wartosci">Nazwa Wartości (Wartość Sprzęt Smart):</label>
                <input type="text" class="form-control" id="nazwa_wartosci" name="nazwa_wartosci" value="<?php echo htmlspecialchars($nazwa_wartosci); ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="typ_wartosci">Typ:</label>
                <select class="form-control" id="typ_wartosci" name="typ_wartosci" required>
                    <option value="slider" <?php if ($typ_wartosci == 'slider') echo 'selected'; ?>>Slider</option>
                    <option value="text" <?php if ($typ_wartosci == 'text') echo 'selected'; ?>>Text</option>
                    <option value="checkbox" <?php if ($typ_wartosci == 'checkbox') echo 'selected'; ?>>Checkbox</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </form>
    </div>
</body>
</html>
