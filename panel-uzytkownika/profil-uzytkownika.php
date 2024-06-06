<html lang="en">
    <?php
        session_start();
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


    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5 ms-xl-2">
                <a href="panel-uzytkownika.php"><img src="../images/fevicon.png" id="logo-image" class="img-fluid"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-2">

                    <?php
                        $user_id = $_SESSION['user_id'];

                        $servername = "localhost";
                        $username = "2025_mpalka21";
                        $password = "palka_majczyk";
                        $dbname = "2025_mpalka21";

                        $conn = new mysqli($servername, $username, $password, $dbname);

                        $query = "SELECT Imie FROM tbl_Uzytkownicy WHERE ID_Uzytkownika = '$user_id'";
                        $result = $conn->query($query);
                        $row = $result->fetch_assoc();
                        $user_name = $row['Imie'];

                        echo "<li class='nav-item'><a class='nav-link active' aria-current='page' href='profil-uzytkownika.php'><b>$user_name</b></a></li>";
                    ?>
                    <li class="nav-item"><a class="nav-link active" id="showForm" aria-current="page" href="panel-uzytkownika.php"><b>Panel urządzeń</b></a></li>
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!"><b>Zgłoś błąd</b></a></li>
                    <!--
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><b>Urządzenia</b></a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!">Dodaj</a></li>
                            <li><a class="dropdown-item" href="#!">Modyfikuj</a></li>
                            <li><a class="dropdown-item" href="#!">Usuń</a></li>
                        </ul>
                    </li>
                    -->
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
            session_start();

            if (!isset($_SESSION['user_id'])) {
                die("Użytkownik nie jest zalogowany.");
            }

            $user_id = $_SESSION['user_id'];

            $servername = "localhost";
            $username = "2025_mpalka21";
            $password = "palka_majczyk";
            $dbname = "2025_mpalka21";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

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

                                            $servername = "localhost";
                                            $username = "2025_mpalka21";
                                            $password = "palka_majczyk";
                                            $dbname = "2025_mpalka21";

                                            $conn = new mysqli($servername, $username, $password, $dbname);

                                            if ($conn->connect_error) {
                                                throw new Exception("Błąd połączenia z bazą danych: " . $conn->connect_error);
                                            }

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

                                        $stmt->close();
                                        $updateStmt->close();
                                        $conn->close();

                                        header("Location: profil-uzytkownika.php");
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