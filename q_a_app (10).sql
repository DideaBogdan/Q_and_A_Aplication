-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2022 at 01:38 AM
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_reaction` (IN `p_is_question` BOOLEAN, IN `p_like` BOOLEAN, IN `p_dislike` BOOLEAN, IN `p_report` BOOLEAN, IN `p_user` VARCHAR(50), IN `p_id_post` INT(38))   BEGIN
	DECLARE 
    	user_id INT;
    SELECT id INTO user_id FROM users WHERE trim(username) = trim(p_user);
    
    INSERT INTO reactions (is_question, `like`, dislike, report, user, id_post) VALUES (p_is_question, p_like, p_dislike,p_report, user_id, p_id_post); 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_user` (IN `p_username` VARCHAR(20), IN `p_password` VARCHAR(300), IN `p_firstname` VARCHAR(50), IN `p_lastname` VARCHAR(50), IN `p_email` VARCHAR(50))   BEGIN
	INSERT INTO users (username, password, firstname, lastname, email) VALUES (p_username, p_password, p_firstname, p_lastname, p_email);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_answer` (IN `p_id` INT(38))   BEGIN
	SELECT user FROM answers WHERE id = p_id;
	DELETE FROM answers WHERE id = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_question` (IN `p_id` INT(38))   BEGIN
	DELETE FROM questions WHERE id = p_id;
    DELETE FROM answers WHERE question = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_reaction` (IN `p_user` VARCHAR(38), IN `p_like` BOOLEAN, IN `p_dislike` BOOLEAN, IN `p_report` BOOLEAN, IN `p_id_post` INT(38), IN `p_is_question` INT)   BEGIN
	DECLARE 
    	user_id INT;
    SELECT id INTO user_id FROM users WHERE trim(username) = trim(p_user);
    
    DELETE FROM reactions WHERE user = user_id AND id_post = p_id_post and p_is_question = is_question and p_like = `like` and p_dislike = dislike and p_report = report;
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
    SELECT q.id, q.text, u.username, q.category, q.updated_at, q.created_at from questions q LEFT OUTER JOIN users u ON u.id = q.user WHERE q.id = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_questions` ()   BEGIN
	SELECT q.id, q.text, u.username, q.category, q.user, q.updated_at from questions q LEFT OUTER JOIN users u ON u.id = q.user ORDER by q.updated_at desc;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_question_search` (IN `p_data` VARCHAR(5000))   BEGIN
	SELECT * FROM questions WHERE text LIKE CONCAT ('%', p_data, '%') or category LIKE CONCAT ('%', p_data, '%');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_reactions` ()   BEGIN
	SELECT id_post, `like`, dislike, report,  user, is_question from reactions ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_reaction_count` (IN `p_report` BOOLEAN, IN `p_id_post` INT(38), IN `p_is_question` BOOLEAN)   BEGIN
	SELECT count(*) as number from reactions where p_report = report and p_id_post = id_post and p_is_question = is_question;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user_id` (IN `p_username` VARCHAR(500))   BEGIN
	SELECT id from users WHERE username = p_username;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `login_by_username` (IN `p_username` VARCHAR(20))   BEGIN
	SELECT * FROM users WHERE username = p_username ;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `verify_admin` (IN `p_id` INT(38))   BEGIN
	DECLARE nrq INT;
    DECLARE nra INT;
    SELECT count(id) INTO nrq FROM questions WHERE p_id = user;
    SELECT count(id) INTO nra FROM answers WHERE p_id = user;
    
    IF nrq >= 10 AND nra >=10 THEN 
    	UPDATE users SET admin = 1 WHERE id = p_id;
     ELSE
     	UPDATE users SET admin = 0 WHERE id = p_id;
       END IF;
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
(158, 'wsdfcgvhbj', 195, NULL, '2022-06-21 12:17:41', '2022-06-21 12:17:41');

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
(1, 'Natura', 24),
(2, 'Sport', 3),
(5, 'Diverse', 73);

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
(195, 'asdfghjkl', 116, 'Natura', '2022-06-21 12:16:16', '2022-06-21 12:16:16'),
(196, 'o intrebare de test care contine cuvantul Natura', 116, 'Natura', '2022-06-21 12:16:16', '2022-06-21 12:16:16'),
(197, 'o intrebare de test care contine cuvantul ', 116, 'Sport', '2022-06-21 12:16:16', '2022-06-21 12:16:16');

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `is_question` tinyint(1) NOT NULL,
  `like` tinyint(1) NOT NULL,
  `dislike` tinyint(1) NOT NULL,
  `report` tinyint(1) NOT NULL DEFAULT 0,
  `user` int(38) NOT NULL,
  `id_post` int(38) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reactions`
--

INSERT INTO `reactions` (`is_question`, `like`, `dislike`, `report`, `user`, `id_post`) VALUES
(0, 0, 0, 1, 111, 135),
(0, 0, 1, 0, 111, 135),
(1, 1, 0, 0, 111, 152),
(1, 0, 0, 1, 111, 152),
(1, 1, 0, 0, 111, 151),
(1, 0, 0, 1, 111, 151),
(1, 0, 0, 1, 112, 152),
(1, 0, 0, 1, 114, 152),
(1, 0, 0, 1, 114, 151),
(1, 0, 0, 1, 114, 148),
(1, 0, 0, 1, 115, 151),
(1, 0, 0, 1, 115, 148),
(1, 0, 0, 1, 112, 148),
(1, 0, 0, 1, 112, 153),
(1, 0, 0, 1, 112, 153),
(1, 0, 0, 1, 116, 153),
(1, 0, 0, 1, 116, 154),
(1, 0, 0, 1, 116, 155),
(1, 0, 0, 1, 116, 156),
(1, 0, 1, 0, 116, 156),
(1, 0, 0, 1, 116, 157),
(1, 0, 0, 1, 116, 158),
(1, 0, 0, 1, 116, 159),
(1, 0, 0, 1, 116, 160),
(1, 0, 0, 1, 116, 161),
(1, 0, 0, 1, 116, 162),
(1, 0, 0, 1, 116, 162),
(1, 0, 0, 1, 116, 162),
(1, 0, 0, 1, 116, 162),
(1, 0, 0, 1, 116, 162),
(1, 0, 0, 1, 116, 162),
(1, 0, 0, 1, 116, 162),
(1, 0, 0, 1, 116, 163),
(1, 0, 0, 1, 116, 164),
(1, 0, 0, 1, 116, 165),
(1, 0, 0, 1, 116, 166),
(1, 0, 0, 1, 116, 167),
(1, 0, 0, 1, 116, 167),
(1, 0, 0, 1, 116, 167),
(1, 0, 0, 1, 116, 168),
(1, 0, 0, 1, 116, 169),
(1, 0, 0, 1, 116, 170),
(1, 0, 0, 1, 116, 171),
(1, 0, 1, 0, 116, 172),
(1, 0, 0, 1, 116, 172),
(1, 0, 1, 0, 116, 173),
(1, 0, 0, 1, 116, 173),
(0, 0, 0, 1, 116, 136),
(1, 0, 0, 1, 116, 174),
(1, 0, 0, 1, 116, 175),
(1, 0, 0, 1, 116, 176),
(1, 0, 0, 1, 116, 177),
(1, 0, 0, 1, 116, 178),
(1, 0, 0, 1, 116, 179),
(1, 0, 0, 1, 116, 180),
(1, 0, 0, 1, 116, 181),
(1, 0, 0, 1, 116, 182),
(1, 0, 0, 1, 116, 183),
(0, 0, 0, 1, 116, 137),
(1, 0, 0, 1, 116, 184),
(1, 0, 0, 1, 116, 185),
(0, 0, 0, 1, 116, 138),
(0, 0, 0, 1, 116, 139),
(1, 0, 0, 1, 116, 186),
(1, 0, 0, 1, 116, 187),
(1, 0, 0, 1, 116, 187),
(1, 0, 0, 1, 116, 188),
(1, 0, 0, 1, 116, 189),
(0, 0, 0, 1, 116, 141),
(0, 0, 0, 1, 116, 142),
(1, 0, 0, 1, 116, 190),
(0, 0, 0, 1, 116, 144),
(0, 0, 0, 1, 116, 145),
(0, 0, 0, 1, 116, 146),
(0, 0, 0, 1, 116, 147),
(0, 0, 0, 1, 116, 148),
(0, 0, 0, 1, 116, 149),
(0, 0, 0, 1, 116, 150),
(0, 0, 0, 1, 116, 151),
(0, 0, 0, 1, 116, 152),
(0, 0, 0, 1, 116, 153),
(0, 0, 0, 1, 116, 154),
(1, 0, 1, 0, 116, 191),
(1, 0, 0, 1, 116, 191),
(1, 0, 1, 0, 116, 192),
(1, 0, 0, 1, 116, 192),
(1, 0, 0, 1, 116, 192),
(1, 0, 1, 0, 116, 193),
(1, 0, 0, 1, 116, 193),
(0, 1, 0, 0, 116, 156),
(0, 0, 1, 0, 116, 156),
(0, 0, 0, 1, 116, 156),
(1, 1, 0, 0, 111, 193),
(1, 0, 0, 1, 111, 193),
(1, 0, 0, 1, 111, 194),
(1, 1, 0, 0, 111, 194),
(1, 0, 1, 0, 115, 194),
(0, 1, 0, 0, 115, 157),
(0, 0, 0, 1, 115, 157),
(1, 1, 0, 0, 116, 194),
(0, 0, 0, 1, 116, 157),
(1, 0, 0, 1, 116, 194);

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
  `email` varchar(50) NOT NULL DEFAULT '',
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `email`, `admin`) VALUES
(111, 'bogdan3', '$2y$10$LIJGuw8M/jUbpR.6s1FJLOkqOAUw.l.TrYUbZATeQgvg56xXQG7uS', 'Didea', 'Bogdan', 'bogdan@qeasfasca', 0),
(112, 'bogdan34', '$2y$10$RFf7gSY3AlhaMJFCj0VrvO4AGY3/mRWi6mwq67okylh0UMYaGkH8C', 'Didea', 'Bogdan', 'bogdan34@dasdasd.com', 0),
(113, 'bogdansadsadasdaas', '$2y$10$hpDmn3EPxZe69p.CSguUyerc5px4Gi9VyJmE3usqXZgjIxEhrvUiC', 'Didea', 'Bogdan', 'bogdan3@sdasadadsasasddas', 0),
(114, 'bogdan2', '$2y$10$XSCiua1BmqnCUTRgbIJav.sV7/cOHcWfK.hOsdAJNc3FOrqBdXQP.', 'Didea', 'Bogdan', 'bogdan2@gmail.com', 1),
(115, 'bogdan4', '$2y$10$2Wc7QKU6gOPSI.8D2CNc8OooPIDvVJtm86LooF.2MHzJrg1CcQh1C', 'Didea', 'Bogdan', 'bogdan4@gmail.com', 0),
(116, 'bogdan5', '$2y$10$I1v50.7qJDpMy7xEPXTTC.NHbw0FDLKfiV/jk.d8pZEpVzVkwXpRe', 'Didea', 'Bogdan', 'bogdan5@gmail.com', 0),
(117, 'sdassad', '$2y$10$b33Q80qTVuNq9DmsTfCR9e36dXOZ8Cfg1cu.2rCQwSpjlNb3.gbRC', 'asdassda', 'dasdasd', 'sadsadas@fgmadasda', 0),
(118, 'sadas', '$2y$10$ct34o4IqqVfvQGJ9FWzdFOwEPPV5xZr5v199ZYrvAJPG75apChQZe', 'sdaasd', 'dasdasd', 'bdasdsa@ogdan34', 0),
(119, 'asdsadda', '$2y$10$dB0y2oj57K/e0h7rQl9VLuKVmjRn6rzoagkx2WAXEyFk5U3JTZDnK', 'dasd', 'dasda', 'basdaada@ogdan34', 0),
(120, 'sddddsfsd', '$2y$10$AORfBknY.5BZyxMB9E/AreUnRXKD5KvJdvlvMptVy52eGCRjdUiOK', 'fdsfsdfsd', 'fsdfsdfsd', 'bofsdfsdfsd@gdan34', 0),
(121, 'dasdasd', '$2y$10$t.sVfl0Ja1WQXd2Yu1AoRel6gt7m/j3/woAUbo3J6.KbdQ45/NjP2', 'dasdsadsa', 'dadasd', 'bdasdasd@ogdan34', 0),
(122, 'sdsdffsdfsf', '$2y$10$w5pFoSwKGW3io7mwS.Fa2.Yb4mJHRxwNtlwdi9BR7gfCS6xbU7Ck.', 'fsdfsdfsd', 'fsdfsdfs', 'bodasdasdas@gdan34', 0),
(123, 'bogdan', '$2y$10$HXXQdh94/tWlHgmraEjngOyMuhwm2Fl1u0F4AC6/YF1qTab7OZwhi', 'dadas', 'dasdas', 'bogdan5@sdsadasad', 0),
(124, 'bogdan3aaaaa', '$2y$10$f9oESJsid4h56qbcK2G8i.KR2L8XNDFyYVXTFyb6JNfQpe36z/Asa', 'sdaasdas', 'dasdasdsa', 'bogdan@qeasfascaaa', 0);

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
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(38) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(38) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
