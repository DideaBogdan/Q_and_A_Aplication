-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2022 at 10:18 PM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_anonymous_answer` (IN `p_text` VARCHAR(5000), IN `p_question` INT(20))   BEGIN
	INSERT INTO answers (text, question) VALUES (p_text, p_question);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_anonymous_question` (IN `p_text` VARCHAR(5000))   BEGIN 
    INSERT into questions (text, user) VALUES (p_text, null);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_answer` (IN `p_text` VARCHAR(5000), IN `p_user` VARCHAR(50), IN `p_question` INT(50))   BEGIN
DECLARE 
var INT;
SELECT id INTO var from users where username = p_user; 
	INSERT INTO answers ( text, user, question) VALUES (p_text, var, p_question);
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
	SELECT q.id, q.text, u.username from questions q LEFT OUTER JOIN users u ON u.id = q.user ORDER by q.updated_at desc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_question_answers` (IN `p_id` INT(20))   BEGIN
    SELECT q.id, q.text, u.username,  q.updated_at, q.created_at from questions q LEFT OUTER JOIN users u ON u.id = q.user  WHERE q.id = p_id
    UNION
    SELECT a.id, a.text, u.username, a.updated_at, a.created_at FROM answers a LEFT OUTER JOIN users u ON a.user = u.id WHERE a.id IN (
    SELECT a.id FROM answers a JOIN users u ON a.user = u.id WHERE question = p_id 
    UNION
    SELECT id FROM answers where user IS NULL ORDER BY updated_at desc) ;
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
  `user` int(6) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `text`, `question`, `user`, `created_at`, `updated_at`) VALUES
(1, 'raspuns la prima intrebare', 1, 2, '2022-06-13 18:11:19', '2022-06-13 18:11:19'),
(2, 'prim raspuns', 1, NULL, '2022-06-13 19:10:21', '2022-06-13 19:10:21'),
(3, 'un al doilea raspuns', 1, 1, '2022-06-13 20:02:13', '2022-06-13 20:02:13'),
(4, 'cred ca asta e un raspuns bun', 23, 0, '2022-06-13 20:04:44', '2022-06-13 20:04:44'),
(5, 'cred ca asta e un raspuns bun', 23, 0, '2022-06-13 20:04:57', '2022-06-13 20:04:57'),
(6, 'un al doilea raspuns', 1, 0, '2022-06-13 20:07:13', '2022-06-13 20:07:13'),
(7, 'cred ca asta e un raspuns bun', 23, 1, '2022-06-13 20:15:19', '2022-06-13 20:15:19'),
(8, 'dar asta e un raspuns si mai bun', 23, 1, '2022-06-13 20:15:49', '2022-06-13 20:15:49'),
(9, 'a treia oara e cu noroc', 23, 1, '2022-06-13 20:16:08', '2022-06-13 20:16:08');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(6) UNSIGNED NOT NULL,
  `text` varchar(5000) NOT NULL,
  `user` int(6) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `text`, `user`, `created_at`, `updated_at`) VALUES
(1, 'intrebare de test', 1, '2022-06-04 21:00:00', '2022-06-04 21:00:00'),
(2, 'dasdgfgdf', 1, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(3, 'hello this is my first', 2, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(4, 'i hope this works', 1, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(5, 'fdsfsdfs', 1, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(6, 'adasdasdadas', 1, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(7, 'i hope this works 2', 1, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(8, 'i hope this works 2', 1, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(9, 'i hope this works 3', 1, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(10, 'i hope this works 4', 1, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(11, 'i hope this works 5', 1, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(12, 'i hope this works 5', 1, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(13, 'i hope this works 6', 1, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(14, 'i hope this works 7', 1, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(15, 'test intrebare', 1, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(16, 'intrebare pusa de anonim?', NULL, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(17, 'intrebare pusa de anonim --2', NULL, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(18, 'intrebare pusa de anonim-', NULL, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(19, 'de uitat pe q&a simplu', NULL, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(20, 'intrebare pusa de anonim-', NULL, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(21, 'este frumos afara?', NULL, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(22, 'qwerrtttytrr', NULL, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(23, 'intrebare pusa de anonim-', NULL, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(24, 'intrebare pusa de anonim-23', NULL, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(25, 'intrebare pusa de anonim-5555', 1, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(26, 'intrebare pusa de anonim-1234', NULL, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(27, 'intrebare pusa de anonim-12345', NULL, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(28, 'intrebare pusa de anonim-1234567', NULL, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(29, 'intrebare pusa de anonim-11112', NULL, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(30, 'test-1', 1, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(31, 'test-anonim', NULL, '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(32, 'intrebare pusa de bogdan la 8:19PM', 1, '2022-06-08 17:19:10', '2022-06-08 17:19:10'),
(33, 'intrebare pusa de anonim la 8:19PM', NULL, '2022-06-08 17:19:42', '2022-06-08 17:19:42'),
(34, 'ultima intrebare pusa sa vad daca inca merge', NULL, '2022-06-13 13:58:03', '2022-06-13 13:58:03'),
(35, 'adasdadadads', NULL, '2022-06-13 16:43:25', '2022-06-13 16:43:25'),
(36, 'i hope this works', NULL, '2022-06-13 16:44:07', '2022-06-13 16:44:07'),
(37, 'i hope this works', NULL, '2022-06-13 16:53:47', '2022-06-13 16:53:47'),
(38, 'intrebare pusa de anonim-', NULL, '2022-06-13 16:54:09', '2022-06-13 16:54:09');

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
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(38) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
