<!DOCTYPE html>
<html lang="pl">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Rejestracja</title>
      <link rel="stylesheet" href="css/ext-style.css">
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
  </head>
  <body>
      <section class="main">
          <header>
          </header>

          <div class="center">
              <h1>Zarejestruj się</h1>
              <form method="post" action="">
                <div class="txt_field">
                  <input type="text" name="imie" required>
                  <span></span>
                  <label>Imię</label>
                </div>
                <div class="txt_field">
                  <input type="text" name="nazwisko" required>
                  <span></span>
                  <label>Nazwisko</label>
                </div>
                <div class="txt_field">
                  <input type="tel" name="nrtelefonu" required>
                  <span></span>
                  <label>Nr telefonu</label>
                </div>
                <div class="txt_field">
                  <input type="email" name="email" required>
                  <span></span>
                  <label>E-mail</label>
                </div>
                <div class="txt_field">
                  <input type="password" name="password" required>
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
                  include('db_connection.php');

                  try {
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
                    
                    $check = "SELECT * FROM tbl_Uzytkownicy WHERE Email = ?";
                    $stmt_check = $conn->prepare($check);
                    $stmt_check->bind_param("s", $useremail);
                    $stmt_check->execute();
                    $result = $stmt_check->get_result();

                    if ($result->num_rows > 0) {
                      throw new Exception("Użytkownik o podanym emailu już istnieje.");
                    }
                    
                    $salt = "Ms3Hx@j57dW2Nv1(bn$5Ah%";
                    $salted_password = $salt . $userpassword;
                    $hashed_password = hash('sha256', $salted_password);
                    $salt2 = "Nd2t%7m!8";
                    $salted_password2 = $hashed_password . $salt2;
                    $hashed_password2 = hash('sha256', $salted_password2);
                    
                    $deactivated = 0;

                    $user_insert = $conn->prepare("INSERT INTO tbl_Uzytkownicy (Imie, Nazwisko, NrTelefonu, Email, Haslo, Dezaktywowany) VALUES (?, ?, ?, ?, ?, ?)");
                    $user_insert->bind_param("sssssi", $imie, $nazwisko, $nrtel, $useremail, $hashed_password2, $deactivated);
                    $user_insert->execute();

                    $id_uzytkownika_query = $conn->prepare("SELECT ID_Uzytkownika FROM tbl_Uzytkownicy WHERE Email = ?");
                    $id_uzytkownika_query->bind_param("s", $useremail);
                    $id_uzytkownika_query->execute();
                    $result_id = $id_uzytkownika_query->get_result();

                    if ($result_id->num_rows > 0) {
                      $row = $result_id->fetch_assoc();
                      $id_uzytkownika = $row['ID_Uzytkownika'];
                      $user_permissions_insert = $conn->prepare("INSERT INTO tbl_UprawnieniaUzytkownikow (ID_Uzytkownika, TypUprawnienia) VALUES (?, 'User')");
                      $user_permissions_insert->bind_param("i", $id_uzytkownika);
                      $user_permissions_insert->execute();

                      echo "<script>
                              window.onload = function() {
                                alert('Rejestracja zakończona sukcesem! Spróbuj się teraz zalogować');
                                window.location.href = 'logowanie.php';
                              }
                            </script>";
                    } else {
                      throw new Exception("Błąd podczas pobierania ID użytkownika.");
                    }

                    $user_insert->close();
                    $id_uzytkownika_query->close();
                    $user_permissions_insert->close();
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
