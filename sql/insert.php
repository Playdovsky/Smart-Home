<?php
    $insert[] = "INSERT INTO `" . $prefix . "_DomyslneUstawieniaSprzetu` (`ID_DomyslnegoUstawieniaSprzetu`, `ID_SprzetSmart`, `Nazwa`, `WartoscLiczbowa`, `KolorPodswietlenia`) VALUES
    (1, 1, 'Termostat', 21, 'Czerwony'),
    (2, 2, 'Żarówka', 80, 'Biały'),
    (3, 3, 'Zamek', 1234, 'Niebieski'),
    (4, 4, 'Video dzwonek', 50, 'Niebieski'),
    (5, 5, 'Czujnik dymu', 1, 'Czerwony'),
    (6, 6, 'Kamera', 1, 'Niebieski'),
    (7, 21, 'Czujnik ruchu', 20, 'Różowy'),
    (8, 22, 'TestNazwa', 50, 'Żółty');";

    $insert[] = "INSERT INTO `" . $prefix . "_SprzetSmart` (`ID_SprzetSmart`, `Typ`, `Nazwa`, `Sciezka`) VALUES
    (1, 'Komfort', 'Termostat', 'Termostat.png'),
    (2, 'Komfort', 'Żarówka', 'Zarowka.png'),
    (3, 'Bezpieczenstwo', 'Zamek do drzwi', 'Zamek.png'),
    (4, 'Bezpieczenstwo', 'Video dzwonek do drzwi', 'VideoDzwonek.png'),
    (5, 'Bezpieczenstwo', 'Czujnik dymu', 'CzujnikDymu.png'),
    (6, 'Bezpieczenstwo', 'Kamera', 'Kamera.png'),
    (21, 'Bezpieczeństwo', 'Czujnik ruchu', 'czujnik_ruchu.png');";

    $insert[] = "INSERT INTO `" . $prefix . "_WartoscSprzetSmart` (`ID_WartoscSprzetSmart`, `ID_SprzetSmart`, `NazwaWartosci`, `Typ`) VALUES
    (1, 1, 'Temperatura (°C)', 'slider'),
    (2, 2, 'Jasność (%)', 'slider'),
    (3, 3, 'PIN', 'text'),
    (4, 4, 'Głośność (dB)', 'slider'),
    (5, 5, 'Czy natychmiast powiadamiać straż?', 'checkbox'),
    (6, 6, 'Automatyczne śledzenie ruchu', 'checkbox'),
    (15, 21, 'Czułość wykrywania', 'slider');";
?>