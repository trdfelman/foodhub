-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2015 at 04:46 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `foodhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(20) NOT NULL,
  PRIMARY KEY (`id`,`user_email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1101433219883850 ;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `full_name`, `user_email`, `user_password`) VALUES
(1, 'Jameshwart Lopez', 'jameshwartlopez@gmail.com', 'admin'),
(2, 'jameshwartlopez', 'jameshwart@gmail.com', 'admin'),
(3, 'jameshwartlopez', 'jameshwartlopez@gmail.com', 'asdf'),
(4, 'asdf sdf', 'sdfsdfeeeererer@gmail.com', 'admin'),
(5, 'jasper', 'jas@gmail.com', 'admin'),
(965884976769140, 'Jameshwart Lopez', 'jameshwartlopez@gmail.com', ''),
(965884976769141, 'jameshwkjlkj klj', 'lsdjksldkf@gmail.com', 'lsdkjf'),
(965884976769142, 'db', 'xsdf@gmail.com', 'lsdkjf'),
(965884976769143, 'gsdf', 'askdfj@gmai.com', 'lskdjf'),
(965884976769144, 'QDDDD', 'DDDD@GMAIL.COM', 'DSLFJKLKSDFSDKFJ'),
(1090313817662456, 'Felman Buntog', 'phenomenalteen@yahoo.com', ''),
(1090313817662457, 'Felman Buntog', 'trd.felman@gmail.com', 'admin'),
(1090313817662458, 'juan', 'juan@gmail.com', 'admin'),
(1090313817662459, 'pedro', 'pedro@yahoo.com', 'admin'),
(1090313817662460, 'burakyat', 'foo@gmail.com', 'admin'),
(1090313817662461, 'juan tamad', 'juanjuan@gmail.com', '1234567890'),
(1090313817662462, 'juanmasipag', 'juanmasipag@gmail.com', '1234'),
(1090313817662463, 'bleee', 'bleeh@gmail.com', '12345'),
(1101433219883849, 'Felman Buntog', 'phenomenalteen@yahoo.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_review`
--

CREATE TABLE IF NOT EXISTS `user_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placeid` text NOT NULL,
  `user_info_id` bigint(100) NOT NULL,
  `rating` int(11) NOT NULL,
  `reviewtext` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `user_review`
--

INSERT INTO `user_review` (`id`, `placeid`, `user_info_id`, `rating`, `reviewtext`) VALUES
(1, 'ChIJKcMatRKZqTMRWDp2NCg_gRs', 965884976769143, 5, 'lasvegas ktv'),
(2, 'ChIJKcMatRKZqTMRWDp2NCg_gRs', 1, 3, 'pare ha '),
(3, 'ChIJKcMatRKZqTMRWDp2NCg_gRs', 965884976769143, 4, 'jameshwart review text'),
(4, 'ChIJKcMatRKZqTMRWDp2NCg_gRs', 1, 5, 'felman review text'),
(5, 'ChIJ4-_MohCZqTMRUiCNgqe7_v4', 1, 4, 'checkenamit'),
(6, 'ChIJ4-_MohCZqTMRUiCNgqe7_v4', 1, 5, 'checkenamit review text 2'),
(7, 'ChIJh6gtPRSZqTMR3Gsex3maNRY', 1, 0, ''),
(8, 'ChIJwwMU2gSZqTMRPfigMqkWgT0', 1, 5, 'sdf sdfsdfsdf'),
(9, 'ChIJxcliOlSYqTMRGIk1gLWI5-g', 1090313817662456, 5, 'taas ang pila sa BPI atm pirme'),
(10, 'ChIJJbfd4lSYqTMR34zEWuRmy5I', 1090313817662456, 4, 'libog ang ngalan kay east ug west'),
(11, 'ChIJEfUXMrWeqTMRdynVlHmJisA', 1101433219883849, 5, 'Daghan kwarta'),
(12, 'ChIJQ42IO2aZqTMRgVibHdXNHpY', 1101433219883849, 5, '"shame on you" \n                                 -lel'),
(13, 'ChIJjVyOt1SYqTMRx-aKLLHb1-Y', 1101433219883849, 1, 'samok bdo'),
(14, 'ChIJebzpLlKYqTMRIchXbGOvSi4', 1101433219883849, 2, 'langhap sarap sa jobee'),
(15, 'ChIJT4UUEVOYqTMR_hHls7VCIsk', 1101433219883849, 5, 'daghan mumu!'),
(16, 'ChIJw_dhQU6ZqTMRNKl2cv5XdAI', 1090313817662457, 5, 'test review message Bank of Commerce!\n');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
