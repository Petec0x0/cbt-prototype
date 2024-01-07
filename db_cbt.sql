-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 07, 2023 at 02:18 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cbt`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `username` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`username`, `nama`, `password`) VALUES
('asf6768', 'Ambalan Soekarno Fatmawati', '$2y$10$Ck1kx4S4.o/JO8cNJa0JGOGFHFOhIzVlLh7LGx06M8oibUjGD40gC'),
('testtest', 'testtest', '$2y$10$HUpd3UU1Oz4wCNbWbtropuBIeoi2pgE2m2uexx6SRReN/eNmhvHOK');

-- --------------------------------------------------------

--
-- Table structure for table `tb_answer`
--

CREATE TABLE `tb_answer` (
  `id_answer` int(11) NOT NULL,
  `username_answer` varchar(100) CHARACTER SET latin1 NOT NULL,
  `team_answer` int(11) NOT NULL,
  `question` int(11) NOT NULL,
  `choice` int(11) NOT NULL,
  `time_answer` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_log`
--

CREATE TABLE `tb_log` (
  `id_log` int(11) NOT NULL,
  `username_log` varchar(100) CHARACTER SET latin1 NOT NULL,
  `type_log` varchar(50) CHARACTER SET latin1 NOT NULL,
  `time_log` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_question`
--

CREATE TABLE `tb_question` (
  `id_question` int(11) NOT NULL,
  `question_name` text NOT NULL,
  `question_image` varchar(255) DEFAULT NULL,
  `option1` varchar(100) NOT NULL,
  `option2` varchar(100) NOT NULL,
  `option3` varchar(100) NOT NULL,
  `option4` varchar(100) NOT NULL,
  `answer` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_question`
--

INSERT INTO `tb_question` (`id_question`, `question_name`, `question_image`, `option1`, `option2`, `option3`, `option4`, `answer`, `group_id`) VALUES
(12, 'Transistors are unique features of which generation of computer classification?', '', 'First', 'Second', 'Third', 'Fourth', 2, 14),
(13, '_____ is the technology used in the first generation', '', 'Transistor', 'Integrated circuit', 'Large scale integrated circuit', 'Vaccum tube', 4, 14),
(14, '_____ is the technology for the Third generation of Computer classification is associated', '', 'Vaccum Tube', 'Transistors', 'Integrated Circuit', 'None of the above', 3, 14),
(15, 'What year was the vacuum tube invented?', '', '1995 - 1964', '1964 - 1972', '1946', '1990 to date', 3, 14),
(16, 'Information can be referred to as processed ____', '', 'Paper', 'Ideas', 'Data', 'Plastic', 3, 14),
(17, 'One of these does not explain the stage of the computer except?', '', 'Output - data - information', 'Input - processing - output', 'Processing - input - output', 'None of the above', 2, 14),
(18, 'The computer program to compute the Bernoulli sequence on the Analytical Engine was written by _____', '', 'John Atanasoff', 'Grace Hopper', 'Charles babbage', 'Ada lovelace', 3, 14),
(19, 'In what year did Blaise Pascal invent the first mechanical calculator?', '', '1942', '1642', '1756', '1655', 2, 14),
(20, 'Computer processing speeds are measured in _____', 'img/Screenshot from 2023-08-07 01-03-57.png', 'Kilograms', 'Kilohertz', 'Kilobytes', 'Kilometers', 2, 14);

-- --------------------------------------------------------

--
-- Table structure for table `tb_result`
--

CREATE TABLE `tb_result` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `answer_right` int(11) NOT NULL,
  `answer_wrong` int(11) NOT NULL,
  `answer_empty` int(11) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_result`
--

INSERT INTO `tb_result` (`id`, `username`, `answer_right`, `answer_wrong`, `answer_empty`, `score`) VALUES
(2, 'GWF071423762', 4, 3, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tb_setting`
--

CREATE TABLE `tb_setting` (
  `total_question` int(11) NOT NULL,
  `point_right` int(11) NOT NULL,
  `point_wrong` int(11) NOT NULL,
  `point_unanswered` int(11) NOT NULL,
  `time_hours` int(11) NOT NULL,
  `time_minutes` int(11) NOT NULL,
  `allow_registration` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_setting`
--

INSERT INTO `tb_setting` (`total_question`, `point_right`, `point_wrong`, `point_unanswered`, `time_hours`, `time_minutes`, `allow_registration`) VALUES
(50, 1, 0, 0, 1, 30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_team`
--

CREATE TABLE `tb_team` (
  `id_team` int(11) NOT NULL,
  `name_team` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_team`
--

INSERT INTO `tb_team` (`id_team`, `name_team`, `creator_id`, `created_at`) VALUES
(14, 'CSC 101 2017', 0, '2023-08-04 01:18:37');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `username` varchar(100) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `team` int(11) DEFAULT NULL,
  `done` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`username`, `nama`, `password`, `team`, `done`) VALUES
('GWF071423762', 'Wence', '$2y$10$alUYOkAjR9vICxyCWKPbE.eI3jCj4xhsT2AWDGoL.RdvoEfApcihK', 14, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `tb_answer`
--
ALTER TABLE `tb_answer`
  ADD PRIMARY KEY (`id_answer`),
  ADD KEY `user_answer` (`username_answer`),
  ADD KEY `user_question` (`question`),
  ADD KEY `team_answer` (`team_answer`);

--
-- Indexes for table `tb_log`
--
ALTER TABLE `tb_log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `user_log` (`username_log`);

--
-- Indexes for table `tb_question`
--
ALTER TABLE `tb_question`
  ADD PRIMARY KEY (`id_question`);

--
-- Indexes for table `tb_result`
--
ALTER TABLE `tb_result`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_team`
--
ALTER TABLE `tb_team`
  ADD PRIMARY KEY (`id_team`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`username`),
  ADD KEY `team_name` (`team`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_answer`
--
ALTER TABLE `tb_answer`
  MODIFY `id_answer` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_log`
--
ALTER TABLE `tb_log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_question`
--
ALTER TABLE `tb_question`
  MODIFY `id_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tb_result`
--
ALTER TABLE `tb_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_team`
--
ALTER TABLE `tb_team`
  MODIFY `id_team` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_answer`
--
ALTER TABLE `tb_answer`
  ADD CONSTRAINT `team_answer` FOREIGN KEY (`team_answer`) REFERENCES `tb_team` (`id_team`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_answer` FOREIGN KEY (`username_answer`) REFERENCES `tb_user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_question` FOREIGN KEY (`question`) REFERENCES `tb_question` (`id_question`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_log`
--
ALTER TABLE `tb_log`
  ADD CONSTRAINT `user_log` FOREIGN KEY (`username_log`) REFERENCES `tb_user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `team_name` FOREIGN KEY (`team`) REFERENCES `tb_team` (`id_team`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
