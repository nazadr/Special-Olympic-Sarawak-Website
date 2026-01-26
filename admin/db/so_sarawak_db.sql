-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2026 at 03:38 AM
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
-- Table structure for table `alp_page_settings`
--

CREATE TABLE `alp_page_settings` (
  `id` int(11) NOT NULL,
  `hero_image_path` varchar(500) DEFAULT NULL COMMENT 'Path to the hero section background image',
  `hero_title` varchar(255) NOT NULL DEFAULT 'Athlete Leadership Program (ALP)' COMMENT 'Hero section title',
  `description_content` longtext DEFAULT NULL COMMENT 'Full HTML description content with Rich Text formatting',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` varchar(100) DEFAULT NULL COMMENT 'Admin who last updated'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alp_page_settings`
--

INSERT INTO `alp_page_settings` (`id`, `hero_image_path`, `hero_title`, `description_content`, `updated_at`, `updated_by`) VALUES
(1, '../assets/images/alp-hero-temp.jpg', 'Athlete Leadership Program ', '<p>The Athlete Leadership Program (ALP) at Special Olympics Sarawak is designed to empower athletes to become leaders both on and off the field. This program aims to cultivate leadership skills, foster self-confidence, and create opportunities for athletes to take on roles of responsibility within the organization. Through a combination of training, mentorship, and hands-on experience, athletes are given the tools to advocate for themselves and their peers, contribute to the growth of the Special Olympics movement, and become influential role models in their communities. The key features of this program are:<br><br></p>\r\n\r\n<ul>\r\n<li><strong>Leadership Development:</strong> Athletes will learn core leadership skills, including effective communication, team-building, public speaking, and decision-making.</li>\r\n<li><strong>Empowerment Through Roles:</strong> The program offers various leadership roles within the Special Olympics Sarawak community, allowing athletes to represent their peers, organize events, and advocate for inclusion.</li>\r\n<li><strong>Mentorship Opportunities:</strong> Athletes are paired with experienced leaders and mentors who provide guidance, support, and advice throughout their leadership journey.</li>\r\n<li><strong>Advocacy and Awareness:</strong> Participants have the chance to speak out on issues that matter to them, raising awareness and promoting inclusion for people with intellectual disabilities.</li>\r\n<li><strong>Community Engagement:</strong> The program encourages athletes to engage with local communities, spreading the message of empowerment, acceptance, and unity in both sporting and non-sporting environments.</li>\r\n<li><strong>Training and Workshops:</strong> A series of workshops and training sessions are offered to equip athletes with the skills they need to succeed in leadership positions, including conflict resolution, organizational skills, and goal setting.</li>\r\n<li><strong>Personal Growth:</strong> The Athlete Leadership Program fosters personal development by helping athletes build confidence, resilience, and self-awareness.<br><br></li>\r\n</ul>\r\n\r\n<p>The program is open to all athletes involved in Special Olympics Sarawak, with different levels of participation based on experience and interests. Whether athletes want to take on a leadership role within their sport or in the broader community, the program offers structured opportunities to develop and practice these skills.</p>\r\n\r\n<p>Through active participation in the Athlete Leadership Program, athletes not only enhance their personal development but also contribute to creating a more inclusive, diverse, and empowered community.</p>', '2026-01-23 07:37:07', 'SO Sarawak Admin');

-- --------------------------------------------------------

--
-- Table structure for table `athletes`
--

CREATE TABLE `athletes` (
  `id` int(11) NOT NULL,
  `excel_row_id` int(11) DEFAULT NULL COMMENT 'Row number from Excel for reference',
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `chapter` varchar(100) DEFAULT NULL COMMENT 'Kuching, Miri, Sibu, Bintulu, Samarahan',
  `sports_interested` text DEFAULT NULL COMMENT 'Sports they want to participate in',
  `medical_conditions` text DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(50) DEFAULT NULL,
  `registration_date` datetime DEFAULT NULL,
  `status` enum('pending','approved','rejected','archived') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `excel_filename` varchar(255) DEFAULT NULL COMMENT 'Source Excel file name',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `athletes`
--

INSERT INTO `athletes` (`id`, `excel_row_id`, `full_name`, `email`, `phone`, `date_of_birth`, `gender`, `chapter`, `sports_interested`, `medical_conditions`, `emergency_contact_name`, `emergency_contact_phone`, `registration_date`, `status`, `notes`, `excel_filename`, `created_at`, `updated_at`) VALUES
(6, 2, 'John Doe', 'john.doe@example.com', '0123456789', '1995-05-15', 'Male', 'Kuching', 'Swimming, Athletics', 'None', 'Jane Doe', '0129876543', '2025-01-06 10:30:00', 'approved', NULL, 'athletes_20260125_084943.xlsx', '2026-01-25 07:49:43', '2026-01-25 07:49:55'),
(7, 3, 'Sarah Lee', 'sarah.lee@example.com', '0134567890', '1998-08-22', 'Female', 'Miri', 'Basketball, Badminton', 'Asthma', 'Michael Lee', '0145678901', '2025-01-06 11:00:00', 'rejected', NULL, 'athletes_20260125_084943.xlsx', '2026-01-25 07:49:43', '2026-01-25 07:50:02'),
(8, 4, 'Ahmad Ibrahim', 'ahmad@example.com', '0156789012', '1992-03-10', 'Male', 'Sibu', 'Football, Volleyball', '', 'Siti Ibrahim', '0167890123', '2025-01-06 11:30:00', 'approved', NULL, 'athletes_20260125_084943.xlsx', '2026-01-25 07:49:43', '2026-01-25 07:50:14'),
(9, 5, 'Melissa Wong', 'melissa.wong@example.com', '0178901234', '2000-11-05', 'Female', 'Bintulu', 'Table Tennis', '', 'David Wong', '0189012345', '2025-01-06 12:00:00', 'approved', NULL, 'athletes_20260125_084943.xlsx', '2026-01-25 07:49:43', '2026-01-25 07:50:17'),
(10, 6, 'Raj Kumar', 'raj.kumar@example.com', '0190123456', '1996-07-18', 'Male', 'Samarahan', 'Cycling, Running', 'Diabetes', 'Priya Kumar', '0101234567', '2025-01-06 12:30:00', 'pending', NULL, 'athletes_20260125_084943.xlsx', '2026-01-25 07:49:43', '2026-01-25 07:49:43');

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
-- Table structure for table `coaches`
--

CREATE TABLE `coaches` (
  `id` int(11) NOT NULL,
  `excel_row_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `chapter` varchar(100) DEFAULT NULL,
  `sports_expertise` text DEFAULT NULL COMMENT 'Sports they can coach',
  `experience_years` int(11) DEFAULT NULL,
  `certifications` text DEFAULT NULL COMMENT 'Coaching certifications',
  `availability` varchar(255) DEFAULT NULL COMMENT 'Days/times available',
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(50) DEFAULT NULL,
  `registration_date` datetime DEFAULT NULL,
  `status` enum('pending','approved','rejected','archived') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `excel_filename` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coaches`
--

INSERT INTO `coaches` (`id`, `excel_row_id`, `full_name`, `email`, `phone`, `date_of_birth`, `gender`, `chapter`, `sports_expertise`, `experience_years`, `certifications`, `availability`, `emergency_contact_name`, `emergency_contact_phone`, `registration_date`, `status`, `notes`, `excel_filename`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Jane Smith', 'jane@example.com', '0129876543', NULL, NULL, 'Miri', 'Basketball, Football', 5, NULL, NULL, NULL, NULL, NULL, 'approved', NULL, NULL, '2026-01-22 08:27:47', '2026-01-22 08:27:47'),
(2, 2, 'Robert Chen', 'robert.chen@example.com', '111222333', '1985-04-12', 'Male', 'Kuching', '0', 10, 'Level 2 Swimming Coach, Athletics Instructor', 'Weekends', 'Michelle Chen', '122333444', '2025-01-06 09:00:00', 'pending', NULL, 'coaches_20260123_041537.xlsx', '2026-01-23 03:15:37', '2026-01-23 03:15:37'),
(3, 3, 'Linda Tan', 'linda.tan@example.com', '133444555', '1988-09-25', 'Female', 'Miri', '0', 7, 'Basketball Coach Certification', 'Mon-Fri Evenings', 'James Tan', '144555666', '2025-01-06 09:30:00', 'pending', NULL, 'coaches_20260123_041537.xlsx', '2026-01-23 03:15:37', '2026-01-23 03:15:37'),
(4, 4, 'Hassan Ali', 'hassan.ali@example.com', '155666777', '1982-06-08', 'Male', 'Sibu', '0', 15, 'UEFA B License', 'Flexible', 'Aina Ali', '166777888', '2025-01-06 10:00:00', 'pending', NULL, 'coaches_20260123_041537.xlsx', '2026-01-23 03:15:37', '2026-01-23 03:15:37'),
(5, 5, 'Emily Lim', 'emily.lim@example.com', '177888999', '1990-12-30', 'Female', 'Bintulu', '0', 5, 'Level 1 Badminton Coach', 'Weekends Only', 'Peter Lim', '188999000', '2025-01-06 10:30:00', 'pending', NULL, 'coaches_20260123_041537.xlsx', '2026-01-23 03:15:37', '2026-01-23 03:15:37'),
(6, 6, 'Kumar Selvan', 'kumar.s@example.com', '199000111', '1987-02-14', 'Male', 'Samarahan', '0', 8, 'Cycling Instructor Cert', 'Mon/Wed/Fri', 'Devi Selvan', '100111222', '2025-01-06 11:00:00', 'pending', NULL, 'coaches_20260123_041537.xlsx', '2026-01-23 03:15:37', '2026-01-23 03:15:37');

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
(6, 'Bintulu Marathon Rerun 2025', 'Another event of Bintulu Marathon', 'Stadium Bintulu', 'Bintulu', '2025-12-03', '9:00 AM - 3:00 PM', 'training', '../assets/images/events/68a2eb4b8975d_child_family_news.jpg'),
(9, '7th State Game Kuching Opening Ceremony', 'A Special Olympic Event', 'Sarawak Stadium', 'Kuching', '2025-10-23', '9:00 AM - 3:00 PM', 'ceremony', '../assets/images/events/68ef10b2d0f4e_another_news.jpg'),
(10, 'Bintulu Marathon', '1122', 'Stadium Bintulu', 'Bintulu', '2025-10-20', '9:00 AM - 3:00 PM', 'special', '../assets/images/events/68f5857e22783_70d51a4e6014c4ffa71909d9ea0c816d.jpg'),
(15, 'Young Athlete Program', 'Young Athlete Program', 'Lasar Kenyalang', 'Bintulu', '2025-11-29', '8.00 P.M - 12.00 P.M', 'special', 'assets/images/events/6927c69f94de5_yap-gal-3.jpg'),
(18, 'Bintulu Ultra Marathon', 'Bintulu Ultra Marathon', 'Tanjung Batu', 'Bintulu', '2025-12-05', '8.00 A.M - 12.00 P.M', 'special', 'assets/images/events/692ce1c87e7f6_68f5857e22783_70d51a4e6014c4ffa71909d9ea0c816d.jpg'),
(23, 'Special Olympics Malaysia 6th National Games', 'Bintulu Sarawak', 'Dewan Suarah', 'Bintulu', '2026-04-25', '8.00 a.m - 5.00 p.m', 'special', 'assets/images/events/697331bf2a235_profile_2_1764641692.png'),
(24, 'SONG26 Syndication Meeting with YBDS', 'SONG26 Syndication Meeting with YBDS', 'Kuching', 'Kuching', '2026-01-30', '9:00 AM - 12:00 PM', 'meeting', NULL);

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
(23, 7, '../assets/images/gallery_photos_upload/1764295405_0_sohap-gal-1.jpg', '2025-11-28 02:03:25', 3),
(24, 7, '../assets/images/gallery_photos_upload/1764295405_1_sohap-gal-2.jpg', '2025-11-28 02:03:25', 4),
(25, 7, '../assets/images/gallery_photos_upload/1764295405_2_sohap-gal-3.jpg', '2025-11-28 02:03:25', 2),
(26, 7, '../assets/images/gallery_photos_upload/1764295405_3_sohap-gal-4.jpg', '2025-11-28 02:03:25', 5),
(27, 7, '../assets/images/gallery_photos_upload/1764295405_4_sohap-gal-5.jpg', '2025-11-28 02:03:25', 1),
(28, 7, '../assets/images/gallery_photos_upload/1764295405_5_sohap-gal-6.jpg', '2025-11-28 02:03:25', 6),
(29, 7, '../assets/images/gallery_photos_upload/1764295405_6_sohap-gal-7.jpg', '2025-11-28 02:03:25', 7),
(30, 8, '../assets/images/gallery_photos_upload/1764295580_0_chapter-bintulu.jpg', '2025-11-28 02:06:20', 2),
(31, 8, '../assets/images/gallery_photos_upload/1764300654_0_bintulu_marathon_2025.jpg', '2025-11-28 03:30:54', 1),
(32, 8, '../assets/images/gallery_photos_upload/1764313074_0_another_news.jpg', '2025-11-28 06:57:54', 4),
(33, 8, '../assets/images/gallery_photos_upload/1764313074_1_healthy_program_1.jpg', '2025-11-28 06:57:54', 3),
(34, 9, '../assets/images/gallery_photos_upload/1767919531_0_IMG_20220703_095426.jpg', '2026-01-09 00:45:31', 2),
(35, 9, '../assets/images/gallery_photos_upload/1767919531_1_IMG_20220703_094316.jpg', '2026-01-09 00:45:31', 3),
(36, 9, '../assets/images/gallery_photos_upload/1767919531_2_IMG_20220703_093706.jpg', '2026-01-09 00:45:31', 4),
(37, 9, '../assets/images/gallery_photos_upload/1767919531_3_IMG_20220703_092826.jpg', '2026-01-09 00:45:31', 5),
(38, 9, '../assets/images/gallery_photos_upload/1767919531_4_20220703_083443.jpg', '2026-01-09 00:45:31', 1);

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
(6, 'Kuching Chapter', 'This is a collection of the Special Olympics Kuching Chapter.', '2025-11-27 00:50:46', 4),
(7, 'Healthy Athletes', 'This is a collection of Healthy Athletes Program.', '2025-11-28 00:40:00', 1),
(8, 'Bintulu Chapter', 'This is a collection of Special Olympics Bintulu Chapter', '2025-11-28 02:06:20', 3),
(9, 'Young Athlete Program', 'This is a collection of Young Athlete Program photo', '2026-01-09 00:40:51', 2);

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
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_videos`
--

INSERT INTO `gallery_videos` (`id`, `collection_id`, `video_path`, `cover_path`, `title`, `description`, `display_order`, `created_at`) VALUES
(1, 1, '../assets/videos/yap-lm-v1.mp4', '../assets/videos/GalleryVid/thumbnail/yap-gal-1.jpg', 'Lets Play Together with YAP', 'Promotional video introducing Young Athletes Program (YAP).', 0, '2025-11-19 01:47:27'),
(6, 2, '../assets/videos/gallery_videos_upload/video_2_1768203207_0.mp4', 'assets/videos/gallery_videos_upload/covers/video_6_thumb_1768203256.jpg', 'Jurassic Fun!', 'Day of Joy', 0, '2026-01-12 07:33:27'),
(7, 2, '../assets/videos/gallery_videos_upload/video_2_1768203207_1.mp4', 'assets/videos/gallery_videos_upload/covers/video_7_thumb_1768203239.jpg', 'Lets Play', 'Play Smart and Fun', 0, '2026-01-12 07:33:27');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_videos_collection`
--

CREATE TABLE `gallery_videos_collection` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_videos_collection`
--

INSERT INTO `gallery_videos_collection` (`id`, `name`, `description`, `display_order`, `created_at`) VALUES
(1, 'Young Athletes Program', 'A video collection of Young Athletes Program.', 0, '2025-11-19 01:43:13'),
(2, 'Young Athletes Program II', 'This is a video collection for the Healthy Athlete Program II', 0, '2026-01-09 01:49:38');

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
(2, 'Athletic Wellness Initiative', 'ATHLETES', 'Comprehensive health education and fitness programs designed to empower athletes with knowledge about nutrition, fitness, and healthy lifestyle choices.', '../assets/images/young_athelte_1.jpg', '', 2, '2025-12-05 00:36:12', '2025-12-18 01:42:57'),
(3, 'Healthcare Partnership Success', 'IN THE NEWS', 'Collaboration with medical professionals brings specialized care directly to Special Olympics events, ensuring athletes receive the support they need.', '../assets/images/another_news.jpg', '', 3, '2025-12-05 00:36:12', '2025-12-18 01:43:01');

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
(6, '../assets/images/news_uploads/88931f16a199bd5a5fb88839668568e2.jpg', 'Bintulu Marathon 2025', '2025-08-03', 'Bintulu Marathon 2025', '2025-08-26 02:35:45'),
(7, '../assets/images/news_uploads/505cbb515bcaa601fe6878531516ab21.jpg', 'Bintulu Port', '2025-10-30', 'Bintulu Marathon', '2025-10-30 06:33:55'),
(13, '../assets/images/news_uploads/809a869a2f7a4b861013478ee32a5d9c.jpg', 'Additional News', '2025-12-12', 'Addition of SO National Games News', '2025-12-12 00:59:12'),
(14, '../assets/images/news_uploads/b78a617363b08ab42b67eaaa1db88af7.jpg', 'Healthy Program', '2026-01-07', 'Program was conducted aimed to improve the health awareness of the participants', '2026-01-08 01:28:57');

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
(2, 'Special Olympics Malaysia', 'malaysia', '../assets/images/SO Malaysia.png', '../assets/images/SO Malaysia.png', 'https://www.specialolympicsmalaysia.org', 2, 1, '2025-12-17 01:03:56', '2025-12-17 01:03:56'),
(3, 'Special Olympics Johor', 'state', '../assets/images/Square logo/SO Johor - square logo.png', '../assets/images/SO Johor.png', '', 10, 1, '2025-12-17 01:03:56', '2026-01-05 00:49:49'),
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
-- Table structure for table `participant_excel_uploads`
--

CREATE TABLE `participant_excel_uploads` (
  `id` int(11) NOT NULL,
  `participant_type` enum('athlete','coach','volunteer') NOT NULL,
  `filename` varchar(255) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `rows_imported` int(11) DEFAULT 0,
  `rows_updated` int(11) DEFAULT 0,
  `rows_failed` int(11) DEFAULT 0,
  `uploaded_by` int(11) DEFAULT NULL COMMENT 'admin_id',
  `upload_status` enum('success','partial','failed') DEFAULT 'success',
  `error_log` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `participant_excel_uploads`
--

INSERT INTO `participant_excel_uploads` (`id`, `participant_type`, `filename`, `original_filename`, `file_path`, `rows_imported`, `rows_updated`, `rows_failed`, `uploaded_by`, `upload_status`, `error_log`, `created_at`) VALUES
(7, 'athlete', 'athletes_20260123_013923.xlsx', 'athletes_20260123_013923.xlsx', 'uploads/participants/athletes/athletes_20260123_013923.xlsx', 0, 0, 0, 1, 'failed', 'No records found in database. File may have been uploaded but import failed.', '2026-01-23 00:39:23'),
(8, 'athlete', 'athletes_20260123_014131.xlsx', 'athletes_20260123_014131.xlsx', 'uploads/participants/athletes/athletes_20260123_014131.xlsx', 0, 0, 0, 1, 'failed', 'No records found in database. File may have been uploaded but import failed.', '2026-01-23 00:41:31'),
(9, 'athlete', 'athletes_20260123_014317.xlsx', 'athletes_20260123_014317.xlsx', 'uploads/participants/athletes/athletes_20260123_014317.xlsx', 0, 0, 0, 1, 'failed', 'No records found in database. File may have been uploaded but import failed.', '2026-01-23 00:43:17'),
(10, 'athlete', 'athletes_20260123_014716.xlsx', 'athletes_20260123_014716.xlsx', 'uploads/participants/athletes/athletes_20260123_014716.xlsx', 5, 0, 0, 1, 'success', '', '2026-01-23 00:47:16'),
(11, 'volunteer', 'volunteers_20260123_014627.xlsx', 'volunteers_20260123_014627.xlsx', 'uploads/participants/volunteers/volunteers_20260123_014627.xlsx', 0, 0, 0, 1, 'failed', 'No records found in database. File may have been uploaded but import failed.', '2026-01-23 00:46:27'),
(12, 'volunteer', 'volunteers_20260123_032829.xlsx', 'volunteers_20260123_032829.xlsx', 'uploads/participants/volunteers/volunteers_20260123_032829.xlsx', 5, 0, 0, 1, 'success', '', '2026-01-23 02:28:29'),
(13, 'coach', 'coaches_20260123_041537.xlsx', 'coaches.xlsx', '../../uploads/participants/coaches/coaches_20260123_041537.xlsx', 5, 0, 0, 1, 'success', NULL, '2026-01-23 03:15:37'),
(14, 'athlete', 'athletes_20260123_093348.xlsx', 'Athletes_Template.xlsx', '../../uploads/participants/athletes/athletes_20260123_093348.xlsx', 0, 5, 0, 1, 'success', NULL, '2026-01-23 08:33:48'),
(15, 'athlete', 'athletes_20260125_084943.xlsx', 'Athletes_Template.xlsx', '../../uploads/participants/athletes/athletes_20260125_084943.xlsx', 5, 0, 0, 1, 'success', NULL, '2026-01-25 07:49:43');

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
  `logo_path` varchar(255) NOT NULL COMMENT 'Hardcoded logo path - not editable via admin',
  `status` enum('active','upcoming','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sarawak_chapters`
--

INSERT INTO `sarawak_chapters` (`id`, `chapter_name`, `city`, `chairman`, `vice_chairman`, `secretary`, `logo_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SO Kuching Chapter', 'Kuching', 'Madam Liza Chai', 'Unknown', '', 'assets/images/Remake/SO Sarawak Kuching Chapter BG - Official logo.png', 'active', '2025-12-01 01:53:08', '2025-12-17 00:36:33'),
(2, 'SO Samarahan Chapter', 'Samarahan', 'TBD', 'TBD', 'TBD', 'assets/images/Remake/SO Sarawak Samarahan Chapter BG - Official logo.png', 'upcoming', '2025-12-01 01:53:08', '2025-12-19 00:53:56'),
(3, 'SO Sibu Chapter', 'Sibu', 'Pemanca Datuk Jason Tai Hee', 'TBD', '', 'assets/images/Remake/SO Sarawak Sibu Chapter BG - Official logo.png', 'active', '2025-12-01 01:53:08', '2025-12-24 08:08:41'),
(4, 'SO Bintulu Chapter', 'Bintulu', 'Dato Haji Ruslan Bin Abdul Ghani', 'TBD', 'Sabrina Cheong Oi Lin binti Abdullah', 'assets/images/Remake/SO Sarawak Bintulu Chapter BG - Official logo.png', 'active', '2025-12-01 01:53:08', '2026-01-15 00:56:57'),
(5, 'SO Miri Chapter', 'Miri', 'Datin Dayang Mariani Abang Zain', 'TBD', 'TBD', 'assets/images/Remake/SO Sarawak Miri Chapter BG - Official logo.png', 'active', '2025-12-01 01:53:08', '2025-12-01 02:59:07');

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
(6, 'Pertama Ferroalloys Sdn Bhd', 'Kuching Chapter', 1, 'supporter', '../assets/images/sponsorships/693f53a1336a4_pertama_ferroalloys_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:36:47'),
(8, 'Behn Meyer AgriCare', 'Special Olympics Sarawak', NULL, 'bronze', '../assets/images/sponsorships/692917fd73f55_bhenmayer_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 01:12:05'),
(11, 'Sunmow Holdings Berhad', 'Miri Chapter', 5, 'supporter', '../assets/images/sponsorships/693f5385acaaf_sunmow_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:39:10'),
(12, 'Yayasan Bintulu Port', 'Special Olympics Sarawak', NULL, 'silver', '../assets/images/sponsorships/693f53c64b963_yayasan_bintulu_port_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 01:08:49'),
(13, 'MTT Shipping Sdn. Bhd.', 'Samarahan Chapter', 2, 'supporter', 'http://localhost/Special-Olympic-Sarawak-Website-Staging-environment/assets/images/sponsorships/693f53d54d2c8_mtt_shipping_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:37:06'),
(14, 'Lions International', 'Samarahan Chapter', 2, 'supporter', '../assets/images/sponsorships/693f543e1a827_lion_international_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:38:14'),
(15, 'Lions International', 'Special Olympics Sarawak', NULL, 'supporter', '../assets/images/sponsorships/693f544991379_lion_international_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:36:04'),
(16, 'Sunmow Holdings Berhad', 'Sibu Chapter', 3, 'supporter', '../assets/images/sponsorships/693f54aec6d08_sunmow_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:39:18'),
(17, 'Remix Technologies', 'Special Olympics Sarawak', NULL, 'supporter', '../assets/images/sponsorships/693f54caedbad_remixtechnology_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:36:19'),
(18, 'Pertama Ferroalloys Sdn Bhd', 'Special Olympics Sarawak', NULL, 'supporter', '../assets/images/sponsorships/693f54e1ca8a6_pertama_ferroalloys_logo.png', 0, 1, '2025-12-15 00:50:50', '2025-12-15 02:36:43'),
(19, 'Remix Technologies', 'Bintulu Chapter', 4, 'silver', '../assets/images/sponsorships/694a45e08ffc0_693f54caedbad_remixtechnology_logo.png', 0, 1, '2025-12-23 07:33:52', '2025-12-23 07:33:52');

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
(1, 'Athletics', 'Track and field events including sprints, relays, jumps and throws', 'https://akm-img-a-in.tosshub.com/sites/media2/indiatoday/images/stories/2015July/special-olympic-5_072515021147.jpg', 2, '2025-12-01 01:12:54', '2026-01-14 07:42:29'),
(2, 'Aquatics', 'Individual and team aquatic sport with various strokes and distances', '../assets/images/Aquatics_sport.jpg', 1, '2025-12-01 01:12:54', '2026-01-14 07:42:29'),
(3, 'Badminton', 'Fast-paced racquet sport played individually or in doubles', 'https://www.businesstoday.com.my/wp-content/uploads/2025/05/badminton.png', 4, '2025-12-01 01:12:54', '2025-12-19 08:29:10'),
(4, 'Basketball', 'Team sport with dribbling, passing and shooting skills', 'https://dotorg.brightspotcdn.com/dims4/default/ee9e8a5/2147483647/strip/true/crop/800x450+0+42/resize/800x450!/quality/90/?url=http%3A%2F%2Fsoi-brightspot.s3.amazonaws.com%2Fdotorg%2F79%2F2c%2Fdff376344b05bacc6cc4a6108434%2Fandrew-marquise.JPG', 3, '2025-12-01 01:12:54', '2025-12-19 08:29:10'),
(5, 'Bocce', 'Traditional precision ball sport with strategy and skill', 'https://www.weekly-echo.com/wp-content/uploads/2023/06/special-olympics-bocce-nurul-1.jpg', 7, '2025-12-01 01:12:54', '2026-01-14 03:19:07'),
(6, 'Bowling', 'Popular sport combining fun and skill with lane strategy', '../assets/images/sports/692cef5e17cac_SO_bowling.jpg', 5, '2025-12-01 01:12:54', '2025-12-15 07:20:21'),
(7, 'Floorball', 'Fast indoor team sport similar to floor hockey', 'https://www.specialolympicsmalaysia.org/images/FIH%20Hockey/FIH-SOM%20FIH%20ID-Hockey2.png', 6, '2025-12-01 01:12:54', '2026-01-14 03:19:07'),
(8, 'Football', 'The world\'s most popular sport', 'https://jpwpl.gov.my/sanasini/wp-content/uploads/2017/11/olympiad-smklajau-768x448.jpg', 8, '2025-12-01 01:12:54', '2025-12-01 06:12:00'),
(9, 'Judo', 'Martial art focusing on throws and grappling techniques', '../assets/images/sports/692cefaeed625_SO_judo.jpg', 12, '2025-12-01 01:12:54', '2025-12-18 07:21:38'),
(10, 'Netball', 'Fast-paced team sport similar to basketball', 'https://www.thestatesman.com/wp-content/uploads/2018/08/net-ball.jpg', 9, '2025-12-01 01:12:54', '2025-12-01 06:12:02'),
(11, 'Swimming', 'Individual and team aquatic sport with various strokes and distances', 'https://dotorg.brightspotcdn.com/ac/e1/a4297c14411e803691dafbd93b26/1300x680-aquatics.jpg', 10, '2025-12-01 01:12:54', '2025-12-16 02:11:01'),
(12, 'Tennis', 'Racquet sport played individually or in doubles on a court', '../assets/images/sports/692cefb9f18b2_SO_tennis.jpg', 13, '2025-12-01 01:12:54', '2026-01-14 03:19:55'),
(13, 'Table Tennis', 'Fast-paced indoor racquet sport played on a table', 'https://dotorg.brightspotcdn.com/dims4/default/612aa0c/2147483647/strip/true/crop/2160x1440+0+0/resize/800x533!/quality/90/?url=http%3A%2F%2Fsoi-brightspot.s3.amazonaws.com%2Fdotorg%2F0a%2F60%2F7dad13d84fb9bcb4fa8eac7baaae%2Fsbr0078.jpg', 11, '2025-12-01 01:12:54', '2025-12-18 07:21:38');

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
(1, '8th State Games Kuching 2025', 'TBA 2025', 'The 8th edition of the State Games will be held in Kuching, Sarawak in 2025. This event will feature a variety of sports and activities, bringing together athletes from across the state to compete and celebrate their achievements.', 'https://www.facebook.com/100063692706438/posts/borneo-game-kuching-september-2025-the-thrill-of-8-exciting-sports-happening-at-/1314245047375240/', 'https://www.theborneopost.com/newsimages/2025/05/kch-030525-dd-fatimah-702x336.jpg', 1, '2025-12-04 08:14:36', '2026-01-13 00:43:41'),
(2, 'National Games 2026', 'TBA 2026', 'An event that brings together athletes from across Malaysia to compete in a variety of sports.', 'https://www.facebook.com/selangor2026/?locale=ms_MY', 'https://www.theborneopost.com/newsimages/2025/09/kch-260925-mtu-bg_ath_roundup-p1-B.jpg', 2, '2025-12-04 08:14:36', '2026-01-13 00:46:28'),
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
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `id` int(11) NOT NULL,
  `excel_row_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `chapter` varchar(100) DEFAULT NULL,
  `volunteer_role` text DEFAULT NULL COMMENT 'Preferred volunteer roles',
  `skills` text DEFAULT NULL COMMENT 'Skills they can offer',
  `availability` varchar(255) DEFAULT NULL,
  `previous_volunteer_experience` text DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(50) DEFAULT NULL,
  `registration_date` datetime DEFAULT NULL,
  `status` enum('pending','approved','rejected','archived') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `excel_filename` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`id`, `excel_row_id`, `full_name`, `email`, `phone`, `date_of_birth`, `gender`, `chapter`, `volunteer_role`, `skills`, `availability`, `previous_volunteer_experience`, `emergency_contact_name`, `emergency_contact_phone`, `registration_date`, `status`, `notes`, `excel_filename`, `created_at`, `updated_at`) VALUES
(8, 2, 'Jessica Wong', 'jessica.w@example.com', '112223344', '1995-03-20', 'Female', 'Kuching', 'Event Coordinator, Photographer', 'Photography, Event Planning', 'Weekends', '2 years at Red Cross', 'Richard Wong', '123334455', '2025-01-06 08:00:00', 'pending', NULL, 'volunteers_20260123_032829.xlsx', '2026-01-23 02:28:30', '2026-01-23 02:28:30'),
(9, 3, 'Daniel Lee', 'daniel.lee@example.com', '134445566', '1992-07-15', 'Male', 'Miri', 'Transportation, Setup Crew', 'Driving, Manual Labor', 'Flexible', 'First time volunteering', 'Susan Lee', '145556677', '2025-01-06 08:30:00', 'approved', NULL, 'volunteers_20260123_032829.xlsx', '2026-01-23 02:28:30', '2026-01-23 03:22:46'),
(10, 4, 'Fatimah Zahra', 'fatimah.z@example.com', '156667788', '1998-11-02', 'Female', 'Sibu', 'Medical Support, First Aid', 'Nursing, First Aid Certified', 'Mon-Fri Mornings', '3 years at Hospital Volunteer', 'Ahmad Zahra', '167778899', '2025-01-06 09:00:00', 'pending', NULL, 'volunteers_20260123_032829.xlsx', '2026-01-23 02:28:30', '2026-01-23 02:28:30'),
(11, 5, 'Kevin Tan', 'kevin.tan@example.com', '178889900', '1990-05-28', 'Male', 'Bintulu', 'IT Support, Registration Desk', 'IT, Computer Skills', 'Weekends', 'Volunteer at Tech Event', 'Mary Tan', '189990011', '2025-01-06 09:30:00', 'pending', NULL, 'volunteers_20260123_032829.xlsx', '2026-01-23 02:28:30', '2026-01-23 02:28:30'),
(12, 6, 'Priya Nair', 'priya.nair@example.com', '190001122', '1994-09-10', 'Female', 'Samarahan', 'Coaching Assistant, Mentor', 'Teaching, Sports Knowledge', 'Tue/Thu Evenings', 'Coach volunteer 1 year', 'Raj Nair', '101112233', '2025-01-06 10:00:00', 'pending', NULL, 'volunteers_20260123_032829.xlsx', '2026-01-23 02:28:30', '2026-01-23 02:28:30');

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
(1, '../assets/images/yap-hero.jpg', 'Young Athletes Program', '<p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Special Olympics Young Athletes is an early childhood play program for children with and without intellectual disabilities, ages 2 to 7 years old. Young Athletes introduces basic sport skills, like running, kicking and throwing. Young Athletes offers families, teachers, caregivers and people from the community the chance to share the joy of sports with all children.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes provides children of all abilities the same opportunities to advance in core developmental milestones. Children learn how to play with others and develop important skills for learning. Children also learn to share, take turns and follow directions. These skills help children in family, community and school activities.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes is a fun way for children to stay active and establish healthy habits for the future. It is important to teach children healthy habits while they are young. This can set the stage for a life of physical activity, friendships and learning. Young Athletes is easy to do and fun for all. It can be done at home, in schools or in the community using the Young Athletes Activity Guide and basic equipment. Through Young Athletes, all children, their families and people in the community can be a part of an inclusive team.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes welcomes children and their families into the Special Olympics Sarawak.</p><ul style=\"max-width: 1160px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-size: 1.1rem; color: rgb(51, 51, 51); font-family: &quot;Segoe UI&quot;, sans-serif;\"><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Motor Skills:</strong>&nbsp;Children with intellectual disabilities who took part in Young Athletes developed motor skills more than twice as fast as others who did not take part.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Social, Emotional and Learning Skills:</strong>&nbsp;Parents and teachers of children who took part in the Young Athletes curriculum said the children learned skills that they will use in pre-primary school.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Expectations:</strong>&nbsp;Family members say that Young Athletes raised their hopes for their child’s future.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Sport Readiness:</strong>&nbsp;Young Athletes helps children get ready to take part in sports when they are older.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Acceptance:</strong>&nbsp;Inclusive play helps children without a disability to better understand and accept others.</li></ul><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">For more information about Young Athletes,&nbsp;<a href=\"http://localhost/Special-Olympic-Sarawak-Website-Staging-environment/src/yap-lm.html\" style=\"color: rgb(230, 57, 70); text-decoration-line: none;\">visit our Young Athletes Program Resources page.</a></p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Studies show that after two months of participation in Young Athletes, children with intellectual disabilities experienced a seven month gain in motor skills, representing an improvement at twice the rate of children with intellectual disabilities who have not participated in the program.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Children with intellectual disabilities participating in Young Athletes exhibited greater increases in communication, social, and daily living skills, compared to children with ID not participating in Young Athletes.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Children and families participating in a comprehensive Child and Family Health program, inclusive of Young Athletes, Family Health Forum, and Healthy Young Athletes Pediatric Screening, experienced improvements across the whole family, positively impacting child development and efficacy and empowerment for parents and caregivers.</p>', '\"When my baby was born and I learned he had an intellectual disability, I felt lost, unsure of what the future would hold. But at Young Athletes Program, I see him so full of joy ??? running, laughing, and connecting with others. It\'s such a beautiful sight to witness, and it fills me with hope, reminding me that one day, he might just be able to stand on his own, stronger than I could have ever imagined.\"', 'SARAH, MOTHER OF A YOUNG ATHLETES IN KUCHING', 'KUCHING', 'Resources for Young Athlete Program', '', 'LEARN MORE', '../src/yap-lm.html', '../assets/images/yap-lm-hero-hf.jpg', 1, '2025-12-05 07:34:03', '2026-01-23 08:01:45'),
(2, '../assets/images/yap-hero.jpg', 'Young Athletes Program', '<p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Special Olympics Young Athletes is an early childhood play program for children with and without intellectual disabilities, ages 2 to 7 years old. Young Athletes introduces basic sport skills, like running, kicking and throwing. Young Athletes offers families, teachers, caregivers and people from the community the chance to share the joy of sports with all children.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes provides children of all abilities the same opportunities to advance in core developmental milestones. Children learn how to play with others and develop important skills for learning. Children also learn to share, take turns and follow directions. These skills help children in family, community and school activities.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes is a fun way for children to stay active and establish healthy habits for the future. It is important to teach children healthy habits while they are young. This can set the stage for a life of physical activity, friendships and learning. Young Athletes is easy to do and fun for all. It can be done at home, in schools or in the community using the Young Athletes Activity Guide and basic equipment. Through Young Athletes, all children, their families and people in the community can be a part of an inclusive team.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes welcomes children and their families into the Special Olympics Sarawak.</p><ul style=\"max-width: 1160px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-size: 1.1rem; color: rgb(51, 51, 51); font-family: &quot;Segoe UI&quot;, sans-serif;\"><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Motor Skills:</strong>&nbsp;Children with intellectual disabilities who took part in Young Athletes developed motor skills more than twice as fast as others who did not take part.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Social, Emotional and Learning Skills:</strong>&nbsp;Parents and teachers of children who took part in the Young Athletes curriculum said the children learned skills that they will use in pre-primary school.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Expectations:</strong>&nbsp;Family members say that Young Athletes raised their hopes for their child’s future.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Sport Readiness:</strong>&nbsp;Young Athletes helps children get ready to take part in sports when they are older.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Acceptance:</strong>&nbsp;Inclusive play helps children without a disability to better understand and accept others.</li></ul><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">For more information about Young Athletes,&nbsp;<a href=\"http://localhost/Special-Olympic-Sarawak-Website-Staging-environment/src/yap-lm.html\" style=\"color: rgb(230, 57, 70); text-decoration-line: none;\">visit our Young Athletes Program (YAP) Resources page.</a></p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Studies show that after two months of participation in Young Athletes, children with intellectual disabilities experienced a seven month gain in motor skills, representing an improvement at twice the rate of children with intellectual disabilities who have not participated in the program.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Children with intellectual disabilities participating in Young Athletes exhibited greater increases in communication, social, and daily living skills, compared to children with ID not participating in Young Athletes.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Children and families participating in a comprehensive Child and Family Health program, inclusive of Young Athletes, Family Health Forum, and Healthy Young Athletes Pediatric Screening, experienced improvements across the whole family, positively impacting child development and efficacy and empowerment for parents and caregivers.</p>', '\"When my baby was born and I learned he had an intellectual disability, I felt lost, unsure of what the future would hold. But at Young Athletes Program, I see him so full of joy ??? running, laughing, and connecting with others. It\'s such a beautiful sight to witness, and it fills me with hope, reminding me that one day, he might just be able to stand on his own, stronger than I could have ever imagined.\"', 'SARAH, MOTHER OF A YOUNG ATHLETES IN KUCHING', 'KUCHING', 'Resources for YAP', '', 'LEARN MORE', '../src/yap-lm.html', '../assets/images/yap-lm-hero-hf.jpg', 1, '2026-01-23 07:31:43', '2026-01-23 07:31:43'),
(3, '../assets/images/yap-hero.jpg', 'Young Athletes Program', '<p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Special Olympics Young Athletes is an early childhood play program for children with and without intellectual disabilities, ages 2 to 7 years old. Young Athletes introduces basic sport skills, like running, kicking and throwing. Young Athletes offers families, teachers, caregivers and people from the community the chance to share the joy of sports with all children.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes provides children of all abilities the same opportunities to advance in core developmental milestones. Children learn how to play with others and develop important skills for learning. Children also learn to share, take turns and follow directions. These skills help children in family, community and school activities.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes is a fun way for children to stay active and establish healthy habits for the future. It is important to teach children healthy habits while they are young. This can set the stage for a life of physical activity, friendships and learning. Young Athletes is easy to do and fun for all. It can be done at home, in schools or in the community using the Young Athletes Activity Guide and basic equipment. Through Young Athletes, all children, their families and people in the community can be a part of an inclusive team.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes welcomes children and their families into the Special Olympics Sarawak.</p><ul style=\"max-width: 1160px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-size: 1.1rem; color: rgb(51, 51, 51); font-family: &quot;Segoe UI&quot;, sans-serif;\"><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Motor Skills:</strong>&nbsp;Children with intellectual disabilities who took part in Young Athletes developed motor skills more than twice as fast as others who did not take part.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Social, Emotional and Learning Skills:</strong>&nbsp;Parents and teachers of children who took part in the Young Athletes curriculum said the children learned skills that they will use in pre-primary school.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Expectations:</strong>&nbsp;Family members say that Young Athletes raised their hopes for their child’s future.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Sport Readiness:</strong>&nbsp;Young Athletes helps children get ready to take part in sports when they are older.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Acceptance:</strong>&nbsp;Inclusive play helps children without a disability to better understand and accept others.</li></ul><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">For more information about Young Athletes,&nbsp;<a href=\"http://localhost/Special-Olympic-Sarawak-Website-Staging-environment/src/yap-lm.html\" style=\"color: rgb(230, 57, 70); text-decoration-line: none;\">visit our Young Athletes Program (YAP) Resources page.</a></p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Studies show that after two months of participation in Young Athletes, children with intellectual disabilities experienced a seven month gain in motor skills, representing an improvement at twice the rate of children with intellectual disabilities who have not participated in the program.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Children with intellectual disabilities participating in Young Athletes exhibited greater increases in communication, social, and daily living skills, compared to children with ID not participating in Young Athletes.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Children and families participating in a comprehensive Child and Family Health program, inclusive of Young Athletes, Family Health Forum, and Healthy Young Athletes Pediatric Screening, experienced improvements across the whole family, positively impacting child development and efficacy and empowerment for parents and caregivers.</p>', '\"When my baby was born and I learned he had an intellectual disability, I felt lost, unsure of what the future would hold. But at Young Athletes Program, I see him so full of joy ??? running, laughing, and connecting with others. It\'s such a beautiful sight to witness, and it fills me with hope, reminding me that one day, he might just be able to stand on his own, stronger than I could have ever imagined.\"', 'SARAH, MOTHER OF A YOUNG ATHLETES IN KUCHING', 'KUCHING', 'Resources for YAP', '', 'LEARN MORE', '../src/yap-lm.html', '../assets/images/yap-lm-hero-hf.jpg', 1, '2026-01-23 07:32:02', '2026-01-23 07:32:02'),
(4, '../assets/images/yap-hero.jpg', 'Young Athletes Program', '<p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Special Olympics Young Athletes is an early childhood play program for children with and without intellectual disabilities, ages 2 to 7 years old. Young Athletes introduces basic sport skills, like running, kicking and throwing. Young Athletes offers families, teachers, caregivers and people from the community the chance to share the joy of sports with all children.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes provides children of all abilities the same opportunities to advance in core developmental milestones. Children learn how to play with others and develop important skills for learning. Children also learn to share, take turns and follow directions. These skills help children in family, community and school activities.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes is a fun way for children to stay active and establish healthy habits for the future. It is important to teach children healthy habits while they are young. This can set the stage for a life of physical activity, friendships and learning. Young Athletes is easy to do and fun for all. It can be done at home, in schools or in the community using the Young Athletes Activity Guide and basic equipment. Through Young Athletes, all children, their families and people in the community can be a part of an inclusive team.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes welcomes children and their families into the Special Olympics Sarawak.</p><ul style=\"max-width: 1160px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-size: 1.1rem; color: rgb(51, 51, 51); font-family: &quot;Segoe UI&quot;, sans-serif;\"><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Motor Skills:</strong>&nbsp;Children with intellectual disabilities who took part in Young Athletes developed motor skills more than twice as fast as others who did not take part.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Social, Emotional and Learning Skills:</strong>&nbsp;Parents and teachers of children who took part in the Young Athletes curriculum said the children learned skills that they will use in pre-primary school.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Expectations:</strong>&nbsp;Family members say that Young Athletes raised their hopes for their child’s future.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Sport Readiness:</strong>&nbsp;Young Athletes helps children get ready to take part in sports when they are older.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Acceptance:</strong>&nbsp;Inclusive play helps children without a disability to better understand and accept others.</li></ul><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">For more information about Young Athletes,&nbsp;<a href=\"http://localhost/Special-Olympic-Sarawak-Website-Staging-environment/src/yap-lm.html\" style=\"color: rgb(230, 57, 70); text-decoration-line: none;\">visit our Young Athletes Program (YAP) Resources page.</a></p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Studies show that after two months of participation in Young Athletes, children with intellectual disabilities experienced a seven month gain in motor skills, representing an improvement at twice the rate of children with intellectual disabilities who have not participated in the program.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Children with intellectual disabilities participating in Young Athletes exhibited greater increases in communication, social, and daily living skills, compared to children with ID not participating in Young Athletes.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Children and families participating in a comprehensive Child and Family Health program, inclusive of Young Athletes, Family Health Forum, and Healthy Young Athletes Pediatric Screening, experienced improvements across the whole family, positively impacting child development and efficacy and empowerment for parents and caregivers.</p>', '\"When my baby was born and I learned he had an intellectual disability, I felt lost, unsure of what the future would hold. But at Young Athletes Program, I see him so full of joy ??? running, laughing, and connecting with others. It\'s such a beautiful sight to witness, and it fills me with hope, reminding me that one day, he might just be able to stand on his own, stronger than I could have ever imagined.\"', 'SARAH, MOTHER OF A YOUNG ATHLETES IN KUCHING', 'KUCHING', 'Resources for YAP', '', 'LEARN MORE', '../src/yap-lm.html', '../assets/images/yap-lm-hero-hf.jpg', 1, '2026-01-23 07:33:47', '2026-01-23 07:33:47'),
(5, '../assets/images/yap-hero.jpg', 'Young Athletes Program', '<p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Special Olympics Young Athletes is an early childhood play program for children with and without intellectual disabilities, ages 2 to 7 years old. Young Athletes introduces basic sport skills, like running, kicking and throwing. Young Athletes offers families, teachers, caregivers and people from the community the chance to share the joy of sports with all children.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes provides children of all abilities the same opportunities to advance in core developmental milestones. Children learn how to play with others and develop important skills for learning. Children also learn to share, take turns and follow directions. These skills help children in family, community and school activities.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes is a fun way for children to stay active and establish healthy habits for the future. It is important to teach children healthy habits while they are young. This can set the stage for a life of physical activity, friendships and learning. Young Athletes is easy to do and fun for all. It can be done at home, in schools or in the community using the Young Athletes Activity Guide and basic equipment. Through Young Athletes, all children, their families and people in the community can be a part of an inclusive team.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Young Athletes welcomes children and their families into the Special Olympics Sarawak.</p><ul style=\"max-width: 1160px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-size: 1.1rem; color: rgb(51, 51, 51); font-family: &quot;Segoe UI&quot;, sans-serif;\"><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Motor Skills:</strong>&nbsp;Children with intellectual disabilities who took part in Young Athletes developed motor skills more than twice as fast as others who did not take part.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Social, Emotional and Learning Skills:</strong>&nbsp;Parents and teachers of children who took part in the Young Athletes curriculum said the children learned skills that they will use in pre-primary school.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Expectations:</strong>&nbsp;Family members say that Young Athletes raised their hopes for their child’s future.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Sport Readiness:</strong>&nbsp;Young Athletes helps children get ready to take part in sports when they are older.</li><li style=\"margin-bottom: 12px; line-height: 1.6;\"><strong>Acceptance:</strong>&nbsp;Inclusive play helps children without a disability to better understand and accept others.</li></ul><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">For more information about Young Athletes,&nbsp;<a href=\"http://localhost/Special-Olympic-Sarawak-Website-Staging-environment/src/yap-lm.html\" style=\"color: rgb(230, 57, 70); text-decoration-line: none;\">visit our Young Athletes Program (YAP) Resources page.</a></p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Studies show that after two months of participation in Young Athletes, children with intellectual disabilities experienced a seven month gain in motor skills, representing an improvement at twice the rate of children with intellectual disabilities who have not participated in the program.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Children with intellectual disabilities participating in Young Athletes exhibited greater increases in communication, social, and daily living skills, compared to children with ID not participating in Young Athletes.</p><p style=\"font-size: 1.1rem; line-height: 1.6; color: rgb(51, 51, 51); max-width: 1200px; margin-right: auto; margin-bottom: 40px; margin-left: auto; font-family: &quot;Segoe UI&quot;, sans-serif;\">Children and families participating in a comprehensive Child and Family Health program, inclusive of Young Athletes, Family Health Forum, and Healthy Young Athletes Pediatric Screening, experienced improvements across the whole family, positively impacting child development and efficacy and empowerment for parents and caregivers.</p>', '\"When my baby was born and I learned he had an intellectual disability, I felt lost, unsure of what the future would hold. But at Young Athletes Program, I see him so full of joy ??? running, laughing, and connecting with others. It\'s such a beautiful sight to witness, and it fills me with hope, reminding me that one day, he might just be able to stand on his own, stronger than I could have ever imagined.\"', 'SARAH, MOTHER OF A YOUNG ATHLETES IN KUCHING', 'KUCHING', 'Resources for YAP', '', 'LEARN MORE', '../src/yap-lm.html', '../assets/images/yap-lm-hero-hf.jpg', 1, '2026-01-23 07:36:05', '2026-01-23 07:36:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alp_page_settings`
--
ALTER TABLE `alp_page_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `athletes`
--
ALTER TABLE `athletes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_chapter` (`chapter`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `chapter_participants`
--
ALTER TABLE `chapter_participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chapter_id` (`chapter_id`),
  ADD KEY `year` (`year`);

--
-- Indexes for table `coaches`
--
ALTER TABLE `coaches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_chapter` (`chapter`),
  ADD KEY `idx_created_at` (`created_at`);

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
-- Indexes for table `participant_excel_uploads`
--
ALTER TABLE `participant_excel_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_type` (`participant_type`),
  ADD KEY `idx_created_at` (`created_at`);

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
-- Indexes for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_chapter` (`chapter`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `yap_content`
--
ALTER TABLE `yap_content`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alp_page_settings`
--
ALTER TABLE `alp_page_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `athletes`
--
ALTER TABLE `athletes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `chapter_participants`
--
ALTER TABLE `chapter_participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coaches`
--
ALTER TABLE `coaches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `gallery_photos`
--
ALTER TABLE `gallery_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `gallery_photos_collection`
--
ALTER TABLE `gallery_photos_collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gallery_videos`
--
ALTER TABLE `gallery_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gallery_videos_collection`
--
ALTER TABLE `gallery_videos_collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hap`
--
ALTER TABLE `hap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `other_special_olympics`
--
ALTER TABLE `other_special_olympics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `participant_excel_uploads`
--
ALTER TABLE `participant_excel_uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sarawak_chapters`
--
ALTER TABLE `sarawak_chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sponsorships`
--
ALTER TABLE `sponsorships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `yap_content`
--
ALTER TABLE `yap_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
