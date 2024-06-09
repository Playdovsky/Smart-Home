<?php
session_start();
include('../admin_check.php');
include('../db_connection.php'); 

// Pobierz ID zalogowanego użytkownika
$logged_in_user_id = $_SESSION['user_id'];

// Funkcja do aktywacji/dezaktywacji użytkownika
if (isset($_POST['toggle_status'])) {
    $user_id = $_POST['user_id'] ?? null;
    if ($user_id) {
        $sql = "UPDATE tbl_Uzytkownicy SET Dezaktywowany = IF(Dezaktywowany = 0, 1, 0) WHERE ID_Uzytkownika = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Funkcja do zmiany uprawnień użytkownika
if (isset($_POST['change_role'])) {
    $user_id = $_POST['user_id'] ?? null;
    $new_role = $_POST['new_role'] ?? null;
    if ($user_id && $new_role && $user_id != $logged_in_user_id) { // Zabezpieczenie, aby użytkownik nie mógł zmienić swoich uprawnień
        $sql = "UPDATE tbl_UprawnieniaUzytkownikow SET TypUprawnienia = ? WHERE ID_Uzytkownika = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_role, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Pobranie listy użytkowników z bazy danych
$sql = "SELECT u.ID_Uzytkownika, u.Imie, u.Nazwisko, u.NrTelefonu, u.Email, u.Dezaktywowany, up.TypUprawnienia
        FROM tbl_Uzytkownicy u
        LEFT JOIN tbl_UprawnieniaUzytkownikow up ON u.ID_Uzytkownika = up.ID_Uzytkownika";
$result = $conn->query($sql);

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
            <li class="nav-item"><a class="nav-link active" aria-current="page" href="panel-administratora.php"><b>Widok użytkownika</b></a></li>
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
            <a href="">Urządzenia</a>
            <a href="dashboard_reports.php">Zgłoszenia</a>
        </div>
    </nav>
    <main>
        <h2>Dashboard</h2>
        <h3>Użytkownicy</h3>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>ID Użytkownika</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Uprawnienia</th>
                    <th>Telefon</th>
                    <th>Email</th>
                    <th>Dezaktywowany</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['ID_Uzytkownika']); ?></td>
                            <td><?php echo htmlspecialchars($row['Imie']); ?></td>
                            <td><?php echo htmlspecialchars($row['Nazwisko']); ?></td>
                            <td>
                                <?php if ($row['ID_Uzytkownika'] != $logged_in_user_id): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['ID_Uzytkownika']); ?>">
                                        <select name="new_role" class="transparent-combobox" onchange="this.form.submit()">
                                            <option value="Admin" <?php if($row['TypUprawnienia'] == 'Admin') echo 'selected'; ?>>Admin</option>
                                            <option value="User" <?php if($row['TypUprawnienia'] == 'User') echo 'selected'; ?>>User</option>
                                        </select>
                                        <input type="hidden" name="change_role" value="1">
                                    </form>
                                <?php else: ?>
                                    <?php echo htmlspecialchars($row['TypUprawnienia']); ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['NrTelefonu']); ?></td>
                            <td><?php echo htmlspecialchars($row['Email']); ?></td>
                            <td><?php echo $row['Dezaktywowany'] ? 'Tak' : 'Nie'; ?></td>
                            <td>
                                <a href="profil-uzytkownika.php?id=<?php echo $row['ID_Uzytkownika']; ?>" class="btn btn-primary btn-sm">Edytuj</a>
                                <?php if ($row['ID_Uzytkownika'] != $logged_in_user_id): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['ID_Uzytkownika']); ?>">
                                        <button type="submit" name="toggle_status" class="btn btn-warning btn-sm">
                                            <?php echo $row['Dezaktywowany'] ? 'Aktywuj' : 'Dezaktywuj'; ?>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Brak użytkowników</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>
