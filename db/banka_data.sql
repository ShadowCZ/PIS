-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 24. dub 2014, 16:23
-- Verze serveru: 5.6.15-log
-- Verze PHP: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `banka`
--

--
-- Vypisuji data pro tabulku `account_type`
--

INSERT INTO `account_type` (`id_account_type`, `name`, `description`) VALUES
(1, 'transactional', 'Běžný účet'),
(2, 'savings', 'Spořící účet'),
(3, 'time_deposit', 'Termínovaný vklad');

--
-- Vypisuji data pro tabulku `operation_type`
--

INSERT INTO `operation_type` (`id_operation_type`, `name`) VALUES
(1, 'withdraw'),
(2, 'deposit'),
(3, 'transaction');

--
-- Vypisuji data pro tabulku `role`
--

INSERT INTO `role` (`id_role`, `name`, `description`) VALUES
(1, 'admin', 'Administrátor bankovního systému'),
(2, 'adviser', 'Finanční poradce'),
(3, 'employee', 'Zaměstnanec na přepážce'),
(4, 'transaction_manager', 'Správce transakcí');

--
-- Vypisuji data pro tabulku `employee`
--

INSERT INTO `employee` (`id_employee`, `id_role`, `name`, `surname`, `address1`, `address2`, `postal_code`, `telephone`, `email`, `login`, `password`, `active`, `last_ip`) VALUES
(1, NULL, 'test', '', '', '', '', NULL, NULL, '', 't', 1, '127.0.0.1'),
(2, 1, 'Radim', 'Reš', '', '', '', NULL, NULL, 'admin', 'admin', 1, '127.0.0.1'),
(3, 2, 'Martin', 'Foukal', '', '', '', NULL, NULL, 'foukal', 'foukal', 1, ''),
(4, 3, 'Tomáš', 'Smetka', '', '', '', NULL, '', 'smetka', 'smetka', 1, ''),
(5, 4, 'Ondřej', 'Šimíček', '', '', '', NULL, NULL, 'simicek', 'simicek', 1, '');

--
-- Vypisuji data pro tabulku `client`
--

INSERT INTO `client` (`id_client`, `name`, `surname`, `address1`, `address2`, `postal_code`, `personal_number`, `telephone`, `email`) VALUES
(1, 'Petr', 'Kopřiva', 'Lidická 10', '', '60200', '', NULL, NULL),
(2, 'Romana', 'Kvapilová', 'Kachlíkova 7', '', '63500', '', NULL, NULL),
(3, 'Roman', 'Houska', 'Husova 6', '', '60200', '', NULL, NULL),
(4, 'Petr', 'Skula', 'Kosmova 12', '', '61200', '', NULL, NULL),
(5, 'Lucie', 'Adamová', 'Kozí 9', '', '60200', '', NULL, NULL),
(6, 'Gabriela', 'Soukalová', 'Šoustalova 69', '', '62500', '', NULL, NULL),
(7, 'Ivo', 'Viktor', 'U Sokolovny 5', '', '63500', '', NULL, NULL),
(8, 'Daniel', 'Svoboda', 'Švermova 8', '', '62500', '', NULL, NULL),
(9, 'Petra', 'Andresová', 'Údolní 20', '', '60200', '', NULL, NULL),
(10, 'Veronika', 'Suchá', 'Vlhká 9', '', '60200', '', NULL, NULL);

--
-- Vypisuji data pro tabulku `account`
--

INSERT INTO `account` (`id_account`, `id_account_type`, `id_client`, `account_number`, `value`, `avalaible_value`) VALUES
(1, 1, 1, 355421774, 55000, 55000),
(2, 2, 1, 250022895, 235250, 235250),
(3, 1, 2, 780520000, 23000, 23000),
(4, 1, 3, 780520001, 65000, 65000),
(5, 1, 4, 780520002, 123562, 123562),
(6, 1, 5, 780520003, 2000, 2000),
(7, 1, 6, 780520004, 18520, 18520),
(8, 1, 7, 780520005, 180500, 180500),
(9, 1, 8, 780520006, 500, 500),
(10, 1, 9, 780520007, 12800, 12800),
(11, 1, 10, 780520008, 53120, 53120),
(12, 3, 10, 790130040, 500000, 500000);

--
-- Vypisuji data pro tabulku `delegated_person`
--

INSERT INTO `delegated_person` (`id_delegated_person`, `id_client`, `id_account`, `value_limit`) VALUES
(1, 1, 1, 9999999),
(2, 1, 2, 10000),
(3, 2, 3, 9999999),
(4, 3, 4, 9999999),
(5, 4, 5, 9999999),
(6, 5, 6, 9999999),
(7, 6, 7, 9999999),
(8, 7, 8, 9999999),
(9, 8, 9, 9999999),
(10, 9, 10, 9999999),
(11, 10, 11, 9999999),
(12, 10, 12, 0),
(13, 1, 3, 5000),
(14, 1, 4, 2000),
(15, 3, 8, 10000),
(16, 4, 9, 5000),
(17, 2, 7, 10000),
(18, 9, 5, 1000),
(19, 6, 3, 5000),
(20, 7, 5, 20000);



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
