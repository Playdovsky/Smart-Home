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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="zglos-blad.php"><b>Zgłoś błąd</b></a></li>
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
                    <h1 class="display-4 fw-bolder text-black">ZGŁOSZENIA</h1>
                    <p class="lead fw-normal text-black-50 mb-0">Panel do zgłaszania błędów oraz incydentów</p>
                </div>
            </div>
        </header>

        <!-- Section-->
        <section class="py-5">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-header text-center text-white bg-dark">
                                <h2><b>Formularz zgłoszeniowy</b></h2>
                            </div>
                            <div class="card-body">
                                <form id="reportForm" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label text-black">Typ zgłoszenia:</label>
                                        <select class="form-control" id="inputTyp" name="typ" required>
                                            <option value="Błąd strony">Błąd strony</option>
                                            <option value="Błąd profilu">Błąd profilu</option>
                                            <option value="Błąd urządzenia">Błąd urządzenia</option>
                                            <option value="Propozycja zmiany">Propozycja zmiany</option>
                                            <option value="Inne">Inne</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-black">Opis:</label>
                                        <textarea class="form-control" id="inputOpis" name="opis" rows="4" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-2" id="sendReportBtn">Wyślij zgłoszenie</button>
                                    <a href="lista-zgloszen.php" class = "btn btn-secondary mb-2">Twoja lista zgłoszeń</a>
                                    <div id="responseMessage"></div>
                                </form>
                            </div>

                            <?php
                                if (!isset($_SESSION['user_id'])) {
                                    echo "<p style='color: red; text-align: center; margin-bottom: 10px;'><b>Musisz być zalogowany, aby wysłać zgłoszenie.</b></p>";
                                    exit();
                                }

                                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                                    $typ = $_POST['typ'] ?? '';
                                    $opis = $_POST['opis'] ?? '';
                                    $user_id = $_SESSION['user_id'];

                                    if (empty($typ) || empty($opis)) {
                                        echo "<p style='color: red; text-align: center; margin-bottom: 10px;'><b>Typ i opis zgłoszenia są wymagane.</b></p>";
                                        exit();
                                    }

                                    $servername = "localhost";
                                    $username = "2025_mpalka21";
                                    $password = "palka_majczyk";
                                    $dbname = "2025_mpalka21";

                                    try {
                                        $conn = new mysqli($servername, $username, $password, $dbname);

                                        if ($conn->connect_error) {
                                            throw new Exception("Błąd połączenia z bazą danych: " . $conn->connect_error);
                                        }

                                        $insertQuery = "INSERT INTO tbl_Zgloszenia (ID_Uzytkownika, Typ, Opis, Status, DataZgloszenia) VALUES (?, ?, ?, 0, NOW())";
                                        $stmt = $conn->prepare($insertQuery);
                                        if (!$stmt) {
                                            throw new Exception("Błąd przygotowania zapytania: " . $conn->error);
                                        }
                                        $stmt->bind_param("iss", $user_id, $typ, $opis);
                                        if (!$stmt->execute()) {
                                            throw new Exception("Błąd wykonania zapytania: " . $conn->error);
                                        }

                                        echo "<p style='color: green; text-align: center; margin-bottom: 10px;'><b>Zgłoszenie zostało wysłane.</b></p>";
                                    } catch (Exception $e) {
                                        echo "<p style='color: red; text-align: center; margin-bottom: 10px;'><b>" . $e->getMessage() . "</b></p>";
                                    }

                                    $stmt->close();
                                    $conn->close();

                                    exit();
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>