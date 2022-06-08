-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2022 at 12:59 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_anonymous_question` (IN `p_text` VARCHAR(5000))   BEGIN 
    INSERT into questions (text, user) VALUES (p_text, "");
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_question` (IN `p_text` VARCHAR(5000), IN `p_username` VARCHAR(20))   BEGIN 
	DECLARE val INT;
    SELECT id INTO val FROM users WHERE p_username = username;
    
    INSERT into questions (text, user) VALUES (p_text, val);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_user` (IN `p_username` VARCHAR(20), IN `p_password` VARCHAR(20), IN `p_firstname` VARCHAR(50), IN `p_lastname` VARCHAR(50), IN `p_email` VARCHAR(50))   BEGIN
	INSERT INTO users (username, password, firstname, lastname, email) VALUES (p_username, p_password, p_firstname, p_lastname, p_email);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_questions` ()   BEGIN
	SELECT q.id, q.text, u.username from questions q JOIN users u ON u.id = q.user
    UNION
    SELECT id, text, user from questions WHERE user IS NULL; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `login_by_username` (IN `p_username` VARCHAR(20), IN `p_password` VARCHAR(20))   BEGIN
	SELECT id, username, password FROM users WHERE username = p_username and password = p_password;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `used_username` (IN `p_username` VARCHAR(20), IN `p_email` VARCHAR(50))   BEGIN 
	SELECT username, email FROM users WHERE p_username = username or p_email = email;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(6) UNSIGNED NOT NULL,
  `text` varchar(300) NOT NULL,
  `question` int(6) UNSIGNED NOT NULL,
  `user` int(6) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(6) UNSIGNED NOT NULL,
  `text` varchar(5000) NOT NULL,
  `user` int(6) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `text`, `user`) VALUES
(1, 'intrebare de test', 1),
(2, 'dasdgfgdf', 1),
(3, 'hello this is my first', 2),
(4, 'i hope this works', 1),
(5, 'fdsfsdfs', 1),
(6, 'adasdasdadas', 1),
(7, 'i hope this works 2', 1),
(8, 'i hope this works 2', 1),
(9, 'i hope this works 3', 1),
(10, 'i hope this works 4', 1),
(11, 'i hope this works 5', 1),
(12, 'i hope this works 5', 1),
(13, 'i hope this works 6', 1),
(14, 'i hope this works 7', 1),
(15, 'test intrebare', 1),
(16, 'intrebare pusa de anonim?', NULL);

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
(98, 'user8', '12345678', 'dsadasd', 'dasdasdsa', 'bogdansdaadd@kjhjhkhj'),
(99, 'saSaSsas', '123456781221312312', 'sASasAS', 'aSs', 'bogdansAAS@adsadasdaa'),
(100, 'dasdasdas', '12345678', 'afsdfsdfsd', 'fsdfsdsdfsd', 'bogdanfdsfdswfdsfhg@fgdgdf.com'),
(101, 'bogdan123454', 'sdfsd', 'sdfsdfsd', 'fsdfsdfsdfsdfsd', 'dideabogdan@gmail.com'),
(102, 'bogdandasdasdasda123', '12345678', 'Didea', 'Bogdan', 'dideabogdan@gmail.com1111'),
(103, 'fdsdsdgdfg', '12345678', 'fdgfdgfdg', 'fdgdfgfdgd', 'bogdan@dfsdfsd'),
(104, 'bogdanaqqeqw', '12345678', 'ewqwqeq', 'wqewqeqw', 'bogdan@dsadaadsda'),
(105, 'bogdan111111', '12345678', 'dasdas', 'dasdas', 'dideabogdan@gmail.com'),
(106, 'asdasdasdasas', '12345678', 'Didea', 'Bogdan', 'dideabogdan@gmail.com'),
(107, 'bogdanhjgkhjgghj', '12345678', 'Didea', 'Bogdan', 'dideabogdan@gmail.com'),
(108, 'bogdan11111111', '12345678', 'asdas', 'asda', 'bogdan@ads'),
(109, 'wqewqewqe', '12345678', 'wqeqweqw', 'eqwewqewqewq', 'bogdan@adseqweqwwe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
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
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(38) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
