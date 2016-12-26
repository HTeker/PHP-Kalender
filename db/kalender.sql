-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 26 dec 2016 om 20:17
-- Serverversie: 5.7.14
-- PHP-versie: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kalender`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `evenementen`
--

CREATE TABLE `evenementen` (
  `id` int(11) NOT NULL,
  `omschrijving` text NOT NULL,
  `begin_datum` date NOT NULL,
  `eind_datum` date NOT NULL,
  `begin_tijd` time NOT NULL,
  `eind_tijd` time NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `evenementen`
--

INSERT INTO `evenementen` (`id`, `omschrijving`, `begin_datum`, `eind_datum`, `begin_tijd`, `eind_tijd`, `status`) VALUES
(1, 'Dit is het eerste evenement! Zowel het begin als het eind valt binnen de huidige maand.', '2014-05-23', '2014-05-25', '12:00:00', '14:00:00', 0),
(2, 'Dit is het tweede evenement!\n\nHet begin valt in de vorige en het eind valt binnen de huidige maand.', '2014-04-24', '2014-05-08', '13:00:00', '18:00:00', 0),
(3, 'Dit is het derde evenement!\r\n\r\nHet begin valt in de huidige en het eind valt binnen de volgende maand.', '2014-05-22', '2014-06-03', '08:00:00', '16:00:00', 0),
(4, 'Dit is het vierde evenement!\r\n\r\nHet begin valt in de vorige maand en het eind valt binnen de volgende maand.', '2014-04-24', '2014-06-11', '12:00:00', '17:00:00', 0),
(5, 'Dit is het vijfde evenement!\r\n\r\nZowel het begin als het eind valt in de vorige maand.', '2014-04-16', '2014-04-18', '13:00:00', '17:00:00', 0),
(6, 'Dit is het zesde evenement!\r\n\r\nZowel het begin als het eind valt binnen de volgende maand.', '2014-06-11', '2014-06-12', '10:00:00', '11:00:00', 0);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `evenementen`
--
ALTER TABLE `evenementen`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `evenementen`
--
ALTER TABLE `evenementen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
