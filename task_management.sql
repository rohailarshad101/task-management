-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 29, 2024 at 05:52 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Category 1', '2024-07-22 16:19:06', '2024-07-29 18:18:01', NULL),
(2, 'Category 2', '2024-07-22 16:19:06', '2024-07-29 16:05:48', NULL),
(4, 'CAtegory 3', '2024-07-29 18:17:41', '2024-07-29 18:17:49', NULL),
(5, 'dasda', '2024-07-31 14:56:25', '2024-07-31 14:56:27', '2024-07-31 09:56:27');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2024-08-26-174453', 'App\\Database\\Migrations\\CreateNotificationsTable', 'default', 'App', 1724694447, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 2, 'New Task ', 'Task `Task 1` has been reassigned to you and is due on 2024-08-26.', 0, '2024-08-26 17:59:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `key` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `key`) VALUES
(1, 'Super Admin', 'super_admin'),
(2, 'Admin', 'admin'),
(3, 'User', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `created_by` int DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` date NOT NULL,
  `due_date` date NOT NULL,
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `priority` enum('Low','Medium','High') NOT NULL,
  `status` enum('Active','In Progress','On Hold','Completed','Canceled','Closed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `repetition_frequency` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `created_by`, `title`, `category_id`, `start_date`, `due_date`, `tags`, `priority`, `status`, `repetition_frequency`, `description`, `completed_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, NULL, 'Task 1', '1', '2024-06-14', '2024-08-26', NULL, 'High', 'Active', NULL, 'This is test description Updated', NULL, '2024-06-13 10:21:56', '2024-08-26 17:59:14', NULL),
(3, NULL, 'New Test Task', '2', '2024-07-27', '2024-08-15', NULL, 'Low', 'In Progress', 'Bi-Weekly', 'This is test Task', '2024-08-15 17:34:12', '2024-07-08 19:12:15', '2024-08-26 17:40:56', NULL),
(4, NULL, 'NEw Task 3', '1', '2024-07-27', '2024-10-15', NULL, 'Medium', 'Canceled', NULL, 'dasdasdasd', NULL, '2024-07-28 08:29:03', '2024-08-26 17:41:00', NULL),
(5, NULL, 'Work Order', '1', '2024-08-01', '2024-08-30', NULL, 'Low', 'In Progress', NULL, 'dasdasd', NULL, '2024-07-29 17:37:10', '2024-08-26 17:40:53', NULL),
(18, NULL, 'NEw Work Order 4', '2', '2024-07-31', '2024-08-09', NULL, 'Low', 'On Hold', 'Monthly', 'This is another test work order', NULL, '2024-07-29 19:53:39', '2024-08-26 17:41:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks_files`
--

CREATE TABLE `tasks_files` (
  `id` int NOT NULL,
  `task_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_size` varchar(8) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks_files`
--

INSERT INTO `tasks_files` (`id`, `task_id`, `user_id`, `file_name`, `file_path`, `file_type`, `file_size`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 'dilwala-d4aff1902f97dd7a50f4.jpg', 'uploads\\task_related_documents\\', 'image/jpeg', NULL, '2024-07-30 00:52:26', '2024-07-31 23:48:31', NULL),
(2, 2, 1, 'dilwala-profile-ce0d6011083dab3663b7.jpg', 'uploads\\task_related_documents\\', 'image/jpeg', NULL, '2024-07-30 00:52:29', '2024-07-31 23:48:39', NULL),
(3, 18, 1, 'dilwala-d4aff1902f97dd7a50f4.jpg', 'uploads\\task_related_documents\\', 'image/jpeg', NULL, '2024-07-30 00:52:26', '2024-07-31 23:48:48', NULL),
(4, 18, 1, 'dilwala-profile-ce0d6011083dab3663b7.jpg', 'uploads\\task_related_documents\\', 'image/jpeg', NULL, '2024-07-30 00:52:29', '2024-07-31 23:48:54', NULL),
(5, 4, 1, 'communities_companies_history-f09ee82ebfafc11b24f8.jpg', 'uploads\\task_related_documents\\', 'image/jpeg', NULL, '2024-07-31 23:16:55', '2024-07-31 23:49:02', NULL),
(6, 4, 1, 'AYvXu-9ba293379e1a709292d3.png', 'uploads\\task_related_documents\\', 'image/png', '8.34 KB', '2024-07-31 23:27:59', '2024-07-31 23:49:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks_users`
--

CREATE TABLE `tasks_users` (
  `id` int NOT NULL,
  `task_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks_users`
--

INSERT INTO `tasks_users` (`id`, `task_id`, `user_id`, `created_at`, `updated_at`) VALUES
(13, 2, 2, '2024-07-28 11:13:23', '2024-07-28 11:13:23'),
(16, 4, 2, '2024-07-29 17:38:07', '2024-07-29 17:38:07'),
(17, 5, 3, '2024-07-29 18:10:50', '2024-07-29 18:10:50'),
(54, 3, 2, '2024-08-26 16:59:43', '2024-08-26 16:59:43'),
(55, 3, 3, '2024-08-26 16:59:43', '2024-08-26 16:59:43'),
(56, 18, 2, '2024-08-26 17:00:30', '2024-08-26 17:00:30'),
(57, 18, 3, '2024-08-26 17:00:30', '2024-08-26 17:00:30');

-- --------------------------------------------------------

--
-- Table structure for table `task_comments`
--

CREATE TABLE `task_comments` (
  `id` int NOT NULL,
  `task_id` int NOT NULL,
  `user_id` int NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_comment_attachments`
--

CREATE TABLE `task_comment_attachments` (
  `id` int NOT NULL,
  `task_comment_id` int NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int DEFAULT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `mobile`, `password`, `role_id`, `profile_picture`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super', 'Admin', 'superadmin', 'superadmin@example.com', '+12155014450', '$2y$10$H8nTV79/nSBwSfSLgM56j..OijGa35F272bxnNZHIm1.ji63P2eeu', 1, '', 1, '2024-07-22 16:23:14', '2024-07-27 06:58:03', NULL),
(2, 'John', 'Doe', 'johndoe', 'john.doe@example.com', '+12252542523', '$2y$10$LzOl13lwEfv7FW88.nZqreTGgpW90bP.LmkociOMIXXeUDD79T5em', 3, '', 1, '2024-07-22 16:23:14', '2024-07-27 06:54:01', NULL),
(3, 'Michael', 'Lee pdated', 'michaellee', 'michael.lee@example.com', '+12156695708', '$2y$10$LzOl13lwEfv7FW88.nZqreTGgpW90bP.LmkociOMIXXeUDD79T5em', 3, '', 1, '2024-07-22 16:23:14', '2024-07-29 17:33:53', NULL),
(7, 'Rohail', 'Arshad', '', '', NULL, '', NULL, '', 1, '2024-07-29 17:33:40', '2024-07-29 17:33:44', '2024-07-29 12:33:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `tasks_files`
--
ALTER TABLE `tasks_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `id` (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tasks_users`
--
ALTER TABLE `tasks_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `task_comments`
--
ALTER TABLE `task_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `task_comment_attachments`
--
ALTER TABLE `task_comment_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`task_comment_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tasks_files`
--
ALTER TABLE `tasks_files`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tasks_users`
--
ALTER TABLE `tasks_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `task_comments`
--
ALTER TABLE `task_comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_comment_attachments`
--
ALTER TABLE `task_comment_attachments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_created_by_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `tasks_files`
--
ALTER TABLE `tasks_files`
  ADD CONSTRAINT `tasks_files_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_files_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `tasks_users`
--
ALTER TABLE `tasks_users`
  ADD CONSTRAINT `tasks_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_users_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_comments`
--
ALTER TABLE `task_comments`
  ADD CONSTRAINT `task_comments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
  ADD CONSTRAINT `task_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `task_comment_attachments`
--
ALTER TABLE `task_comment_attachments`
  ADD CONSTRAINT `task_comment_attachments_ibfk_1` FOREIGN KEY (`task_comment_id`) REFERENCES `task_comments` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
