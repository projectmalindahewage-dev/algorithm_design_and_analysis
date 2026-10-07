-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 26, 2026 at 04:13 AM
-- Server version: 9.1.0
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `algoredam_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `department_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `added_by` bigint DEFAULT NULL,
  `added_date` timestamp NULL DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--


-- --------------------------------------------------------

--
-- Table structure for table `department_rosters`
--

DROP TABLE IF EXISTS `department_rosters`;
CREATE TABLE IF NOT EXISTS `department_rosters` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `department_id` int NOT NULL,
  `date` date NOT NULL,
  `shift_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>active,0=>deactivate',
  `added_by` bigint DEFAULT NULL,
  `added_date` timestamp NULL DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=161 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `department_rosters`
--


-- --------------------------------------------------------

--
-- Table structure for table `department_shifts`
--

DROP TABLE IF EXISTS `department_shifts`;
CREATE TABLE IF NOT EXISTS `department_shifts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `department_id` int NOT NULL,
  `shift_start_at` time NOT NULL,
  `shift_work_time` time NOT NULL,
  `ot_start_after` time DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>active,0=>deactivate',
  `added_by` bigint DEFAULT NULL,
  `added_date` timestamp NULL DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `department_shifts`
--


-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_no` bigint NOT NULL,
  `first_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `added_by` bigint DEFAULT NULL,
  `added_date` timestamp NULL DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2636 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--


-- --------------------------------------------------------

--
-- Table structure for table `employee_attendances`
--

DROP TABLE IF EXISTS `employee_attendances`;
CREATE TABLE IF NOT EXISTS `employee_attendances` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_no` bigint NOT NULL,
  `in_time` datetime DEFAULT NULL,
  `out_time` datetime DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `formatted_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=>not,1=>formatted',
  `added_by` bigint DEFAULT NULL,
  `added_date` timestamp NULL DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39892662 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_attendances`
--


-- --------------------------------------------------------

--
-- Table structure for table `employee_departments`
--

DROP TABLE IF EXISTS `employee_departments`;
CREATE TABLE IF NOT EXISTS `employee_departments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` bigint NOT NULL,
  `department_id` bigint NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `added_by` bigint DEFAULT NULL,
  `added_date` timestamp NULL DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5447 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_departments`
--


-- --------------------------------------------------------

--
-- Table structure for table `employee_in_shifts`
--

DROP TABLE IF EXISTS `employee_in_shifts`;
CREATE TABLE IF NOT EXISTS `employee_in_shifts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `department_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>active,0=>deactivate',
  `added_by` bigint DEFAULT NULL,
  `added_date` timestamp NULL DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_in_shifts`
--


-- --------------------------------------------------------

--
-- Table structure for table `formatted_attendances`
--

DROP TABLE IF EXISTS `formatted_attendances`;
CREATE TABLE IF NOT EXISTS `formatted_attendances` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `date` date NOT NULL,
  `day` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_work_time` bigint DEFAULT NULL,
  `weekend` tinyint NOT NULL DEFAULT '0' COMMENT '0=> day,1=>weekend',
  `holiday` tinyint NOT NULL DEFAULT '0' COMMENT '0=>Not,1=>half,2=>full',
  `off` tinyint NOT NULL DEFAULT '0' COMMENT '0=>Not,1=>half,2=>full',
  `leave` tinyint NOT NULL DEFAULT '0' COMMENT '0=>Not,1=>half,2=>full',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>active,0=>deactivate',
  `added_by` bigint DEFAULT NULL,
  `added_date` timestamp NULL DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9263 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `formatted_attendances`
--


-- --------------------------------------------------------

--
-- Table structure for table `formatted_attendance_details`
--

DROP TABLE IF EXISTS `formatted_attendance_details`;
CREATE TABLE IF NOT EXISTS `formatted_attendance_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `formatted_attendance_id` bigint NOT NULL,
  `attendance_referance_id` bigint NOT NULL,
  `in_date` date NOT NULL,
  `in_time` time NOT NULL,
  `out_date` date NOT NULL,
  `out_time` time NOT NULL,
  `shift_id` int DEFAULT NULL,
  `roster_id` int DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>active,0=>deactivate',
  `added_by` bigint DEFAULT NULL,
  `added_date` timestamp NULL DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9295 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `formatted_attendance_details`
--


-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

DROP TABLE IF EXISTS `holidays`;
CREATE TABLE IF NOT EXISTS `holidays` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `added_by` bigint DEFAULT NULL,
  `added_date` timestamp NULL DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=315 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holidays`
--


-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

DROP TABLE IF EXISTS `leave_requests`;
CREATE TABLE IF NOT EXISTS `leave_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `applied_from` date NOT NULL,
  `applied_to` date NOT NULL,
  `no_of_days` int NOT NULL,
  `employee_id` int NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `added_by` bigint DEFAULT NULL,
  `added_date` timestamp NULL DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45558 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_requests`
--


-- --------------------------------------------------------

--
-- Table structure for table `leave_request_dates`
--

DROP TABLE IF EXISTS `leave_request_dates`;
CREATE TABLE IF NOT EXISTS `leave_request_dates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `leave_request_id` bigint NOT NULL,
  `leave_date` date NOT NULL,
  `full_half_day` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leave_session` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `added_by` bigint DEFAULT NULL,
  `added_date` timestamp NULL DEFAULT NULL,
  `updated_by` bigint DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53911 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_request_dates`
--


-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2026_09_25_102500_create_departments_table', 1),
(3, '2026_09_25_102508_create_employees_table', 1),
(4, '2026_09_25_102553_create_department_shifts_table', 1),
(5, '2026_09_25_102626_create_department_rosters_table', 1),
(6, '2026_09_25_102755_create_employee_in_shifts_table', 1),
(7, '2026_09_25_102815_create_holidays_table', 1),
(8, '2026_09_25_102834_create_leave_requests_table', 1),
(9, '2026_09_25_102854_create_leave_request_dates_table', 1),
(10, '2026_09_25_102923_create_employee_departments_table', 1),
(14, '2026_09_25_102942_create_employee_attendances_table', 2),
(16, '2026_09_25_103050_create_formatted_attendance_details_table', 3),
(17, '2026_09_25_103029_create_formatted_attendances_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
