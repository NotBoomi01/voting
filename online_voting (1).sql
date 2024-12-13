-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 13, 2024 at 09:09 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_voting`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `Username`, `Password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Partylist` varchar(255) NOT NULL,
  `Position` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `PoliticalPlatform` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Image` varchar(255) NOT NULL,
  `votes` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `Name`, `Username`, `password`, `Partylist`, `Position`, `birthday`, `PoliticalPlatform`, `Image`, `votes`) VALUES
(2, 'James Reid', 'jamespogi', '$2y$10$14y1N275lbvzV.g1PAeANOMAG9dvhXwqkeU5i7ecq5rWtamUvncWm', 'Blue', 'President', '2024-12-03', 'naniniwala na ako sa forever', 'JAMES_REID_MINT_PERFUME_HOLIDAYS_2015_(26253072737)_(cropped).jpg', 9),
(3, 'Alden Richards', 'yayadub', '$2y$10$NDnw1gf4HwB1f.gUYKZqt.lRTlJUmKVIv3fGwcZ6fJHDKn98I8JSG', 'Red', 'President', '2024-12-03', 'ansarap ni maine mendoza', 'aldeneeee.png', 0),
(4, 'Daniel Padilla', 'dj', '$2y$10$qMCR/M3hJ1i60U3tEShybe7MDcIs7E3gmYZatpPKbPcil3/sZqNgW', 'Blue', 'Vice President', '2024-12-02', 'yummy', 'djj.jpg', 1),
(5, 'Coco Martin', 'coco', '$2y$10$LjxkiQgRqvK2nQ9YZzr1LerZvlNlmn43U2m4UX1XSBCW.1ls.CWti', 'Red', 'Vice President', '2024-01-29', 'tangol', 'coco.png', 2),
(6, 'Leni Robredo', 'leni', '$2y$10$Df6DCqJjGxIEXdOe2Q3gnuTWZwqyaKcnwd9HxdiTCIuBF2pANNZQy', 'Blue', 'Muse', '2024-12-02', 'pinkish', 'Leni_Robredo_Portrait.png', 3),
(7, 'Inday Sara', 'kalbo', '$2y$10$o8N9dkj9G.sZcZOFeTfMHeUXms4/edReDkD4HVDTeNdELLdw2Xi9S', 'Red', 'Muse', '2024-12-02', 'suntukin', 'inday.jpg', 0),
(8, 'Rodrigo Duterte', 'd30', '$2y$10$T9hM9G9gwzNUGvOohgICneFuPZ5CYxsPlVBrFomfIJdYHRZCnUsgy', 'Blue', 'Escort', '2024-12-04', 'droga', 'duterte.jpg', 2),
(9, 'Ferdinand Marcos', 'marcs', '$2y$10$0L33S08qycIEIdoawNiPbOR69aCuVjqDWYq076rixOMCsI99eLAb6', 'Red', 'Escort', '2024-12-03', 'nice', 'marcos.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `partylist`
--

CREATE TABLE `partylist` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `partylist`
--

INSERT INTO `partylist` (`id`, `name`, `description`, `image`) VALUES
(1, 'green', 'Description for Partylist 1', NULL),
(2, 'Partylist Blue', 'Description for Partylist 2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_votes`
--

CREATE TABLE `user_votes` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `candidate_id` int NOT NULL,
  `vote_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voters`
--

CREATE TABLE `voters` (
  `id` int NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `voters`
--

INSERT INTO `voters` (`id`, `LastName`, `FirstName`, `Email`, `Username`, `password`, `is_admin`) VALUES
(19, 'asd', 'asd', 'asd@asd', 'asd', '$2y$10$DvLlg26Iw4nRaF2Uq1UrPurO5QNtKu2Ickw7aEqWEtSymOKx4GXry', 0),
(20, 'qwe', 'qwe', 'qwe@qwe', 'qwe', '$2y$10$bnzpb3foWbk45u9KD.Nm5uNaiYpe4MpPOa6.HYrrD19avyxEOTpEO', 0),
(21, 'Durant', 'Kevin', 'Kevindurant@gmail.com', 'kdsalalam', '$2y$10$K404qDzfjZ5fkj98HtH.aOouAyvOgywjixLNcEVLHSjaXWpqe2MT2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `candidate_id` int DEFAULT NULL,
  `vote_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `position` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `candidate_id`, `vote_date`, `position`) VALUES
(42, 19, 2, '2024-12-13 18:54:29', NULL),
(43, 19, 5, '2024-12-13 18:54:30', 'Vice President'),
(44, 19, 6, '2024-12-13 18:54:31', 'Muse'),
(45, 19, 8, '2024-12-13 18:54:32', 'Escort'),
(46, 19, 2, '2024-12-13 18:54:40', NULL),
(47, 20, 2, '2024-12-13 18:55:15', NULL),
(48, 20, 2, '2024-12-13 18:55:23', NULL),
(49, 20, 5, '2024-12-13 18:55:25', 'Vice President'),
(50, 20, 6, '2024-12-13 18:55:26', 'Muse'),
(51, 20, 9, '2024-12-13 18:55:28', 'Escort'),
(52, 20, 2, '2024-12-13 18:55:36', NULL),
(53, 19, 2, '2024-12-13 19:02:56', NULL),
(54, 19, 2, '2024-12-13 19:30:25', NULL),
(55, 19, 2, '2024-12-13 19:33:22', NULL),
(56, 21, 2, '2024-12-13 21:02:01', NULL),
(57, 21, 4, '2024-12-13 21:02:17', 'Vice President'),
(58, 21, 6, '2024-12-13 21:02:19', 'Muse'),
(59, 21, 8, '2024-12-13 21:02:25', 'Escort');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partylist`
--
ALTER TABLE `partylist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_votes`
--
ALTER TABLE `user_votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `idx_candidate_id` (`candidate_id`);

--
-- Indexes for table `voters`
--
ALTER TABLE `voters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `candidate_id` (`candidate_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `partylist`
--
ALTER TABLE `partylist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_votes`
--
ALTER TABLE `user_votes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voters`
--
ALTER TABLE `voters`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_votes`
--
ALTER TABLE `user_votes`
  ADD CONSTRAINT `user_votes_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`),
  ADD CONSTRAINT `user_votes_ibfk_2` FOREIGN KEY (`id`) REFERENCES `voters` (`id`);

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `voters` (`id`),
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
