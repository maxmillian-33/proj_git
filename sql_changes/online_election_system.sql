-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2025 at 03:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_election_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `name` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `password` varchar(25) NOT NULL,
  `user_id` int(10) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`name`, `email`, `phone`, `password`, `user_id`, `image`) VALUES
('Fabin', 'fabin@gmail.com', '415464156', 'fabin', 6, 'kararte.webp'),
('Kanye Omari West', 'ye@gmail.com', '1122334456', 'west', 17, 'kanye_meme.jpeg'),
('Trump', 'trump@gmail.com', '578901554', 'trump', 18, 'trump.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `election`
--

CREATE TABLE `election` (
  `title` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `result_date` date NOT NULL,
  `result_time` time DEFAULT NULL,
  `election_id` int(10) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `election`
--

INSERT INTO `election` (`title`, `description`, `start_date`, `result_date`, `result_time`, `election_id`, `start_time`, `end_time`) VALUES
('2024 Student Council Election', 'Elect your next student council representatives.', '2025-01-02', '2025-01-09', '02:00:00', 1, '01:00:00', '23:59:00'),
('Presidential Election 2024', 'Vote for the next president.', '2025-01-04', '2025-01-15', '02:00:00', 5, '09:00:00', '14:00:00'),
('class leader election', 'bca s5 class leader election', '2024-10-22', '2024-10-25', '02:00:00', 7, '09:00:00', '17:00:00'),
('test', 'test desc', '2025-01-03', '2025-01-09', '14:00:00', 10, '00:01:00', '23:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `election_candidates`
--

CREATE TABLE `election_candidates` (
  `id` int(11) NOT NULL,
  `election_id` int(11) DEFAULT NULL,
  `candidate_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `election_candidates`
--

INSERT INTO `election_candidates` (`id`, `election_id`, `candidate_id`) VALUES
(2, 1, 6),
(6, 1, 5),
(7, 1, 7),
(10, 5, 5),
(11, 5, 17),
(12, 5, 18),
(13, 5, 6),
(14, 8, 6),
(15, 8, 18),
(16, 1, 18);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `email` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `user_code` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`email`, `password`, `user_code`) VALUES
('admin@gmail.com', 'admin123', 2),
('blah@gmail.com', 'test43', 1),
('carti@gmail.com', 'carti', 1),
('fabin@gmail.com', 'fabin', 0),
('hari@gmail.com', 'hari', 1),
('jeff@gmail.com', 'jeff', 1),
('kiran@gmail.com', 'kiran', 1),
('max@gmail.com', 'max33', 1),
('tes4t@gmail.com', 'test', 1),
('test@gmail.com', 'test', 1),
('trump@gmail.com', 'trump', 0),
('ye@gmail.com', 'west', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `name` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `image` varchar(255) NOT NULL,
  `password` varchar(25) NOT NULL,
  `user_id` int(10) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `aadhar_number` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`name`, `email`, `phone`, `image`, `password`, `user_id`, `address`, `dob`, `age`, `aadhar_number`) VALUES
('Hari', 'hari@gmail.com', '1209348756', 'Screenshot (10).png', 'hari', 4, 'South Aduvasheri', '2004-05-04', 20, '78151789517'),
('kiran', 'kiran@gmail.com', '0987654321', '', 'kiran', 8, NULL, NULL, NULL, NULL),
('max', 'max@gmail.com', '098765432', 'default.jpg', 'max33', 9, 'Netherlands', '2004-04-03', 20, '070147814004'),
('carti', 'carti@gmail.com', '213524645', '', 'carti', 10, 'fadfdfaf', '2024-10-02', 23, '2314243414'),
('test', 'test@gmail.com', '0987654321', 'solitude.jpg', 'test', 11, NULL, NULL, NULL, NULL),
('tesrt', 'tes4t@gmail.com', '21234512456', 'default.png', 'test', 12, NULL, NULL, NULL, NULL),
('jeff', 'jeff@gmail.com', '140978915', 'default.png', 'jeff', 13, NULL, NULL, NULL, NULL),
('test43', 'blah@gmail.com', '141414156', 'Screenshot (73).png', 'test43', 14, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `vote_id` int(11) NOT NULL,
  `election_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `election`
--
ALTER TABLE `election`
  ADD PRIMARY KEY (`election_id`);

--
-- Indexes for table `election_candidates`
--
ALTER TABLE `election_candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`vote_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `election`
--
ALTER TABLE `election`
  MODIFY `election_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `election_candidates`
--
ALTER TABLE `election_candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
