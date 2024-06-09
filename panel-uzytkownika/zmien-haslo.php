<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Zmiana hasła</title>
        <link rel="stylesheet" href="../style.css">
        <link rel="icon" href="../images/fevicon.png" type="image/gif" />
    </head>
    <body>
        <section class="main">
            <div class="center">
                <h1>Zmiana hasła</h1>
                <form method="post" name="changePassword">
                    <div class="txt_field">
                        <input type="password" name="oldPassword" required>
                        <span></span>
                        <label>Stare hasło</label>
                    </div>
                    <div class="txt_field">
                        <input type="password" name="newPassword" required>
                        <span></span>
                        <label>Nowe hasło</label>
                    </div>
                    <div class="txt_field">
                        <input type="password" name="newConfirmPassword" required>
                        <span></span>
                        <label>Potwierdź nowe hasło</label>
                    </div>
                    <input type="submit" value="Zmień hasło">
                    <div class="signup_link">
                        <a href="panel-uzytkownika.php">Anulowanie procedury zmiany hasła</a>
                    </div>
                    
                    <?php
                        session_start();
                        include('../user_check.php');
                        
                        if (!isset($_SESSION['user_id'])) {
                            header("Location: ../logowanie.php");
                            exit();
                        }

                        if ($_SERVER["REQUEST_METHOD"] === "POST") {
                            $oldPassword = $_POST['oldPassword'] ?? '';
                            $newPassword = $_POST['newPassword'] ?? '';
                            $newConfirmPassword = $_POST['newConfirmPassword'] ?? '';

                            if (!preg_match("/^(?=.*[A-Z])(?=.*[0-9]).{8,}$/", $newPassword)) {
                                echo "<p style='color: red; text-align: center; margin-bottom: 10px;'><b>Nowe hasło musi zawierać minimum 8 znaków, przynajmniej jedną dużą literę i jedną cyfrę.</b></p>";
                                exit();
                            }

                            if ($newPassword !== $newConfirmPassword) {
                                echo "<p style='color: red; text-align: center; margin-bottom: 10px;'><b>Nowe hasło i potwierdzenie nowego hasła nie są identyczne.</b></p>";
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

                                $user_id = $_SESSION['user_id'];

                                $sql = "SELECT Haslo FROM tbl_Uzytkownicy WHERE ID_Uzytkownika = ?";
                                $stmt = $conn->prepare($sql);
                                if (!$stmt) {
                                    throw new Exception("Błąd przygotowania zapytania: " . $conn->error);
                                }
                                $stmt->bind_param("i", $user_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $hashed_password = $row['Haslo'];

                                    $salt = "Ms3Hx@j57dW2Nv1(bn$5Ah%";
                                    $salted_password = $salt.$oldPassword;
                                    $hashed_old_password = hash('sha256', $salted_password);
                                    $salt2 = "Nd2t%7m!8";
                                    $salted_old_password = $hashed_old_password.$salt2;
                                    $hashed_old_password2 = hash('sha256', $salted_old_password);

                                    if (hash_equals($hashed_password, $hashed_old_password2)) {
                                        $salted_new_password = $salt.$newPassword;
                                        $hashed_new_password = hash('sha256', $salted_new_password);
                                        $salted_new_password2 = $hashed_new_password.$salt2;
                                        $hashed_new_password2 = hash('sha256', $salted_new_password2);

                                        $update_sql = "UPDATE tbl_Uzytkownicy SET Haslo = ? WHERE ID_Uzytkownika = ?";
                                        $update_stmt = $conn->prepare($update_sql);
                                        if (!$update_stmt) {
                                            throw new Exception("Błąd przygotowania zapytania: " . $conn->error);
                                        }
                                        $update_stmt->bind_param("si", $hashed_new_password2, $user_id);
                                        if (!$update_stmt->execute()) {
                                            throw new Exception("Błąd wykonania zapytania: " . $conn->error);
                                        }

                                        $_SESSION = array();
                                        session_destroy();

                                        header("Location: ../logowanie.php");
                                        exit();
                                    } else {
                                        throw new Exception("Podane stare hasło jest nieprawidłowe.");
                                    }
                                } else {
                                    throw new Exception("Nie znaleziono użytkownika.");
                                }
                            } catch (Exception $e) {
                                echo "<p style='color: red; text-align: center; margin-bottom: 10px;'><b>".$e->getMessage()."</b></p>";
                            } finally {
                                if (isset($stmt)) $stmt->close();
                                if (isset($update_stmt)) $update_stmt->close();
                                if (isset($conn)) $conn->close();
                            }
                        }
                    ?>

                </form>
            </div>
        </section>
    </body>
</html>
