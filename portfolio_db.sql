-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2025 at 08:53 AM
-- Server version: 8.0.35
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portfolio_db`
--

-- --------------------------------------------------------
CREATE DATABASE portfolio_db;
USE portfolio_db;
--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` varchar(50) NOT NULL,
  `label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `label`) VALUES
('all', 'All Skills'),
('backend', 'Backend'),
('frontend', 'Frontend'),
('tools', 'Tools & Platforms');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `title`, `image`, `description`) VALUES
(1, 'TechExplosion Certificate', './assets/images/certificates/1.jpg', 'Certificate of Participation in TechExplosion, a school-based web development and computer programming competition.'),
(2, '2nd Place - TechExplosion', './assets/images/certificates/2.jpg', 'Awarded 2nd Place in TechExplosion, a school-wide competition where students from all year levels competed in web development. My project utilized Laravel and JavaScript.'),
(3, 'National Certificate II (NC II)', './assets/images/certificates/3.jpg', 'National Certificate II (NC II), awarded upon successful completion of technical competency requirements.'),
(4, 'Blockchain Workshop Certificate', './assets/images/certificates/5.jpg', 'Certificate of Participation in a specialized workshop focused on blockchain technology and its applications.'),
(5, '12th BYCIT Certificate', './assets/images/certificates/7.png', 'Certificate of Participation in the 12th BYCIT event, a two-day mentorship and training program.');

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `id` int NOT NULL,
  `title` varchar(150) NOT NULL,
  `institution` varchar(150) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`id`, `title`, `institution`, `start_date`, `end_date`, `description`) VALUES
(1, 'Information Technology', 'CSPC.', '2022-08-04', NULL, 'Learn About Software Development/Web development');

-- --------------------------------------------------------

--
-- Table structure for table `personal_info`
--

CREATE TABLE `personal_info` (
  `id` int NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `about_summary` text,
  `profile_picture_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `personal_info`
--

INSERT INTO `personal_info` (`id`, `full_name`, `tagline`, `email`, `phone_number`, `about_summary`, `profile_picture_url`) VALUES
(1, '        Mark Ely Calipjo', NULL, 'calipjo.markely@gmail.com', '09302727854', ' I\'m a Web Developer passionate about building and managing websites. Skilled in both frontend and backend development, I specialize in creating seamless, dynamic digital experiences.', './assets/images/profile.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `demo_url` varchar(255) DEFAULT NULL,
  `github_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `image`, `demo_url`, `github_url`) VALUES
(1, 'Navigatormaritime', 'A Clone Website of Navigatormatirime', './assets/images/projects/4.png', 'https://navigatormaritime-clone.infinityfreeapp.com/', 'https://github.com/CODERELY07/navigatormaritime'),
(3, 'WataShop E-Commerce', 'E-Commerce Platform. Use FakeStore Api', './assets/images/projects/5.png', 'https://e-commerce-ten-khaki-53.vercel.app/', 'https://github.com/CODERELY07/E-Commerce');

-- --------------------------------------------------------

--
-- Table structure for table `project_tags`
--

CREATE TABLE `project_tags` (
  `id` int NOT NULL,
  `project_id` int DEFAULT NULL,
  `tag` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `project_tags`
--

INSERT INTO `project_tags` (`id`, `project_id`, `tag`) VALUES
(1, 1, 'HTML'),
(2, 1, 'CSS'),
(3, 1, 'JS'),
(4, 1, 'Bootstrap'),
(5, 1, 'JQUERY'),
(6, 1, 'MYSQL'),
(7, 1, 'PHP'),
(8, 3, 'React'),
(9, 3, 'Tailwind'),
(10, 3, 'External API');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int NOT NULL,
  `skill_name` varchar(100) NOT NULL,
  `proficiency` int DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `years` decimal(3,1) DEFAULT '0.0'
) ;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `skill_name`, `proficiency`, `category`, `years`) VALUES
(1, 'HTML/CSS', 85, 'frontend', 2.0),
(2, 'JavaScript', 70, 'frontend', 2.0),
(3, 'React', 50, 'frontend', 1.0),
(4, 'Tailwind CSS', 75, 'frontend', 1.0),
(5, 'Next.js', 60, 'frontend', 0.5),
(6, 'PHP', 80, 'backend', 2.0),
(7, 'Laravel', 60, 'backend', 2.0),
(8, 'MySQL', 80, 'backend', 2.0),
(9, 'Supabase', 50, 'backend', 0.5),
(10, 'Trpc', 50, 'backend', 0.5),
(11, 'Git/GitHub', 80, 'tools', 2.0),
(12, 'Figma', 30, 'tools', 1.0),
(13, 'VS Code', 90, 'tools', 4.0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_info`
--
ALTER TABLE `personal_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_tags`
--
ALTER TABLE `project_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_info`
--
ALTER TABLE `personal_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `project_tags`
--
ALTER TABLE `project_tags`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `project_tags`
--
ALTER TABLE `project_tags`
  ADD CONSTRAINT `project_tags_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
