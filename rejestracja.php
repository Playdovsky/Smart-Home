<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
</head>
<body>
    <section class="main">
        <header>
        </header>

        <div class="center">
            <h1>Zarejestruj się</h1>
            <form method="post">

              <div class="txt_field">
                <input type="text" name='imie' required>
                <span></span>
                <label>Imię</label>
              </div>
              <div class="txt_field">
                <input type="text" name='nazwisko' required>
                <span></span>
                <label>Nazwisko</label>
              </div>
              <div class="txt_field">
                <input type="tel" name='nrtelefonu' required>
                <span></span>
                <label>Nr telefonu</label>
              </div>
              <div class="txt_field">
                <input type="text" name='email' required>
                <span></span>
                <label>E-mail</label>
              </div>
              <div class="txt_field">
                <input type="password" name='password' required>
                <span></span>
                <label>Hasło</label>
              </div>
              <input type="submit" value="Zarejestruj się">
              <div class="signup_link">
                Masz już konto? <a href="logowanie.php">Wróć do logowania</a>
              </div>
            </form>

            <?php
              if ($_SERVER["REQUEST_METHOD"] == "POST"){
                $servername = "localhost";
                $username = "2025_mpalka21";
                $password = "palka_majczyk";
                $dbname = "2025_mpalka21";

                try {
                  $conn = new mysqli($servername, $username, $password, $dbname);
                  
                  $imie = $_POST['imie'];
                  $nazwisko = $_POST['nazwisko'];
                  $nrtel = $_POST['nrtelefonu'];
                  $useremail = $_POST['email'];
                  $userpassword = $_POST['password'];

                  $nrtel = str_replace([' ', '-'], '', $nrtel);

                  if (!preg_match("/^[0-9]{9}$/", $nrtel)) {
                    throw new Exception("Nieprawidłowy numer telefonu.");
                  }

                  if (!filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("Nieprawidłowy adres email.");
                  }

                  if (!preg_match("/^(?=.*[A-Z])(?=.*[0-9]).{8,}$/", $userpassword)) {
                    throw new Exception("Hasło musi zawierać minimum 8 znaków, przynajmniej jedną dużą literę i jedną cyfrę.");
                  }
                  
                  $check = "SELECT * FROM tbl_Uzytkownicy WHERE Email = '$useremail'";
                  $result = $conn->query($check);

                  if($result->num_rows > 0){
                    throw new Exception("Użytkownik o podanym emailu już istnieje.");
                  }
                  
                  $salt = "Ms3Hx@j57dW2Nv1(bn$5Ah%";
                  $salted_password = $salt.$userpassword;
                  $hashed_password = hash('sha256', $salted_password);
                  $salt2 = "Nd2t%7m!8";
                  $salted_password2 = $hashed_password.$salt2;
                  $hashed_password2 = hash('sha256', $salted_password2);
                  
                  $deactivated = 0;

                  $user_insert = $conn->prepare("INSERT INTO tbl_Uzytkownicy (Imie, Nazwisko, NrTelefonu, Email, Haslo, Dezaktywowany) VALUES (?, ?, ?, ?, ?, ?)");
                  $user_insert->bind_param("sssss", $imie, $nazwisko, $nrtel, $useremail, $hashed_password2, $deactivated);
                  $user_insert->execute();

                  $id_uzytkownika_query = $conn->query("SELECT ID_Uzytkownika FROM tbl_Uzytkownicy WHERE Email = '$useremail'");
                  $row = $id_uzytkownika_query->fetch_assoc();
                  $id_uzytkownika = $row['ID_Uzytkownika'];
                  $user_permissions_insert = $conn->query("INSERT INTO tbl_UprawnieniaUzytkownikow (ID_Uzytkownika, TypUprawnienia) VALUES ('$id_uzytkownika', 'User')");

                  echo "<script>
                          window.onload = function() {
                            alert('Rejestracja zakończona sukcesem! Spróbuj się teraz zalogować');
                            window.location.href = 'logowanie.php';
                          }
                        </script>";

                  $user_insert->close();
                  $conn->close();

                } catch (Exception $e) {
                  echo "<p style='color: red; text-align: center; margin-bottom: 10px;'><b>".$e->getMessage()."</b></p>";
                }
              }
            ?>

          </div>
    </section>
</body>
</html>