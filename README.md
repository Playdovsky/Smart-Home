# Smart-Home
Aplikacja Smart-Home (nazywana również Smart-Future) została stworzona dla użytkowników, którzy posiadają inteligentne urządzenia w swoich domach, takie jak inteligentne żarówki, termostaty, czujniki, kamery itp. Naszym celem jest zapewnienie łatwego i wygodnego panelu sterowania wszystkimi urządzeniami danego użytkownika w jednym miejscu, chcemy aby użytkownik mógł korzystać z urządzeń różnych producentów za pomocą jednej a nie dedykowanych kilku aplikacji.

## Wymagania systemowe
* Apache/2.4.41 (Ubuntu)
* PHP Version 7.4.3-4ubuntu2.22
* 10.3.39-MariaDB-0ubuntu0.20.04.2 - Ubuntu 20.04

## Instalacja
1.	Przesłane pliki zamieścić na serwerze Manticore poprzez program „WinSCP”.
2.	Otworzyć stronę https://www.manticore.uni.lodz.pl/~mpalka21/Smart-Home/
3.	Aplikacja samodzielnie sprawdzi swój stan oraz przejdzie do instalacji. Od tego momentu wystarczy aby użytkownik podążał za instrukcjami instalatora.
4.	Stwórz plik db_connection poprzez program „Putty” np. touch db_connection.php a następnie odśwież stronę np. poprzez przycisk „F5”.
5.	Zmień uprawnienia dla pliku db_connection.php np. chmod o+w db_connection.php a następnie odśwież stronę np. poprzez przycisk „F5”.
6.	Uzupełnij formularz wprowadzając odpowiednie dane.
    * a.	Nazwa lub adres serwera – informacje uzyskiwane u administratora serwera (w ramach tworzenia aplikacji używany był localhost).
    * b.	Nazwa bazy danych – z phpMyAdmin.
    * c.	Nazwa użytkownika -  z phpMyAdmin.
    * d.	Hasło – z phpMyAdmin powiązane z nazwą użytkownika.
7.	Przy prawidłowym podaniu danych instalator w krokach 2-4 będzie zakulisowo tworzył plik konfiguracyjny, strukturę oraz wstawiał dane. Wystarczy abyś klikał przyciski z nazwami odpowiednich kroków aż zostanie przeniesiony do kroku 5.
8.	Instalator wyświetli formularz tworzenia pierwszego konta czyli konta administratorskiego. W górnej części formularza na czerwono wyświetlane są wytyczne wobec, których konto musi zostać stworzone. Jeśli konto spełni wszystkie wymogi zostaniesz o tym poinformowany.
9.	Na etapie kroku 6 instalacja jest prawie ukończona. Zmień prawa dostępu do db_connection.php np. chmod o-w db_connection.php oraz prawa dostępu do katalogu images np. chmod o+rwx images. Gdy będziesz pewny że aplikacja działa usuń install.php np. rm install.php
Aby przenieść się do działającej strony można wykorzystać link z pkt 2 lub kliknąć w link instalatora „Strona główna”.

## Autorzy
* **Mateusz Pałka** 
* *nr  albumu: 406326*
* *mpalka21*
* 
* **Bartosz Majczyk**
* *nr albumu: 406363*
* *bmajczyk*

## Wykorzystane zewnętrzne biblioteki
* Bootstrap 5.2.3
* jQuery 3.5.1