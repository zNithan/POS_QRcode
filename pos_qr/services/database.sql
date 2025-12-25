

-- Drop table if exists `users`
DROP TABLE IF EXISTS `users`;

-- Table structure for `users`
CREATE TABLE `users` (`id` INT NOT NULL, `email` VARCHAR(17) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `users` VALUES (1, 'demo@customer.com');