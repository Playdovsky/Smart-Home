<html lang="en">
<?php
    session_start();
    include('../db_connection.php');
    include('../user_check.php');

    // Sprawdź, czy użytkownik jest administratorem
    $user_id = $_SESSION['user_id'];
    $query = "SELECT u.Imie, up.TypUprawnienia 
            FROM tbl_Uzytkownicy u
            JOIN tbl_UprawnieniaUzytkownikow up ON u.ID_Uzytkownika = up.ID_Uzytkownika
            WHERE u.ID_Uzytkownika = '$user_id'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $user_name = $row['Imie'];
    $user_permission = $row['TypUprawnienia'];

    // Przechowuj uprawnienia użytkownika w zmiennej sesyjnej
    $_SESSION['user_permission'] = $user_permission;
?>

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
        <!--<link href="css/styles.css" rel="stylesheet" />-->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/profil.js"></script>
    </head>
    <body>
        <?php
            include('naglowek.php');
        ?>

        <!-- Header-->
        <header class="py-2" style="background-color: rgb(192, 192, 192);">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center">
                    <h1 class="display-4 fw-bolder text-black">PROFIL UŻYTKOWNIKA</h1>
                    <p class="lead fw-normal text-black-50 mb-0">Twój profil w Smart-Future</p>
                </div>
            </div>
        </header>

        <?php
            if (!isset($_SESSION['user_id'])) {
                die("Użytkownik nie jest zalogowany.");
            }

            $user_id = $_SESSION['user_id'];

            include('../db_connection.php');

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

        <!-- Section-->
        <section class="py-5">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-header text-center text-white bg-dark">
                                <h2><b><?php echo $imie . " " . $nazwisko; ?></b></h2>
                            </div>
                            <div class="card-body">
                                <form id="profileForm" method="POST">
                                    <div class="mb-3 hidden">
                                        <label class="form-label text-black">Imię:</label>
                                        <input type="text" class="form-control" id="inputImie" name="imie" value="<?php echo $imie; ?>" required>
                                    </div>
                                    <div class="mb-3 hidden">
                                        <label class="form-label text-black">Nazwisko:</label>
                                        <input type="text" class="form-control" id="inputNazwisko" name="nazwisko" value="<?php echo $nazwisko; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-black">Numer telefonu:</label>
                                        <input type="text" class="form-control" id="inputNrTelefonu" name="nrTelefonu" value="<?php echo $nrTelefonu; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-black">Adres email:</label>
                                        <input type="email" class="form-control" id="inputEmail" name="email" value="<?php echo $email; ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-2 hidden" id="saveChangesBtn">Zapisz zmiany</button>
                                    <a href="zmien-haslo.php" class="btn btn-primary mb-2" id="changePasswordBtn">Zmień hasło</a>
                                    <a href="dezaktywuj-konto.php" class="btn btn-danger mb-2" id="deactivateAccountBtn">Dezaktywuj konto</a>
                                    <div id="responseMessage"></div>
                                </form>

                                <?php
                                    if (!isset($_SESSION['user_id'])) {
                                        header("Location: ../logowanie.php");
                                        exit();
                                    }

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

                                            include('../db_connection.php');

                                            $user_id = $_SESSION['user_id'];

                                            $sql = "SELECT Email FROM tbl_Uzytkownicy WHERE ID_Uzytkownika = ?";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bind_param("i", $user_id);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                $current_email = $row['Email'];

                                                if ($email != $current_email) {
                                                    $checkEmailQuery = "SELECT * FROM tbl_Uzytkownicy WHERE Email = ?";
                                                    $checkEmailStmt = $conn->prepare($checkEmailQuery);
                                                    if (!$checkEmailStmt) {
                                                        throw new Exception("Błąd przygotowania zapytania: " . $conn->error);
                                                    }
                                                    $checkEmailStmt->bind_param("s", $email);
                                                    $checkEmailStmt->execute();
                                                    $checkEmailResult = $checkEmailStmt->get_result();

                                                    if ($checkEmailResult->num_rows > 0) {
                                                        throw new Exception("Użytkownik o podanym adresie email już istnieje.");
                                                    }
                                                }
                                            }

                                            $updateQuery = "UPDATE tbl_Uzytkownicy SET Imie = ?, Nazwisko = ?, NrTelefonu = ?, Email = ? WHERE ID_Uzytkownika = ?";
                                            $updateStmt = $conn->prepare($updateQuery);
                                            if (!$updateStmt) {
                                                throw new Exception("Błąd przygotowania zapytania: " . $conn->error);
                                            }
                                            $updateStmt->bind_param("ssssi", $imie, $nazwisko, $nrTelefonu, $email, $user_id);
                                            if (!$updateStmt->execute()) {
                                                throw new Exception("Błąd wykonania zapytania: " . $conn->error);
                                            }

                                            echo "<p style='color: green; text-align: center; margin-bottom: 10px;'><b>Zmiany zostały zapisane i będą gotowe po odświeżeniu strony.</b></p>";

                                        } catch (Exception $e) {
                                            echo "<p style='color: red; text-align: center; margin-bottom: 10px;'><b>" . $e->getMessage() . "</b></p>";
                                        }

                                        exit();
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>