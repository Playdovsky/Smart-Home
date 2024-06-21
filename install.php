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
                error_reporting(E_ALL);
                ini_set('display_errors', 1);

                $config_file = "db_connection.php";
                $step = isset($_POST['step']) ? intval($_POST['step']) : 0;
                echo "<h1>Instalator<br>krok $step</h1>";

                function form_install_1(){
                    echo    "<form method='post' name='instalacja'>
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
                                <div class='txt_field'>
                                    <input type='text' name='prefix' required>
                                    <span></span>
                                    <label>Prefix tabeli</label>
                                </div>
                                <input type='hidden' name='step' value='2'>
                                <input type='submit' value='Krok 2'>
                            </form>";
                }

                function step2(){
                    global $config_file, $prefix, $link, $dbname;
                    $file = fopen($config_file, "w");
                    $config = "<?php
                    \$host = \"" . $_POST['host'] . "\";
                    \$user = \"" . $_POST['user'] . "\";
                    \$password = \"" . $_POST['passwd'] . "\";
                    \$dbname = \"" . $_POST['dbname'] . "\";
                    \$prefix = \"" . $_POST['prefix'] . "\";
                    \$link = mysqli_connect(\$host, \$user, \$password, \$dbname);
                    if (!\$link) {
                        header('Location: install.php');
                        exit;                    
                    }
                    \n";

                    if (!fwrite($file, $config)) { 
                        print "Nie mogę zapisać do pliku ($file)"; 
                        exit; 
                    }

                    fclose($file); 

                    include "db_connection.php";

                    echo "<p>Krok 2 zakończony: \n";
                    echo "Plik konfiguracyjny utworzony</p>"; 
                    echo "<form method='post'>
                            <input type='hidden' name='step' value='3'>
                            <input type='submit' value='Krok 3'>
                          </form>";
                }
                
                function step3() {
                    global $link, $dbname, $create;
                    if (file_exists("sql/sql.php")) {
                        include("sql/sql.php");
                        echo "Tworzę tabele bazy: ".$dbname.".<br>\n";
                        var_dump($dbname); //ZWRACA NULL JAKO NAZWE BAZY
                        mysqli_select_db($link, $dbname) or die(mysqli_error($link)); //NA TYM SIE ZATRZYMUJE KOD I NIE IDZIE DALEJ
                        for ($i = 0; $i < count($create); $i++) {
                            echo "<p>".$i.". <code>".$create[$i]."</code></p>\n";
                            mysqli_query($link, $create[$i]);
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
                    global $link, $dbname, $insert;
                    if (file_exists("sql/insert.php")) {
                        include("sql/insert.php");
                        echo "<p>Wstawiam dane do tabel bazy: ".$dbname.".</p>\n";
                        var_dump($dbname);
                        mysqli_select_db($link, $dbname) or die(mysqli_error($link));
                        for ($i = 0; $i < count($insert); $i++) {
                            echo "<p>".$i.". <code>".$insert[$i]."</code></p>\n";
                            mysqli_query($link, $insert[$i]);
                        }
                        echo "<form method='post'>
                                <input type='hidden' name='step' value='5'>
                                <input type='submit' value='Krok 5'>
                              </form>";
                    } else {
                        echo "Brak pliku sql/insert.php";
                    }
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
                        echo "Krok 5";
                        break;
                    
                    default:
                        if (file_exists($config_file)) {
                            if (is_writable($config_file)) {
                                $step = 1;
                                form_install_1();
                            } else {
                                echo "<p>Zmień uprawnienia do pliku <code>".$config_file."</code><br>np. <code>chmod o+w ".$config_file."</code></p>";
                                echo "<p><button class='btn btn-info' onClick='window.location.href=window.location.href'>Odśwież stronę</button></p>";
                            }
                        } else {
                            echo "<p>Stwórz plik <code>".$config_file."</code><br>np. <code>touch ".$config_file."</code></p>";
                            echo "<p><button class='btn btn-info' onClick='window.location.href=window.location.href'>Odśwież stronę</button></p>";
                        }
                        break;
                }
            ?>

            </div>
        </section>
    </body>
</html>
