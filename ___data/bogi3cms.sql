-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 29, 2014 at 01:59 PM
-- Server version: 5.5.35-0ubuntu0.13.10.1
-- PHP Version: 5.5.3-1ubuntu2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bogi3cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE IF NOT EXISTS `area` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(45) NOT NULL,
  PRIMARY KEY (`area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`area_id`, `area_name`) VALUES
(1, 'article');

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `article_parent_id` int(11) DEFAULT NULL,
  `article_language_id` int(11) DEFAULT NULL,
  `article_desc` varchar(500) DEFAULT NULL,
  `article_keywords` varchar(500) DEFAULT NULL,
  `link` varchar(500) DEFAULT NULL,
  `article_title` varchar(255) NOT NULL,
  `article_text` text,
  `article_seq` int(11) DEFAULT NULL,
  `is_just_parent` tinyint(4) DEFAULT NULL,
  `is_just_link` tinyint(4) NOT NULL DEFAULT '0',
  `article_status` enum('inedit','active','passive') NOT NULL DEFAULT 'inedit',
  PRIMARY KEY (`article_id`),
  KEY `fk_article_id_to_parent_idx` (`article_parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `media_to_object`
--

CREATE TABLE IF NOT EXISTS `media_to_object` (
  `media_to_object_id` int(11) NOT NULL AUTO_INCREMENT,
  `medium_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `priority` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`media_to_object_id`),
  KEY `medium_to_mto_idx` (`medium_id`),
  KEY `fk_media_to_object_1_idx` (`area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `medium`
--

CREATE TABLE IF NOT EXISTS `medium` (
  `medium_id` int(11) NOT NULL AUTO_INCREMENT,
  `mime_type` varchar(45) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `subtitle` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`medium_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(55) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `phone_num` varchar(12) NOT NULL,
  `city` varchar(45) NOT NULL,
  `zip_code` varchar(4) NOT NULL,
  `address` varchar(125) NOT NULL,
  `user_status` enum('tilted','normal','manager','nimda') NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `username`, `first_name`, `last_name`, `phone_num`, `city`, `zip_code`, `address`, `user_status`, `password`) VALUES
(1, 'david@naszta.hu', 'admin', 'Dávid', 'Nasztanovics', '+36203428407', 'Budapest', '1138', 'Révész utca 2/c', 'nimda', '5c8a84351381252780decdeabedb9a92');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_article_id_to_parent` FOREIGN KEY (`article_parent_id`) REFERENCES `article` (`article_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
