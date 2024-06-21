<?php
    global $prefix;

    $create[] = "CREATE TABLE `" . $prefix . "_DomyslneUstawieniaSprzetu` (
    `ID_DomyslnegoUstawieniaSprzetu` int(11) NOT NULL,
    `ID_SprzetSmart` int(11) DEFAULT NULL,
    `Nazwa` varchar(50) NOT NULL,
    `WartoscLiczbowa` int(11) NOT NULL,
    `KolorPodswietlenia` varchar(50) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "CREATE TABLE `" . $prefix . "_Kontakt` (
    `ID_Kontaktowe` int(11) NOT NULL,
    `Imie` varchar(20) NOT NULL,
    `NrTelefonu` varchar(15) NOT NULL,
    `Email` varchar(30) NOT NULL,
    `Wiadomosc` varchar(300) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "CREATE TABLE `" . $prefix . "_SprzetSmart` (
    `ID_SprzetSmart` int(11) NOT NULL,
    `Typ` varchar(20) NOT NULL,
    `Nazwa` varchar(30) NOT NULL,
    `Sciezka` varchar(300) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "CREATE TABLE `" . $prefix . "_SprzetUzytkownikow` (
    `ID_SprzetUzytkownika` int(11) NOT NULL,
    `ID_SprzetSmart` int(11) NOT NULL,
    `ID_Uzytkownika` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "CREATE TABLE `" . $prefix . "_UprawnieniaUzytkownikow` (
    `ID_Uprawnien` int(11) NOT NULL,
    `ID_Uzytkownika` int(11) NOT NULL,
    `TypUprawnienia` varchar(20) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "CREATE TABLE `" . $prefix . "_UstawieniaSprzetu` (
    `ID_UstawieniaSprzetu` int(11) NOT NULL,
    `ID_SprzetUzytkownika` int(11) NOT NULL,
    `Nazwa` varchar(20) NOT NULL,
    `WartoscLiczbowa` int(11) NOT NULL,
    `KolorPodswietlenia` varchar(20) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "CREATE TABLE `" . $prefix . "_Uzytkownicy` (
    `ID_Uzytkownika` int(11) NOT NULL,
    `Imie` varchar(20) NOT NULL,
    `Nazwisko` varchar(20) NOT NULL,
    `NrTelefonu` varchar(15) DEFAULT NULL,
    `Email` varchar(30) NOT NULL,
    `Haslo` varchar(100) DEFAULT NULL,
    `Dezaktywowany` bit(1) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "CREATE TABLE `" . $prefix . "_WartoscSprzetSmart` (
    `ID_WartoscSprzetSmart` int(11) NOT NULL,
    `ID_SprzetSmart` int(11) NOT NULL,
    `NazwaWartosci` varchar(50) NOT NULL,
    `Typ` varchar(30) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "CREATE TABLE `" . $prefix . "_Zgloszenia` (
    `ID_Zgloszenia` int(11) NOT NULL,
    `ID_Uzytkownika` int(11) NOT NULL,
    `Typ` varchar(50) DEFAULT NULL,
    `Opis` varchar(400) DEFAULT NULL,
    `Status` tinyint(4) DEFAULT NULL,
    `DataZgloszenia` date NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "ALTER TABLE `" . $prefix . "_DomyslneUstawieniaSprzetu`
    ADD PRIMARY KEY (`ID_DomyslnegoUstawieniaSprzetu`),
    ADD KEY `ID_SprzetSmart` (`ID_SprzetSmart`);";

    $create[] = "ALTER TABLE `" . $prefix . "_Kontakt`
    ADD PRIMARY KEY (`ID_Kontaktowe`);";

    $create[] = "ALTER TABLE `" . $prefix . "_SprzetSmart`
    ADD PRIMARY KEY (`ID_SprzetSmart`);";

    $create[] = "ALTER TABLE `" . $prefix . "_SprzetUzytkownikow`
    ADD PRIMARY KEY (`ID_SprzetUzytkownika`),
    ADD KEY `ID_SprzetSmart` (`ID_SprzetSmart`),
    ADD KEY `ID_Uzytkownika` (`ID_Uzytkownika`);";

    $create[] = "ALTER TABLE `" . $prefix . "_UprawnieniaUzytkownikow`
    ADD PRIMARY KEY (`ID_Uprawnien`),
    ADD KEY `ID_Uzytkownika` (`ID_Uzytkownika`);";

    $create[] = "ALTER TABLE `" . $prefix . "_UstawieniaSprzetu`
    ADD PRIMARY KEY (`ID_UstawieniaSprzetu`),
    ADD KEY `ID_SprzetUzytkownika` (`ID_SprzetUzytkownika`);";

    $create[] = "ALTER TABLE `" . $prefix . "_Uzytkownicy`
    ADD PRIMARY KEY (`ID_Uzytkownika`);";

    $create[] = "ALTER TABLE `" . $prefix . "_WartoscSprzetSmart`
    ADD PRIMARY KEY (`ID_WartoscSprzetSmart`),
    ADD KEY `ID_SprzetSmart` (`ID_SprzetSmart`);";

    $create[] = "ALTER TABLE `" . $prefix . "_Zgloszenia`
    ADD PRIMARY KEY (`ID_Zgloszenia`),
    ADD KEY `ID_Uzytkownika` (`ID_Uzytkownika`);";

    $create[] = "ALTER TABLE `" . $prefix . "_DomyslneUstawieniaSprzetu`
    MODIFY `ID_DomyslnegoUstawieniaSprzetu` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `" . $prefix . "_Kontakt`
    MODIFY `ID_Kontaktowe` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `" . $prefix . "_SprzetSmart`
    MODIFY `ID_SprzetSmart` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `" . $prefix . "_SprzetUzytkownikow`
    MODIFY `ID_SprzetUzytkownika` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `" . $prefix . "_UprawnieniaUzytkownikow`
    MODIFY `ID_Uprawnien` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `" . $prefix . "_UstawieniaSprzetu`
    MODIFY `ID_UstawieniaSprzetu` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `" . $prefix . "_Uzytkownicy`
    MODIFY `ID_Uzytkownika` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `" . $prefix . "_WartoscSprzetSmart`
    MODIFY `ID_WartoscSprzetSmart` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `" . $prefix . "_Zgloszenia`
    MODIFY `ID_Zgloszenia` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `" . $prefix . "_DomyslneUstawieniaSprzetu`
    ADD CONSTRAINT `" . $prefix . "_DomyslneUstawieniaSprzetu_ibfk_1` FOREIGN KEY (`ID_SprzetSmart`) REFERENCES `" . $prefix . "_SprzetSmart` (`ID_SprzetSmart`);";

    $create[] = "ALTER TABLE `" . $prefix . "_SprzetUzytkownikow`
    ADD CONSTRAINT `" . $prefix . "_SprzetUzytkownikow_ibfk_1` FOREIGN KEY (`ID_SprzetSmart`) REFERENCES `" . $prefix . "_SprzetSmart` (`ID_SprzetSmart`),
    ADD CONSTRAINT `" . $prefix . "_SprzetUzytkownikow_ibfk_2` FOREIGN KEY (`ID_Uzytkownika`) REFERENCES `" . $prefix . "_Uzytkownicy` (`ID_Uzytkownika`);";

    $create[] = "ALTER TABLE `" . $prefix . "_UprawnieniaUzytkownikow`
    ADD CONSTRAINT `" . $prefix . "_UprawnieniaUzytkownikow_ibfk_1` FOREIGN KEY (`ID_Uzytkownika`) REFERENCES `" . $prefix . "_Uzytkownicy` (`ID_Uzytkownika`);";

    $create[] = "ALTER TABLE `" . $prefix . "_UstawieniaSprzetu`
    ADD CONSTRAINT `" . $prefix . "_UstawieniaSprzetu_ibfk_1` FOREIGN KEY (`ID_SprzetUzytkownika`) REFERENCES `" . $prefix . "_SprzetUzytkownikow` (`ID_SprzetUzytkownika`);";

    $create[] = "ALTER TABLE `" . $prefix . "_WartoscSprzetSmart`
    ADD CONSTRAINT `" . $prefix . "_WartoscSprzetSmart_ibfk_1` FOREIGN KEY (`ID_SprzetSmart`) REFERENCES `" . $prefix . "_SprzetSmart` (`ID_SprzetSmart`);";

    $create[] = "ALTER TABLE `" . $prefix . "_Zgloszenia`
    ADD CONSTRAINT `" . $prefix . "_Zgloszenia_ibfk_1` FOREIGN KEY (`ID_Uzytkownika`) REFERENCES `" . $prefix . "_Uzytkownicy` (`ID_Uzytkownika`);
    COMMIT;";
?>