-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2025 at 02:30 AM
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
-- Database: `so_sarawak_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `location`, `city`, `event_date`, `event_time`, `type`, `image_path`) VALUES
(6, 'Bintulu Marathon Rerun 2025', 'Lorem ipsum dolor sit amet.', 'Stadium Bintulu', 'Bintulu', '2025-12-03', '9:00 AM - 3:00 PM', 'training', '../assets/images/events/68a2eb4b8975d_child_family_news.jpg'),
(9, 'Check City', 'abcdefg', 'Boulevard Mall', 'Miri', '2025-10-23', '9:00 AM - 3:00 PM', 'meeting', '../assets/images/events/68ef10b2d0f4e_another_news.jpg'),
(10, 'Bintulu Marathon', 'lorem ipsum', 'Stadium Bintulu', 'Bintulu', '2025-10-20', '9:00 AM - 3:00 PM', 'social', '../assets/images/events/68f5857e22783_70d51a4e6014c4ffa71909d9ea0c816d.jpg'),
(11, 'Handover', 'kucing comel', 'The Spring', 'Bintulu', '2025-11-26', '9:00 AM - 3:00 PM', 'meeting', '../assets/images/events/691d6487e15a4_404-dev.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_photos`
--

CREATE TABLE `gallery_photos` (
  `id` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_photos`
--

INSERT INTO `gallery_photos` (`id`, `collection_id`, `image_path`, `created_at`) VALUES
(3, 3, '../assets/images/gallery_photos_upload/sohap-gal-1.jpg', '2025-11-14 08:17:14'),
(4, 3, '../assets/images/gallery_photos_upload/sohap-gal-2.jpg', '2025-11-14 08:18:29'),
(5, 3, '../assets/images/gallery_photos_upload/sohap-gal-3.jpg', '2025-11-14 08:18:29'),
(6, 3, '../assets/images/gallery_photos_upload/sohap-gal-4.jpg', '2025-11-14 08:27:01'),
(7, 3, '../assets/images/gallery_photos_upload/sohap-gal-5.jpg', '2025-11-14 08:27:01'),
(8, 3, '../assets/images/gallery_photos_upload/sohap-gal-6.jpg', '2025-11-14 08:27:01'),
(16, 4, '../assets/images/gallery_photos_upload/1763971878_bintulu_marathon_news.jpg', '2025-11-24 08:11:18');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_photos_collection`
--

CREATE TABLE `gallery_photos_collection` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_photos_collection`
--

INSERT INTO `gallery_photos_collection` (`id`, `name`, `description`, `created_at`) VALUES
(3, 'Healthy Athletes', 'This is a collection for Healthy Athletes Program.', '2025-11-14 08:16:10'),
(4, 'Bintulu Chapter', 'This is a collection of the Special Olympics Bintulu Chapter.', '2025-11-21 01:10:02');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_videos`
--

CREATE TABLE `gallery_videos` (
  `id` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL,
  `video_path` varchar(255) NOT NULL,
  `cover_path` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_videos`
--

INSERT INTO `gallery_videos` (`id`, `collection_id`, `video_path`, `cover_path`, `title`, `description`, `created_at`) VALUES
(1, 1, '../assets/videos/yap-lm-v1.mp4', '../assets/videos/GalleryVid/thumbnail/yap-gal-1.jpg', 'Lets Play Together with YAP', 'Promotional video introducing Young Athletes Program (YAP).', '2025-11-19 01:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_videos_collection`
--

CREATE TABLE `gallery_videos_collection` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_videos_collection`
--

INSERT INTO `gallery_videos_collection` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Young Athletes Program', 'A video collection of Young Athletes Program.', '2025-11-19 01:43:13');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `headline` varchar(255) NOT NULL,
  `news_date` date NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `image_path`, `headline`, `news_date`, `description`, `created_at`) VALUES
(6, '../assets/images/news_uploads/88931f16a199bd5a5fb88839668568e2.jpg', 'Bintulu Marathon 2025', '2025-08-03', 'Bintulu Maratthn 2025', '2025-08-26 02:35:45'),
(7, '../assets/images/news_uploads/505cbb515bcaa601fe6878531516ab21.jpg', 'Bintulu Port', '2025-10-30', 'Lorem ipsum dolor sit amet consectetuer adipiscing elit.', '2025-10-30 06:33:55');

-- --------------------------------------------------------

--
-- Table structure for table `sponsorships`
--

CREATE TABLE `sponsorships` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sponsorships`
--

INSERT INTO `sponsorships` (`id`, `type`, `image_path`) VALUES
(1, 'Special Olympics Sarawak', '../assets/images/yayasan_bintulu_port_logo.png'),
(2, 'Bintulu Chapter', '../assets/images/pressmetal_logo.png'),
(3, 'Miri Chapter', '../assets/images/lorem-ipsum.png'),
(6, 'Kuching Chapter', '/assets/images/sponsorships/69200fc05fa06_pertama_ferroalloys_logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `created_at`) VALUES
(1, 'admin', 'admin@1234', '$2y$10$xAcz/xaTr5/xlyvdYIWT9eTi9w8AH78B5B7oiBoS3Zaf7OXrLQ5uG', '2025-08-18 07:59:37'),
(2, 'SO Sarawak Admin', 'sosarawak@gmail.com', '$2y$10$NF7SHtLRu8skMVfi0d3LvOyfM36xXdO1SsU8JUf6WbGzgkurBF3uu', '2025-11-03 01:08:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_photos`
--
ALTER TABLE `gallery_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collection_id` (`collection_id`);

--
-- Indexes for table `gallery_photos_collection`
--
ALTER TABLE `gallery_photos_collection`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `gallery_videos`
--
ALTER TABLE `gallery_videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collection_id` (`collection_id`);

--
-- Indexes for table `gallery_videos_collection`
--
ALTER TABLE `gallery_videos_collection`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sponsorships`
--
ALTER TABLE `sponsorships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `gallery_photos`
--
ALTER TABLE `gallery_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `gallery_photos_collection`
--
ALTER TABLE `gallery_photos_collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gallery_videos`
--
ALTER TABLE `gallery_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gallery_videos_collection`
--
ALTER TABLE `gallery_videos_collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sponsorships`
--
ALTER TABLE `sponsorships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gallery_photos`
--
ALTER TABLE `gallery_photos`
  ADD CONSTRAINT `gallery_photos_ibfk_1` FOREIGN KEY (`collection_id`) REFERENCES `gallery_photos_collection` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gallery_videos`
--
ALTER TABLE `gallery_videos`
  ADD CONSTRAINT `gallery_videos_ibfk_1` FOREIGN KEY (`collection_id`) REFERENCES `gallery_videos_collection` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
