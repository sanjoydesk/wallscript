

-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2014 at 03:11 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `tutorials`
--

CREATE DATABASE `tutorials`;
-- --------------------------------------------------------

--
-- Table structure for table `facebook_posts`
--

CREATE TABLE IF NOT EXISTS `facebook_posts` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(50) NOT NULL,
  `post` varchar(255) NOT NULL,
  `f_image` varchar(50) NOT NULL,
  `date_created` int(11) NOT NULL,
  `userip` varchar(200) NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `facebook_posts`
--

INSERT INTO `facebook_posts` (`p_id`, `f_name`, `post`, `f_image`, `date_created`, `userip`) VALUES
(4, 'www.appsntech.com', 'Hello Wolrd!!', '', 1409165908, '::1'),
(14, 'www.appsntech.com', 'Idea that people fall in love with', '', 1409318934, '::1'),
(23, 'www.appsntech.com', 'Facebook Wallscript', '', 1409319605, '::1'),
(27, 'www.appsntech.com', 'Watching Furious 6', '', 1409432306, '::1'),
(33, 'www.appsntech.com', 'Arree abhi to party shuru hui hai ............ :)', '', 1409492353, '::1'),
(34, 'www.appsntech.com', 'http://www.youtube.com/watch?v=D8I2D6VLQQc', '', 1409515007, '::1'),
(46, 'www.appsntech.com', 'Hello I am fine... how are you ?', '', 1409600976, '::1'),
(47, 'www.appsntech.com', 'https://www.youtube.com/watch?v=hEBRkG9SCcs', '', 1409601286, '::1'),
(51, 'www.appsntech.com', 'Let me check', '', 1409601655, '::1'),
(52, 'www.appsntech.com', 'Must use. Bootstrap theme with widgets', '', 1409602204, '::1'),
(53, 'www.appsntech.com', 'Must Watch Avenger Video', '', 1409602274, '::1'),
(54, 'www.appsntech.com', 'Is this working now ?', '', 1409773195, '::1');


-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2014 at 03:15 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `tutorials`
--

-- --------------------------------------------------------

--
-- Table structure for table `facebook_posts_comments`
--

CREATE TABLE IF NOT EXISTS `facebook_posts_comments` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `userip` varchar(200) NOT NULL,
  `comments` text NOT NULL,
  `date_created` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

--
-- Dumping data for table `facebook_posts_comments`
--

INSERT INTO `facebook_posts_comments` (`c_id`, `userip`, `comments`, `date_created`, `post_id`) VALUES
(3, '::1', 'Hello How WallScript Working ?', 1409174535, 4),
(9, '::1', 'Working great!!', 1409175052, 4),
(17, '::1', 'Hekele', 1409176850, 6),
(18, '::1', 'Write a comment...', 1409176857, 6),
(20, '::1', 'Seems working great!', 1409253400, 6),
(21, '::1', 'hello hello hello', 1409261947, 6),
(22, '::1', 'Hi how are you ?', 1409262095, 6),
(23, '::1', 'This is testing goes here', 1409262256, 6),
(47, '::1', 'It is nice movie', 1409486906, 27),
(48, '::1', 'Yesterday I watched. Good one', 1409486922, 27),
(49, '::1', 'What a idea', 1409491195, 14),
(50, '::1', 'What a song yaar.. Great', 1409492583, 33),
(53, '::1', 'Badshah will overtake Honey singh', 1409492998, 33),
(56, '::1', 'May be lets see', 1409493093, 33),
(59, '::1', 'Waiting for another best compose', 1409493782, 33),
(60, '::1', 'Facebook wall clone... Great job Sanjoy', 1409493817, 23),
(61, '::1', 'Weldone sanjoy. keep it up', 1409493897, 23),
(62, '::1', 'When is the next release ?', 1409494046, 27),
(65, '::1', 'Good Video', 1409600863, 34),
(66, '::1', 'Yes really Nice one', 1409600871, 34),
(67, '::1', 'More features Coming up', 1409601662, 51),
(69, '::1', 'Hello Checking now', 1409602214, 52),
(70, '::1', 'Seems working fine now', 1409602227, 52),
(71, '::1', 'Facebook Wallscript Working great with Bootstrap theme', 1409602283, 53),
(73, '::1', 'Fast and Furious', 1409773918, 54),
(75, '::1', 'Working seems', 1409773944, 54);


