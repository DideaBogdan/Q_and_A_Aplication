-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2022 at 12:43 PM
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
(6, 'un al doilea raspuns', 1, 0, '2022-06-13 20:07:13', '2022-06-13 20:07:13'),
(7, 'cred ca asta e un raspuns bun', 23, 1, '2022-06-13 20:15:19', '2022-06-13 20:15:19'),
(8, 'dar asta e un raspuns si mai bun', 23, 1, '2022-06-13 20:15:49', '2022-06-13 20:15:49'),
(9, 'a treia oara e cu noroc', 23, 1, '2022-06-13 20:16:08', '2022-06-13 20:16:08'),
(10, 'un raspuns cult dom\'le', 44, 1, '2022-06-14 15:51:04', '2022-06-14 15:51:04'),
(11, 'alt raspuns', 44, 1, '2022-06-14 16:02:26', '2022-06-14 16:02:26'),
(12, 'e stricata ceva functie din baza de date...', 1, 1, '2022-06-14 16:03:00', '2022-06-14 16:03:00'),
(13, 'sadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadadad', 44, NULL, '2022-06-16 15:16:10', '2022-06-16 15:16:10'),
(14, 'saddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsdffdghdddddddddddddddddddddddddddddd fd gfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgdfgdf', 52, NULL, '2022-06-16 15:30:50', '2022-06-16 15:30:50'),
(15, 'SADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADADSADDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDSADASDASDASDASDASDASDASDASDASDASDASDASDASDHJSF KSDH KSD SDLK HSDKJSD GSDSH JDK HSD JAK JJ HADJKASG ', 52, NULL, '2022-06-16 15:40:40', '2022-06-16 15:40:40'),
(16, 'saddasdasdasdasda', 52, NULL, '2022-06-16 21:28:47', '2022-06-16 21:28:47'),
(17, 'asdasdasdasfdas asd as das das', 54, 1, '2022-06-16 21:30:52', '2022-06-16 21:30:52'),
(18, 'asdasdasdadas', 54, 1, '2022-06-17 07:42:10', '2022-06-17 07:42:10'),
(19, 'wqewqfxcz  as xz vxz', 55, 2, '2022-06-18 01:21:07', '2022-06-18 01:21:07'),
(20, 'xczxcxzz s sdf asda ', 55, 1, '2022-06-18 09:37:11', '2022-06-18 09:37:11'),
(21, '', 55, NULL, '2022-06-18 10:18:13', '2022-06-18 10:18:13'),
(22, 'dsaasd asa as asdd a', 55, NULL, '2022-06-18 10:20:40', '2022-06-18 10:20:40'),
(23, ' dasb hj ojasb asbkhas sdb  a\n', 67, NULL, '2022-06-18 12:32:58', '2022-06-18 12:32:58'),
(24, 'dasds ad asjld hasjk has as hask; as as;jas\' \'as jas a \n\n', 70, 111, '2022-06-18 20:17:45', '2022-06-18 20:17:45'),
(25, 'dasas dsad as das ds', 70, 111, '2022-06-18 20:18:16', '2022-06-18 20:18:16'),
(26, 'un al treilea raspuns\n', 70, 111, '2022-06-18 20:18:35', '2022-06-18 20:18:35');

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
(1, 'Natura', 3),
(2, 'Sport', 3),
(5, 'Diverse', 5);

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
(1, 'intrebare de test', 1, '', '2022-06-04 21:00:00', '2018-12-05 22:00:00'),
(2, 'dasdgfgdf', 1, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(3, 'hello this is my first', 2, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(4, 'i hope this works', 1, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(5, 'fdsfsdfs', 1, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(6, 'adasdasdadas', 1, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(7, 'i hope this works 2', 1, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(8, 'i hope this works 2', 1, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(9, 'i hope this works 3', 1, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(10, 'i hope this works 4', 1, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(11, 'i hope this works 5', 1, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(12, 'i hope this works 5', 1, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(13, 'i hope this works 6', 1, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(14, 'i hope this works 7', 1, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(15, 'test intrebare', 1, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(16, 'intrebare pusa de anonim?', NULL, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(17, 'intrebare pusa de anonim --2', NULL, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(18, 'intrebare pusa de anonim-', NULL, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(19, 'de uitat pe q&a simplu', NULL, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(20, 'intrebare pusa de anonim-', NULL, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(21, 'este frumos afara?', NULL, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(22, 'qwerrtttytrr', NULL, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(23, 'intrebare pusa de anonim-', NULL, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(24, 'intrebare pusa de anonim-23', NULL, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(25, 'intrebare pusa de anonim-5555', 1, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(26, 'intrebare pusa de anonim-1234', NULL, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(27, 'intrebare pusa de anonim-12345', NULL, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(28, 'intrebare pusa de anonim-1234567', NULL, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(29, 'intrebare pusa de anonim-11112', NULL, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(30, 'test-1', 1, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(31, 'test-anonim', NULL, '', '2022-06-07 21:00:00', '2022-06-07 21:00:00'),
(32, 'intrebare pusa de bogdan la 8:19PM', 1, '', '2022-06-08 17:19:10', '2022-06-08 17:19:10'),
(33, 'intrebare pusa de anonim la 8:19PM', NULL, '', '2022-06-08 17:19:42', '2022-06-08 17:19:42'),
(34, 'ultima intrebare pusa sa vad daca inca merge', NULL, '', '2022-06-13 13:58:03', '2022-06-13 13:58:03'),
(35, 'adasdadadads', NULL, '', '2022-06-13 16:43:25', '2022-06-13 16:43:25'),
(36, 'i hope this works', NULL, '', '2022-06-13 16:44:07', '2022-06-13 16:44:07'),
(37, 'i hope this works', NULL, '', '2022-06-13 16:53:47', '2022-06-13 16:53:47'),
(38, 'intrebare pusa de anonim-', NULL, '', '2022-06-13 16:54:09', '2022-06-13 16:54:09'),
(39, 'o intrebare de test cu form-ul de intrbare customizat', 1, '', '2022-06-14 14:49:17', '2022-06-14 14:49:17'),
(44, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ut pellentesque ante, vel gravida sem. Nullam neque nibh, porta eu dui sed, porttitor tempor augue. In laoreet justo in justo scelerisque, id rutrum mauris sollicitudin. Sed commodo, ex quis tincidunt suscipit, felis odio ultrices orci, at accumsan sapien erat vel lacus. Vestibulum tristique eu nunc et ullamcorper. Maecenas in iaculis ex, sed efficitur sapien. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce aliquet id libero quis porttitor. Aenean id nunc tristique, facilisis purus sit amet, congue elit. Quisque condimentum lorem condimentum lobortis euismod. Vivamus a pretium sem. Aenean consequat dui lectus, id sagittis tortor congue vitae. Vestibulum vulputate nec magna a elementum. Morbi ultrices nisi ex. Morbi a lectus sodales, vulputate est quis, egestas purus. Donec eleifend elit consectetur purus eleifend, at tempus tellus convallis. Etiam vulputate feugiat arcu, ut placerat velit cursus at. Maecenas eget sagittis massa. Morbi sapien sapien, rutrum et velit vitae, tempus imperdiet nisi. Duis ligula odio, suscipit ut turpis et, elementum euismod lorem. Vivamus vel congue purus, eget tincidunt magna. Etiam feugiat orci diam, ac tincidunt neque scelerisque ut. Integer vitae scelerisque lorem, in dignissim tortor. Vivamus ac tristique eros, et tincidunt metus. Etiam quis placerat sapien. Proin tempor, velit ut suscipit ultricies, nibh risus sodales velit, sed sodales turpis lorem eget dolor. Morbi nisl augue, dignissim ut tristique eget, fringilla in quam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec placerat cursus ipsum eget ullamcorper. Sed consectetur tempus luctus. Vestibulum posuere, arcu ut mollis ultricies, arcu eros dapibus nisi, a posuere erat ante vitae dui. Sed varius pharetra hendrerit. Suspendisse gravida bibendum neque, quis interdum mauris venenatis vitae. Pellentesque finibus nisi urna, sed sagittis nibh commodo nec. Quisque iaculis orci sollicitudin, pharetra orci sed, egestas magna. Maecenas a nibh eget elit congue blandit a at risus. Ut orci ante, tincidunt vel sollicitudin eget, varius nec urna. Nulla nec nisi auctor diam vulputate laoreet nec in est. Nam rutrum metus id leo blandit, id suscipit massa ultricies. Nam mollis tempus tortor a feugiat. Sed nec lorem vel quam lobortis egestas. Ut id enim tristique, fringilla dolor a, egestas velit. Donec hendrerit eget neque at faucibus. Etiam elit eros, facilisis ac lobortis ac, mollis nec augue. Integer at tortor id odio dignissim aliquet. Ut feugiat, mi nec gravida dignissim, ligula leo molestie nibh, quis facilisis velit erat nec risus. Donec nec mattis sapien. Ut et pellentesque elit, at laoreet dolor. Nam volutpat commodo ante id tincidunt. Curabitur maximus accumsan lorem, vestibulum tincidunt erat blandit vel. Donec id libero quis velit ultricies tempus. In tempor lacus dui, at dignissim risus varius vel. Maecenas tellus odio, sollicitudin et nisl id, finibus vestibulum lectus. Nam ullamcorper ac ligula vel hendrerit. Aliquam facilisis bibendum tellus, sit amet commodo erat malesuada in. Fusce sed dui vitae dolor sollicitudin posuere in a augue. Curabitur vel nulla quis enim luctus aliquet non in ligula. Ut volutpat cursus orci, non dignissim justo venenatis auctor. Phasellus tincidunt felis non tempus bibendum. Vestibulum mollis, mi vitae facilisis luctus, odio mi semper erat, sit amet suscipit lectus orci ac quam. Integer posuere mi vitae eros consequat, ut vehicula metus feugiat. Fusce eget ex neque. Sed nec venenatis purus, in elementum libero. Aenean dapibus scelerisque malesuada. Sed ut tincidunt enim, ac dapibus lectus. Nunc suscipit velit nec lectus bibendum, ut efficitur dolor hendrerit.', 1, '', '2022-06-14 15:09:43', '2022-06-14 15:09:43'),
(45, 'intrebaree     cu     multe    spatii    ', 1, '', '2022-06-14 15:36:31', '2022-06-14 15:36:31'),
(46, 'intrebare    care   are multe spatii    dar sppeeeee rrrr ca mergeeee   ', 1, '', '2022-06-14 15:38:41', '2022-06-14 15:38:41'),
(47, '    asddas      ', 1, '', '2022-06-14 15:38:54', '2022-06-14 15:38:54'),
(48, 'adadasdasdadada daasdas asddasda', 1, '', '2022-06-14 15:41:28', '2022-06-14 15:41:28'),
(49, 'intrebare de test', 1, '', '2022-06-14 16:02:40', '2022-06-14 16:02:40'),
(50, 'adsdfsvdffdgdfgdfgdfgdgdf', 1, '', '2022-06-14 16:06:56', '2022-06-14 16:06:56'),
(52, 'wqeqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqasdasdaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaasdasdasdasdas', NULL, '', '2022-06-16 15:05:07', '2022-06-16 15:05:07'),
(53, 'intrebare recenta', NULL, '', '2022-06-16 15:58:32', '2022-06-16 15:58:32'),
(54, 'hbvjh hhj uy', NULL, '', '2022-06-16 16:42:23', '2022-06-16 16:42:23'),
(55, 'intrebare ca sa vad daca merge sistemul de like/ dislike', 1, '', '2022-06-17 21:26:56', '2022-06-17 21:26:56'),
(59, 'dsad ssd fsfse', NULL, '', '2022-06-18 11:19:01', '2022-06-18 11:19:01'),
(60, 'prima intrebare cu categorie?', NULL, '', '2022-06-18 11:42:49', '2022-06-18 11:42:49'),
(61, 'intrebare care incrementeaza categoria diverse', NULL, '', '2022-06-18 11:46:15', '2022-06-18 11:46:15'),
(62, 'intrebare care incrementeaza categoria diverse', NULL, '', '2022-06-18 11:46:53', '2022-06-18 11:46:53'),
(63, 'd dadhas djd khjasj b asl das ndas da', NULL, 'Diverse', '2022-06-18 11:52:09', '2022-06-18 11:52:09'),
(64, 'intrebare la Natura', NULL, 'Diverse', '2022-06-18 11:53:43', '2022-06-18 11:53:43'),
(65, 'intrebre la sport', NULL, 'Sport', '2022-06-18 11:55:53', '2022-06-18 11:55:53'),
(66, 'alta la sport', NULL, 'Sport', '2022-06-18 11:56:25', '2022-06-18 11:56:25'),
(67, 'una la diverse', NULL, 'Diverse', '2022-06-18 11:56:39', '2022-06-18 11:56:39'),
(68, 'asdqdn kas', NULL, 'Diverse', '2022-06-18 14:32:46', '2022-06-18 14:32:46'),
(69, 'das asd asd asd as das as', 111, 'Diverse', '2022-06-18 20:12:44', '2022-06-18 20:12:44'),
(70, 'sdasad as das das dasdasas a as das dasd a', 111, 'Diverse', '2022-06-18 20:13:06', '2022-06-18 20:13:06'),
(71, 'sd sad as as dsa as fsdf sd fsd ds', NULL, 'Natura', '2022-06-19 09:23:12', '2022-06-19 09:23:12');

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `id` int(11) NOT NULL,
  `is_question` tinyint(1) NOT NULL,
  `like` tinyint(1) NOT NULL,
  `dislike` tinyint(1) NOT NULL,
  `user` int(38) NOT NULL,
  `id_post` int(38) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reactions`
--

INSERT INTO `reactions` (`id`, `is_question`, `like`, `dislike`, `user`, `id_post`) VALUES
(312, 1, 0, 1, 1, 47),
(313, 1, 1, 0, 1, 46),
(316, 1, 1, 0, 2, 55),
(317, 1, 0, 1, 2, 54),
(318, 1, 1, 0, 2, 53),
(320, 1, 1, 0, 2, 50),
(322, 1, 1, 0, 2, 52),
(323, 1, 0, 1, 2, 49),
(324, 1, 1, 0, 2, 48),
(325, 1, 1, 0, 2, 47),
(326, 1, 0, 1, 2, 46),
(338, 1, 0, 1, 1, 54),
(339, 1, 1, 0, 1, 53),
(340, 1, 1, 0, 1, 52),
(341, 1, 1, 0, 1, 50),
(343, 1, 1, 0, 1, 49),
(344, 1, 1, 0, 1, 48),
(347, 1, 1, 0, 1, 55),
(349, 0, 1, 0, 1, 19),
(351, 0, 1, 0, 1, 20),
(449, 0, 1, 0, 111, 24),
(450, 0, 0, 1, 111, 25),
(451, 0, 1, 0, 111, 26),
(464, 1, 0, 1, 111, 70);

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
(109, 'wqewqewqe', '12345678', 'wqeqweqw', 'eqwewqewqewq', 'bogdan@adseqweqwwe'),
(110, 'bogdan2', '$2y$10$Jt0ADasB0q4tG', 'Didea', 'Bogdan', 'bogdan@dsadaasa.com'),
(111, 'bogdan3', '$2y$10$SYFmZKZaTDJBgn1JoNuAzuGRu/k8zlrFpgpBtHT0wsHBLHraKxmSK', 'Didea', 'Bogdan', 'bogdan@qeasfasca');

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
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
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
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(38) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=465;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(38) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
