<?php
    $create[] = "CREATE TABLE `tbl_DomyslneUstawieniaSprzetu` (
    `ID_DomyslnegoUstawieniaSprzetu` int(11) NOT NULL,
    `ID_SprzetSmart` int(11) DEFAULT NULL,
    `Nazwa` varchar(50) NOT NULL,
    `WartoscLiczbowa` int(11) NOT NULL,
    `KolorPodswietlenia` varchar(50) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "CREATE TABLE `tbl_Kontakt` (
    `ID_Kontaktowe` int(11) NOT NULL,
    `Imie` varchar(20) NOT NULL,
    `NrTelefonu` varchar(15) NOT NULL,
    `Email` varchar(30) NOT NULL,
    `Wiadomosc` varchar(300) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "CREATE TABLE `tbl_SprzetSmart` (
    `ID_SprzetSmart` int(11) NOT NULL,
    `Typ` varchar(20) NOT NULL,
    `Nazwa` varchar(30) NOT NULL,
    `Sciezka` varchar(300) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "CREATE TABLE `tbl_SprzetUzytkownikow` (
    `ID_SprzetUzytkownika` int(11) NOT NULL,
    `ID_SprzetSmart` int(11) NOT NULL,
    `ID_Uzytkownika` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "CREATE TABLE `tbl_UprawnieniaUzytkownikow` (
    `ID_Uprawnien` int(11) NOT NULL,
    `ID_Uzytkownika` int(11) NOT NULL,
    `TypUprawnienia` varchar(20) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "CREATE TABLE `tbl_UstawieniaSprzetu` (
    `ID_UstawieniaSprzetu` int(11) NOT NULL,
    `ID_SprzetUzytkownika` int(11) NOT NULL,
    `Nazwa` varchar(20) NOT NULL,
    `WartoscLiczbowa` int(11) NOT NULL,
    `KolorPodswietlenia` varchar(20) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "CREATE TABLE `tbl_Uzytkownicy` (
    `ID_Uzytkownika` int(11) NOT NULL,
    `Imie` varchar(20) NOT NULL,
    `Nazwisko` varchar(20) NOT NULL,
    `NrTelefonu` varchar(15) DEFAULT NULL,
    `Email` varchar(30) NOT NULL,
    `Haslo` varchar(100) DEFAULT NULL,
    `Dezaktywowany` bit(1) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "CREATE TABLE `tbl_WartoscSprzetSmart` (
    `ID_WartoscSprzetSmart` int(11) NOT NULL,
    `ID_SprzetSmart` int(11) NOT NULL,
    `NazwaWartosci` varchar(50) NOT NULL,
    `Typ` varchar(30) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "CREATE TABLE `tbl_Zgloszenia` (
    `ID_Zgloszenia` int(11) NOT NULL,
    `ID_Uzytkownika` int(11) NOT NULL,
    `Typ` varchar(50) DEFAULT NULL,
    `Opis` varchar(400) DEFAULT NULL,
    `Status` tinyint(4) DEFAULT NULL,
    `DataZgloszenia` date NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $create[] = "ALTER TABLE `tbl_DomyslneUstawieniaSprzetu`
    ADD PRIMARY KEY (`ID_DomyslnegoUstawieniaSprzetu`),
    ADD KEY `ID_SprzetSmart` (`ID_SprzetSmart`);";

    $create[] = "ALTER TABLE `tbl_Kontakt`
    ADD PRIMARY KEY (`ID_Kontaktowe`);";

    $create[] = "ALTER TABLE `tbl_SprzetSmart`
    ADD PRIMARY KEY (`ID_SprzetSmart`);";

    $create[] = "ALTER TABLE `tbl_SprzetUzytkownikow`
    ADD PRIMARY KEY (`ID_SprzetUzytkownika`),
    ADD KEY `ID_SprzetSmart` (`ID_SprzetSmart`),
    ADD KEY `ID_Uzytkownika` (`ID_Uzytkownika`);";

    $create[] = "ALTER TABLE `tbl_UprawnieniaUzytkownikow`
    ADD PRIMARY KEY (`ID_Uprawnien`),
    ADD KEY `ID_Uzytkownika` (`ID_Uzytkownika`);";

    $create[] = "ALTER TABLE `tbl_UstawieniaSprzetu`
    ADD PRIMARY KEY (`ID_UstawieniaSprzetu`),
    ADD KEY `ID_SprzetUzytkownika` (`ID_SprzetUzytkownika`);";

    $create[] = "ALTER TABLE `tbl_Uzytkownicy`
    ADD PRIMARY KEY (`ID_Uzytkownika`);";

    $create[] = "ALTER TABLE `tbl_WartoscSprzetSmart`
    ADD PRIMARY KEY (`ID_WartoscSprzetSmart`),
    ADD KEY `ID_SprzetSmart` (`ID_SprzetSmart`);";

    $create[] = "ALTER TABLE `tbl_Zgloszenia`
    ADD PRIMARY KEY (`ID_Zgloszenia`),
    ADD KEY `ID_Uzytkownika` (`ID_Uzytkownika`);";

    $create[] = "ALTER TABLE `tbl_DomyslneUstawieniaSprzetu`
    MODIFY `ID_DomyslnegoUstawieniaSprzetu` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `tbl_Kontakt`
    MODIFY `ID_Kontaktowe` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `tbl_SprzetSmart`
    MODIFY `ID_SprzetSmart` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `tbl_SprzetUzytkownikow`
    MODIFY `ID_SprzetUzytkownika` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `tbl_UprawnieniaUzytkownikow`
    MODIFY `ID_Uprawnien` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `tbl_UstawieniaSprzetu`
    MODIFY `ID_UstawieniaSprzetu` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `tbl_Uzytkownicy`
    MODIFY `ID_Uzytkownika` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `tbl_WartoscSprzetSmart`
    MODIFY `ID_WartoscSprzetSmart` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `tbl_Zgloszenia`
    MODIFY `ID_Zgloszenia` int(11) NOT NULL AUTO_INCREMENT;";

    $create[] = "ALTER TABLE `tbl_DomyslneUstawieniaSprzetu`
    ADD CONSTRAINT `tbl_DomyslneUstawieniaSprzetu_ibfk_1` FOREIGN KEY (`ID_SprzetSmart`) REFERENCES `tbl_SprzetSmart` (`ID_SprzetSmart`);";

    $create[] = "ALTER TABLE `tbl_SprzetUzytkownikow`
    ADD CONSTRAINT `tbl_SprzetUzytkownikow_ibfk_1` FOREIGN KEY (`ID_SprzetSmart`) REFERENCES `tbl_SprzetSmart` (`ID_SprzetSmart`),
    ADD CONSTRAINT `tbl_SprzetUzytkownikow_ibfk_2` FOREIGN KEY (`ID_Uzytkownika`) REFERENCES `tbl_Uzytkownicy` (`ID_Uzytkownika`);";

    $create[] = "ALTER TABLE `tbl_UprawnieniaUzytkownikow`
    ADD CONSTRAINT `tbl_UprawnieniaUzytkownikow_ibfk_1` FOREIGN KEY (`ID_Uzytkownika`) REFERENCES `tbl_Uzytkownicy` (`ID_Uzytkownika`);";

    $create[] = "ALTER TABLE `tbl_UstawieniaSprzetu`
    ADD CONSTRAINT `tbl_UstawieniaSprzetu_ibfk_1` FOREIGN KEY (`ID_SprzetUzytkownika`) REFERENCES `tbl_SprzetUzytkownikow` (`ID_SprzetUzytkownika`);";

    $create[] = "ALTER TABLE `tbl_WartoscSprzetSmart`
    ADD CONSTRAINT `tbl_WartoscSprzetSmart_ibfk_1` FOREIGN KEY (`ID_SprzetSmart`) REFERENCES `tbl_SprzetSmart` (`ID_SprzetSmart`);";

    $create[] = "ALTER TABLE `tbl_Zgloszenia`
    ADD CONSTRAINT `tbl_Zgloszenia_ibfk_1` FOREIGN KEY (`ID_Uzytkownika`) REFERENCES `tbl_Uzytkownicy` (`ID_Uzytkownika`);
    COMMIT;";
?>