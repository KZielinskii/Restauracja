-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 05 Sty 2023, 09:14
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `restaurant`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cart`
--

CREATE TABLE `cart` (
  `KoszykID` int(11) NOT NULL,
  `LoginID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `opinions`
--

CREATE TABLE `opinions` (
  `OpinionID` int(11) NOT NULL,
  `LoginID` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `opinions`
--

INSERT INTO `opinions` (`OpinionID`, `LoginID`, `text`) VALUES
(2, 2, 'Jedzenie bardzo pyszne, mojej Ani bardzo smakowało pomimo zawartości glutenu!'),
(3, 3, 'Bardzo smaczne steki. Niebo w gębie. Polecam 10/10.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `category` text NOT NULL,
  `price` double NOT NULL,
  `name` text NOT NULL,
  `picture` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `products`
--

INSERT INTO `products` (`ProductID`, `category`, `price`, `name`, `picture`) VALUES
(1, 'przystawka', 9.99, 'Frytki', 'graphic/frytki.jpg'),
(3, 'przystawka', 12.99, 'Rosół', 'graphic/rosol.jpg'),
(4, 'przystawka', 8.99, 'Chleb z smalcem', 'graphic/chlebzsmalcem.jpg'),
(5, 'wino', 20.99, 'Wino czerwone', 'graphic/Cantina-Signae-Montefalco-Rosso.jpg'),
(6, 'wino', 20.99, 'Wino białe', 'graphic/massolino-chardonnay-langhe-dop.jpg'),
(7, 'stek', 18.99, 'Stek krwisty', 'graphic/krwisty-stek.jpg'),
(8, 'stek', 19.99, 'Stek pół-krwisty', 'graphic/pol-krwisty-stek.png'),
(9, 'stek', 20.99, 'Stek medium-well', 'graphic/medium-well.jpg'),
(10, 'stek', 21.99, 'Stek well-done', 'graphic/well-done-stek.jpg'),
(11, 'przystawka', 19.99, 'Kebab', 'graphic/krwisty-stek.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `todo`
--

CREATE TABLE `todo` (
  `ToDoID` int(11) NOT NULL,
  `KoszykID` int(11) NOT NULL,
  `LoginID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `paid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `login` text NOT NULL,
  `name` text NOT NULL,
  `surename` text NOT NULL,
  `telephone` int(11) NOT NULL,
  `city` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `street` text NOT NULL,
  `building` text NOT NULL,
  `apartament` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`ID`, `login`, `name`, `surename`, `telephone`, `city`, `email`, `password`, `street`, `building`, `apartament`) VALUES
(1, 'admin', 'Adam', 'Nowak', 999999999, 'Warszawa', 'adam@adam.pl', '$2y$10$62Ne9BCTET.OC5URVTgBKeIWumIyTmRTPTayXz3KBfTPipQekwhnK', 'Złota', '12', '13'),
(2, 'robercik', 'Robert', 'Lewandowski', 999888777, 'Warszawa', 'robus@123.pl', '$2y$10$Qx4KR6/bp33ONatV0KxIDeSdQQzq6U5HezTspODJqJSRBP649995a', 'Złota', '45', '4567'),
(3, 'kacperek', 'Kacper', 'Zieliński', 500600700, 'Łódź', 'jakacper@onet.pl', '$2y$10$CpPYs6g1gEStIGH57h6RX.aVeStxj447hiGLvyXlIwEtVK3vs8lAW', 'Daniłowskiego', '5', '2');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`KoszykID`);

--
-- Indeksy dla tabeli `opinions`
--
ALTER TABLE `opinions`
  ADD PRIMARY KEY (`OpinionID`);

--
-- Indeksy dla tabeli `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indeksy dla tabeli `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`ToDoID`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `cart`
--
ALTER TABLE `cart`
  MODIFY `KoszykID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT dla tabeli `opinions`
--
ALTER TABLE `opinions`
  MODIFY `OpinionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `todo`
--
ALTER TABLE `todo`
  MODIFY `ToDoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
