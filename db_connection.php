<?php
                    $host = "localhost";
                    $user = "2025_mpalka21";
                    $password = "palka_majczyk";
                    $dbname = "2025_mpalka21";
                    $prefix = "tbl";
                    $base_url = "https://www.manticore.uni.lodz.pl/~mpalka21/Smart-Home/";
                    $nazwa_aplikacji = "Smart-Home";
                    $data_powstania = "2024-06-23";
                    $brand = "Smart-Future";
                    $adres = "Rewolucji 1905 r.";
                    $adres2 = "Łódź, 90-221";
                    $phone = "742325752";
                    $conn = mysqli_connect($host, $user, $password, $dbname);
                    if (!$conn) {
                        if(file_exists('db_connection.php')){
                            header('Location: install.php');
                            exit;             
                        }
                        else{
                            echo 'Błąd połączenia';
                        }       
                    }
                    ?>
