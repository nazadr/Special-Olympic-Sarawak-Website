-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2025 at 03:07 AM
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
-- Table structure for table `chapter_participants`
--

CREATE TABLE `chapter_participants` (
  `id` int(11) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `athletes_male` int(11) DEFAULT 0,
  `athletes_female` int(11) DEFAULT 0,
  `coaches_male` int(11) DEFAULT 0,
  `coaches_female` int(11) DEFAULT 0,
  `volunteers_male` int(11) DEFAULT 0,
  `volunteers_female` int(11) DEFAULT 0,
  `total_participants` int(11) GENERATED ALWAYS AS (`athletes_male` + `athletes_female` + `coaches_male` + `coaches_female` + `volunteers_male` + `volunteers_female`) STORED COMMENT 'Auto-calculated total',
  `athletes_total` int(11) GENERATED ALWAYS AS (`athletes_male` + `athletes_female`) STORED,
  `coaches_total` int(11) GENERATED ALWAYS AS (`coaches_male` + `coaches_female`) STORED,
  `volunteers_total` int(11) GENERATED ALWAYS AS (`volunteers_male` + `volunteers_female`) STORED,
  `year` year(4) DEFAULT year(curdate()),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapter_participants`
--

INSERT INTO `chapter_participants` (`id`, `chapter_id`, `athletes_male`, `athletes_female`, `coaches_male`, `coaches_female`, `volunteers_male`, `volunteers_female`, `year`, `updated_at`) VALUES
(1, 1, 160, 140, 27, 23, 72, 48, '2025', '2025-12-01 01:53:08'),
(2, 2, 15, 10, 5, 3, 8, 6, '2025', '2025-12-01 01:53:08'),
(3, 3, 95, 85, 12, 10, 25, 20, '2025', '2025-12-01 01:53:08'),
(4, 4, 120, 100, 15, 12, 30, 25, '2025', '2025-12-01 01:53:08'),
(5, 5, 80, 75, 10, 8, 20, 15, '2025', '2025-12-01 01:53:08');

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
(9, 'Check City', 'abcdefgg', 'Boulevard Mall', 'Miri', '2025-10-23', '9:00 AM - 3:00 PM', 'meeting', '../assets/images/events/68ef10b2d0f4e_another_news.jpg'),
(10, 'Bintulu Marathon', 'lorem ipsum', 'Stadium Bintulu', 'Bintulu', '2025-10-20', '9:00 AM - 3:00 PM', 'special', '../assets/images/events/68f5857e22783_70d51a4e6014c4ffa71909d9ea0c816d.jpg'),
(15, 'Test Event (test edit entries)', 'Testing entries\r\n', 'Lasar Kenyalang', 'Bintulu', '2025-11-29', '8.00 P.M - 12.00 P.M', 'special', 'assets/images/events/6927c69f94de5_yap-gal-3.jpg'),
(18, 'Bintulu Ultra Marathon', 'Bintulu Ultra Marathon', 'Lasar Kenyalang', 'Bintulu', '2025-12-05', '8.00 A.M - 12.00 P.M', 'special', 'assets/images/events/692ce1c87e7f6_68f5857e22783_70d51a4e6014c4ffa71909d9ea0c816d.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_photos`
--

CREATE TABLE `gallery_photos` (
  `id` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_photos`
--

INSERT INTO `gallery_photos` (`id`, `collection_id`, `image_path`, `created_at`, `sort_order`) VALUES
(22, 6, '../assets/images/gallery_photos_upload/1764204646_chapter-kuching.jpg', '2025-11-27 00:50:46', 0),
(23, 7, '../assets/images/gallery_photos_upload/1764295405_0_sohap-gal-1.jpg', '2025-11-28 02:03:25', 1),
(24, 7, '../assets/images/gallery_photos_upload/1764295405_1_sohap-gal-2.jpg', '2025-11-28 02:03:25', 4),
(25, 7, '../assets/images/gallery_photos_upload/1764295405_2_sohap-gal-3.jpg', '2025-11-28 02:03:25', 2),
(26, 7, '../assets/images/gallery_photos_upload/1764295405_3_sohap-gal-4.jpg', '2025-11-28 02:03:25', 5),
(27, 7, '../assets/images/gallery_photos_upload/1764295405_4_sohap-gal-5.jpg', '2025-11-28 02:03:25', 3),
(28, 7, '../assets/images/gallery_photos_upload/1764295405_5_sohap-gal-6.jpg', '2025-11-28 02:03:25', 6),
(29, 7, '../assets/images/gallery_photos_upload/1764295405_6_sohap-gal-7.jpg', '2025-11-28 02:03:25', 7),
(30, 8, '../assets/images/gallery_photos_upload/1764295580_0_chapter-bintulu.jpg', '2025-11-28 02:06:20', 1),
(31, 8, '../assets/images/gallery_photos_upload/1764300654_0_bintulu_marathon_2025.jpg', '2025-11-28 03:30:54', 4),
(32, 8, '../assets/images/gallery_photos_upload/1764313074_0_another_news.jpg', '2025-11-28 06:57:54', 3),
(33, 8, '../assets/images/gallery_photos_upload/1764313074_1_healthy_program_1.jpg', '2025-11-28 06:57:54', 2);

-- --------------------------------------------------------

--
-- Table structure for table `gallery_photos_collection`
--

CREATE TABLE `gallery_photos_collection` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_photos_collection`
--

INSERT INTO `gallery_photos_collection` (`id`, `name`, `description`, `created_at`, `sort_order`) VALUES
(6, 'Kuching Chapter', 'This is a collection of the Special Olympics Kuching Chapter.', '2025-11-27 00:50:46', 3),
(7, 'Healthy Athletes', 'This is a collection of Healthy Athletes Program.', '2025-11-28 00:40:00', 1),
(8, 'Bintulu Chapter', 'This is a collection of Special Olympics Bintulu Chapter', '2025-11-28 02:06:20', 2);

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
(7, '../assets/images/news_uploads/505cbb515bcaa601fe6878531516ab21.jpg', 'Bintulu Port', '2025-10-30', 'Lorem ipsum dolor sit amet consectetuer adipiscing elit.', '2025-10-30 06:33:55'),
(11, '../assets/images/news_uploads/4a32e54b41b22383246f6fd6e9a012e8.jpg', 'Test news', '2025-11-28', 'Please work', '2025-11-28 03:28:26');

-- --------------------------------------------------------

--
-- Table structure for table `sarawak_chapters`
--

CREATE TABLE `sarawak_chapters` (
  `id` int(11) NOT NULL,
  `chapter_name` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `chairman` varchar(255) DEFAULT NULL,
  `vice_chairman` varchar(255) DEFAULT NULL,
  `secretary` varchar(255) DEFAULT NULL,
  `treasurer` varchar(255) DEFAULT NULL,
  `logo_path` varchar(255) NOT NULL COMMENT 'Hardcoded logo path - not editable via admin',
  `status` enum('active','upcoming','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sarawak_chapters`
--

INSERT INTO `sarawak_chapters` (`id`, `chapter_name`, `city`, `chairman`, `vice_chairman`, `secretary`, `treasurer`, `logo_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SO Kuching Chapter', 'Kuching', 'Madam Liza Chai', 'Unknown', 'TBD', 'TBD', 'assets/images/Remake/SO Sarawak Kuching Chapter BG - Official logo.png', 'active', '2025-12-01 01:53:08', '2025-12-02 01:00:38'),
(2, 'SO Samarahan Chapter', 'Samarahan', 'Edos', 'TBD', 'TBD', 'TBD', 'assets/images/Remake/SO Sarawak Samarahan Chapter BG - Official logo.png', 'upcoming', '2025-12-01 01:53:08', '2025-12-01 08:32:26'),
(3, 'SO Sibu Chapter', 'Sibu', 'Pemanca Datuk Jason Tai Hee', 'TBD', 'TBD', 'TBD', 'assets/images/Remake/SO Sarawak Sibu Chapter BG - Official logo.png', 'active', '2025-12-01 01:53:08', '2025-12-01 02:53:18'),
(4, 'SO Bintulu Chapter', 'Bintulu', 'Dato Haji Ruslan Bin Abdul Ghani', 'TBD', 'Sabrina Cheong Oi Lin binti Abdullah', 'TBD', 'assets/images/Remake/SO Sarawak Bintulu Chapter BG - Official logo.png', 'active', '2025-12-01 01:53:08', '2025-12-01 02:53:36'),
(5, 'SO Miri Chapter', 'Miri', 'Datin Dayang Mariani Abang Zain', 'TBD', 'TBD', 'TBD', 'assets/images/Remake/SO Sarawak Miri Chapter BG - Official logo.png', 'active', '2025-12-01 01:53:08', '2025-12-01 02:59:07');

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
(1, 'Bintulu Chapter', 'http://localhost/Special-Olympic-Sarawak-Website-Staging-environment/assets/images/yayasan_bintulu_port_logo.png'),
(2, 'Bintulu Chapter', '../assets/images/pressmetal_logo.png'),
(3, 'Miri Chapter', '../assets/images/lorem-ipsum.png'),
(6, 'Kuching Chapter', '/assets/images/sponsorships/69200fc05fa06_pertama_ferroalloys_logo.png'),
(8, 'Special Olympics Sarawak', '../assets/images/sponsorships/692917fd73f55_bhenmayer_logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `sports`
--

CREATE TABLE `sports` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sports`
--

INSERT INTO `sports` (`id`, `title`, `description`, `image_path`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 'Athletics', 'Track and field events including sprints, relays, jumps and throws', 'https://akm-img-a-in.tosshub.com/sites/media2/indiatoday/images/stories/2015July/special-olympic-5_072515021147.jpg', 2, '2025-12-01 01:12:54', '2025-12-01 08:32:03'),
(2, 'Aquatics', 'Individual and team aquatic sport with various strokes and distances', '../assets/images/Aquatics_sport.jpg', 3, '2025-12-01 01:12:54', '2025-12-01 08:28:49'),
(3, 'Badminton', 'Fast-paced racquet sport played individually or in doubles', 'https://www.businesstoday.com.my/wp-content/uploads/2025/05/badminton.png', 1, '2025-12-01 01:12:54', '2025-12-01 08:32:03'),
(4, 'Basketball', 'Team sport with dribbling, passing and shooting skills', 'https://dotorg.brightspotcdn.com/dims4/default/ee9e8a5/2147483647/strip/true/crop/800x450+0+42/resize/800x450!/quality/90/?url=http%3A%2F%2Fsoi-brightspot.s3.amazonaws.com%2Fdotorg%2F79%2F2c%2Fdff376344b05bacc6cc4a6108434%2Fandrew-marquise.JPG', 4, '2025-12-01 01:12:54', '2025-12-01 01:31:15'),
(5, 'Bocce', 'Traditional precision ball sport with strategy and skill', 'https://www.weekly-echo.com/wp-content/uploads/2023/06/special-olympics-bocce-nurul-1.jpg', 5, '2025-12-01 01:12:54', '2025-12-01 01:31:15'),
(6, 'Bowling', 'Popular sport combining fun and skill with lane strategy', '../assets/images/sports/692cef5e17cac_SO_bowling.jpg', 6, '2025-12-01 01:12:54', '2025-12-01 01:31:20'),
(7, 'Floorball', 'Fast indoor team sport similar to floor hockey', 'https://www.specialolympicsmalaysia.org/images/FIH%20Hockey/FIH-SOM%20FIH%20ID-Hockey2.png', 7, '2025-12-01 01:12:54', '2025-12-01 06:11:59'),
(8, 'Football', 'The world\'s most popular sport', 'https://jpwpl.gov.my/sanasini/wp-content/uploads/2017/11/olympiad-smklajau-768x448.jpg', 8, '2025-12-01 01:12:54', '2025-12-01 06:12:00'),
(9, 'Judo', 'Martial art focusing on throws and grappling techniques', '../assets/images/sports/692cefaeed625_SO_judo.jpg', 10, '2025-12-01 01:12:54', '2025-12-01 06:12:02'),
(10, 'Netball', 'Fast-paced team sport similar to basketball', 'https://www.thestatesman.com/wp-content/uploads/2018/08/net-ball.jpg', 9, '2025-12-01 01:12:54', '2025-12-01 06:12:02'),
(11, 'Swimming', 'Individual and team aquatic sport with various strokes and distances', 'https://dotorg.brightspotcdn.com/ac/e1/a4297c14411e803691dafbd93b26/1300x680-aquatics.jpg', 11, '2025-12-01 01:12:54', '2025-12-01 06:11:59'),
(12, 'Tennis', 'Racquet sport played individually or in doubles on a court', '../assets/images/sports/692cefb9f18b2_SO_tennis.jpg', 13, '2025-12-01 01:12:54', '2025-12-01 08:28:51'),
(13, 'Table Tennis', 'Fast-paced indoor racquet sport played on a table', 'https://dotorg.brightspotcdn.com/dims4/default/612aa0c/2147483647/strip/true/crop/2160x1440+0+0/resize/800x533!/quality/90/?url=http%3A%2F%2Fsoi-brightspot.s3.amazonaws.com%2Fdotorg%2F0a%2F60%2F7dad13d84fb9bcb4fa8eac7baaae%2Fsbr0078.jpg', 12, '2025-12-01 01:12:54', '2025-12-01 08:28:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `profile_photo`, `phone`, `position`, `bio`, `updated_at`, `created_at`) VALUES
(1, 'admin', 'admin@1234', '$2y$10$xAcz/xaTr5/xlyvdYIWT9eTi9w8AH78B5B7oiBoS3Zaf7OXrLQ5uG', NULL, NULL, NULL, NULL, '2025-12-01 07:33:02', '2025-08-18 07:59:37'),
(2, 'SO Sarawak Admin', 'sosarawak@gmail.com', '$2y$10$NF7SHtLRu8skMVfi0d3LvOyfM36xXdO1SsU8JUf6WbGzgkurBF3uu', 'profile_2_1764640921.png', '+60 12-345-6789', 'System Administrator', 'Dedicated administrator managing the Special Olympics Sarawak digital platform and supporting athletes across all programs.', '2025-12-02 02:02:01', '2025-11-03 01:08:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chapter_participants`
--
ALTER TABLE `chapter_participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chapter_id` (`chapter_id`),
  ADD KEY `year` (`year`);

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
-- Indexes for table `sarawak_chapters`
--
ALTER TABLE `sarawak_chapters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `city` (`city`);

--
-- Indexes for table `sponsorships`
--
ALTER TABLE `sponsorships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sports`
--
ALTER TABLE `sports`
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
-- AUTO_INCREMENT for table `chapter_participants`
--
ALTER TABLE `chapter_participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `gallery_photos`
--
ALTER TABLE `gallery_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `gallery_photos_collection`
--
ALTER TABLE `gallery_photos_collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sarawak_chapters`
--
ALTER TABLE `sarawak_chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sponsorships`
--
ALTER TABLE `sponsorships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sports`
--
ALTER TABLE `sports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chapter_participants`
--
ALTER TABLE `chapter_participants`
  ADD CONSTRAINT `chapter_participants_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `sarawak_chapters` (`id`) ON DELETE CASCADE;

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
