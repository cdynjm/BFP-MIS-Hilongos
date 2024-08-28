-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 28, 2024 at 12:38 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bfp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicant`
--

CREATE TABLE `applicant` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contactNumber` varchar(255) DEFAULT NULL,
  `picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fire_incident`
--

CREATE TABLE `fire_incident` (
  `id` int NOT NULL,
  `owner` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `location` varchar(255) DEFAULT NULL,
  `fireAlarmLevel` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `casualties` int DEFAULT NULL,
  `fireCause` varchar(255) DEFAULT NULL,
  `injuries` int DEFAULT NULL,
  `structureType` varchar(255) DEFAULT NULL,
  `estimatedValueLoss` decimal(11,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fire_incident`
--

INSERT INTO `fire_incident` (`id`, `owner`, `location`, `fireAlarmLevel`, `date`, `time`, `casualties`, `fireCause`, `injuries`, `structureType`, `estimatedValueLoss`, `created_at`, `updated_at`) VALUES
(1, 'Sample Incident', 'Sogod Southern Leyte', 4, '2024-08-15', '22:14:00', 0, 'Short Circuit', 10, 'Building and Department Store', 25000.00, '2024-08-26 17:13:33', '2024-08-26 17:13:33'),
(2, 'Sample Incident 2', 'Bontoc Southern Leyte', 3, '2024-06-12', '23:27:00', 2, 'Burning', 9, 'Building', 25000.00, '2024-08-26 17:25:40', '2024-08-27 16:34:42');

-- --------------------------------------------------------

--
-- Table structure for table `fire_inspection`
--

CREATE TABLE `fire_inspection` (
  `id` int NOT NULL,
  `applicantID` int DEFAULT NULL,
  `buildingName` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `businessName` varchar(255) DEFAULT NULL,
  `businessNature` varchar(255) DEFAULT NULL,
  `FSECNumber` varchar(255) DEFAULT NULL,
  `dateFSEC` date DEFAULT NULL,
  `FSICNumber` varchar(255) DEFAULT NULL,
  `dateFSIC` date DEFAULT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `validFrom` date DEFAULT NULL,
  `amountPaid` decimal(11,2) DEFAULT NULL,
  `ORNumber` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `dateOR` date DEFAULT NULL,
  `recommendApproval` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `recommendPosition` varchar(255) DEFAULT NULL,
  `approved` varchar(255) DEFAULT NULL,
  `approvedPosition` varchar(255) DEFAULT NULL,
  `schedule` date DEFAULT NULL,
  `personnelID` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `certType` int DEFAULT NULL,
  `certStatus` int DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personnel`
--

CREATE TABLE `personnel` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `contactNumber` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `personnel`
--

INSERT INTO `personnel` (`id`, `name`, `position`, `contactNumber`, `picture`, `created_at`, `updated_at`) VALUES
(1, 'SFO1 Joseph L Maceda', 'CHIEF, FSES', '9275021810', 'sfo1-joseph-l-maceda-2024-08-26-090626.jpg', '2024-08-25 16:38:42', '2024-08-26 19:33:30'),
(2, 'INSP Analecto Tesado Jr.', 'ACTING MUNICIPAL FIRE MARSHAL', '9355209089', 'insp-analecto-tesado-jr-2024-08-26-084757.jpg', '2024-08-25 20:17:30', '2024-08-27 16:32:15'),
(3, 'SFO4 Roselito D. Esperanza', 'OIC - MUNICIPAL FIRE MARSHAL', '9275021810', 'sfo4-roselito-d-esperanza-2024-08-26-080306.jpg', '2024-08-25 22:17:58', '2024-08-26 16:17:59'),
(5, 'SFO4 Sample Personnel', 'FIRE MARSHALL', '94567788090', 'sfo4-sample-personnel-2024-08-26-083412.jpg', '2024-08-26 00:34:12', '2024-08-26 16:13:30');

-- --------------------------------------------------------

--
-- Table structure for table `sms_token_identity`
--

CREATE TABLE `sms_token_identity` (
  `id` int NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `mobile_identity` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sms_token_identity`
--

INSERT INTO `sms_token_identity` (`id`, `url`, `access_token`, `mobile_identity`, `created_at`, `updated_at`) VALUES
(1, 'https://api.pushbullet.com/v2/texts', 'o.ZChF6SEHvLdWM6icO4Y7rNVcdvfNQiUE --', 'ujCG6c8HzcOsjxv69TOMZE --', NULL, '2024-08-27 14:49:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `personnelID` int DEFAULT NULL,
  `applicantID` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `personnelID`, `applicantID`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'BFP Admin', 'bfp@admin.com', NULL, '$2y$10$7vvyPuBXRDQhplMLYxpFDuofSE6WoajC8k/3kBE73jAc9tS.0Erau', NULL, 1, NULL, '2024-08-26 22:01:56'),
(51, 1, NULL, NULL, 'joseph@gmail.com', NULL, '$2y$10$4S8mOgL9U.oA9O3DLwuhYOcTsZiDMMHJbtNKhLXRFCN5d8b5Icd06', NULL, 2, '2024-08-25 16:38:42', '2024-08-26 19:33:30'),
(53, 2, NULL, NULL, 'analecto@gmail.com', NULL, '$2y$10$0GdOu3nshMEnxUoFbH9piOX1AVaL6n1/IiKYWAmPjd0davbBfFKQG', NULL, 2, '2024-08-25 20:17:30', '2024-08-27 16:32:15'),
(55, 3, NULL, NULL, 'roselito@gmail.com', NULL, '$2y$10$epNllTgdDuSg0pPSNjkdMe0Up7VDxcIknQKolrzJrQ6xt7kfQzdHG', NULL, 2, '2024-08-25 22:17:58', '2024-08-26 16:17:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicant`
--
ALTER TABLE `applicant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fire_incident`
--
ALTER TABLE `fire_incident`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fire_inspection`
--
ALTER TABLE `fire_inspection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_token_identity`
--
ALTER TABLE `sms_token_identity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicant`
--
ALTER TABLE `applicant`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fire_incident`
--
ALTER TABLE `fire_incident`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fire_inspection`
--
ALTER TABLE `fire_inspection`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sms_token_identity`
--
ALTER TABLE `sms_token_identity`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
