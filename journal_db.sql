-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2026 at 03:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `journal_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `journal`
--

CREATE TABLE `journal` (
  `journal_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `entry_date` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `journal`
--

INSERT INTO `journal` (`journal_id`, `title`, `content`, `entry_date`, `updated_at`) VALUES
(1, 'Be My Own Boyfriend', 'I’ve decided to be my own boyfriend.\r\n\r\nInstead of waiting for someone to text me good morning or make me feel special, I’ll do that for myself. I’ll take care of my own heart, hype myself up, and remind myself that I’m worth choosing.\r\n\r\n', '2026-02-14 20:30:12', '2026-02-14 20:52:04'),
(3, 'Valentine\'s Day', 'I\'m overjoyed that my senior high best friend came to visit, and we went to San Pedro to buy flowers. I got flowers for my mom, and he got fuzzy wired flowers for his boyfriend and then for me. Cute, since my mom got kilig and loved it so much.', '2026-02-14 20:58:41', '2026-02-14 21:00:34'),
(4, 'Goal in Life', 'I\'ve always wanted to have my own house and my dream car; that\'s why I keep on striving to finish my studies and finally have my own life. But I still promise myself that I still support my parents and my brother. After all, all of this hard work is really for them.', '2026-02-14 21:04:16', '2026-02-14 21:04:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `journal`
--
ALTER TABLE `journal`
  ADD PRIMARY KEY (`journal_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `journal`
--
ALTER TABLE `journal`
  MODIFY `journal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
