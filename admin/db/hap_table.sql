-- HAP (Healthy Athletes Program) Articles Table
-- Created: December 5, 2025
-- Purpose: Store editable articles for the Healthy Athletes Program (SOHAP) page

CREATE TABLE IF NOT EXISTS `hap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `learn_more_link` varchar(500) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert default sample articles
INSERT INTO `hap` (`title`, `category`, `description`, `image_path`, `learn_more_link`, `display_order`) VALUES
('Community Health Screening Program', 'COMMUNITY IMPACT', 'Free health screenings provided to athletes including vision, hearing, dental, and fitness assessments to ensure comprehensive healthcare access.', '../assets/images/special-olympics-1-1024x768.webp', '#', 1),
('Athletic Wellness Initiative', 'ATHLETES', 'Comprehensive health education and fitness programs designed to empower athletes with knowledge about nutrition, fitness, and healthy lifestyle choices.', '../assets/images/young_athelte_1.jpg', '#', 2),
('Healthcare Partnership Success', 'IN THE NEWS', 'Collaboration with medical professionals brings specialized care directly to Special Olympics events, ensuring athletes receive the support they need.', '../assets/images/another_news.jpg', '#', 3);