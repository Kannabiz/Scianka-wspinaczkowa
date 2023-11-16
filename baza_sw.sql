-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 25 Kwi 2023, 02:39
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `baza_sw`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `aktualnosci`
--

CREATE TABLE `aktualnosci` (
  `id` int(11) NOT NULL,
  `tytul` varchar(30) NOT NULL,
  `opis` varchar(70) NOT NULL,
  `tresc` text NOT NULL,
  `zdj_link` varchar(40) NOT NULL,
  `autor` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `aktualnosci`
--

INSERT INTO `aktualnosci` (`id`, `tytul`, `opis`, `tresc`, `zdj_link`, `autor`) VALUES
(1, '6 Rocznica STREFY WOLNOŚCI!', 'Jak co roku, 22 kwietnia obchodzimy kolejną rocznicę naszej ścianki.', '', 'akt5.png', ''),
(2, 'Nabór na półkolonie', 'Od 1 maja odbędzie się nabór na kolejną edycję naszych pólkoloni.', '', 'akt4.png', ''),
(3, 'Odejście Dariusza Majewskiego', '7 maja odszedł od nas Dariusz Majewski, nasz wieloletni trener.', '', 'akt3.png', ''),
(5, 'Wyniki zawodów ogłoszone!', 'Wczoraj (10.05) odbyły się zawody we wspinaczce na czas.', 'dtfhgd', 'akt1.png', 'fggggg'),
(6, 'Nowy cennik', 'Z dniem 25 maja wprowadzamy nowy cennik.', 'Z dniem 25 maja wprowadzamy nowy cennik. Ceny będą zmienione dla wszystkich wejść i karnetów. Niestety, zmiany podyktowane są inflacją spowodowaną przez wojnę i rosnące koszty prądu. Nowy cennik będzie widoczny 18 maja.', 'akt2.png', 'Marcin Jureczko');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cennik`
--

CREATE TABLE `cennik` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(80) NOT NULL,
  `cena` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `cennik`
--

INSERT INTO `cennik` (`id`, `nazwa`, `cena`) VALUES
(7, 'Baldy', '15.00'),
(10, 'Ścianka + baldy', '20.00'),
(22, 'Karnet miesięczny (baldy)', '130.00'),
(25, 'Karnet miesięczny (ścianka + baldy) (własny sprzęt)', '170.00'),
(40, 'Karnet dwumiesięczny (ścianka + baldy) (własny sprzęt, 10 wejść)', '180.00'),
(41, 'Wypożyczenie sprzętu', '5.00'),
(42, 'Wypożyczenie liny', '10.00'),
(43, 'Wypożyczenie sprzętu dla posiadacza karnetu', '40.00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kupionebilety`
--

CREATE TABLE `kupionebilety` (
  `id` int(11) NOT NULL,
  `id_uzytkownik` int(11) NOT NULL,
  `akceptacja` varchar(3) NOT NULL DEFAULT 'nie',
  `bilet7` int(11) NOT NULL,
  `biletData7` date NOT NULL,
  `bilet10` int(11) NOT NULL,
  `biletData10` date NOT NULL,
  `bilet22` int(11) NOT NULL,
  `biletData22` date NOT NULL,
  `bilet25` int(11) NOT NULL,
  `biletData25` date NOT NULL,
  `bilet40` int(11) NOT NULL,
  `biletData40` date NOT NULL,
  `bilet41` int(11) NOT NULL,
  `biletData41` date NOT NULL,
  `bilet42` int(11) NOT NULL,
  `biletData42` date NOT NULL,
  `bilet43` int(11) NOT NULL,
  `biletData43` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `kupionebilety`
--

INSERT INTO `kupionebilety` (`id`, `id_uzytkownik`, `akceptacja`, `bilet7`, `biletData7`, `bilet10`, `biletData10`, `bilet22`, `biletData22`, `bilet25`, `biletData25`, `bilet40`, `biletData40`, `bilet41`, `biletData41`, `bilet42`, `biletData42`, `bilet43`, `biletData43`) VALUES
(45, 17, 'tak', 3, '2023-04-24', 0, '2023-04-24', 2, '2023-04-24', 0, '2023-04-24', 0, '2023-04-24', 0, '2023-04-24', 0, '2023-04-24', 0, '2023-04-24'),
(46, 17, 'tak', 2, '2023-04-24', 0, '2023-04-24', 0, '2023-04-24', 1, '2023-04-24', 1, '2023-04-24', 1, '2023-04-24', 0, '2023-04-24', 0, '2023-04-24'),
(47, 17, 'nie', 1, '2023-04-24', 1, '2023-04-24', 0, '2023-04-24', 0, '2023-04-24', 0, '2023-04-24', 1, '2023-04-24', 4, '2023-04-24', 0, '2023-04-24'),
(76, 18, 'tak', 2, '2023-05-07', 0, '2023-04-25', 1, '2023-04-29', 0, '2023-04-25', 6, '2023-05-01', 1, '2023-05-05', 0, '2023-04-25', 0, '2023-04-25');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownik`
--

CREATE TABLE `uzytkownik` (
  `id` int(11) NOT NULL,
  `imie` varchar(30) NOT NULL,
  `nazwisko` varchar(40) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `telefon` int(9) DEFAULT NULL,
  `email` varchar(40) NOT NULL,
  `admin` varchar(3) NOT NULL DEFAULT 'nie'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `uzytkownik`
--

INSERT INTO `uzytkownik` (`id`, `imie`, `nazwisko`, `haslo`, `telefon`, `email`, `admin`) VALUES
(4, 'asd', 'asd', '$2y$10$Jh1NxCUvGxiuUazmzUqk3uv.r87.woZ3SfAXiogQMelCbbjwewGcq', NULL, 'asd@asd.asd', 'tak'),
(17, 'zxc', 'zxc', '$2y$10$LipAKKyL7e1VhXpAYV5TeuCPTTcZbv4vpBaidxCw850Oc7Ubh31vK', 666444777, 'zxc@zxc.zxc', 'nie'),
(18, 'Adam', 'Kosak', '$2y$10$ipkVlBbREJ6.xj4LxPLYwuLZit6xpaL.6mhU12Vfdnw0EdYVGBUye', 236446877, 'adam@kosak.pl', 'nie'),
(20, 'Jan', 'Grey', '$2y$10$hcfwZ7t5T02HssFmHkOE0ukdSCdOBNbY7Kpx64mZ2uOE3TF9N5Ynm', 365875088, 'jan@grey.pl', 'nie');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `aktualnosci`
--
ALTER TABLE `aktualnosci`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `cennik`
--
ALTER TABLE `cennik`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `kupionebilety`
--
ALTER TABLE `kupionebilety`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `aktualnosci`
--
ALTER TABLE `aktualnosci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT dla tabeli `cennik`
--
ALTER TABLE `cennik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT dla tabeli `kupionebilety`
--
ALTER TABLE `kupionebilety`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT dla tabeli `uzytkownik`
--
ALTER TABLE `uzytkownik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
