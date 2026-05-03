-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2026 at 11:17 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `unmute_music`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `playlist_songs`
--

CREATE TABLE IF NOT EXISTS `playlist_songs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playlist_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `playlist_songs`
--

INSERT INTO `playlist_songs` (`id`, `playlist_id`, `song_id`, `added_at`) VALUES
(1, 2, 4, '2026-02-25 06:12:44'),
(3, 3, 2, '2026-02-25 06:14:36'),
(4, 3, 3, '2026-02-27 03:27:56'),
(5, 3, 5, '2026-02-27 03:28:56'),
(6, 3, 1, '2026-02-27 03:34:33'),
(7, 2, 3, '2026-03-04 14:32:42');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE IF NOT EXISTS `songs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `artist` varchar(100) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `song_image` varchar(255) DEFAULT 'default.jpg',
  `artist_image` varchar(255) DEFAULT 'artist.jpg',
  `play_count` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `title`, `artist`, `file`, `song_image`, `artist_image`, `play_count`) VALUES
(1, 'AAJ PHIR', 'ARIJIT SINGH', '1768729176_Aaj Phir - Hate Story 2 [FreshMaza.Info].mp3', '1768729176_arjit.jpeg', '1768729176_arjit.jpeg', 4),
(2, 'AM IN LOVE', 'K.K', '1768733647_Am In Love-2.mp3', '1768733647_WhatsApp Image 2026-01-18 at 4.20.29 PM.jpeg', '1768733647_WhatsApp Image 2026-01-18 at 4.20.29 PM.jpeg', 0),
(3, 'DILNASHIN DILNASHIN', 'K.K', '1768736028_Dilnashin Dilnashin - www.MeraMob.Com.mp3', '1768736028_WhatsApp Image 2026-01-18 at 4.20.29 PM.jpeg', '1768736028_WhatsApp Image 2026-01-18 at 4.20.29 PM.jpeg', 0),
(4, 'BEWAJAH', 'HIMESH RESHAMMIYA', '1768736164_Bewajah 192kbps.mp3', '1768736164_Himesh Reshammiya.jpg', '1768736164_Himesh Reshammiya.jpg', 2),
(5, 'ABHI KUCH DINO SE', 'MOHIT CHAUHAN', '1768736301_Abhi Kuch Dino Se.mp3', '1768736301_Mohit Chauhan Affairs, Net Worth, Age, Height, Bio and More.jpg', '1768736301_Mohit Chauhan Affairs, Net Worth, Age, Height, Bio and More.jpg', 2),
(6, 'TERI UMMED TERA', 'KUMAR SAANU', '1772635984_Teri Ummed Tera Intezar-(MyMp3Singer.com).mp3', '1772635984_1754914078_Thunder.jpeg', '1772635984_kumar saanu.jpg', 4),
(7, 'FALAK TAK', 'UDIT NARAYAN', '1772639745_Falak Tak(PagaiWorld.com).mp3', '1772639745_eng.png', '1772639745_Udit Narayan live in a concert.jpg', 4),
(8, 'LUTT PUTT GAYA', 'ARIJIT SINGH', '1773221445_Lutt Putt Gaya(PagaiWorld.com).mp3', '1773221445_luttput.jpg', '1773221445_arjit.jpeg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `otp_code` varchar(10) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `profile_pic` varchar(255) DEFAULT NULL,
  `song_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `otp_code`, `otp_expiry`, `name`, `email`, `password`, `is_verified`, `profile_pic`, `song_file`) VALUES
(11, NULL, NULL, 'DARSHAN DUTT', 'darshandatt74@gmail.com', '$2y$10$tV5rTwgs.YPtkNPWouqtpedS.x/v8nTEbePyNOaQhoOK47bEGHjv6', 1, '69906594a40c1.png', NULL),
(17, NULL, NULL, 'ROHIT BHAI', 'dantanirohit68@gmail.com', '$2y$10$1wXA1w28ha7rzXjoiwxnHOulFoNvdSp6L/JQGlyf/ojok/UlPl/96', 1, NULL, NULL),
(18, NULL, NULL, 'ANJALI ', 'anjalidatt492@gmail.com', '$2y$10$C3z2wRByjEknC5uqTuT31uP2R9Jioe7KSESwIUwXYZEFkYpeD/ksy', 1, NULL, NULL),
(19, NULL, NULL, 'SNEHA SHAH', 'shahsneha1705@gmail.com', '$2y$10$XPKCyQqbbo4wI0xevD4dGOHtQxCkiJyYSriz4r4wWSa.3yKd8sbwK', 1, '6993f25457519.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_likes`
--

CREATE TABLE IF NOT EXISTS `user_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `song_id` int(11) NOT NULL,
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `user_likes`
--

INSERT INTO `user_likes` (`id`, `user_email`, `song_id`, `added_at`) VALUES
(2, 'darshandatt74@gmail.com', 15, '2026-02-14 17:51:32'),
(3, 'anjalidatt492@gmail.com', 16, '2026-02-14 17:57:37'),
(5, 'shahsneha1705@gmail.com', 20, '2026-02-17 04:47:21'),
(6, 'darshandatt74@gmail.com', 23, '2026-02-18 06:46:28'),
(9, 'darshandatt74@gmail.com', 28, '2026-02-24 05:14:23'),
(10, 'darshandatt74@gmail.com', 1, '2026-03-02 07:17:11');

-- --------------------------------------------------------

--
-- Table structure for table `user_playlist`
--

CREATE TABLE IF NOT EXISTS `user_playlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `song_id` int(11) NOT NULL,
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `user_playlist`
--

INSERT INTO `user_playlist` (`id`, `user_email`, `song_id`, `added_at`) VALUES
(2, 'darshandatt74@gmail.com', 15, '2026-02-14 17:51:33'),
(3, 'anjalidatt492@gmail.com', 16, '2026-02-14 17:57:40'),
(4, 'shahsneha1705@gmail.com', 16, '2026-02-17 04:46:53'),
(6, 'darshandatt74@gmail.com', 23, '2026-02-18 06:46:26'),
(7, 'darshandatt74@gmail.com', 16, '2026-02-24 05:14:42'),
(10, 'darshandatt74@gmail.com', 5, '2026-02-25 05:46:36'),
(11, 'darshandatt74@gmail.com', 6, '2026-02-25 05:52:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_playlists`
--

CREATE TABLE IF NOT EXISTS `user_playlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `playlist_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_playlists`
--

INSERT INTO `user_playlists` (`id`, `user_email`, `playlist_name`, `created_at`) VALUES
(2, 'darshandatt74@gmail.com', 'SAD', '2026-02-25 05:47:35'),
(3, 'darshandatt74@gmail.com', 'LOVE', '2026-02-25 06:13:41');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
