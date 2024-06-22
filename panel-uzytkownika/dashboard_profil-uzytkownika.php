<?php
session_start();
include('../admin_check.php');
include('../db_connection.php');

if (!isset($_GET['id'])) {
    die("Nie podano ID użytkownika.");
}

$user_id = intval($_GET['id']);

// Obsługa aktualizacji danych użytkownika
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $imie = $_POST['imie'] ?? '';
    $nazwisko = $_POST['nazwisko'] ?? '';
    $nrTelefonu = $_POST['nrTelefonu'] ?? '';
    $email = $_POST['email'] ?? '';

    try {
        $nrTelefonu = str_replace([' ', '-'], '', $nrTelefonu);
        if (!preg_match("/^[0-9]{9}$/", $nrTelefonu)) {
            throw new Exception("Nieprawidłowy numer telefonu.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Nieprawidłowy adres email.");
        }

        $sql = "SELECT Email FROM tbl_Uzytkownicy WHERE ID_Uzytkownika = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $current_email = $row['Email'];

            if ($email != $current_email) {
                $checkEmailQuery = "SELECT Email FROM tbl_Uzytkownicy WHERE Email = ?";
                $checkEmailStmt = $conn->prepare($checkEmailQuery);
                $checkEmailStmt->bind_param("s", $email);
                $checkEmailStmt->execute();
                $checkEmailResult = $checkEmailStmt->get_result();

                if ($checkEmailResult->num_rows > 0) {
                    throw new Exception("Podany adres email jest już zajęty.");
                }
            }

            $update_query = "UPDATE tbl_Uzytkownicy SET Imie = ?, Nazwisko = ?, NrTelefonu = ?, Email = ? WHERE ID_Uzytkownika = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ssssi", $imie, $nazwisko, $nrTelefonu, $email, $user_id);

            if ($update_stmt->execute()) {
                $message = "Dane zostały pomyślnie zaktualizowane.";
                header("Location: profil-uzytkownika.php?id=$user_id");
                exit();
            } else {
                throw new Exception("Błąd aktualizacji danych.");
            }

            $update_stmt->close();
        } else {
            throw new Exception("Użytkownik nie istnieje.");
        }

        $stmt->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }

    $conn->close();
}

// Pobranie danych użytkownika z bazy danych
$sql = "SELECT Imie, Nazwisko, NrTelefonu, Email FROM tbl_Uzytkownicy WHERE ID_Uzytkownika = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imie = htmlspecialchars($row['Imie']);
    $nazwisko = htmlspecialchars($row['Nazwisko']);
    $nrTelefonu = htmlspecialchars($row['NrTelefonu']);
    $email = htmlspecialchars($row['Email']);
} else {
    die("Nie znaleziono danych użytkownika.");
}

$stmt->close();
$conn->close();
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
                <li class="nav-item"><a class="nav-link active" id="showForm" aria-current="page" href="panel-uzytkownika.php"><b>Panel urządzeń</b></a></li>
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
                <h1 class="display-4 fw-bolder text-black">PROFIL UŻYTKOWNIKA</h1>
                <p class="lead fw-normal text-black-50 mb-0"><?php echo $imie . " " . $nazwisko; ?></p>
            </div>
        </div>
    </header>
    <section class="py-5">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header text-center text-white bg-dark">
                            <h2><b><?php echo $imie . " " . $nazwisko; ?></b></h2>
                        </div>
                        <div class="card-body">
                            <?php if (isset($message)) { echo "<div class='alert alert-success'>$message</div>"; } ?>
                            <?php if (isset($error_message)) { echo "<div class='alert alert-danger'>$error_message</div>"; } ?>
                            <form id="profileForm" method="POST" action="">
                                <div class="mb-3">
                                    <label class="form-label text-black">Imię:</label>
                                    <input type="text" class="form-control" name="imie" value="<?php echo $imie; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-black">Nazwisko:</label>
                                    <input type="text" class="form-control" name="nazwisko" value="<?php echo $nazwisko; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-black">Numer telefonu:</label>
                                    <input type="text" class="form-control" name="nrTelefonu" value="<?php echo $nrTelefonu; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-black">Adres email:</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Zapisz zmiany</button>
                                <div id="responseMessage"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
