-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2015 at 09:55 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mangacreator_main`
--
CREATE DATABASE IF NOT EXISTS `mangacreator_main` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mangacreator_main`;

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

DROP TABLE IF EXISTS `collections`;
CREATE TABLE IF NOT EXISTS `collections` (
  `user` varchar(16) NOT NULL,
  `manga_id` int(11) unsigned NOT NULL,
  `date_collected` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
`id` int(10) unsigned NOT NULL,
  `user` varchar(16) NOT NULL,
  `type` varchar(8) NOT NULL,
  `to_id` int(11) unsigned NOT NULL,
  `text` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_post`
--

DROP TABLE IF EXISTS `forum_post`;
CREATE TABLE IF NOT EXISTS `forum_post` (
`id` int(10) unsigned NOT NULL,
  `user` varchar(32) NOT NULL,
  `text` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `topic` varchar(16) NOT NULL,
  `categ` varchar(16) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6532 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_topic`
--

DROP TABLE IF EXISTS `forum_topic`;
CREATE TABLE IF NOT EXISTS `forum_topic` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(16) NOT NULL,
  `user` varchar(32) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `categ` varchar(16) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96 ;

-- --------------------------------------------------------

--
-- Table structure for table `mangas`
--

DROP TABLE IF EXISTS `mangas`;
CREATE TABLE IF NOT EXISTS `mangas` (
`id` int(10) unsigned NOT NULL,
  `user` varchar(16) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_url` longtext NOT NULL,
  `thumbnail` longtext NOT NULL,
  `last_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `avatar` varchar(64) NOT NULL DEFAULT '/imagevault/uploaded/avatars/default.jpg',
  `status` varchar(10) NOT NULL DEFAULT 'user',
  `register` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_old`
--

DROP TABLE IF EXISTS `users_old`;
CREATE TABLE IF NOT EXISTS `users_old` (
`id` int(10) unsigned NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `avatar` varchar(64) NOT NULL DEFAULT '/imagevault/uploaded/avatars/default.jpg',
  `description` varchar(256) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'user',
  `register` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_title_background` varchar(128) NOT NULL DEFAULT '#ffffff',
  `profile_title_background_size` varchar(16) NOT NULL DEFAULT 'auto',
  `profile_title_color` varchar(16) NOT NULL DEFAULT '#000000',
  `profile_title_font` varchar(32) NOT NULL DEFAULT 'Sans-Serif',
  `profile_description_background` varchar(128) NOT NULL DEFAULT '#ffffff',
  `profile_description_background_size` varchar(16) NOT NULL DEFAULT 'auto',
  `profile_description_color` varchar(16) NOT NULL DEFAULT '#000000',
  `profile_description_font` varchar(32) NOT NULL DEFAULT 'monospace',
  `profile_stats_background` varchar(128) NOT NULL DEFAULT '#ffffff',
  `profile_stats_background_size` varchar(16) NOT NULL DEFAULT 'auto',
  `profile_stats_color` varchar(16) NOT NULL DEFAULT '#000000',
  `profile_stats_font` varchar(32) NOT NULL DEFAULT 'monospace',
  `profile_stats_border` varchar(32) NOT NULL DEFAULT '1px solid black',
  `irrelevant` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_profile_style`
--

DROP TABLE IF EXISTS `user_profile_style`;
CREATE TABLE IF NOT EXISTS `user_profile_style` (
  `user` varchar(16) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `title_background` varchar(128) NOT NULL DEFAULT '#ffffff',
  `title_background_size` varchar(16) NOT NULL DEFAULT 'auto',
  `title_color` varchar(16) NOT NULL DEFAULT '#000000',
  `title_font` varchar(32) NOT NULL DEFAULT 'Sans-Serif',
  `description_background` varchar(128) NOT NULL DEFAULT '#ffffff',
  `description_background_size` varchar(16) NOT NULL DEFAULT 'auto',
  `description_color` varchar(16) NOT NULL DEFAULT '#000000',
  `description_font` varchar(32) NOT NULL DEFAULT 'Sans-Serif',
  `stats_background` varchar(128) NOT NULL DEFAULT '#ffffff',
  `stats_background_size` varchar(16) NOT NULL DEFAULT 'auto',
  `stats_color` varchar(16) NOT NULL DEFAULT '#000000',
  `stats_font` varchar(32) NOT NULL DEFAULT 'Sans-Serif',
  `stats_border` varchar(32) NOT NULL DEFAULT '1px solid black',
  `irrelevant` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
CREATE TABLE IF NOT EXISTS `votes` (
  `user` varchar(16) NOT NULL,
  `to_id` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
 ADD PRIMARY KEY (`user`,`manga_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_post`
--
ALTER TABLE `forum_post`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_topic`
--
ALTER TABLE `forum_topic`
 ADD PRIMARY KEY (`id`), ADD FULLTEXT KEY `name_2` (`name`), ADD FULLTEXT KEY `name_3` (`name`);

--
-- Indexes for table `mangas`
--
ALTER TABLE `mangas`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_old`
--
ALTER TABLE `users_old`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profile_style`
--
ALTER TABLE `user_profile_style`
 ADD PRIMARY KEY (`user`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
 ADD PRIMARY KEY (`user`,`to_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=94;
--
-- AUTO_INCREMENT for table `forum_post`
--
ALTER TABLE `forum_post`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6532;
--
-- AUTO_INCREMENT for table `forum_topic`
--
ALTER TABLE `forum_topic`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT for table `mangas`
--
ALTER TABLE `mangas`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `users_old`
--
ALTER TABLE `users_old`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
