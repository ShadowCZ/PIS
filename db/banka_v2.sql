-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vygenerováno: Pon 07. dub 2014, 16:03
-- Verze serveru: 5.6.11
-- Verze PHP: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `banka`
--
CREATE DATABASE IF NOT EXISTS `banka` DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci;
USE `banka`;

-- --------------------------------------------------------

--
-- Struktura tabulky `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id_account` int(11) NOT NULL AUTO_INCREMENT,
  `id_account_type` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `account_number` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `avalaible_value` int(11) NOT NULL,
  PRIMARY KEY (`id_account`),
  UNIQUE KEY `account_number` (`account_number`),
  KEY `id_account_type` (`id_account_type`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `account_type`
--

CREATE TABLE IF NOT EXISTS `account_type` (
  `id_account_type` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_account_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `surname` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `address1` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `address2` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `postal_code` varchar(5) COLLATE utf8_czech_ci NOT NULL,
  `personal_number` varchar(10) COLLATE utf8_czech_ci NOT NULL,
  `telephone` varchar(13) COLLATE utf8_czech_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `delegated_person`
--

CREATE TABLE IF NOT EXISTS `delegated_person` (
  `id_delegated_person` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL,
  `id_account` int(11) NOT NULL,
  `value_limit` int(11) NOT NULL,
  PRIMARY KEY (`id_delegated_person`),
  KEY `id_client` (`id_client`),
  KEY `id_account` (`id_account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id_employee` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(11) DEFAULT NULL,
  `name` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `surname` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `address1` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `address2` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `postal_code` varchar(5) COLLATE utf8_czech_ci NOT NULL,
  `telephone` varchar(13) COLLATE utf8_czech_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `login` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_employee`),
  UNIQUE KEY `login` (`login`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `employee`
--

INSERT INTO `employee` (`id_employee`, `id_role`, `name`, `surname`, `address1`, `address2`, `postal_code`, `telephone`, `email`, `login`, `password`, `active`) VALUES
(1, NULL, 'test', '', '', '', '', NULL, NULL, '', 't', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `operation`
--

CREATE TABLE IF NOT EXISTS `operation` (
  `id_operation` int(11) NOT NULL AUTO_INCREMENT,
  `id_delegated_person` int(11) NOT NULL,
  `id_employee` int(11) NOT NULL,
  `id_operation_type` int(11) NOT NULL,
  `target_account_number` int(11) NOT NULL,
  `bank_number` int(11) NOT NULL,
  `variable_symbol` int(11) DEFAULT NULL,
  `specific_symbol` int(11) DEFAULT NULL,
  `constant_symbol` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `value` int(11) NOT NULL,
  `message` varchar(1000) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_operation`),
  KEY `id_delegated_person` (`id_delegated_person`),
  KEY `id_employee` (`id_employee`),
  KEY `id_operation_type` (`id_operation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `operation_type`
--

CREATE TABLE IF NOT EXISTS `operation_type` (
  `id_operation_type` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_operation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `fk_id_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_account_type` FOREIGN KEY (`id_account_type`) REFERENCES `account_type` (`id_account_type`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `delegated_person`
--
ALTER TABLE `delegated_person`
  ADD CONSTRAINT `fk_id_account2` FOREIGN KEY (`id_account`) REFERENCES `account` (`id_account`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_client2` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `fk_id_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `operation`
--
ALTER TABLE `operation`
  ADD CONSTRAINT `fk_id_delegated_person` FOREIGN KEY (`id_delegated_person`) REFERENCES `delegated_person` (`id_delegated_person`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_employee` FOREIGN KEY (`id_employee`) REFERENCES `employee` (`id_employee`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_operation_type` FOREIGN KEY (`id_operation_type`) REFERENCES `operation_type` (`id_operation_type`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
