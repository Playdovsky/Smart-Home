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

    $sql_update = "UPDATE tbl_Uzytkownicy SET Dezaktywowany = 1 WHERE ID_Uzytkownika = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $user_id);
    $stmt_update->execute();

    if ($stmt_update->affected_rows > 0) {
        echo "Konto zostało dezaktywowane.";
    } else {
        echo "Nie udało się dezaktywować konta.";
    }

    $_SESSION = array();
    session_destroy();

    $stmt_update->close();
    $conn->close();

    header("Location: ../index.php");
    exit();
?>