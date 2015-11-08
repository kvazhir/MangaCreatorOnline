-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2015 at 09:37 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `forum_post`
--

CREATE TABLE IF NOT EXISTS `forum_post` (
`id` int(10) unsigned NOT NULL,
  `user` varchar(32) NOT NULL,
  `text` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `topic` varchar(16) NOT NULL,
  `categ` varchar(16) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `forum_post`
--

INSERT INTO `forum_post` (`id`, `user`, `text`, `timestamp`, `topic`, `categ`) VALUES
(2, 'Rexu', 'dasdqweqwwwwwwwwwwwwdasdqweqwwwwwwwwwwwwdasdqweqwwwwwwwwwwwwdasdqweqwwwwwwwwwwwwdasdqweqwwwwwwwwwwww', '2015-03-26 09:13:07', 'test1', 'introductions'),
(3, 'asd', 'asdasdasdsadas', '2015-03-25 00:36:00', 'test', 'introductions'),
(4, 'qweq', 'eqweqweqweqweqweqe', '0000-00-00 00:00:00', 'test1', 'manga'),
(5, 'qweqw', 'qweqtrqwtqwtqwtqwtqwrqweqweqtrqwtqwtqwtqwtqwrqweqweqtrqwtqwtqwtqwtqwrqweqweqtrqwtqwtqwtqwtqwrqweqweqtrqwtqwtqwtqwtqwrqweqweqtrqwtqwtqwtqwtqwrqweqweqtrqwtqwtqwtqwtqwrqweqweqtrqwtqwtqwtqwtqwrqweqweqtrqwtqwtqwtqwtqwrqwe', '0000-00-00 00:00:00', 'test', 'introductions');

-- --------------------------------------------------------

--
-- Table structure for table `forum_topic`
--

CREATE TABLE IF NOT EXISTS `forum_topic` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(16) NOT NULL,
  `user` varchar(32) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `categ` varchar(16) NOT NULL,
  `posts` int(10) unsigned NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `forum_topic`
--

INSERT INTO `forum_topic` (`id`, `name`, `user`, `timestamp`, `categ`, `posts`) VALUES
(1, 'Potato', 'Rexu', '2015-03-03 05:14:10', 'introductions', 0),
(2, '1234567890123456', '1234567890123456', '2015-03-03 04:00:00', 'introductions', 0),
(3, 'Asdasd', 'Rexu', '2015-03-06 15:36:00', 'manga', 0),
(4, 'test', 'test', '0000-00-00 00:00:00', 'introductions', 0),
(5, 'test1', 'test', '0000-00-00 00:00:00', 'introductions', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mangas`
--

CREATE TABLE IF NOT EXISTS `mangas` (
`id` int(10) unsigned NOT NULL,
  `user` varchar(32) NOT NULL,
  `timestamp` datetime NOT NULL,
  `likes` int(10) unsigned NOT NULL,
  `collects` int(10) unsigned NOT NULL,
  `data_url` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'test1', '123456789', 'test1@gmail.com'),
(4, 'Ishimaru', 'fake_password', '313123123'),
(5, '123123', 'asdasda', 'asdadasa'),
(6, 'Ishimaru', 'fake_password', ''),
(7, 'Ishimarue', 'asda', 'qq'),
(8, 'Ilovepotatoes', '123456`1', 'ssad'),
(9, 'Meownere', '1231312311', 'dasd@sdasd.com'),
(10, 'Ishimaru1', 'qweqwewqeqwweqeweqeqweqeqweqeweqeqweqeqweqweqwweqe', 'easdaa@sdasd.asd'),
(11, 'Ilovepottooo', '123456789', 'lcasd@lasda2.com'),
(12, 'Ishimarudasdasd', 'asdasdassdasd', 'asdasdas@sdasd.asd'),
(13, 'asdadasdasdasda', 'dasdadasdadasd', 'adasdasdasdasdas@asd.asd'),
(14, 'asdadasasd', 'dawdasdasasd', 'dadasda@asdasd.com'),
(15, 'test', 'testtesyutiuiuiu', 'test@gm.com'),
(16, 'test3', 'testtesttest', 'test3@gm.com'),
(17, 'test4', 'testtetsat', 'test4@gm.com'),
(18, 'sadasdsad', 'astgaswte', 'atsaet@gmail.com'),
(19, 'astaswte', 'eataetae', 'gszdgsd@gmail.com'),
(20, 'test0100', '123456789', 'test@test0100.com'),
(21, 'test01', '123456789', 'test1@test.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forum_post`
--
ALTER TABLE `forum_post`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_topic`
--
ALTER TABLE `forum_topic`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forum_post`
--
ALTER TABLE `forum_post`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `forum_topic`
--
ALTER TABLE `forum_topic`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `mangas`
--
ALTER TABLE `mangas`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
