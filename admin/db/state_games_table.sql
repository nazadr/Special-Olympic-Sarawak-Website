-- State Games Management Table Structure
-- This table stores the major events displayed on the State Games page

CREATE TABLE IF NOT EXISTS `state_games` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `event_title` varchar(255) NOT NULL,
    `event_date` varchar(100) NOT NULL,
    `event_description` text NOT NULL,
    `learn_more_link` varchar(500) DEFAULT NULL,
    `image_path` varchar(500) DEFAULT NULL,
    `display_order` int(11) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `idx_display_order` (`display_order`),
    INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data (optional - these match the current HTML content)
INSERT INTO `state_games` (`event_title`, `event_date`, `event_description`, `learn_more_link`, `image_path`, `display_order`) VALUES
('8th State Games Kuching 2025', 'TBA 2025', 'The 8th edition of the State Games will be held in Kuching, Sarawak in 2025. This event will feature a variety of sports and activities, bringing together athletes from across the state to compete and celebrate their achievements.', '#', 'https://www.theborneopost.com/newsimages/2025/05/kch-030525-dd-fatimah-702x336.jpg', 1),
('National Games 2027', 'TBA 2027', 'An event that brings together athletes from across Malaysia to compete in a variety of sports.', '#', 'https://www.theborneopost.com/newsimages/2025/09/kch-260925-mtu-bg_ath_roundup-p1-B.jpg', 2),
('SEA Games 2027', 'TBA 2027', 'This event card is just a placeholder for mockup.', '#', 'https://media.freemalaysiatoday.com/wp-content/uploads/2022/05/Sea-Gaes-2017-Malaysia-Bernama.jpg', 3);