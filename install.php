<!DOCTYPE html>
    <html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Instalacja</title>
        <link rel="stylesheet" href="css/ext-style.css">
        <link rel="icon" href="images/fevicon.png" type="image/gif" />
    </head>

    <body>
        <section class="main">
            <div class="center">
            <?php
                $config_file = "db_connection.php";
                $step = isset($_POST['step']) ? intval($_POST['step']) : 1;
                echo "<h1>Instalator<br>krok $step</h1>";

                function form_install_1(){
                    echo "<form method='post' name='instalacja'>
                            <div class='txt_field'>
                                <input type='text' name='host' required>
                                <span></span>
                                <label>Nazwa lub adres serwera</label>
                            </div>
                            <div class='txt_field'>
                                <input type='text' name='dbname' required>
                                <span></span>
                                <label>Nazwa bazy danych</label>
                            </div>
                            <div class='txt_field'>
                                <input type='text' name='user' required>
                                <span></span>
                                <label>Nazwa użytkownika</label>
                            </div>
                            <div class='txt_field'>
                                <input type='password' name='passwd' required>
                                <span></span>
                                <label>Hasło</label>
                            </div>
                            <input type='hidden' name='step' value='2'>
                            <input type='submit' value='Krok 2'>
                        </form>";
                }

                function step2(){
                    global $config_file, $prefix, $conn, $dbname;
                    $file = fopen($config_file, "w");
                    if (!$file) {
                        die("Nie mogę otworzyć pliku $config_file");
                    }
                
                    $host = $_POST['host'];
                    $user = $_POST['user'];
                    $password = $_POST['passwd'];
                    $dbname = $_POST['dbname'];
                
                    $conn = mysqli_connect($host, $user, $password, $dbname);
                    if (!$conn) {
                        header("Location: install.php");
                        die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
                    }
                
                    $data_powstania = date('Y-m-d');
                
                    $config = "<?php
                    \$host = \"$host\";
                    \$user = \"$user\";
                    \$password = \"$password\";
                    \$dbname = \"$dbname\";
                    \$prefix = \"tbl\";
                    \$base_url = \"https://www.manticore.uni.lodz.pl/~mpalka21/Smart-Home/\";
                    \$nazwa_aplikacji = \"Smart-Home\";
                    \$data_powstania = \"$data_powstania\";
                    \$brand = \"Smart-Future\";
                    \$adres = \"Rewolucji 1905 r.\";
                    \$adres2 = \"Łódź, 90-221\";
                    \$phone = \"742325752\";
                    \$conn = mysqli_connect(\$host, \$user, \$password, \$dbname);
                    if (!\$conn) {
                        if(file_exists('db_connection.php')){
                            header('Location: install.php');
                            exit;             
                        }
                        else{
                            echo 'Błąd połączenia';
                        }       
                    }
                    ?>\n";
                
                    if (!fwrite($file, $config)) { 
                        die("Nie mogę zapisać do pliku ($file)"); 
                    }
                
                    fclose($file); 
                
                    echo "<p>Krok 2 zakończony: \n";
                    echo "Plik konfiguracyjny utworzony</p>"; 
                    echo "<form method='post'>
                            <input type='hidden' name='step' value='3'>
                            <input type='submit' value='Krok 3'>
                        </form>";

                }                
                    
                function step3() {
                    global $conn, $dbname, $create;
                    include "db_connection.php";
                    if (file_exists("sql/sql.php")) {
                        include("sql/sql.php");
                        echo "Tworzę tabele bazy: ".$dbname.".<br>\n";
                        mysqli_select_db($conn, $dbname) or die(mysqli_error($conn));
                        for ($i = 0; $i < count($create); $i++) {
                            mysqli_query($conn, $create[$i]);
                        }
                        
                        echo "<form method='post'>
                                <input type='hidden' name='step' value='4'>
                                <input type='submit' value='Krok 4'>
                            </form>";
                    } else {
                        echo "Brak pliku sql/sql.php";
                    }
                }
                
                function step4(){
                    global $conn, $dbname, $insert;
                    include "db_connection.php";
                    if (file_exists("sql/insert.php")) {
                        include("sql/insert.php");
                        echo "<p>Wstawiam dane do tabel bazy: ".$dbname.".</p>\n";
                        mysqli_select_db($conn, $dbname) or die(mysqli_error($conn));
                        for ($i = 0; $i < count($insert); $i++) {
                            mysqli_query($conn, $insert[$i]);
                        }
                        echo "<form method='post'>
                                <input type='hidden' name='step' value='5'>
                                <input type='submit' value='Krok 5'>
                            </form>";
                    } else {
                        echo "Brak pliku sql/insert.php";
                    }
                }

                function renderRegistrationForm($errors = []) {
                    session_start();
                    $imie = isset($_SESSION['imie']) ? $_SESSION['imie'] : '';
                    $nazwisko = isset($_SESSION['nazwisko']) ? $_SESSION['nazwisko'] : '';
                    $nrtel = isset($_SESSION['nrtelefonu']) ? $_SESSION['nrtelefonu'] : '';
                    $useremail = isset($_SESSION['email']) ? $_SESSION['email'] : '';
                    if (!empty($errors)) {
                        echo "<p style='color: red; text-align: center; margin-bottom: 10px;'><b>".implode("<br>", $errors)."</b></p>";
                    }
                    echo "<form method='post' name='rejestracja_admina'>
                            <div class='txt_field'>
                                <input type='text' name='imie' value='$imie' required>
                                <span></span>
                                <label>Imię</label>
                            </div>
                            <div class='txt_field'>
                                <input type='text' name='nazwisko' value='$nazwisko' required>
                                <span></span>
                                <label>Nazwisko</label>
                            </div>
                            <div class='txt_field'>
                                <input type='tel' name='nrtelefonu' value='$nrtel' required>
                                <span></span>
                                <label>Nr telefonu</label>
                            </div>
                            <div class='txt_field'>
                                <input type='email' name='email' value='$useremail' required>
                                <span></span>
                                <label>E-mail</label>
                            </div>
                            <div class='txt_field'>
                                <input type='password' name='password' required>
                                <span></span>
                                <label>Hasło</label>
                            </div>
                            <div class='txt_field'>
                                <input type='password' name='passwordAgain' required>
                                <span></span>
                                <label>Powtórz hasło</label>
                            </div>
                            <input type='hidden' name='step' value='5'>
                            <input type='submit' value='Krok 6'>
                        </form>
                    </div>";
                }
                
                function processRegistration() {
                    include('db_connection.php');
                    $errors = [];
                    try {
                        $imie = $_POST['imie'];
                        $nazwisko = $_POST['nazwisko'];
                        $nrtel = $_POST['nrtelefonu'];
                        $useremail = $_POST['email'];
                        $userpassword = $_POST['password'];
                        $userpasswordagain = $_POST['passwordAgain'];
                
                        $_SESSION['imie'] = $imie;
                        $_SESSION['nazwisko'] = $nazwisko;
                        $_SESSION['nrtelefonu'] = $nrtel;
                        $_SESSION['email'] = $useremail;
                
                        $nrtel = str_replace([' ', '-'], '', $nrtel);
                
                        if (!preg_match("/^[0-9]{9}$/", $nrtel)) {
                            $errors[] = "Nieprawidłowy numer telefonu.";
                        }
                
                        if (!filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
                            $errors[] = "Nieprawidłowy adres email.";
                        }
                
                        if (!preg_match("/^(?=.*[A-Z])(?=.*[0-9]).{8,}$/", $userpassword)) {
                            $errors[] = "Hasło musi zawierać minimum 8 znaków, przynajmniej jedną dużą literę i jedną cyfrę.";
                        }
                
                        if ($userpassword !== $userpasswordagain) {
                            $errors[] = "Hasło i powtórzone hasło muszą się zgadzać!";
                        }
                
                        if (!empty($errors)) {
                            throw new Exception("Wystąpiły błędy podczas przetwarzania formularza.");
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
                            $user_permissions_insert = $conn->prepare("INSERT INTO tbl_UprawnieniaUzytkownikow (ID_Uzytkownika, TypUprawnienia) VALUES (?, 'Admin')");
                            $user_permissions_insert->bind_param("i", $id_uzytkownika);
                            $user_permissions_insert->execute();
                        } else {
                            throw new Exception("Błąd podczas pobierania ID użytkownika.");
                        }
                
                        $user_insert->close();
                        $id_uzytkownika_query->close();
                        $user_permissions_insert->close();
                        $conn->close();
                
                        session_unset();
                        session_destroy();

                        echo "<p>Rejestracja konta administratorskiego zakończona sukcesem.</p>";
                        echo "<form method='post'>
                                <input type='hidden' name='step' value='6'>
                                <input type='submit' value='Krok 6'>
                            </form>";
                                
                    } catch (Exception $e) {
                        renderRegistrationForm($errors);
                    }
                }
                
                function step5() {
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['step']) && $_POST['step'] == '5') {
                        processRegistration();
                    } else {
                        renderRegistrationForm();
                    }
                }
                
                function step6(){
                    global $config_file, $step;
                    echo "<p>Instalacja prawie ukończona :)</p>";
                    echo "<br>";
                    echo "<h3>Ostatnie szlify</h3>";
                    echo "<p>1. Zmień prawa dostępu do db_connection.php<br>np. chmod o-w " . $config_file . "</p>";
                    echo "<p>2. Gdy będziesz pewny, że aplikacja działa poprawnie pamiętaj aby usunąć install.php<br>np. rm install.php.</p>";
                    echo "<br>";
                    echo "<p>Aplikacja internetowa jest już zainstalowana i gotowa do działania, poniższy link pozwoli ci się do niej przenieść</p>";
                    echo "<a href='index.php'>Strona główna</a>";
                }

                switch($step) {
                    case 2:
                        step2();
                        break;
                    
                    case 3:
                        step3();
                        break;
                    
                    case 4:
                        step4();
                        break;
                    
                    case 5:
                        step5();
                        break;

                    case 6:
                        step6();
                        break;
                    
                    default:
                        if (file_exists($config_file)) {
                            if (is_writable($config_file)) {
                                $step = 1;
                                form_install_1();
                            } else {
                                echo "<p>Zmień uprawnienia do pliku <code>".$config_file."</code><br>np. <code>chmod o+w ".$config_file."</code></p>";
                                echo "<br>";
                                echo "<p>Gdy to zrobisz odśwież stronę klikając przycisk strzałki w lewym górnym rogu lub przycisk 'F5'</p>";
                            }
                        } else {
                            echo "<p>Stwórz plik <code>".$config_file."</code><br>np. <code>touch ".$config_file."</code></p>";
                            echo "<br>";
                            echo "<p>Gdy to zrobisz odśwież stronę klikając przycisk strzałki w lewym górnym rogu lub przycisk 'F5'</p>";
                        }
                        break;
                }
            ?>
            </div>
        </section>
    </body>
</html>
