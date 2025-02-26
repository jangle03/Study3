-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2025 at 07:36 PM
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
-- Database: `english`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_users` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `liked_sentences`
--

CREATE TABLE `liked_sentences` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sentence_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `liked_texts`
--

CREATE TABLE `liked_texts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `liked_words`
--

CREATE TABLE `liked_words` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `word_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `liked_words`
--

INSERT INTO `liked_words` (`id`, `user_id`, `word_id`) VALUES
(1, 4, 128);

-- --------------------------------------------------------

--
-- Table structure for table `sentences`
--

CREATE TABLE `sentences` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `word_id` int(11) NOT NULL,
  `sentence` varchar(255) NOT NULL,
  `translation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sentences`
--

INSERT INTO `sentences` (`id`, `user_id`, `word_id`, `sentence`, `translation`) VALUES
(1, 4, 128, 'aaaqq', 'aaa');

-- --------------------------------------------------------

--
-- Table structure for table `texts`
--

CREATE TABLE `texts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` varchar(2000) NOT NULL,
  `translation` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `texts`
--

INSERT INTO `texts` (`id`, `user_id`, `title`, `content`, `translation`) VALUES
(1, 4, '11111', '111111111', '11111111111');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'default.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `profile_picture`, `created_at`) VALUES
(4, 'admin', 'Huyenaaaaa', 'admin@gmail.com', 'admin', 'c8adcfb581a68b888c5ddf949081541147415b96a4de52f262d0ef75064f3489', 'pngegg.png', '2025-02-03 08:31:32'),
(5, 'user1', 'Huyenahahha', 'user@gmail.com', 'user', 'c8adcfb581a68b888c5ddf949081541147415b96a4de52f262d0ef75064f3489', 'pngegg.png', '2025-02-03 08:33:30'),
(7, 'Khanh', 'Huyen', 'khanhhuyenlee2412@gmail.com', 'khanhhuyenaerin', '18b8ef2c10be86d5811ef922061e58ebd3f4cf8fdc6ed582f4f86a3354989488', 'pngegg.png', '2025-02-24 09:13:36');

-- --------------------------------------------------------

--
-- Table structure for table `words`
--

CREATE TABLE `words` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `word` varchar(150) NOT NULL,
  `translation` varchar(150) DEFAULT NULL,
  `definition` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `words`
--

INSERT INTO `words` (`id`, `user_id`, `word`, `translation`, `definition`) VALUES
(127, 4, 'hello', 'xin chào', '1111'),
(128, 4, 'eweweaaaa', 'aaaa', 'aa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_blog_users` (`id_users`);

--
-- Indexes for table `liked_sentences`
--
ALTER TABLE `liked_sentences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sentence_id` (`sentence_id`);

--
-- Indexes for table `liked_texts`
--
ALTER TABLE `liked_texts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `text_id` (`text_id`);

--
-- Indexes for table `liked_words`
--
ALTER TABLE `liked_words`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `word_id` (`word_id`);

--
-- Indexes for table `sentences`
--
ALTER TABLE `sentences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `word_id` (`word_id`);

--
-- Indexes for table `texts`
--
ALTER TABLE `texts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `words`
--
ALTER TABLE `words`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `liked_sentences`
--
ALTER TABLE `liked_sentences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `liked_texts`
--
ALTER TABLE `liked_texts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `liked_words`
--
ALTER TABLE `liked_words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sentences`
--
ALTER TABLE `sentences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `texts`
--
ALTER TABLE `texts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `words`
--
ALTER TABLE `words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `fk_blog_users` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);

--
-- Constraints for table `liked_sentences`
--
ALTER TABLE `liked_sentences`
  ADD CONSTRAINT `liked_sentences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `liked_sentences_ibfk_2` FOREIGN KEY (`sentence_id`) REFERENCES `sentences` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `liked_texts`
--
ALTER TABLE `liked_texts`
  ADD CONSTRAINT `liked_texts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `liked_texts_ibfk_2` FOREIGN KEY (`text_id`) REFERENCES `texts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `liked_words`
--
ALTER TABLE `liked_words`
  ADD CONSTRAINT `liked_words_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `liked_words_ibfk_2` FOREIGN KEY (`word_id`) REFERENCES `words` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sentences`
--
ALTER TABLE `sentences`
  ADD CONSTRAINT `sentences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sentences_ibfk_2` FOREIGN KEY (`word_id`) REFERENCES `words` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `texts`
--
ALTER TABLE `texts`
  ADD CONSTRAINT `texts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `words`
--
ALTER TABLE `words`
  ADD CONSTRAINT `words_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
