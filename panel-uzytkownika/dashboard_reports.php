<?php
session_start();
include('../admin_check.php');
include('../db_connection.php'); 

// Pobierz ID zalogowanego użytkownika
$logged_in_user_id = $_SESSION['user_id'];

// Obsługa aktualizacji statusu zgłoszenia
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['id']) && isset($_POST['status'])) {
        $id = $_POST['id'];
        $status = $_POST['status'] ? 1 : 0;

        $sql = "UPDATE tbl_Zgloszenia SET Status = $status WHERE ID_Zgloszenia = $id";
        $result = $conn->query($sql);

        if($result === TRUE) {
;
        } else {
            echo "Error updating status: " . $conn->error;
        }
    }
}

// Pobranie listy zgłoszeń z bazy danych
$sql = "SELECT z.ID_Zgloszenia, z.Typ, z.Opis, z.Status, z.DataZgloszenia, 
               u.ID_Uzytkownika, u.Imie, u.Nazwisko, u.NrTelefonu, u.Email
        FROM tbl_Zgloszenia z
        JOIN tbl_Uzytkownicy u ON z.ID_Uzytkownika = u.ID_Uzytkownika";
$result = $conn->query($sql);

// Dodaj obsługę błędów
if ($result === false) {
    die("Błąd w zapytaniu SQL: " . $conn->error);
}

$conn->close();
?>


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
    <link href="css/overlay.css" rel="stylesheet" >
    <link href="../css/responsive.css?v=1.0" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/overlay.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5 ms-xl-2">
        <a href="dashboard.php"><img src="../images/fevicon.png" id="logo-image" class="img-fluid"></a>
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
<div class="wrapper">
    <nav class="sidebar">
        <div class="nav-items">
            <a href="">coś tu będzie</a>
            <a href="dashboard_users.php">Użytkownicy</a>
            <a href="dashboard_urzadzenia.php">Urządzenia</a>
            <a href="dashboard_reports.php">Zgłoszenia</a>
        </div>
    </nav>
    <main>
        <h2>Dashboard</h2>
        <h3>Zgłoszenia</h3>
        <table class="table-bordered">
    <thead>
        <tr>
            <th>Data zgłoszenia</th>
            <th>Kontakt</th>
            <th>Typ</th>
            <th>Opis</th>
            <th>Wykonane</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['DataZgloszenia']); ?></td>
                    <td>
                        <?php echo htmlspecialchars($row['Imie']) . ' ' . htmlspecialchars($row['Nazwisko']); ?><br>
                        <?php echo htmlspecialchars($row['NrTelefonu']); ?><br>
                        <?php echo htmlspecialchars($row['Email']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['Typ']); ?></td>
                    <td><?php echo htmlspecialchars($row['Opis']); ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?php echo $row['ID_Zgloszenia']; ?>">
                            <input type="checkbox" name="status" <?php echo $row['Status'] ? 'checked' : ''; ?> onchange="this.form.submit()">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Brak zgłoszeń</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
    </main>
</div>
</body>
</html>