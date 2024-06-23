<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5 ml-xl-2 d-flex align-items-center">
        <a href="panel-uzytkownika.php"><img src="../images/fevicon.png" id="logo-image" class="img-fluid"></a>
        <button class="navbar-toggler ms-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-2">
                <?php
                    $user_id = $_SESSION['user_id'];

                    include('../db_connection.php');

                    $query = "SELECT Imie FROM tbl_Uzytkownicy WHERE ID_Uzytkownika = '$user_id'";
                    $result = $conn->query($query);
                    $row = $result->fetch_assoc();
                    $user_name = $row['Imie'];

                    echo "<li class='nav-item'><a class='nav-link active' aria-current='page' href='profil-uzytkownika.php'><b>$user_name</b></a></li>";

                    $current_page = basename($_SERVER['PHP_SELF']);

                    if (strpos($current_page, 'panel-uzytkownika.php') !== false) {
                        echo '<li class="nav-item"><a class="nav-link active" id="showForm" aria-current="page" href="#"><b>Dodaj urządzenie</b></a></li>';
                    } else {
                        echo '<li class="nav-item"><a class="nav-link active" id="showForm" aria-current="page" href="panel-uzytkownika.php"><b>Panel urządzeń</b></a></li>';
                    }

                    echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="zglos-blad.php"><b>Zgłoś błąd</b></a></li>';
                
                if ($_SESSION['user_permission'] == 'Admin') {
                    echo "<li class='nav-item'><a class='nav-link active' aria-current='page' href='dashboard_users.php'><b>Dashboard</b></a></li>";
                }
                ?>
            </ul>

            <div class="ml-auto" id="wylogowanie">
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
        </div>
    </div>
</nav>