<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        die("Użytkownik nie jest zalogowany.");
    }

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        die("Nieprawidłowe żądanie.");
    }

    $user_id = $_SESSION['user_id'];

    $imie = $_POST['imie'] ?? '';
    $nazwisko = $_POST['nazwisko'] ?? '';
    $nrTelefonu = $_POST['nrTelefonu'] ?? '';
    $email = $_POST['email'] ?? '';

    $servername = "localhost";
    $username = "2025_mpalka21";
    $password = "palka_majczyk";
    $dbname = "2025_mpalka21";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE tbl_Uzytkownicy SET Imie = ?, Nazwisko = ?, NrTelefonu = ?, Email = ? WHERE ID_Uzytkownika = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $imie, $nazwisko, $nrTelefonu, $email, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Zmiany zostały zapisane.";
    } else {
        echo "Nie udało się zapisać zmian.";
    }

    $stmt->close();
    $conn->close();

    header("Location: panel-uzytkownika.php");
    exit();
?>