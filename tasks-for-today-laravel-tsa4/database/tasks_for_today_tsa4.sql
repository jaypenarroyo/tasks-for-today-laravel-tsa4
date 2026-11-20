-- IT0049 TSA4 - Tasks for Today Management System (Full CRUD, Auth, Email)
-- Optional MySQL export matching the Laravel migrations and seeders.
-- Recommended setup: `php artisan migrate --seed`

CREATE DATABASE IF NOT EXISTS `tasks_for_today_tsa4`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `tasks_for_today_tsa4`;

DROP TABLE IF EXISTS `tasks`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tasks` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `status` VARCHAR(255) NOT NULL DEFAULT 'pending',
  `task_date` DATE NOT NULL,
  `is_archived` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Default user password: "password" (bcrypt hash)
INSERT INTO `users` (`username`, `full_name`, `email`, `password`) VALUES
  ('johnjames', 'John James', 'jpenarroyo53@gmail.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO `tasks` (`title`, `status`, `task_date`, `is_archived`) VALUES
  ('Configure Laravel Breeze authentication and middleware protection', 'done', DATE_SUB(CURDATE(), INTERVAL 1 DAY), 0),
  ('Add is_archived column to tasks migration for soft deletion', 'done', DATE_SUB(CURDATE(), INTERVAL 1 DAY), 0),
  ('Verify TaskCompletedMail triggers when a pending task is marked done', 'pending', CURDATE(), 0),
  ('Confirm editing an already-done task does not resend notification email', 'done', CURDATE(), 0),
  ('Test Create, Edit, and Soft-Delete (Archive) flows while logged in', 'in_progress', CURDATE(), 0),
  ('Confirm guests can view public pages but cannot modify tasks', 'pending', CURDATE(), 0),
  ('Run PHPUnit feature tests for CRUD, Auth, Validation, and Mail', 'pending', DATE_ADD(CURDATE(), INTERVAL 1 DAY), 0),
  ('Review README.md setup and mail configuration documentation', 'pending', DATE_ADD(CURDATE(), INTERVAL 1 DAY), 0),
  ('Deploy TSA4 Laravel application and test live hosted URL', 'pending', DATE_ADD(CURDATE(), INTERVAL 3 DAY), 0),
  ('Submit GitHub repository and live application link for IT0049 TSA4', 'pending', DATE_ADD(CURDATE(), INTERVAL 3 DAY), 0);
