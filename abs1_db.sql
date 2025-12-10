-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2025 at 11:45 AM
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
-- Database: `abs1_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `absence`
--

CREATE TABLE `absence` (
  `id_a` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `id_p` int(11) NOT NULL,
  `id_e` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absence`
--

INSERT INTO `absence` (`id_a`, `datetime`, `id_p`, `id_e`) VALUES
(1, '2024-12-01 08:30:00', 2, 1),
(2, '2025-12-08 20:56:03', 2, 4),
(4, '2025-12-08 20:56:12', 2, 6),
(5, '2025-12-08 20:56:32', 3, 4),
(6, '2025-12-08 20:56:32', 3, 5),
(7, '2025-12-09 00:04:21', 2, 6),
(8, '2025-12-09 00:04:26', 2, 6),
(9, '2025-12-09 00:04:26', 2, 10),
(10, '2025-12-09 12:52:13', 2, 12),
(11, '2025-12-09 14:12:12', 2, 4),
(12, '2025-12-09 14:12:12', 2, 12),
(13, '2025-12-09 23:11:24', 2, 12),
(14, '2025-12-09 23:11:24', 2, 16),
(15, '2025-12-09 23:25:49', 22, 5),
(16, '2025-12-09 23:25:49', 22, 12),
(17, '2025-12-09 23:25:49', 22, 16),
(18, '2025-12-09 23:27:01', 7, 5),
(19, '2025-12-09 23:27:01', 7, 12),
(20, '2025-12-09 23:27:01', 7, 16),
(21, '2025-12-10 11:10:17', 22, 5);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id_c` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id_c`, `nom`) VALUES
(1, '1A'),
(2, '1B'),
(7, '1C');

-- --------------------------------------------------------

--
-- Table structure for table `prof_class`
--

CREATE TABLE `prof_class` (
  `id_p` int(11) NOT NULL,
  `id_c` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prof_class`
--

INSERT INTO `prof_class` (`id_p`, `id_c`) VALUES
(2, 1),
(2, 2),
(2, 7),
(3, 1),
(3, 7),
(7, 1),
(7, 2),
(8, 1),
(8, 7),
(9, 2),
(18, 7),
(22, 1),
(22, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_u` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` enum('admin','prof','etudiant') NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `matiere` varchar(100) DEFAULT NULL,
  `id_c` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_u`, `email`, `password`, `role`, `nom`, `prenom`, `matiere`, `id_c`, `photo`) VALUES
(1, 'maysam.abdelli@sesame.com.tn', '123', 'admin', 'Admin', 'User', NULL, NULL, '1765228525_wp9079448.jpg'),
(2, 'prof1@gmail.com', '1234', 'prof', 'James', 'Smith', 'Math', NULL, 'default.jpg'),
(3, 'prof2@gmail.com', '1234', 'prof', 'Laura', 'Brown', 'Sciences', NULL, 'default.jpg'),
(4, 'student1@gmail.com', '1234', 'etudiant', 'John', 'Doe', NULL, 2, 'default.jpg'),
(5, 'student2@gmail.com', '1234', 'etudiant', 'Emma', 'Stone', NULL, 1, 'default.jpg'),
(6, 'student3@gmail.com', '1234', 'etudiant', 'Markus', 'Lee', NULL, 2, 'default.jpg'),
(7, 'prof3@gmail.com', '1234', 'prof', 'bang', 'chan', 'English', NULL, 'default.jpg'),
(8, 'prof4@gmail.com', '1234', 'prof', 'hwang', 'hyunjin', 'Dance', NULL, 'default.jpg'),
(9, 'prof5@gmail.com', '1234', 'prof', 'seo', 'changbin', 'P.E', NULL, 'default.jpg'),
(10, 'student4@gmail.com', '1234', 'etudiant', 'kim', 'dokja', NULL, 2, 'default.jpg'),
(12, 'student5@gmail.com', '1234', 'etudiant', 'lee', 'felix', NULL, 1, 'default.jpg'),
(13, 'student15@gmail.com', '1234', 'etudiant', 'kim', 'chan', NULL, 4, 'default.jpg'),
(16, 'student6@gmail.com', '1234', 'etudiant', 'Potter', 'Harry', NULL, 1, 'default.jpg'),
(17, 'prof20@gmail.com', '1234', 'prof', 'gharbi', 'zaydoun', 'P.E', NULL, 'default.jpg'),
(18, 'prof21@gmail.com', '1234', 'prof', 'mezyena', 'farouha', 'French', NULL, 'default.jpg'),
(22, 'prof22@gmail.com', '1234', 'prof', 'Gojo', 'Satoru', 'Curses', NULL, '1765284928_uwp4871652.webp'),
(23, 'prof23@gmail.com', '1234', 'prof', 'Snape', 'Severus', 'Potions', NULL, 'default.jpg'),
(24, 'student20@gmail.com', '1234', 'etudiant', 'Weasly', 'Ronald', NULL, 7, 'default.jpg'),
(25, 'student21@gmail.com', '1234', 'etudiant', 'Granger', 'Hermione', NULL, 7, 'default.jpg'),
(26, 'student22@gmail.com', '1234', 'etudiant', 'Malfoy', 'Draco', NULL, 7, 'default.jpg'),
(27, 'student23@gmail.com', '1234', 'etudiant', 'Weasly', 'Ginny', NULL, 7, 'default.jpg'),
(28, 'student24@gmail.com', '1234', 'etudiant', 'Yoo', 'Joonghyuk', NULL, 2, 'default.jpg'),
(29, 'student25@gmail.com', '1234', 'etudiant', 'Han', 'Sooyung', NULL, 2, 'default.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absence`
--
ALTER TABLE `absence`
  ADD PRIMARY KEY (`id_a`),
  ADD KEY `id_p` (`id_p`),
  ADD KEY `id_e` (`id_e`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id_c`);

--
-- Indexes for table `prof_class`
--
ALTER TABLE `prof_class`
  ADD PRIMARY KEY (`id_p`,`id_c`),
  ADD KEY `id_c` (`id_c`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_u`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absence`
--
ALTER TABLE `absence`
  MODIFY `id_a` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id_c` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_u` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absence`
--
ALTER TABLE `absence`
  ADD CONSTRAINT `absence_ibfk_1` FOREIGN KEY (`id_p`) REFERENCES `users` (`id_u`) ON DELETE CASCADE,
  ADD CONSTRAINT `absence_ibfk_2` FOREIGN KEY (`id_e`) REFERENCES `users` (`id_u`) ON DELETE CASCADE;

--
-- Constraints for table `prof_class`
--
ALTER TABLE `prof_class`
  ADD CONSTRAINT `prof_class_ibfk_1` FOREIGN KEY (`id_p`) REFERENCES `users` (`id_u`) ON DELETE CASCADE,
  ADD CONSTRAINT `prof_class_ibfk_2` FOREIGN KEY (`id_c`) REFERENCES `class` (`id_c`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
