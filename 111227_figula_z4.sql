-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+jammy2
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: localhost:3306
-- Čas generovania: St 03.Máj 2023, 14:33
-- Verzia serveru: 8.0.32-0ubuntu0.22.04.2
-- Verzia PHP: 8.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `z4`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `ip_address` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci DEFAULT NULL,
  `user_address` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci DEFAULT NULL,
  `country` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci DEFAULT NULL,
  `country_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci DEFAULT NULL,
  `lat` decimal(10,4) DEFAULT NULL,
  `lng` decimal(10,4) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `users`
--

INSERT INTO `users` (`id`, `ip_address`, `user_address`, `country`, `country_code`, `lat`, `lng`, `date_time`) VALUES
(2, '147.175.250.200', 'Tomášikova 4858/50, 080 01 Prešov, Slovakia', 'Slovakia', 'SK', 49.0171, 21.2287, '2023-04-22 06:44:33'),
(10, '147.175.250.38', 'Brno, Czechia', 'Czechia', 'CZ', 49.1951, 16.6068, '2023-04-24 20:01:42'),
(12, '147.175.250.77', 'Budapest, Hungary', 'Hungary', 'HU', 47.4979, 19.0402, '2023-04-25 19:09:35'),
(13, '147.175.250.41', '27-300 Lipsko, Poland', 'Poland', 'PL', 51.1590, 21.6491, '2023-04-26 09:40:54'),
(14, '147.175.7.150', '976 63 Predajná, Slovensko', 'Slovensko', 'SK', 48.8145, 19.4624, '2023-04-26 10:23:43'),
(15, '147.175.106.152', 'Lesnícka 1593/20, 960 01 Zvolen, Slovensko', 'Slovensko', 'SK', 48.5680, 19.1146, '2023-04-26 14:42:21'),
(24, '147.175.250.23', 'Brno, Czechia', 'Czechia', 'CZ', 49.1951, 16.6068, '2023-04-26 16:32:33'),
(25, '147.175.250.23', 'Brno, Czechia', 'Czechia', 'CZ', 49.1951, 16.6068, '2023-04-26 16:32:33'),
(26, '147.175.250.23', 'Oslo, Norway', 'Norway', 'NO', 59.9139, 10.7522, '2023-04-26 16:45:27'),
(35, '147.175.250.185', 'Washington, DC, USA', 'USA', 'US', 38.9072, -77.0369, '2023-04-27 15:02:10'),
(36, '147.175.250.185', 'Sydney NSW, Australia', 'Australia', 'AU', -33.8688, 151.2093, '2023-04-27 15:07:45'),
(54, '147.175.250.252', 'Budapest, Hungary', 'Hungary', 'HU', 47.4979, 19.0402, '2023-05-03 16:16:48');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
