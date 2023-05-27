-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1:3306
-- Vytvořeno: Sob 27. kvě 2023, 14:53
-- Verze serveru: 8.0.31
-- Verze PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `praxe`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `dodavatele`
--

DROP TABLE IF EXISTS `dodavatele`;
CREATE TABLE IF NOT EXISTS `dodavatele` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'automatické ID',
  `nazev` varchar(200) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'jméno dodavatele',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nazev` (`nazev`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Číselník - Dodavatelé';

--
-- Vypisuji data pro tabulku `dodavatele`
--

INSERT INTO `dodavatele` (`id`, `nazev`) VALUES
(3, 'Běžný dodavatel'),
(1, 'Nejlevnější energie'),
(2, 'Šetříme všem');

-- --------------------------------------------------------

--
-- Struktura tabulky `komodity`
--

DROP TABLE IF EXISTS `komodity`;
CREATE TABLE IF NOT EXISTS `komodity` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'automatické ID',
  `nazev` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'název komodity',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nazev` (`nazev`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Číselník - Komodity';

--
-- Vypisuji data pro tabulku `komodity`
--

INSERT INTO `komodity` (`id`, `nazev`) VALUES
(1, 'Elektřina'),
(2, 'Plyn');

-- --------------------------------------------------------

--
-- Struktura tabulky `nabidky`
--

DROP TABLE IF EXISTS `nabidky`;
CREATE TABLE IF NOT EXISTS `nabidky` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'automatické ID',
  `dodavatel` int NOT NULL COMMENT 'id dodavatele',
  `komodita` int NOT NULL COMMENT 'id komodity',
  `spotreba_od` float NOT NULL COMMENT 'spotřeba od mwh',
  `spotreba_do` float NOT NULL COMMENT 'spotřeba do mwh',
  `cena` float NOT NULL COMMENT 'cena za nabídku',
  `poplatek` float NOT NULL COMMENT 'poplatek za nabídku',
  PRIMARY KEY (`id`),
  KEY `dodavatel` (`dodavatel`),
  KEY `komodita` (`komodita`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabulka s nabídkami';

--
-- Vypisuji data pro tabulku `nabidky`
--

INSERT INTO `nabidky` (`id`, `dodavatel`, `komodita`, `spotreba_od`, `spotreba_do`, `cena`, `poplatek`) VALUES
(1, 1, 1, 0, 3.9, 1200, 100),
(2, 1, 1, 3.9001, 20.9999, 1000, 80),
(3, 1, 1, 21, 50, 900, 70),
(4, 1, 2, 0, 5.9999, 900, 100),
(5, 1, 2, 6, 25.9999, 850, 90),
(6, 1, 2, 26, 50, 750, 80),
(7, 2, 1, 0, 3.9, 1300, 110),
(8, 2, 1, 3.9001, 20.9999, 900, 70),
(9, 2, 1, 21, 50, 800, 60),
(10, 2, 2, 0, 5.9999, 930, 110),
(11, 2, 2, 6, 25.9999, 800, 80),
(12, 2, 2, 26, 50, 730, 50),
(13, 3, 1, 0, 3.9, 1100, 80),
(14, 3, 1, 3.9001, 20.9999, 1050, 70),
(15, 3, 1, 21, 50, 900, 80),
(16, 3, 2, 0, 5.9999, 920, 110),
(17, 3, 2, 6, 25.9999, 800, 80),
(18, 3, 2, 26, 50, 800, 80);

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `nabidky`
--
ALTER TABLE `nabidky`
  ADD CONSTRAINT `nabidky_ibfk_1` FOREIGN KEY (`dodavatel`) REFERENCES `dodavatele` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nabidky_ibfk_2` FOREIGN KEY (`komodita`) REFERENCES `komodity` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
