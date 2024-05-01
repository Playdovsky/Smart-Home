<html lang="pl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
  </head>
  
  <body>
      <section class="main">

        <div class="center">
          <h1>Zaloguj się</h1>
          <form method="post" name="logowanie">
            <div class="txt_field">
              <input type="text" name="email" required>
              <span></span>
              <label>E-mail</label>
            </div>
            <div class="txt_field">
              <input type="password" name="password" required>
              <span></span>
              <label>Hasło</label>
            </div>
            <div class="pass">Zapomniałeś hasło?</div>
            <input type="submit" value="Zaloguj się">
            <div class="signup_link">
              Nie masz konta? <a href="rejestracja.php">Zarejestruj się</a>
            </div>
            <?php
              if ($_SERVER["REQUEST_METHOD"] == "POST"){
                session_start();
                $servername = "localhost";
                $username = "2025_mpalka21";
                $password = "palka_majczyk";
                $dbname = "2025_mpalka21";

                $conn = new mysqli($servername, $username, $password, $dbname);

                $useremail = $_POST['email'];
                $userpassword = $_POST['password'];
                $check = "SELECT * FROM tbl_Uzytkownicy WHERE Email = '$useremail' AND Haslo = '$userpassword'";
                $result = $conn->query($check);

                if($result->num_rows > 0){
                  $row = $result->fetch_assoc();
                  $_SESSION['user_id'] = $row['ID_Uzytkownika'];
                  header("Location: panel-uzytkownika/panel-uzytkownika.php");
                  exit();
                }
                else{
                  echo "<p style='color: red; text-align: center; margin-bottom: 10px;'><b>Nieprawidłowe dane logowania.</b></p>";
                }

                mysqli_close($conn);
              }
            ?>
          </form>
        </div>
      </section>
  </body>
</html>