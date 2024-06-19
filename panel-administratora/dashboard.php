<?php
session_start();
include('admin_check.php');
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
        <!--<link href="css/styles.css" rel="stylesheet" />-->

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
    
    <div class="wrapper">
        <nav class="sidebar">
            <div class="nav-items">
                <a href="">coś tu będzie</a>
                <a href="">Użytkownicy</a>
                <a href="">Urządzenia</a>
                <a href="">Zgłoszenia</a>
            </div>
        </nav>
        <main>
            <h2>Dashboard</h2>
            <h3>Coś tu będzie</h3>
            <div class="posts">
                <div class="box box-content">
                    <div class="box-text">
                        <h4>Coś tu będzie</h4>
                        <a href="#">Edytuj</a>
                        <a href="#">Usuń</a>
                    </div>
                </div>
                <div class="box">
                    <div class="box-text">
                        <h4>Coś tu będzie</h4>
                        <a href="#">Edytuj</a>
                        <a href="#">Usuń</a>
                    </div>
                </div>
                <div class="box">
                    <div class="box-text">
                        <h4>Coś tu będzie</h4>
                        <a href="#">Edytuj</a>
                        <a href="#">Usuń</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>