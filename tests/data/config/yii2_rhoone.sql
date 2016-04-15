-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 15, 2016 at 12:46 PM
-- Server version: 5.7.11
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rho.one`
--

-- --------------------------------------------------------

--
-- Table structure for table `extension`
--
-- Creation: Apr 10, 2016 at 12:31 PM
-- Last update: Apr 15, 2016 at 02:13 AM
--

DROP TABLE IF EXISTS `extension`;
CREATE TABLE IF NOT EXISTS `extension` (
  `guid` varchar(36) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Module GUID',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Module Name',
  `classname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'classname',
  `enabled` bit(1) NOT NULL DEFAULT b'0' COMMENT 'Enabled',
  `monopolized` bit(1) NOT NULL DEFAULT b'0' COMMENT 'Monopolized',
  `default` bit(1) NOT NULL DEFAULT b'0' COMMENT 'Default',
  `create_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT 'Create Time',
  `update_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT 'Update Time',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Description',
  PRIMARY KEY (`guid`),
  UNIQUE KEY `extension_classname_unique` (`classname`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `headword`
--
-- Creation: Apr 10, 2016 at 12:39 PM
--

DROP TABLE IF EXISTS `headword`;
CREATE TABLE IF NOT EXISTS `headword` (
  `guid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `word` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension_guid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`guid`),
  UNIQUE KEY `headword_extension_unique` (`word`,`extension_guid`),
  KEY `headword_extension_fkey` (`extension_guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--
-- Creation: Apr 07, 2016 at 08:25 AM
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `guid` varchar(36) COLLATE utf8_unicode_ci NOT NULL COMMENT 'User GUID',
  `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nickname',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Email',
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Phone',
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'First Name',
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Last Name',
  `individual_sign` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Individual Sign',
  `create_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT 'Create Time',
  `update_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT 'Update Time',
  PRIMARY KEY (`guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Profile';

-- --------------------------------------------------------

--
-- Table structure for table `synonyms`
--
-- Creation: Apr 10, 2016 at 12:40 PM
--

DROP TABLE IF EXISTS `synonyms`;
CREATE TABLE IF NOT EXISTS `synonyms` (
  `guid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `word` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headword_guid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`guid`),
  UNIQUE KEY `synonyms_headword_unique` (`word`,`headword_guid`),
  KEY `synonyms_headword_fkey` (`headword_guid`)
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
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `user_profile_fkey` FOREIGN KEY (`guid`) REFERENCES `user` (`guid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `synonyms`
--
ALTER TABLE `synonyms`
  ADD CONSTRAINT `synonyms_headword_fkey` FOREIGN KEY (`headword_guid`) REFERENCES `headword` (`guid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
