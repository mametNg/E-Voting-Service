-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2022 at 04:53 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voting`
--

-- --------------------------------------------------------

--
-- Table structure for table `db_admins`
--

CREATE TABLE `db_admins` (
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `created` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_campaign`
--

CREATE TABLE `db_campaign` (
  `code` varchar(5) NOT NULL,
  `number` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_candidate`
--

CREATE TABLE `db_candidate` (
  `candidate_code` varchar(5) NOT NULL,
  `code` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `role` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_candidate_role`
--

CREATE TABLE `db_candidate_role` (
  `code` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_class`
--

CREATE TABLE `db_class` (
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_roles`
--

CREATE TABLE `db_roles` (
  `code` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_subs_class`
--

CREATE TABLE `db_subs_class` (
  `class_code` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_users`
--

CREATE TABLE `db_users` (
  `nim` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `take` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `header`
--

CREATE TABLE `header` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `header`
--

INSERT INTO `header` (`id`, `title`, `icon`, `description`) VALUES
(1, 'E-VOTING SERVICE', 'cso.svg', 'Use Your Voting Rights. Choose Candidates Who Can Inspire Students.');

-- --------------------------------------------------------

--
-- Table structure for table `web_activation`
--

CREATE TABLE `web_activation` (
  `code` varchar(6) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `web_setting`
--

CREATE TABLE `web_setting` (
  `code` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `web_setting`
--

INSERT INTO `web_setting` (`code`, `name`, `status`) VALUES
('BKJFW', 'Activation', 0),
('HKAJD', 'Maintenance', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `db_admins`
--
ALTER TABLE `db_admins`
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `db_campaign`
--
ALTER TABLE `db_campaign`
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `number` (`number`);

--
-- Indexes for table `db_candidate`
--
ALTER TABLE `db_candidate`
  ADD UNIQUE KEY `candidate_code` (`candidate_code`);

--
-- Indexes for table `db_candidate_role`
--
ALTER TABLE `db_candidate_role`
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `db_class`
--
ALTER TABLE `db_class`
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `db_roles`
--
ALTER TABLE `db_roles`
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `db_subs_class`
--
ALTER TABLE `db_subs_class`
  ADD UNIQUE KEY `class_code` (`class_code`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `db_users`
--
ALTER TABLE `db_users`
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indexes for table `header`
--
ALTER TABLE `header`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_activation`
--
ALTER TABLE `web_activation`
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `web_setting`
--
ALTER TABLE `web_setting`
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `header`
--
ALTER TABLE `header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
