-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 29, 2016 at 10:59 AM
-- Server version: 5.7.12
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rho.one`
--
CREATE DATABASE IF NOT EXISTS `rho.one` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `rho.one`;

-- --------------------------------------------------------

--
-- Table structure for table `extension`
--
-- Creation: Apr 22, 2016 at 05:39 AM
--

DROP TABLE IF EXISTS `extension`;
CREATE TABLE IF NOT EXISTS `extension` (
  `guid` varchar(36) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Extension GUID',
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Extension ID',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Extension Name',
  `classname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'classname',
  `config_array` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Configuration Array',
  `enabled` bit(1) NOT NULL DEFAULT b'0' COMMENT 'Enabled',
  `monopolized` bit(1) NOT NULL DEFAULT b'0' COMMENT 'Monopolized',
  `default` bit(1) NOT NULL DEFAULT b'0' COMMENT 'Default',
  `create_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT 'Create Time',
  `update_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT 'Update Time',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Description',
  PRIMARY KEY (`guid`),
  UNIQUE KEY `extension_classname_unique` (`classname`) USING BTREE,
  UNIQUE KEY `extension_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `headword`
--
-- Creation: Apr 29, 2016 at 02:52 AM
--

DROP TABLE IF EXISTS `headword`;
CREATE TABLE IF NOT EXISTS `headword` (
  `guid` varchar(36) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Headword GUID',
  `word` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Headword',
  `extension_guid` varchar(36) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Extension GUID',
  `create_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT 'Create Time',
  `update_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT 'Update Time',
  PRIMARY KEY (`guid`),
  UNIQUE KEY `headword_extension_unique` (`word`,`extension_guid`),
  KEY `headword_extension_fkey` (`extension_guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `server`
--
-- Creation: Apr 29, 2016 at 02:59 AM
--

DROP TABLE IF EXISTS `server`;
CREATE TABLE IF NOT EXISTS `server` (
  `guid` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Server GUID',
  `id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Server ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Server Name',
  `endpoint` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Endpoint',
  `create_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT 'Create Time',
  `update_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT 'Create Time',
  PRIMARY KEY (`guid`),
  UNIQUE KEY `server_id_unique` (`id`),
  UNIQUE KEY `server_endpoint_unique` (`endpoint`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `synonym`
--
-- Creation: Apr 29, 2016 at 02:50 AM
-- Last update: Apr 29, 2016 at 02:50 AM
--

DROP TABLE IF EXISTS `synonym`;
CREATE TABLE IF NOT EXISTS `synonym` (
  `guid` varchar(36) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Synonym GUID',
  `word` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Synonym',
  `headword_guid` varchar(36) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Headword GUID',
  `create_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT 'Create Time',
  `update_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT 'Update Time',
  PRIMARY KEY (`guid`),
  UNIQUE KEY `synonym_headword_unique` (`word`,`headword_guid`) USING BTREE,
  KEY `synonym_headword_fkey` (`headword_guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `headword`
--
ALTER TABLE `headword`
  ADD CONSTRAINT `headword_extension_fkey` FOREIGN KEY (`extension_guid`) REFERENCES `extension` (`guid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `synonym`
--
ALTER TABLE `synonym`
  ADD CONSTRAINT `synonym_headword_fkey` FOREIGN KEY (`headword_guid`) REFERENCES `headword` (`guid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
