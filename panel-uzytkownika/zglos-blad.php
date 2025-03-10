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
    </head>
    <body>
        <?php
            include('naglowek.php');
        ?>

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

                                    include('../db_connection.php');

                                    try {

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