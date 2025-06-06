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

        <?php
            if (!isset($_SESSION['user_id'])) {
                header("Location: ../logowanie.php");
                exit();
            }

            include('../db_connection.php');

            $user_id = $_SESSION['user_id'];
            $sql = "SELECT Typ, Opis, Status, DataZgloszenia FROM tbl_Zgloszenia WHERE ID_Uzytkownika = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $zgloszenia = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $zgloszenia[] = $row;
                }
            }

            $stmt->close();
            $conn->close();
        ?>

        <!-- Section-->
        <section class="py-5">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card shadow-lg">
                            <div class="card-header text-center text-white bg-dark">
                                <h2><b>Lista zgłoszeń</b></h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Typ zgłoszenia</th>
                                            <th>Opis</th>
                                            <th>Status</th>
                                            <th>Data zgłoszenia</th> <!-- Dodana kolumna -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($zgloszenia)): ?>
                                            <tr>
                                                <td colspan="4" class="text-center">Brak zgłoszeń</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($zgloszenia as $zgloszenie): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($zgloszenie['Typ']); ?></td>
                                                    <td><?php echo htmlspecialchars($zgloszenie['Opis']); ?></td>
                                                    <td>
                                                        <?php 
                                                        $status = $zgloszenie['Status'];
                                                        $formatted_status = '';
                                                        
                                                        switch ($status) {
                                                            case 0:
                                                                $formatted_status = '<b style="color:blue;">Oczekuje na sprawdzenie</b>';
                                                                break;
                                                            case 1:
                                                                $formatted_status = '<b style="color:green;">Rozpatrzono pozytywnie</b>';
                                                                break;
                                                            case 2:
                                                                $formatted_status = '<b style="color:red;">Rozpatrzono negatywnie</b>';
                                                                break;
                                                            default:
                                                                $formatted_status = 'Nieznany status';
                                                        }
                                                        
                                                        echo $formatted_status;
                                                        ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($zgloszenie['DataZgloszenia']); ?></td> <!-- Dodana kolumna -->
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>