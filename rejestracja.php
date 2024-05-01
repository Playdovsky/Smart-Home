<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="#">
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
                <input type="text" name='nrtelefonu' required>
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

                  $conn = new mysqli($servername, $username, $password, $dbname);
                  
                  $imie = $_POST['imie'];
                  $nazwisko = $_POST['nazwisko'];
                  $nrtel = $_POST['nrtelefonu'];
                  $useremail = $_POST['email'];
                  $userpassword = $_POST['password'];

                  $adduser = "INSERT INTO tbl_Uzytkownicy (Imie, Nazwisko, NrTelefonu, Email, Haslo) VALUES ('$imie', '$nazwisko', '$nrtel', '$useremail', '$userpassword')";

                  if ($conn->query($adduser) === TRUE) {
                    echo "<script>
                    window.onload = function() {
                      alert('Rejestracja zakończona sukcesem! Spróbuj się teraz zalogować');
                      window.location.href = 'logowanie.php';
                    }
                    </script>";
                  }
                  $conn->close();
              }
            ?>
          </div>
    </section>
</body>
</html>