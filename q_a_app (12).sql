-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20220618.41c48b423e
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: iun. 22, 2022 la 06:27 AM
-- Versiune server: 10.4.24-MariaDB
-- Versiune PHP: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `q&a_app`
--

DELIMITER $$
--
-- Proceduri
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
-- Structură tabel pentru tabel `answers`
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
-- Eliminarea datelor din tabel `answers`
--

INSERT INTO `answers` (`id`, `text`, `question`, `user`, `created_at`, `updated_at`) VALUES
(158, 'wsdfcgvhbj', 195, NULL, '2022-06-21 12:17:41', '2022-06-21 12:17:41'),
(159, 'Cel mai popular sport este fotbalul.', 198, 125, '2022-06-22 03:25:08', '2022-06-22 03:25:08'),
(160, 'Consider ca este o intrebare care nu isi are rostul.', 196, 125, '2022-06-22 03:37:04', '2022-06-22 03:37:04'),
(161, 'Cum probabil toata lumea stie, Ronaldo.', 202, 125, '2022-06-22 03:37:48', '2022-06-22 03:37:48'),
(162, 'Platon a creat scoala filosofica.', 209, 125, '2022-06-22 03:38:19', '2022-06-22 03:38:19'),
(163, 'Aristotel, deoarece el a dezvoltat sistemul filosofic.', 209, 126, '2022-06-22 03:41:46', '2022-06-22 03:41:46'),
(164, 'Santiago Bernabeu - Madrid, Spania - capacitate : 90000 locuri.', 208, 126, '2022-06-22 03:43:02', '2022-06-22 03:43:02'),
(165, 'Nu', 207, 126, '2022-06-22 03:45:32', '2022-06-22 03:45:32'),
(166, 'In Marea Corarilor, nord-estul Australiei.', 203, 126, '2022-06-22 03:46:48', '2022-06-22 03:46:48'),
(167, 'Real Madrid.', 214, 127, '2022-06-22 03:49:06', '2022-06-22 03:49:06'),
(168, ' Cauză pentru care frunzele cad nu este legată de frig sau iarnă, ci de…secetă!', 200, 127, '2022-06-22 03:50:06', '2022-06-22 03:50:06'),
(169, 'Cu ajutorul extraterestrilor :)).', 205, 127, '2022-06-22 03:51:04', '2022-06-22 03:51:04'),
(170, 'Depinde de cat timp investesti in acel ceva.', 210, 128, '2022-06-22 03:53:11', '2022-06-22 03:53:11'),
(171, 'Incepe din ce in ce mai mult sa fie, si sunt organizate si turnee, oricum ar bate mult inspre sah, nu sport de contact.', 206, 128, '2022-06-22 03:54:34', '2022-06-22 03:54:34'),
(172, 'Din totdeauna.', 204, 129, '2022-06-22 03:56:09', '2022-06-22 03:56:09'),
(173, 'Cel mai probabil nimic, dar cred ca ar fi mai indicat sa consulti un doctor decat sa pierzi timpul pe aici.', 201, 129, '2022-06-22 03:56:51', '2022-06-22 03:56:51'),
(174, 'Muntele este demonstrat ca fiind cel mai bun loc pentru o vacanta pentru persoanele care cauta eliminarea stresului.', 218, 125, '2022-06-22 04:02:36', '2022-06-22 04:02:36'),
(175, '77 de ani', 217, 125, '2022-06-22 04:02:48', '2022-06-22 04:02:48'),
(176, 'Seria de filme Harry Potter, probabil si datorita cartilor aparute precend si a publicitatii masive de care a avut partei inainte de lansare.', 215, 125, '2022-06-22 04:03:34', '2022-06-22 04:03:34'),
(177, 'Nu toate albinele mor', 220, 125, '2022-06-22 04:03:50', '2022-06-22 04:03:50'),
(178, '55 de grade celsius, inregistrata in Valea Mortii, California.', 216, 125, '2022-06-22 04:04:48', '2022-06-22 04:04:48'),
(179, 'Cel mai popula sport din lume este fotbalul, dar este o intrebare specifica pentru fiecare tara.', 213, 125, '2022-06-22 04:05:13', '2022-06-22 04:05:13'),
(180, 'Regula celor 10000 de ora se aplica foarte bine aici, dupa 10000 de ore petrecute in ceva nou, poti spune ca te apropii in a deveni maestru.', 210, 125, '2022-06-22 04:05:58', '2022-06-22 04:05:58'),
(181, 'Este o intrebare care da batai de cap si astazi cercetatorilor.', 205, 125, '2022-06-22 04:06:17', '2022-06-22 04:06:17'),
(182, 'Pentru ca cultura lor se bazeaza pe alte sportutri care de ex nu sunt populare la noi.', 219, 125, '2022-06-22 04:06:41', '2022-06-22 04:06:41'),
(183, 'Real Madrid cu 14 trofee castigate.', 214, 125, '2022-06-22 04:07:42', '2022-06-22 04:07:42'),
(184, 'Acel sport este unul extrem si nu este recomandat nimanui.', 225, 130, '2022-06-22 04:11:02', '2022-06-22 04:11:02'),
(185, 'Piramida lui Keops – Marea Piramidă din Giza/Gizeh Grădinile Suspendate din Babilon – Grădinile Semiramidei Templul Zeiței Artemis din Efes – Templul Dianei Statuia lui Zeus din Olympia Mausoleul din Halicarnas Colosul din Rodos Farul din Alexandria\n', 224, 130, '2022-06-22 04:11:41', '2022-06-22 04:11:41'),
(186, 'Cel recomandat este de 2l, cel mediu de lichide este mai mare, cel de apa mai mic :))', 223, 130, '2022-06-22 04:12:05', '2022-06-22 04:12:05'),
(187, 'El nu este albastru, doar ca noi il vedem asa.', 199, 130, '2022-06-22 04:12:30', '2022-06-22 04:12:30'),
(188, 'Depinde daca este munca fizica sau nu, depinde daca muncesti incontinuu sau nu.', 226, 131, '2022-06-22 04:13:47', '2022-06-22 04:13:47'),
(189, '30 min pe zi odata la 2 zile', 222, 131, '2022-06-22 04:16:33', '2022-06-22 04:16:33'),
(190, 'Deoarece pentru majoritatea animalelor saliva functioneaza drept tratament pentru acele rani.', 221, 132, '2022-06-22 04:18:27', '2022-06-22 04:18:27'),
(191, 'Prin exersare poti oricand sa mareste acel cat.', 226, 132, '2022-06-22 04:19:09', '2022-06-22 04:19:09'),
(192, '?', 195, 132, '2022-06-22 04:19:19', '2022-06-22 04:19:19'),
(193, 'Cea vizuala, desenul.', 228, 133, '2022-06-22 04:21:22', '2022-06-22 04:21:22'),
(194, 'Generalul Sherman, acestia pot fi gasiti in SUA - Carolina de nord si ajung la o inaltime de 75 de m.', 227, 133, '2022-06-22 04:22:50', '2022-06-22 04:22:50');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `badges`
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
-- Eliminarea datelor din tabel `badges`
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
-- Structură tabel pentru tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(38) NOT NULL,
  `name` varchar(500) NOT NULL,
  `questions_count` int(38) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `questions_count`) VALUES
(1, 'Natura', 32),
(2, 'Sport', 12),
(5, 'Diverse', 88);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `questions`
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
-- Eliminarea datelor din tabel `questions`
--

INSERT INTO `questions` (`id`, `text`, `user`, `category`, `created_at`, `updated_at`) VALUES
(195, 'asdfghjkl', 116, 'Natura', '2022-06-21 12:16:16', '2022-06-21 12:16:16'),
(196, 'o intrebare de test care contine cuvantul Natura', 116, 'Natura', '2022-06-21 12:16:16', '2022-06-21 12:16:16'),
(197, 'o intrebare de test care contine cuvantul ', 116, 'Sport', '2022-06-21 12:16:16', '2022-06-21 12:16:16'),
(198, 'Care este cel mai popular sport?', NULL, 'Sport', '2022-06-22 03:23:20', '2022-06-22 03:23:20'),
(199, 'De ce este cerul albastru?', 125, 'Diverse', '2022-06-22 03:25:34', '2022-06-22 03:25:34'),
(200, 'De ce, toamna, cad frunzele?', 125, 'Natura', '2022-06-22 03:26:10', '2022-06-22 03:26:10'),
(201, 'Ce se intampla daca cainele meu a inghitit o bila de golf?', 125, 'Diverse', '2022-06-22 03:27:24', '2022-06-22 03:27:24'),
(202, 'Cine este cel mai bun jucator de fotbal?', 125, 'Sport', '2022-06-22 03:28:46', '2022-06-22 03:28:46'),
(203, 'Unde se gaseste cea mai mare bariera de corali?', 125, 'Natura', '2022-06-22 03:29:28', '2022-06-22 03:29:28'),
(204, 'De cand au inceput oamenii sa aiba notiunea timpului?', 125, 'Diverse', '2022-06-22 03:29:46', '2022-06-22 03:29:46'),
(205, 'Cum au fost construite piramidele?', 125, 'Diverse', '2022-06-22 03:29:59', '2022-06-22 03:29:59'),
(206, 'Ar trebui ca gamingul sa fie considerat un sport?', 125, 'Sport', '2022-06-22 03:30:30', '2022-06-22 03:30:30'),
(207, 'Este ciclul anotimpurilor valabil pentru toate continentele?', 125, 'Natura', '2022-06-22 03:32:28', '2022-06-22 03:32:28'),
(208, 'Care este cel mai cunoscut stadion din lume?', 125, 'Sport', '2022-06-22 03:34:22', '2022-06-22 03:34:22'),
(209, 'Cine este considerat ca fiind parintele filosofiei?', 125, 'Diverse', '2022-06-22 03:35:04', '2022-06-22 03:35:04'),
(210, 'Cat de mult dureaza pana cand poti invata ceva nou?', NULL, 'Diverse', '2022-06-22 03:39:55', '2022-06-22 03:39:55'),
(211, 'Cine a inventat centura de siguranta.', 126, 'Diverse', '2022-06-22 03:43:21', '2022-06-22 03:43:21'),
(212, 'Cat de mult timp ne va lua, daca se va intampla vreodata, sa ajungem sa traim pe alte planete?', 126, 'Diverse', '2022-06-22 03:43:46', '2022-06-22 03:43:46'),
(213, 'Cel mai popual sport din lume?', 126, 'Sport', '2022-06-22 03:44:04', '2022-06-22 03:44:04'),
(214, 'Care este clubul cu cele mai multe Champions League castigate?', 126, 'Sport', '2022-06-22 03:44:30', '2022-06-22 03:44:30'),
(215, 'Care este filmul care a avut cel mai mare succes la lansare?', 127, 'Diverse', '2022-06-22 03:48:31', '2022-06-22 03:48:31'),
(216, 'Care este temperatura maxima atinsa vreodata la suprafata pamantului?', 127, 'Natura', '2022-06-22 03:48:55', '2022-06-22 03:48:55'),
(217, 'Care este speranta de viata medie a unui om?', 128, 'Diverse', '2022-06-22 03:52:01', '2022-06-22 03:52:01'),
(218, 'Ce peisaj natural este demonstrat ca fiind relaxant?', 128, 'Natura', '2022-06-22 03:52:48', '2022-06-22 03:52:48'),
(219, 'De ce nu este fotbalul popular in SUA?', 129, 'Sport', '2022-06-22 03:55:51', '2022-06-22 03:55:51'),
(220, 'De ce mor albinele atunci cand ne inteapa?', 125, 'Diverse', '2022-06-22 03:57:54', '2022-06-22 03:57:54'),
(221, 'De ce isi ling animalele ranile?', 125, 'Natura', '2022-06-22 03:58:24', '2022-06-22 03:58:24'),
(222, 'Cat timp este recomandat sa exersam saptamanal?', 125, 'Sport', '2022-06-22 03:59:19', '2022-06-22 03:59:19'),
(223, 'Care este consumul mediu de apa pentru un adult?', 125, 'Diverse', '2022-06-22 03:59:42', '2022-06-22 03:59:42'),
(224, 'Care sunt cele 7 minuni ale lumii?', 125, 'Natura', '2022-06-22 04:01:57', '2022-06-22 04:01:57'),
(225, 'Este recomandat cave-divingul incepatorilor?', NULL, 'Sport', '2022-06-22 04:09:02', '2022-06-22 04:09:02'),
(226, 'Cat ai putea muncii zilnic pana sa ajungi la epuizare?', 130, 'Diverse', '2022-06-22 04:10:40', '2022-06-22 04:10:40'),
(227, 'Care este cel mai mare copac din lume?', 131, 'Natura', '2022-06-22 04:16:56', '2022-06-22 04:16:56'),
(228, 'Care este cea mai cunoscuta forma de arta?', 132, 'Diverse', '2022-06-22 04:20:03', '2022-06-22 04:20:03'),
(229, 'De ce avem nevoie de 8 ore de somn?', 133, 'Diverse', '2022-06-22 04:21:05', '2022-06-22 04:21:05');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `reactions`
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
-- Eliminarea datelor din tabel `reactions`
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
(1, 0, 0, 1, 116, 194),
(1, 1, 0, 0, 125, 209),
(1, 0, 1, 0, 125, 208),
(1, 1, 0, 0, 125, 207),
(1, 1, 0, 0, 125, 205),
(1, 1, 0, 0, 125, 206),
(1, 0, 1, 0, 125, 204),
(1, 1, 0, 0, 125, 203),
(1, 0, 1, 0, 125, 202),
(1, 1, 0, 0, 125, 201),
(1, 1, 0, 0, 125, 200),
(1, 1, 0, 0, 125, 199),
(1, 0, 1, 0, 125, 195),
(1, 1, 0, 0, 125, 198),
(1, 0, 1, 0, 125, 196),
(1, 0, 1, 0, 125, 197),
(0, 1, 0, 0, 125, 160),
(0, 1, 0, 0, 126, 162),
(0, 1, 0, 0, 126, 163),
(1, 1, 0, 0, 126, 213),
(1, 1, 0, 0, 126, 212),
(1, 0, 1, 0, 126, 211),
(0, 0, 1, 0, 126, 165),
(1, 1, 0, 0, 126, 207),
(1, 0, 1, 0, 126, 209),
(1, 1, 0, 0, 126, 208),
(1, 0, 1, 0, 126, 207),
(1, 1, 0, 0, 126, 206),
(1, 1, 0, 0, 126, 203),
(1, 1, 0, 0, 127, 214),
(0, 1, 0, 0, 127, 167),
(1, 1, 0, 0, 127, 215),
(1, 1, 0, 0, 127, 213),
(1, 1, 0, 0, 127, 212),
(1, 1, 0, 0, 127, 210),
(1, 1, 0, 0, 127, 211),
(1, 1, 0, 0, 127, 208),
(1, 1, 0, 0, 127, 207),
(1, 1, 0, 0, 127, 205),
(1, 1, 0, 0, 127, 204),
(1, 1, 0, 0, 127, 201),
(1, 1, 0, 0, 127, 200),
(1, 1, 0, 0, 127, 200),
(0, 1, 0, 0, 127, 168),
(1, 1, 0, 0, 127, 200),
(1, 1, 0, 0, 128, 217),
(1, 0, 1, 0, 128, 206),
(0, 1, 0, 0, 128, 171),
(0, 1, 0, 0, 125, 167),
(0, 1, 0, 0, 125, 183),
(1, 1, 0, 0, 130, 225),
(1, 1, 0, 0, 130, 199),
(0, 0, 1, 0, 130, 187),
(1, 1, 0, 0, 132, 227),
(1, 1, 0, 0, 132, 226),
(1, 0, 1, 0, 132, 225),
(1, 1, 0, 0, 132, 224),
(1, 1, 0, 0, 133, 229),
(1, 1, 0, 0, 133, 228),
(1, 1, 0, 0, 133, 226),
(1, 1, 0, 0, 133, 227),
(1, 0, 1, 0, 133, 225),
(1, 1, 0, 0, 133, 223),
(1, 1, 0, 0, 133, 224),
(1, 1, 0, 0, 133, 221),
(1, 1, 0, 0, 133, 222),
(1, 1, 0, 0, 133, 220),
(1, 1, 0, 0, 133, 219),
(1, 1, 0, 0, 133, 218),
(1, 1, 0, 0, 133, 217),
(1, 1, 0, 0, 133, 216),
(1, 1, 0, 0, 133, 215),
(1, 1, 0, 0, 133, 214),
(1, 0, 1, 0, 133, 212),
(1, 0, 1, 0, 133, 211),
(1, 1, 0, 0, 133, 209),
(1, 1, 0, 0, 133, 208);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users`
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
-- Eliminarea datelor din tabel `users`
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
(124, 'bogdan3aaaaa', '$2y$10$f9oESJsid4h56qbcK2G8i.KR2L8XNDFyYVXTFyb6JNfQpe36z/Asa', 'sdaasdas', 'dasdasdsa', 'bogdan@qeasfascaaa', 0),
(125, 'contadmin', '$2y$10$5FiLOf2OTE4SoDHWLWQIgOT4Lfo6tDIxR.5548uD8qvJUMBZRxP9G', 'Admin', 'Super', 'admin@gmail.com', 1),
(126, 'sebi', '$2y$10$gWEviWqEKeKa/RJxFubMieWDlweZlJzBsHpaVgSoWDrsPVujzkUfu', 'Drumia', 'Sebastian', 'sebastiandrumia@gmail.com', 0),
(127, 'serverus001', '$2y$10$xdfEM.L5N9xgxgFmejkJCeqo8CnDA/IBwz1jDms3Kl2AKeYmqmI7K', 'Serverus', 'Snape', 'snape@gmail.com', 0),
(128, 'srq00', '$2y$10$iEZUrOwUS8Ray21DRVui..uyjSzcMDBK8gzbgB.6hflILnkVDY/7.', 'Alex', 'Arnold', 'arnld@gmail.com', 0),
(129, 'Criss', '$2y$10$KxX3fLpLI3l0oZx5kbldXu14jojLFfjm4pAk4kE2YgZM83A71QYbW', 'Cristian', 'David', 'CRSD@yahoo.com', 0),
(130, 'Raul', '$2y$10$0O8tbRJXwvYKGsiSjioSzul3ERzbjCnfMglAyyfH9TEFnzzdK2X9O', 'Raul', 'Mihai', 'mihai@gmail.com', 0),
(131, 'Leonardd', '$2y$10$Vk9QztyeI0yi/Hnu8hH0POPigGx5TBbqOLws.i1vMMmLNJp1ppMay', 'Leonard', 'Nucsa', 'Lard21@gmail.com', 0),
(132, 'Mircea', '$2y$10$KTUAb8815w0gGW2INK0Hh.npzlSHh8VUaFakHy3bViW.yAzb9LqlW', 'Mircea', 'Ionica', 'Mircea@yahoo.com', 0),
(133, 'Markus', '$2y$10$qn2MNsbNEZFnMOPXwTxW.OKHpFeNsmmbKX.DchmIa7/e5/sjJOQpa', 'Markus', 'Zenn', 'Mrkz@gmail.com', 0);

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT pentru tabele `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(38) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pentru tabele `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT pentru tabele `users`
--
ALTER TABLE `users`
  MODIFY `id` int(38) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



