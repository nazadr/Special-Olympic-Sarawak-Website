-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2025 at 09:49 AM
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
-- Table structure for table `alp`
--

CREATE TABLE `alp` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `learn_more_link` varchar(500) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alp`
--

INSERT INTO `alp` (`id`, `title`, `category`, `description`, `image_path`, `learn_more_link`, `display_order`, `created_at`, `updated_at`, `is_active`) VALUES
(4, 'Test', 'SUCCESS STORIES', 'Prevalent Athlete', 'assets/images/alp/693288f6516d6_1764919542.jpeg', '', 1, '2025-12-05 07:25:42', '2025-12-12 08:13:43', 1);

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
(10, 'Bintulu Marathon', '1122', 'Stadium Bintulu', 'Bintulu', '2025-10-20', '9:00 AM - 3:00 PM', 'special', '../assets/images/events/68f5857e22783_70d51a4e6014c4ffa71909d9ea0c816d.jpg'),
(15, 'Test Event ', 'Testing entries\r\n', 'Lasar Kenyalang', 'Bintulu', '2025-11-29', '8.00 P.M - 12.00 P.M', 'special', 'assets/images/events/6927c69f94de5_yap-gal-3.jpg'),
(18, 'Bintulu Ultra Marathon', 'Bintulu Ultra Marathon', 'Tanjung Batu', 'Bintulu', '2025-12-05', '8.00 A.M - 12.00 P.M', 'special', 'assets/images/events/692ce1c87e7f6_68f5857e22783_70d51a4e6014c4ffa71909d9ea0c816d.jpg');

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
(23, 7, '../assets/images/gallery_photos_upload/1764295405_0_sohap-gal-1.jpg', '2025-11-28 02:03:25', 2),
(24, 7, '../assets/images/gallery_photos_upload/1764295405_1_sohap-gal-2.jpg', '2025-11-28 02:03:25', 4),
(25, 7, '../assets/images/gallery_photos_upload/1764295405_2_sohap-gal-3.jpg', '2025-11-28 02:03:25', 3),
(26, 7, '../assets/images/gallery_photos_upload/1764295405_3_sohap-gal-4.jpg', '2025-11-28 02:03:25', 5),
(27, 7, '../assets/images/gallery_photos_upload/1764295405_4_sohap-gal-5.jpg', '2025-11-28 02:03:25', 1),
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
-- Table structure for table `hap`
--

CREATE TABLE `hap` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `learn_more_link` varchar(500) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hap`
--

INSERT INTO `hap` (`id`, `title`, `category`, `description`, `image_path`, `learn_more_link`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 'Community Health Screening Program', 'COMMUNITY IMPACT', 'Free health screenings provided to athletes including vision, hearing, dental, and fitness assessments to ensure comprehensive healthcare access.', '../assets/images/special-olympics-1-1024x768.webp', 'https://www.specialolympicsmalaysia.org/healthy-athletes', 1, '2025-12-05 00:36:12', '2025-12-05 02:11:38'),
(2, 'Athletic Wellness Initiative', 'ATHLETES', 'Comprehensive health education and fitness programs designed to empower athletes with knowledge about nutrition, fitness, and healthy lifestyle choices.', '../assets/images/young_athelte_1.jpg', '#', 2, '2025-12-05 00:36:12', '2025-12-05 00:36:12'),
(3, 'Healthcare Partnership Success', 'IN THE NEWS', 'Collaboration with medical professionals brings specialized care directly to Special Olympics events, ensuring athletes receive the support they need.', '../assets/images/another_news.jpg', '#', 3, '2025-12-05 00:36:12', '2025-12-05 00:36:12');

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
(13, '../assets/images/news_uploads/809a869a2f7a4b861013478ee32a5d9c.jpg', 'Additional News', '2025-12-12', 'Test point of add news function', '2025-12-12 00:59:12');

-- --------------------------------------------------------

--
-- Table structure for table `other_special_olympics`
--

CREATE TABLE `other_special_olympics` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Organization name (e.g., Special Olympics International)',
  `category` enum('international','malaysia','state') NOT NULL COMMENT 'Type of organization',
  `logo_desktop` varchar(500) DEFAULT NULL COMMENT 'Path to desktop/square logo',
  `logo_mobile` varchar(500) DEFAULT NULL COMMENT 'Path to mobile horizontal logo',
  `website_url` varchar(500) DEFAULT NULL COMMENT 'External website URL',
  `display_order` int(11) NOT NULL DEFAULT 0 COMMENT 'Order for display (lower = first)',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = visible, 0 = hidden',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores Special Olympics organizations for Other SO page';

--
-- Dumping data for table `other_special_olympics`
--

INSERT INTO `other_special_olympics` (`id`, `name`, `category`, `logo_desktop`, `logo_mobile`, `website_url`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Special Olympics International', 'international', '../assets/images/SO International.png', '../assets/images/SO International.png', 'https://www.specialolympics.org', 1, 1, '2025-12-17 01:03:56', '2025-12-17 01:03:56'),
(2, 'Special Olympics Malaysia', 'malaysia', '../assets/images/SO Malaysia.png', '../assets/images/SO Malaysia.png', 'https://www.specialolympicsmalaysia.org', 2, 1, '2025-12-17 01:03:56', '2025-12-17 01:03:56'),
(3, 'Special Olympics Johor', 'state', '../assets/images/Square logo/SO Johor - square logo.png', '../assets/images/SO Johor.png', '#', 10, 1, '2025-12-17 01:03:56', '2025-12-17 01:03:56'),
(4, 'Special Olympics Kedah', 'state', '../assets/images/Square logo/SO Kedah - square logo.png', '../assets/images/SO Kedah.png', '#', 20, 1, '2025-12-17 01:03:56', '2025-12-17 01:03:56'),
(5, 'Special Olympics Kelantan', 'state', '../assets/images/Square logo/SO Kelantan - square logo.png', '../assets/images/SO Kelantan.png', '#', 30, 1, '2025-12-17 01:03:56', '2025-12-17 01:03:56'),
(6, 'Special Olympics Malacca', 'state', '../assets/images/Square logo/SO Melaka (EN) - square logo.png', '../assets/images/SO Melaka (EN).png', '#', 40, 1, '2025-12-17 01:03:56', '2025-12-17 01:03:56'),
(7, 'Special Olympics Negeri Sembilan', 'state', '../assets/images/Square logo/SO Negeri Sembilan - square logo.png', '../assets/images/SO Negeri Sembilan.png', '#', 50, 1, '2025-12-17 01:03:56', '2025-12-17 01:03:56'),
(8, 'Special Olympics Pahang', 'state', '../assets/images/Square logo/SO Pahang - square logo.png', '../assets/images/SO Pahang.png', '#', 60, 1, '2025-12-17 01:03:56', '2025-12-17 01:03:56'),
(9, 'Special Olympics Penang', 'state', '../assets/images/Square logo/SO Penang - square logo.png', '../assets/images/SO Penang.png', '#', 70, 1, '2025-12-17 01:03:56', '2025-12-17 01:03:56'),
(10, 'Special Olympics Perak', 'state', '../assets/images/Square logo/SO Perak - square logo.png', '../assets/images/SO Perak.png', '#', 80, 1, '2025-12-17 01:03:56', '2025-12-17 01:03:56'),
(11, 'Special Olympics Perlis', 'state', '../assets/images/Square logo/SO Perlis - square logo.png', '../assets/images/SO Perlis.png', '#', 90, 1, '2025-12-17 01:03:56', '2025-12-17 01:03:56'),
(12, 'Special Olympics Sabah', 'state', '../assets/images/Square logo/SO Sabah - square logo.png', '../assets/images/SO Sabah.png', '#', 100, 1, '2025-12-17 01:03:56', '2025-12-17 01:03:56'),
(13, 'Special Olympics Selangor', 'state', '../assets/images/Square logo/SO Selangor - square logo.png', '../assets/images/SO Selangor.png', 'https://www.specialolympicsselangor.org', 110, 1, '2025-12-17 01:03:56', '2025-12-17 01:03:56'),
(14, 'Special Olympics Terengganu', 'state', '../assets/images/Square logo/SO Terengganu - square logo.png', '../assets/images/SO Terengganu.png', '#', 120, 1, '2025-12-17 01:03:56', '2025-12-17 01:03:56'),
(15, 'Special Olympics Labuan', 'state', '../assets/images/Square logo/SO Labuan - square logo.png', '../assets/images/SO Labuan.png', '#', 130, 1, '2025-12-17 01:03:56', '2025-12-17 01:03:56'),
(16, 'Special Olympics WP Putrajaya', 'state', '../assets/images/Square logo/SO WP Putrajaya - square logo.png', '../assets/images/SO WP Putrajaya.png', '#', 140, 1, '2025-12-17 01:03:56', '2025-12-17 01:04:52');

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
(1, 'SO Kuching Chapter', 'Kuching', 'Madam Liza Chai', 'Unknown', '', '', 'assets/images/Remake/SO Sarawak Kuching Chapter BG - Official logo.png', 'active', '2025-12-01 01:53:08', '2025-12-17 00:36:33'),
(2, 'SO Samarahan Chapter', 'Samarahan', 'TBD', 'TBD', 'TBD', 'TBD', 'assets/images/Remake/SO Sarawak Samarahan Chapter BG - Official logo.png', 'upcoming', '2025-12-01 01:53:08', '2025-12-02 07:06:57'),
(3, 'SO Sibu Chapter', 'Sibu', 'Pemanca Datuk Jason Tai Hee', 'TBD', 'TBD', 'TBD', 'assets/images/Remake/SO Sarawak Sibu Chapter BG - Official logo.png', 'active', '2025-12-01 01:53:08', '2025-12-01 02:53:18'),
(4, 'SO Bintulu Chapter', 'Bintulu', 'Dato Haji Ruslan Bin Abdul Ghani', 'TBD', 'Sabrina Cheong Oi Lin binti Abdullah', 'TBD', 'assets/images/Remake/SO Sarawak Bintulu Chapter BG - Official logo.png', 'active', '2025-12-01 01:53:08', '2025-12-01 02:53:36'),
(5, 'SO Miri Chapter', 'Miri', 'Datin Dayang Mariani Abang Zain', 'TBD', 'TBD', 'TBD', 'assets/images/Remake/SO Sarawak Miri Chapter BG - Official logo.png', 'active', '2025-12-01 01:53:08', '2025-12-01 02:59:07');

-- --------------------------------------------------------

--
-- Table structure for table `sponsorships`
--

CREATE TABLE `sponsorships` (
  `id` int(11) NOT NULL,
  `sponsor_name` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `chapter_id` int(11) DEFAULT NULL,
  `sponsor_tier` enum('platinum','gold','silver','bronze','supporter') DEFAULT 'supporter',
  `image_path` varchar(255) NOT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sponsorships`
--

INSERT INTO `sponsorships` (`id`, `sponsor_name`, `type`, `chapter_id`, `sponsor_tier`, `image_path`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Yayasan Bintulu Port', 'Bintulu Chapter', 4, 'supporter', 'http://localhost/Special-Olympic-Sarawak-Website-Staging-environment/assets/images/yayasan_bintulu_port_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:37:14'),
(2, 'Press Metal', 'Bintulu Chapter', 4, 'supporter', '../assets/images/pressmetal_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:38:39'),
(3, 'Behn Meyer AgriCare', 'Miri Chapter', 5, 'supporter', '../assets/images/sponsorships/693f5348c89a8_692917fd73f55_bhenmayer_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 01:12:11'),
(6, 'Pertama Ferroalloys Sdn Bhd', 'Kuching Chapter', 1, 'supporter', '../assets/images/sponsorships/693f53a1336a4_pertama_ferroalloys_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:36:47'),
(8, 'Behn Meyer AgriCare', 'Special Olympics Sarawak', NULL, 'bronze', '../assets/images/sponsorships/692917fd73f55_bhenmayer_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 01:12:05'),
(11, 'Sunmow Holdings Berhad', 'Miri Chapter', 5, 'supporter', '../assets/images/sponsorships/693f5385acaaf_sunmow_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:39:10'),
(12, 'Yayasan Bintulu Port', 'Special Olympics Sarawak', NULL, 'silver', '../assets/images/sponsorships/693f53c64b963_yayasan_bintulu_port_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 01:08:49'),
(13, 'MTT Shipping Sdn. Bhd.', 'Samarahan Chapter', 2, 'supporter', 'http://localhost/Special-Olympic-Sarawak-Website-Staging-environment/assets/images/sponsorships/693f53d54d2c8_mtt_shipping_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:37:06'),
(14, 'Lions International', 'Samarahan Chapter', 2, 'supporter', '../assets/images/sponsorships/693f543e1a827_lion_international_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:38:14'),
(15, 'Lions International', 'Special Olympics Sarawak', NULL, 'supporter', '../assets/images/sponsorships/693f544991379_lion_international_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:36:04'),
(16, 'Sunmow Holdings Berhad', 'Sibu Chapter', 3, 'supporter', '../assets/images/sponsorships/693f54aec6d08_sunmow_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:39:18'),
(17, 'Remix Technologies', 'Special Olympics Sarawak', NULL, 'supporter', '../assets/images/sponsorships/693f54caedbad_remixtechnology_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:36:19'),
(18, 'Pertama Ferroalloys Sdn Bhd', 'Special Olympics Sarawak', NULL, 'supporter', '../assets/images/sponsorships/693f54e1ca8a6_pertama_ferroalloys_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:36:43');

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
(1, 'Athletics', 'Track and field events including sprints, relays, jumps and throws', 'https://akm-img-a-in.tosshub.com/sites/media2/indiatoday/images/stories/2015July/special-olympic-5_072515021147.jpg', 1, '2025-12-01 01:12:54', '2025-12-15 02:45:29'),
(2, 'Aquatics', 'Individual and team aquatic sport with various strokes and distances', '../assets/images/Aquatics_sport.jpg', 2, '2025-12-01 01:12:54', '2025-12-15 02:45:29'),
(3, 'Badminton', 'Fast-paced racquet sport played individually or in doubles', 'https://www.businesstoday.com.my/wp-content/uploads/2025/05/badminton.png', 3, '2025-12-01 01:12:54', '2025-12-05 07:01:04'),
(4, 'Basketball', 'Team sport with dribbling, passing and shooting skills', 'https://dotorg.brightspotcdn.com/dims4/default/ee9e8a5/2147483647/strip/true/crop/800x450+0+42/resize/800x450!/quality/90/?url=http%3A%2F%2Fsoi-brightspot.s3.amazonaws.com%2Fdotorg%2F79%2F2c%2Fdff376344b05bacc6cc4a6108434%2Fandrew-marquise.JPG', 4, '2025-12-01 01:12:54', '2025-12-01 01:31:15'),
(5, 'Bocce', 'Traditional precision ball sport with strategy and skill', 'https://www.weekly-echo.com/wp-content/uploads/2023/06/special-olympics-bocce-nurul-1.jpg', 6, '2025-12-01 01:12:54', '2025-12-15 07:20:21'),
(6, 'Bowling', 'Popular sport combining fun and skill with lane strategy', '../assets/images/sports/692cef5e17cac_SO_bowling.jpg', 5, '2025-12-01 01:12:54', '2025-12-15 07:20:21'),
(7, 'Floorball', 'Fast indoor team sport similar to floor hockey', 'https://www.specialolympicsmalaysia.org/images/FIH%20Hockey/FIH-SOM%20FIH%20ID-Hockey2.png', 7, '2025-12-01 01:12:54', '2025-12-01 06:11:59'),
(8, 'Football', 'The world\'s most popular sport', 'https://jpwpl.gov.my/sanasini/wp-content/uploads/2017/11/olympiad-smklajau-768x448.jpg', 8, '2025-12-01 01:12:54', '2025-12-01 06:12:00'),
(9, 'Judo', 'Martial art focusing on throws and grappling techniques', '../assets/images/sports/692cefaeed625_SO_judo.jpg', 11, '2025-12-01 01:12:54', '2025-12-16 02:11:01'),
(10, 'Netball', 'Fast-paced team sport similar to basketball', 'https://www.thestatesman.com/wp-content/uploads/2018/08/net-ball.jpg', 9, '2025-12-01 01:12:54', '2025-12-01 06:12:02'),
(11, 'Swimming', 'Individual and team aquatic sport with various strokes and distances', 'https://dotorg.brightspotcdn.com/ac/e1/a4297c14411e803691dafbd93b26/1300x680-aquatics.jpg', 10, '2025-12-01 01:12:54', '2025-12-16 02:11:01'),
(12, 'Tennis', 'Racquet sport played individually or in doubles on a court', '../assets/images/sports/692cefb9f18b2_SO_tennis.jpg', 13, '2025-12-01 01:12:54', '2025-12-01 08:28:51'),
(13, 'Table Tennis', 'Fast-paced indoor racquet sport played on a table', 'https://dotorg.brightspotcdn.com/dims4/default/612aa0c/2147483647/strip/true/crop/2160x1440+0+0/resize/800x533!/quality/90/?url=http%3A%2F%2Fsoi-brightspot.s3.amazonaws.com%2Fdotorg%2F0a%2F60%2F7dad13d84fb9bcb4fa8eac7baaae%2Fsbr0078.jpg', 12, '2025-12-01 01:12:54', '2025-12-01 08:28:51');

-- --------------------------------------------------------

--
-- Table structure for table `state_games`
--

CREATE TABLE `state_games` (
  `id` int(11) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_date` varchar(100) NOT NULL,
  `event_description` text NOT NULL,
  `learn_more_link` varchar(500) DEFAULT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `state_games`
--

INSERT INTO `state_games` (`id`, `event_title`, `event_date`, `event_description`, `learn_more_link`, `image_path`, `display_order`, `created_at`, `updated_at`) VALUES
(1, '8th State Games Kuching 2025', 'TBA 2025', 'The 8th edition of the State Games will be held in Kuching, Sarawak in 2025. This event will feature a variety of sports and activities, bringing together athletes from across the state to compete and celebrate their achievements.', '', 'https://www.theborneopost.com/newsimages/2025/05/kch-030525-dd-fatimah-702x336.jpg', 1, '2025-12-04 08:14:36', '2025-12-17 07:51:23'),
(2, 'National Games 2027', 'TBA 2027', 'An event that brings together athletes from across Malaysia to compete in a variety of sports.', '', 'https://www.theborneopost.com/newsimages/2025/09/kch-260925-mtu-bg_ath_roundup-p1-B.jpg', 2, '2025-12-04 08:14:36', '2025-12-17 07:51:29'),
(3, 'SEA Games 2027', 'TBA 2027', 'This event card is just a placeholder for mockup.', 'https://www.bernama.com/en/region/news.php?id=2500404', 'https://media.freemalaysiatoday.com/wp-content/uploads/2022/05/Sea-Gaes-2017-Malaysia-Bernama.jpg', 3, '2025-12-04 08:14:36', '2025-12-17 07:46:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `phone`, `position`, `bio`, `updated_at`, `created_at`, `profile_photo`) VALUES
(1, 'SO Sarawak Admin', 'sosarawak@gmail.com', '$2y$10$OVIdno8OSwQHKo/a/g3kC.ox8DNGQ42jqqdvvlw4COFYZKASJlgvC', '+60 12-345-6789', 'System Administrator', 'Special Olympics Sarawak System Administrator managing the digital platform.', '2025-12-12 02:11:42', '2025-12-12 02:03:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `yap_content`
--

CREATE TABLE `yap_content` (
  `id` int(11) NOT NULL,
  `hero_image` varchar(500) DEFAULT '../assets/images/yap-hero.jpg',
  `hero_title` varchar(255) DEFAULT 'Young Athletes Program (YAP)',
  `description_text` longtext NOT NULL,
  `testimonial_text` longtext DEFAULT NULL,
  `testimonial_author` varchar(255) DEFAULT NULL,
  `testimonial_location` varchar(255) DEFAULT NULL,
  `resources_title` varchar(255) DEFAULT 'Resources for YAP',
  `resources_description` text DEFAULT NULL,
  `resources_button_text` varchar(100) DEFAULT 'LEARN MORE',
  `resources_button_link` varchar(255) DEFAULT '../src/yap-lm.html',
  `resources_background_image` varchar(500) DEFAULT '../assets/images/yap-lm-hero-hf.jpg',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `yap_content`
--

INSERT INTO `yap_content` (`id`, `hero_image`, `hero_title`, `description_text`, `testimonial_text`, `testimonial_author`, `testimonial_location`, `resources_title`, `resources_description`, `resources_button_text`, `resources_button_link`, `resources_background_image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '../assets/images/yap-hero.jpg', 'Young Athletes Program (YAP)', '<p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Special Olympics Young Athletes is an early childhood play program for children with and without intellectual disabilities, ages 2 to 7 years old. Young Athletes introduces basic sport skills, like running, kicking and throwing. Young Athletes offers families, teachers, caregivers and people from the community the chance to share the joy of sports with all children.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes provides children of all abilities the same opportunities to advance in core developmental milestones. Children learn how to play with others and develop important skills for learning. Children also learn to share, take turns and follow directions. These skills help children in family, community and school activities.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes is a fun way for children to stay active and establish healthy habits for the future. It is important to teach children healthy habits while they are young. This can set the stage for a life of physical activity, friendships and learning. Young Athletes is easy to do and fun for all. It can be done at home, in schools or in the community using the Young Athletes Activity Guide and basic equipment. Through Young Athletes, all children, their families and people in the community can be a part of an inclusive team.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes welcomes children and their families into the Special Olympics Sarawak.</p><ul style=\"max-width: 1160px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-size: 1.1rem; color: rgb(51, 51, 51); font-family: &quot;Segoe UI&quot;, sans-serif;\"><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Motor Skills:</strong>&nbsp;Children with intellectual disabilities who took part in Young Athletes developed motor skills more than twice as fast as others who did not take part.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Social, Emotional and Learning Skills:</strong>&nbsp;Parents and teachers of children who took part in the Young Athletes curriculum said the children learned skills that they will use in pre-primary school.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Expectations:</strong>&nbsp;Family members say that Young Athletes raised their hopes for their child’s future.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Sport Readiness:</strong>&nbsp;Young Athletes helps children get ready to take part in sports when they are older.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Acceptance:</strong>&nbsp;Inclusive play helps children without a disability to better understand and accept others.</li></ul><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">For more information about Young Athletes,&nbsp;<a href=\"http://localhost/Special-Olympic-Sarawak-Website-Staging-environment/src/yap-lm.html\" style=\"color: rgb(230, 57, 70); text-decoration-line: none;\">visit our Young Athletes Program (YAP) Resources page.</a></p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Studies show that after two months of participation in Young Athletes, children with intellectual disabilities experienced a seven month gain in motor skills, representing an improvement at twice the rate of children with intellectual disabilities who have not participated in the program.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Children with intellectual disabilities participating in Young Athletes exhibited greater increases in communication, social, and daily living skills, compared to children with ID not participating in Young Athletes.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Children and families participating in a comprehensive Child and Family Health program, inclusive of Young Athletes, Family Health Forum, and Healthy Young Athletes Pediatric Screening, experienced improvements across the whole family, positively impacting child development and efficacy and empowerment for parents and caregivers.</p>', '\"When my baby was born and I learned he had an intellectual disability, I felt lost, unsure of what the future would hold. But at Young Athletes Program, I see him so full of joy ??? running, laughing, and connecting with others. It\'s such a beautiful sight to witness, and it fills me with hope, reminding me that one day, he might just be able to stand on his own, stronger than I could have ever imagined.\"', 'SARAH, MOTHER OF A YOUNG ATHLETES IN KUCHING', 'KUCHING', 'Resources for YAP', '', 'LEARN MORE', '../src/yap-lm.html', '../assets/images/yap-lm-hero-hf.jpg', 1, '2025-12-05 07:34:03', '2025-12-05 08:31:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alp`
--
ALTER TABLE `alp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_display_order` (`display_order`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_active` (`is_active`);

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
-- Indexes for table `hap`
--
ALTER TABLE `hap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_special_olympics`
--
ALTER TABLE `other_special_olympics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_display_order` (`display_order`),
  ADD KEY `idx_is_active` (`is_active`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_chapter_tier` (`chapter_id`,`sponsor_tier`),
  ADD KEY `idx_display_order` (`display_order`),
  ADD KEY `idx_is_active` (`is_active`);

--
-- Indexes for table `sports`
--
ALTER TABLE `sports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state_games`
--
ALTER TABLE `state_games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_display_order` (`display_order`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `yap_content`
--
ALTER TABLE `yap_content`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alp`
--
ALTER TABLE `alp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chapter_participants`
--
ALTER TABLE `chapter_participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
-- AUTO_INCREMENT for table `hap`
--
ALTER TABLE `hap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `other_special_olympics`
--
ALTER TABLE `other_special_olympics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sarawak_chapters`
--
ALTER TABLE `sarawak_chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sponsorships`
--
ALTER TABLE `sponsorships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sports`
--
ALTER TABLE `sports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `state_games`
--
ALTER TABLE `state_games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `yap_content`
--
ALTER TABLE `yap_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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

--
-- Constraints for table `sponsorships`
--
ALTER TABLE `sponsorships`
  ADD CONSTRAINT `fk_sponsorship_chapter` FOREIGN KEY (`chapter_id`) REFERENCES `sarawak_chapters` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
