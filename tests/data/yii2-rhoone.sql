-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 27, 2016 at 10:23 PM
-- Server version: 5.7.12
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
DROP DATABASE IF EXISTS `rho.one`;
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
-- Creation: Apr 10, 2016 at 12:39 PM
--

DROP TABLE IF EXISTS `headword`;
CREATE TABLE IF NOT EXISTS `headword` (
  `guid` varchar(36) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Headword GUID',
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
-- Table structure for table `synonym`
--
-- Creation: Apr 10, 2016 at 12:40 PM
--

DROP TABLE IF EXISTS `synonym`;
CREATE TABLE IF NOT EXISTS `synonym` (
  `guid` varchar(36) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Synonym GUID',
  `word` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headword_guid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`guid`),
  UNIQUE KEY `synonym_headword_unique` (`word`,`headword_guid`),
  KEY `synonym_headword_fkey` (`headword_guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--
-- Creation: Apr 07, 2016 at 08:25 AM
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `guid` varchar(36) COLLATE utf8_unicode_ci NOT NULL COMMENT 'User GUID',
  `id` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ID',
  `pass_hash` varchar(80) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Password Hash',
  `ip_1` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'IP 1',
  `ip_2` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'IP 2',
  `ip_3` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'IP 3',
  `ip_4` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'IP 4',
  `ip_type` tinyint(3) UNSIGNED NOT NULL DEFAULT '4' COMMENT 'IP Address Type',
  `create_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT 'Create Time',
  `update_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT 'Update Time',
  `auth_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Authentication Key',
  `access_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Access Token',
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Password Reset Token',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT 'Status',
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Type',
  `source` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Source',
  PRIMARY KEY (`guid`),
  UNIQUE KEY `user_id_unique` (`id`),
  KEY `user_auth_key_normal` (`auth_key`),
  KEY `user_access_token_normal` (`access_token`),
  KEY `user_password_reset_token` (`password_reset_token`),
  KEY `user_create_time_normal` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User';

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
-- Constraints for table `synonym`
--
ALTER TABLE `synonym`
  ADD CONSTRAINT `synonym_headword_fkey` FOREIGN KEY (`headword_guid`) REFERENCES `headword` (`guid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
