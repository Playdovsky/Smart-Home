<?php
session_start();
include('../user_check.php');
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

                    <li class="nav-item"><a class="nav-link active" id="showForm" aria-current="page" href="#"><b>Dodaj urządzenie</b></a></li>
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
                    <h1 class="display-4 fw-bolder text-black">PANEL URZĄDZEŃ</h1>
                    <p class="lead fw-normal text-black-50 mb-0">Centrum sterowania twoimi urządzeniami SMART</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">

            <?php
                $user_id = $_SESSION['user_id'];

                $servername = "localhost";
                $username = "2025_mpalka21";
                $password = "palka_majczyk";
                $dbname = "2025_mpalka21";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT su.ID_SprzetUzytkownika, us.Nazwa 
                        FROM tbl_SprzetUzytkownikow su 
                        JOIN tbl_UstawieniaSprzetu us
                        ON su.ID_SprzetUzytkownika = us.ID_SprzetUzytkownika 
                        WHERE su.ID_Uzytkownika = ?";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                echo '<div class="container px-4 px-lg-5 mt-5">';
                    echo '<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-3 justify-content-center">';
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="col mb-5">
                                <div class="card h-100">
                                    <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <h5 class="fw-bolder text-black">' . htmlspecialchars($row['Nazwa']) . '</h5>
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
                            session_start();
                            
                            $user_id = $_SESSION['user_id'];

                            $servername = "localhost";
                            $username = "2025_mpalka21";
                            $password = "palka_majczyk";
                            $dbname = "2025_mpalka21";

                            $conn = new mysqli($servername, $username, $password, $dbname);

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

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