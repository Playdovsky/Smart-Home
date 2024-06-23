<?php
session_start();
include('../admin_check.php');
include('../db_connection.php'); 
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
    <style>
        .preview {
            display: none;
            position: absolute;
            border: 1px solid #ccc;
            background: #fff;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .preview img {
            max-width: 200px;
            max-height: 200px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.device-name').hover(function(e) {
                var imgSrc = $(this).data('img');
                $('#preview').html('<img src="' + imgSrc + '" alt="Podgląd">').css({
                    top: e.pageY + 5 + 'px',
                    left: e.pageX + 5 + 'px'
                }).show();
            }, function() {
                $('#preview').hide();
            });

            $('.device-name').mousemove(function(e) {
                $('#preview').css({
                    top: e.pageY + 5 + 'px',
                    left: e.pageX + 5 + 'px'
                });
            });
        });
    </script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5 ms-xl-2">
        <a href="dashboard.php"><img src="../images/fevicon.png" id="logo-image" class="img-fluid"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-2">
            <li class="nav-item"><a class="nav-link active" aria-current="page" href="panel-uzytkownika.php"><b>Widok użytkownika</b></a></li>
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
            <a href="dashboard_users.php">Użytkownicy</a>
            <a href="dashboard_urzadzenia.php">Urządzenia</a>
            <a href="dashboard_reports.php">Zgłoszenia</a>
        </div>
    </nav>
    <main>
        <h2>Dashboard</h2>
        <div class="d-flex align-items-center">
            <h3 class="me-3">Urządzenia</h3>
            <a href="dashboard_dodawanieUrzadzen.php" class="btn btn-success mb-3">Dodaj sprzęt</a>
        </div>        
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Typ</th>
                    <th>Nazwa</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT ID_SprzetSmart, Typ, Nazwa, Sciezka FROM tbl_SprzetSmart";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $imagePath = "../images/" . htmlspecialchars($row['Sciezka']);
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['Typ']) . "</td>";
                        echo "<td class='device-name' data-img='" . $imagePath . "'>" . htmlspecialchars($row['Nazwa']) . "</td>";
                        echo "<td><a href='dashboard_edycjaUrzadzen.php?id=" . $row['ID_SprzetSmart'] . "' class='btn btn-primary'>Edytuj</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Brak urządzeń w bazie.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div id="preview" class="preview"></div>
    </main>
</div>
</body>
</html>
