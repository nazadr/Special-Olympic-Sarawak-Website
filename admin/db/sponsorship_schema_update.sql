-- Sponsorship Schema Update
-- This script updates the sponsorships table to support chapter grouping
-- Run this in phpMyAdmin or MySQL CLI

-- First, let's add the new columns to existing table
ALTER TABLE `sponsorships` 
ADD COLUMN `sponsor_name` VARCHAR(255) DEFAULT NULL AFTER `id`,
ADD COLUMN `chapter_id` INT(11) DEFAULT NULL AFTER `type`,
ADD COLUMN `sponsor_tier` ENUM('platinum', 'gold', 'silver', 'bronze', 'supporter') DEFAULT 'supporter' AFTER `chapter_id`,
ADD COLUMN `display_order` INT(11) DEFAULT 0 AFTER `image_path`,
ADD COLUMN `is_active` TINYINT(1) DEFAULT 1 AFTER `display_order`,
ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`;

-- Add foreign key constraint to link with sarawak_chapters
-- Note: chapter_id = NULL means "Special Olympics Sarawak" (state-level sponsor)
ALTER TABLE `sponsorships`
ADD CONSTRAINT `fk_sponsorship_chapter` 
FOREIGN KEY (`chapter_id`) REFERENCES `sarawak_chapters`(`id`) 
ON DELETE SET NULL ON UPDATE CASCADE;

-- Add index for better query performance
ALTER TABLE `sponsorships`
ADD INDEX `idx_chapter_tier` (`chapter_id`, `sponsor_tier`),
ADD INDEX `idx_display_order` (`display_order`),
ADD INDEX `idx_is_active` (`is_active`);

-- Migrate existing data: Map type strings to chapter_id
-- First, let's update existing records to populate chapter_id based on type
UPDATE `sponsorships` SET `chapter_id` = 1 WHERE `type` = 'Kuching Chapter';
UPDATE `sponsorships` SET `chapter_id` = 2 WHERE `type` = 'Samarahan Chapter';
UPDATE `sponsorships` SET `chapter_id` = 3 WHERE `type` = 'Sibu Chapter';
UPDATE `sponsorships` SET `chapter_id` = 4 WHERE `type` = 'Bintulu Chapter';
UPDATE `sponsorships` SET `chapter_id` = 5 WHERE `type` = 'Miri Chapter';
-- For "Special Olympics Sarawak", chapter_id remains NULL (state-level)

-- Extract sponsor name from type if not set (optional cleanup)
UPDATE `sponsorships` SET `sponsor_name` = 'Sponsor' WHERE `sponsor_name` IS NULL;

-- View to verify the migration
-- SELECT s.*, c.chapter_name, c.city 
-- FROM sponsorships s 
-- LEFT JOIN sarawak_chapters c ON s.chapter_id = c.id;
