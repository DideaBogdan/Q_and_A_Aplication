-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2022 at 12:39 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `q&a_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(38) NOT NULL,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(20) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `email`) VALUES
(1, 'bogdan', '12345678', 'Didea', 'Bogdan', 'dideabogdan@gmail.com'),
(2, 'cosmin', '12345678', 'Ciobotaru', 'Cosmin', 'cosminemail@gmail.com'),
(94, 'dasdasdasdas', '12345678', 'dasdasdas', 'dasdasdasas', 'bogdan@DASda'),
(93, 'user5', '12345678', 'sadsa`', 'eawedasedsa', 'asdasa@sdaasdasas'),
(92, 'user4', '12345678', 'asddadasda', 'dasdasdasafsdfgsd', 'bogdan1@dsfsd.com'),
(91, 'userr3', '123456782131', 'dasasdsadas', 'fdfdgfdgfd', 'bogdan@12112'),
(90, 'userrr', '12345678', 'Didea', 'Bogdan', 'bogdan1@gmail.com'),
(89, 'userr', '12345678', 'Didea', 'Bogdan', 'bogdan@gmail.com'),
(88, 'adsas', 'sdassadasdasda', 'asddas', 'asdas', 'asdasd@dsaq'),
(87, 'bogdan1', '12345678', 'Didea', 'Bogdan', 'dideabogdan1@gmail.com'),
(95, 'user6', '12345678', 'asdas', 'SADASD', 'bogdan@DADASADASD'),
(96, 'user7', '12345678', 'fdasd', 'sdfsdfs', 'bogdan@dsaasdasd'),
(97, 'dasdasdsasdssdasdasd', '12345678', 'asddasdadas', 'dasdasdasda', 'bogdandsasda@Dadsdasda'),
(98, 'user8', '12345678', 'dsadasd', 'dasdasdsa', 'bogdansdaadd@kjhjhkhj');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(38) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
