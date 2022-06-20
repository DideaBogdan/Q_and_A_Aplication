-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2022 at 06:36 AM
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_anonymous_question` (IN `p_text` VARCHAR(5000), IN `p_category` VARCHAR(500))   BEGIN 
    INSERT into questions (text, user) VALUES (p_text, null);
    
     INSERT into questions (text, user, category) VALUES (p_text, null, p_category);
    UPDATE categories SET questions_count = questions_count+1 where p_category = name ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_answer` (IN `p_text` VARCHAR(5000), IN `p_user` VARCHAR(50), IN `p_question` INT(50))   BEGIN
DECLARE 
var INT;
SELECT id INTO var from users where username = p_user; 
	INSERT INTO answers ( text, user, question) VALUES (p_text, var, p_question);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_question` (IN `p_text` VARCHAR(5000), IN `p_username` VARCHAR(20), IN `p_category` VARCHAR(500))   BEGIN 
	DECLARE val INT;
    SELECT id INTO val FROM users WHERE p_username = username;
    
    INSERT into questions (text, user, category) VALUES (p_text, val, p_category);
    UPDATE categories SET questions_count = questions_count+1 where p_category = name ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_reaction` (IN `p_is_question` BOOLEAN, IN `p_like` BOOLEAN, IN `p_dislike` BOOLEAN, IN `p_user` VARCHAR(50), IN `p_id_post` INT(38))   BEGIN
	DECLARE 
    	user_id INT;
    SELECT id INTO user_id FROM users WHERE trim(username) = trim(p_user);
    
    INSERT INTO reactions (is_question, `like`, dislike, user, id_post) VALUES (p_is_question, p_like, p_dislike, user_id, p_id_post); 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_user` (IN `p_username` VARCHAR(20), IN `p_password` VARCHAR(300), IN `p_firstname` VARCHAR(50), IN `p_lastname` VARCHAR(50), IN `p_email` VARCHAR(50))   BEGIN
	INSERT INTO users (username, password, firstname, lastname, email) VALUES (p_username, p_password, p_firstname, p_lastname, p_email);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_answer` (IN `p_id` INT(38))   BEGIN
	DELETE FROM answers WHERE id = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_question` (IN `p_id` INT(38))   BEGIN
	DELETE FROM questions WHERE id = p_id;
    DELETE FROM answers WHERE question = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_reaction` (IN `p_user` VARCHAR(38), IN `p_id_post` INT(38))   BEGIN
	DECLARE 
    	user_id INT;
    SELECT id INTO user_id FROM users WHERE trim(username) = trim(p_user);
    
    DELETE FROM reactions WHERE user = user_id AND id_post = p_id_post;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_answers` (IN `p_id` INT(50))   BEGIN
    SELECT a.id, a.text, u.username,  a.updated_at, a.created_at from answers a LEFT OUTER JOIN users u ON u.id = a.user  WHERE a.question = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_categories` ()   BEGIN
	SELECT * FROM categories ORDER by name asc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_ledearboard_a` ()   BEGIN
    DECLARE cur_id INT;
    DECLARE stop INT DEFAULT 0;
    DECLARE ct INT DEFAULT 0;
    DECLARE nume VARCHAR(50);
    DECLARE  utilizatori CURSOR FOR SELECT DISTINCT u.id, u.username from users u;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' 
    SET stop = 1;  
    DECLARE CONTINUE HANDLER FOR SQLSTATE '23000' 
    SET stop = 1;
    OPEN utilizatori;
       lbl: LOOP  
    IF stop = 1 THEN  
    LEAVE lbl;  
    END IF;  
    IF NOT stop = 1 THEN
    FETCH utilizatori INTO cur_id, nume; 
      IF stop THEN
      LEAVE lbl;
    END IF;
    SELECT COUNT(*) AS score, cur_id, nume FROM answers WHERE cur_id=answers.user ORDER BY 1;
    END IF;  
    END LOOP;
   CLOSE utilizatori;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_ledearboard_q` ()   BEGIN
    DECLARE cur_id INT;
    DECLARE stop INT DEFAULT 0;
    DECLARE ct INT DEFAULT 0;
    DECLARE nume VARCHAR(50);
    DECLARE  utilizatori CURSOR FOR SELECT u.id, u.username from users u;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' 
    SET stop = 1;  
    DECLARE CONTINUE HANDLER FOR SQLSTATE '23000' 
    SET stop = 1;
    OPEN utilizatori;
       lbl: LOOP  
    IF stop = 1 THEN  
    LEAVE lbl;  
    END IF;  
    IF NOT stop = 1 THEN
    FETCH utilizatori INTO cur_id, nume; 
     IF stop THEN
      LEAVE lbl;
      END if;
    SELECT COUNT(*) AS score, cur_id,nume FROM questions WHERE cur_id=questions.user ORDER by 1;
    END IF;  
    END LOOP;
   CLOSE utilizatori;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_question` (IN `p_id` INT(20))   BEGIN
    SELECT q.id, q.text, u.username, q.category, q.updated_at, q.created_at from questions q LEFT OUTER JOIN users u ON u.id = q.user  WHERE q.id = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_questions` ()   BEGIN
	SELECT q.id, q.text, u.username, q.category, q.user, q.updated_at from questions q LEFT OUTER JOIN users u ON u.id = q.user ORDER by q.updated_at desc;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_reactions` ()   BEGIN
	SELECT id_post, `like`, dislike, user, is_question from reactions ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_statistics` ()   BEGIN
SELECT COUNT(*) as users FROM users;
SELECT COUNT(*) as questions FROM questions;
SELECT COUNT(*) as answers FROM answers;
SELECT COUNT(*) as q_no_a FROM questions LEFT JOIN answers ON questions.id=answers.question WHERE 
    answers.question IS NULL; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_stats` ()   BEGIN 
	SELECT a.user, a.id FROM users u RIGHT OUTER JOIN answers a ON u.id = a.user ORDER BY u.id asc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `login_by_username` (IN `p_username` VARCHAR(20))   BEGIN
	SELECT id, username, password FROM users WHERE username = p_username ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_answer` (IN `p_id` INT(38), IN `p_text` VARCHAR(5000))   BEGIN
UPDATE answers SET text = p_text WHERE id = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_question` (IN `p_id` INT(38), IN `p_text` VARCHAR(5000))   BEGIN
UPDATE questions SET text = p_text WHERE id = p_id;
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
(49, 'merge si update din site?', 90, 111, '2022-06-20 04:32:28', '2022-06-20 04:32:28');

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE `badges` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `desc_locked` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `badges`
--

INSERT INTO `badges` (`id`, `title`, `description`, `image_path`, `category`, `desc_locked`) VALUES
(1, 'QUESTIONER 1', 'Awarded to users who ask at least 5 questions.', 'images\\badges\\questions\\bronze\\Question-bronze.png', 'questions', 'Unlock this badge by asking 5 questions.'),
(2, 'QUESTIONER 2', 'Awarded to users who ask at least 15 questions.', 'images\\badges\\questions\\silver\\Question-silver.png', 'questions', 'Unlock this badge by asking 15 questions.'),
(3, 'QUESTIONER 3', 'Awarded to users who ask at least 50 questions.', 'images\\badges\\questions\\gold\\Question-gold.png', 'questions', 'Unlock this badge by asking 50 questions.'),
(4, 'QUESTIONER 4', 'Awarded to the user with the most asked questions.', 'images\\badges\\questions\\diamond\\Question-diamond.png', 'questions', 'Unlock this badge by asking the most questions.'),
(5, 'ALL-KNOWING 1', 'Awarded to users who gave at least 10 answers.', 'images\\badges\\answers\\bronze\\Answer-bronze.png', 'answers', 'Unlock this badge by giving 10 answers.'),
(6, 'ALL-KNOWING 2', 'Awarded to users who gave at least 25 answers.', 'images\\badges\\answers\\silver\\Answer-silver.png', 'answers', 'Unlock this badge by giving 25 answers.'),
(7, 'ALL-KNOWING 3', 'Awarded to users who gave at least 100 answers.', 'images\\badges\\answers\\gold\\Answer-gold.png', 'answers', 'Unlock this badge by giving 100 answers.'),
(8, 'ALL-KNOWING 4', 'Awarded to the user who has given the most answers.', 'images\\badges\\answers\\diamond\\Answer-diamond.png', 'answers', 'Unlock this badge by giving the most answers.'),
(9, 'POPULAR 1', 'Awarded to users who manage to get a total of  20 likes.', 'images\\badges\\Likes\\bronze\\Like-bronze.png', 'likes', 'Unlock this badge by getting 20 likes.'),
(10, 'POPULAR 2', 'Awarded to users who manage to get a total of  50 likes.', 'images\\badges\\Likes\\silver\\Like-silver.png', 'likes', ''),
(11, 'POPULAR 3', 'Awarded to users who manage to get a total of  200 likes.', 'images\\badges\\Likes\\gold\\Like-gold.png', 'likes', ''),
(12, 'POPULAR 4', 'Awarded to the user who manages to get the most likes.', 'images\\badges\\Likes\\diamond\\Like-diamond.png', 'likes', ''),
(13, 'LOCKED', 'You have yet to unlock this badge.', 'images\\badges\\locked.png', 'locked', '');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(38) NOT NULL,
  `name` varchar(500) NOT NULL,
  `questions_count` int(38) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `questions_count`) VALUES
(1, 'Natura', 2),
(2, 'Sport', 1),
(5, 'Diverse', 8);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(6) UNSIGNED NOT NULL,
  `text` varchar(5000) NOT NULL,
  `user` int(6) UNSIGNED DEFAULT NULL,
  `category` varchar(500) NOT NULL DEFAULT 'Diverse',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `text`, `user`, `category`, `created_at`, `updated_at`) VALUES
(90, 'merge dasdasd as daads haideee', 111, 'Diverse', '2022-06-20 04:07:44', '2022-06-20 04:07:44');

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `is_question` tinyint(1) NOT NULL,
  `like` tinyint(1) NOT NULL,
  `dislike` tinyint(1) NOT NULL,
  `user` int(38) NOT NULL,
  `id_post` int(38) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reactions`
--

INSERT INTO `reactions` (`is_question`, `like`, `dislike`, `user`, `id_post`) VALUES
(1, 0, 1, 111, 80),
(0, 0, 1, 111, 39),
(1, 1, 0, 111, 83),
(1, 1, 0, 111, 84),
(1, 0, 1, 111, 85),
(0, 1, 0, 111, 41),
(1, 1, 0, 111, 86),
(1, 0, 1, 111, 88),
(1, 1, 0, 111, 89),
(1, 0, 1, 111, 87);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(38) NOT NULL,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(300) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `email`) VALUES
(111, 'bogdan3', '$2y$10$LIJGuw8M/jUbpR.6s1FJLOkqOAUw.l.TrYUbZATeQgvg56xXQG7uS', 'Didea', 'Bogdan', 'bogdan@qeasfasca'),
(112, 'bogdan34', '$2y$10$RFf7gSY3AlhaMJFCj0VrvO4AGY3/mRWi6mwq67okylh0UMYaGkH8C', 'Didea', 'Bogdan', 'bogdan34@dasdasd.com'),
(113, 'bogdansadsadasdaas', '$2y$10$hpDmn3EPxZe69p.CSguUyerc5px4Gi9VyJmE3usqXZgjIxEhrvUiC', 'Didea', 'Bogdan', 'bogdan3@sdasadadsasasddas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
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
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(38) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(38) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
