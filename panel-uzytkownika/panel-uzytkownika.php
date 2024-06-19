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

<html lang="en">

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
        <!--<link href="css/styles.css" rel="stylesheet" />-->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/overlay.js"></script>
    </head>
    <body>
        <?php
            include('naglowek.php');
        ?>

        <!-- Header-->
        <header class="py-2" style="background-color: rgb(192, 192, 192);">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center">
                    <h1 class="display-4 fw-bolder text-black">PANEL URZĄDZEŃ</h1>
                    <p class="lead fw-normal text-black-50 mb-0">Centrum sterowania twoimi urządzeniami SMART</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">

            <?php
                $user_id = $_SESSION['user_id'];

                include('../db_connection.php');

                $sql = "SELECT su.ID_SprzetUzytkownika, ss.Nazwa, ss.Sciezka, us.Nazwa AS 'NazwaSprzetuUzytkownika'
                        FROM tbl_SprzetUzytkownikow su 
                        JOIN tbl_SprzetSmart ss ON su.ID_SprzetSmart = ss.ID_SprzetSmart
                        JOIN tbl_UstawieniaSprzetu us ON us.ID_SprzetUzytkownika = su.ID_SprzetUzytkownika
                        WHERE su.ID_Uzytkownika = ?";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                echo '<div class="container px-4 px-lg-5 mt-5">';
                echo '<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-3 justify-content-center">';
                while($row = $result->fetch_assoc()) {
                    $image_path = !empty($row['Sciezka']) ? '../images/' . htmlspecialchars($row['Sciezka']) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg';
                    echo '<div class="col mb-5">
                            <div class="card h-100">
                                <img class="card-img-top custom-img" src="' . $image_path . '" alt="..." />
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h5 class="fw-bolder text-black">' . htmlspecialchars($row['NazwaSprzetuUzytkownika']) . '</h5>
                                    </div>
                                </div>
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center">
                                        <a class="btn btn-outline-dark mt-auto showFormOptions" href="#" data-device-id="' . $row['ID_SprzetUzytkownika'] . '">Opcje</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
                
                echo '</div>';
                echo '</div>';

                $stmt->close();
                $conn->close();
            ?>

        </section>
        
        <div id="overlayOptions" class="overlay d-none">
            <div>
                <h3>Opcje urządzenia</h3>
                <form method="post" id="deviceOptionsForm">
                    <div id="deviceOptionsContent">
                        <!--Dynamicznie pobierana zawartość z dane-urzadzenia.php-->
                    </div>

                    <input type="hidden" id="deviceId" name="device_id" value="<?php echo $row['ID_SprzetUzytkownika']; ?>">
                    <button type="button" id="saveForm" class="btn btn-primary" data-device-id="">Zapisz</button>
                    <button type="button" id="hideFormOptions" class="btn btn-secondary">Anuluj</button>
                    <button type="button" id="deleteForm" class="btn btn-danger" data-device-id="">Usuń</button>
                </form>
            </div>
        </div>

        <div id="overlay" class="overlay d-none">
            <div>
                <h3>Dodaj nowe urządzenie</h3>
                <form action="dodawanie-urzadzenia.php" method="post">
                    <div class="mb-3">
                        <label for="deviceName" class="form-label">Nazwa urządzenia</label>
                        <?php                            
                            $user_id = $_SESSION['user_id'];
                            
                            include('../db_connection.php');

                            $sql = "SELECT DISTINCT Nazwa FROM tbl_SprzetSmart";
                            $result = $conn->query($sql);
                        ?>

                        <select id="deviceName" name="deviceName" class="form-control" required>
                            <?php
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['Nazwa'] . "'>" . $row['Nazwa'] . "</option>";
                                }
                            ?>
                        </select>

                        <?php
                            $conn->close();
                        ?>

                    </div>
                    <div class="mb-3">
                        <label for="deviceNumber" class="form-label">Numer rejestracyjny</label>
                        <input type="text" class="form-control" id="deviceNumber" name="deviceNumber" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Dodaj</button>
                    <button type="button" id="hideForm" class="btn btn-secondary">Anuluj</button>
                </form>
            </div>
        </div>
    </body>
</html>