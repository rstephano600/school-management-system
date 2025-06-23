-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2025 at 04:22 PM
-- Server version: 11.8.1-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_management_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_years`
--

CREATE TABLE `academic_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_years`
--

INSERT INTO `academic_years` (`id`, `school_id`, `name`, `start_date`, `end_date`, `is_current`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Academic year 2021', '2021-01-01', '2021-12-02', 0, 'tehe testing year', '2025-06-20 11:27:43', '2025-06-20 11:27:43'),
(2, 1, 'The Academic year 2022', '2022-01-05', '2022-11-11', 0, 'this is the blessed year', '2025-06-20 11:31:05', '2025-06-20 11:31:05'),
(3, 1, 'This is academic year 2023', '2023-11-01', '2023-11-11', 0, 'he year of success', '2025-06-20 11:32:49', '2025-06-20 11:32:49'),
(4, 1, 'The Academic year 2024', '2024-01-06', '2024-11-28', 0, '2024', '2025-06-20 11:36:50', '2025-06-20 11:36:50'),
(5, 1, 'the current year', '2025-01-06', '2025-11-28', 1, 'the current year', '2025-06-20 11:38:11', '2025-06-20 11:38:11');

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `achievement_date` date NOT NULL,
  `category` enum('academic','sports','arts','other') NOT NULL,
  `awarded_by` bigint(20) UNSIGNED NOT NULL,
  `certificate` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `audience` enum('all','teachers','students','parents','staff') NOT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `school_id`, `title`, `content`, `start_date`, `end_date`, `audience`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Meetingc', 'The meating tobe set by all school members', '2025-06-17', '2025-06-27', 'all', 'draft', 5, '2025-06-22 12:54:35', '2025-06-22 12:54:35'),
(2, 1, 'School day selebration', 'all school members should celebrate for school', '2025-06-24', '2025-06-28', 'all', 'published', 5, '2025-06-22 12:55:52', '2025-06-22 12:55:52'),
(3, 1, 'Parents meating', 'School parents meeting', '2025-06-12', '2025-06-28', 'parents', 'published', 5, '2025-06-22 12:56:47', '2025-06-22 12:57:10');

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `grade_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('exam','test','assignment','exercise','labs') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `issue_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` datetime NOT NULL,
  `max_points` decimal(6,2) NOT NULL,
  `assignment_type` enum('homework','quiz','test','other') NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','graded') NOT NULL DEFAULT 'draft',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `behavior_records`
--

CREATE TABLE `behavior_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `incident_date` date NOT NULL,
  `incident_type` enum('disruption','bullying','cheating','absenteeism','other') NOT NULL,
  `description` text NOT NULL,
  `action_taken` text NOT NULL,
  `status` enum('open','resolved') NOT NULL DEFAULT 'open',
  `reported_by` bigint(20) UNSIGNED NOT NULL,
  `resolved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `resolved_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `behavior_records`
--

INSERT INTO `behavior_records` (`id`, `school_id`, `student_id`, `incident_date`, `incident_type`, `description`, `action_taken`, `status`, `reported_by`, `resolved_by`, `resolved_date`, `created_at`, `updated_at`) VALUES
(1, 1, 10, '2025-06-03', 'other', 'absent test one', 'punishments', 'open', 5, NULL, NULL, '2025-06-22 10:49:28', '2025-06-22 10:51:25'),
(2, 1, 11, '2025-06-19', 'absenteeism', 'absent', 'absenriiiiii', 'open', 5, NULL, NULL, '2025-06-22 10:52:06', '2025-06-22 10:52:06');

-- --------------------------------------------------------

--
-- Table structure for table `book_loans`
--

CREATE TABLE `book_loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `loan_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('issued','returned','overdue','lost') NOT NULL DEFAULT 'issued',
  `fine_amount` decimal(10,2) DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_loans`
--

INSERT INTO `book_loans` (`id`, `school_id`, `book_id`, `user_id`, `loan_date`, `due_date`, `return_date`, `status`, `fine_amount`, `paid_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 12, '2025-05-27', '2025-05-30', NULL, 'issued', NULL, NULL, '2025-06-22 11:53:35', '2025-06-22 11:53:35'),
(2, 1, 3, 8, '2025-05-29', '2025-05-31', '2025-06-22', 'returned', NULL, NULL, '2025-06-22 11:54:15', '2025-06-22 11:54:23');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `grade_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `class_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`class_days`)),
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `max_capacity` int(11) NOT NULL,
  `current_enrollment` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `school_id`, `academic_year_id`, `subject_id`, `grade_id`, `section_id`, `teacher_id`, `room_id`, `class_days`, `start_time`, `end_time`, `max_capacity`, `current_enrollment`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 4, 1, 2, 1, 32, 2, '[\"Monday\"]', '08:00:00', '09:20:00', 60, 0, 1, '2025-06-21 13:31:57', '2025-06-21 13:31:57'),
(4, 1, 5, 2, 2, 2, 32, 2, '[\"Monday\"]', '09:20:00', '10:00:00', 50, 0, 1, '2025-06-21 13:33:07', '2025-06-21 13:33:07');

-- --------------------------------------------------------

--
-- Table structure for table `class_students`
--

CREATE TABLE `class_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `enrollment_date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_teachers`
--

CREATE TABLE `class_teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `event_type` enum('academic','holiday','meeting','sports','cultural','other') NOT NULL,
  `audience` enum('all','teachers','students','parents','staff') NOT NULL,
  `status` enum('scheduled','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `school_id`, `title`, `description`, `start_datetime`, `end_datetime`, `location`, `event_type`, `audience`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 2, 'GRADUATION', 'the graduations hahaa', '2025-06-19 08:00:00', '2025-06-19 23:30:00', 'DAINING HOLE', 'other', 'all', 'scheduled', 14, '2025-06-22 12:38:13', '2025-06-22 12:38:13'),
(2, 2, 'HOLIDAY', 'HOLIDAY', '2025-06-24 18:38:00', '2025-06-28 18:38:00', 'SCHOOL', 'holiday', 'students', 'scheduled', 14, '2025-06-22 12:39:09', '2025-06-22 12:39:09'),
(3, 1, 'HOLIDAY', 'the students holiday', '2025-06-27 08:00:00', '2025-07-05 08:00:00', 'SHOOL', 'holiday', 'students', 'scheduled', 5, '2025-06-22 12:41:56', '2025-06-22 12:41:56'),
(4, 1, 'meeting', 'lets all teachers attend', '2025-06-19 08:00:00', '2025-06-19 23:00:00', 'School Library', 'meeting', 'teachers', 'scheduled', 5, '2025-06-22 12:43:53', '2025-06-22 12:43:53'),
(5, 1, 'HOLIDAY', 'the teachers holiday', '2025-06-28 08:00:00', '2025-07-06 08:00:00', 'school', 'holiday', 'teachers', 'scheduled', 5, '2025-06-22 12:45:00', '2025-06-22 12:45:39');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `exam_type_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `grade_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_marks` decimal(6,2) NOT NULL,
  `passing_marks` decimal(6,2) NOT NULL,
  `status` enum('upcoming','ongoing','completed') NOT NULL DEFAULT 'upcoming',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_results`
--

CREATE TABLE `exam_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `marks_obtained` decimal(6,2) NOT NULL,
  `grade` varchar(5) NOT NULL,
  `remarks` text DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `published_by` bigint(20) UNSIGNED DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_types`
--

CREATE TABLE `exam_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `weight` decimal(5,2) NOT NULL COMMENT 'Weight for final grade calculation',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_payments`
--

CREATE TABLE `fee_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `fee_structure_id` bigint(20) UNSIGNED NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `method` varchar(255) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `received_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fee_payments`
--

INSERT INTO `fee_payments` (`id`, `student_id`, `fee_structure_id`, `amount_paid`, `payment_date`, `method`, `reference`, `note`, `received_by`, `created_at`, `updated_at`) VALUES
(1, 10, 4, 500000.00, '2025-02-04', 'Cash', 'nothing', 'nothing', 5, '2025-06-20 13:57:44', '2025-06-20 13:57:44'),
(2, 12, 4, 300000.00, '2025-01-22', 'M-pesa', 'no', 'no', 5, '2025-06-20 14:26:33', '2025-06-20 14:26:33');

-- --------------------------------------------------------

--
-- Table structure for table `fee_structures`
--

CREATE TABLE `fee_structures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `grade_id` bigint(20) UNSIGNED DEFAULT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `frequency` enum('monthly','quarterly','semester','annual','one-time') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `due_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fee_structures`
--

INSERT INTO `fee_structures` (`id`, `school_id`, `name`, `description`, `grade_id`, `academic_year_id`, `frequency`, `amount`, `due_date`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'First semister', 'mh', NULL, 1, 'quarterly', 50000.00, '2021-02-11', 0, '2025-06-20 11:42:18', '2025-06-20 11:42:18'),
(2, 1, 'Academic year 2022', 'fd', NULL, 2, 'quarterly', 1200000.00, '2022-06-20', 0, '2025-06-20 11:45:33', '2025-06-20 11:45:33'),
(3, 1, 'Academic fee 2023', 'asdfg', NULL, 3, 'quarterly', 1350000.00, '2023-06-12', 0, '2025-06-20 11:47:14', '2025-06-20 11:47:14'),
(4, 1, 'academic year 2025 1250000', 'sfg 2025', NULL, 5, 'quarterly', 1250000.00, '2025-06-20', 1, '2025-06-20 11:48:13', '2025-06-20 11:48:13');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED DEFAULT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `grade_value` varchar(5) DEFAULT NULL,
  `score` decimal(6,2) NOT NULL,
  `max_score` decimal(6,2) NOT NULL,
  `comments` text DEFAULT NULL,
  `graded_by` bigint(20) UNSIGNED NOT NULL,
  `grade_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grade_levels`
--

CREATE TABLE `grade_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(10) NOT NULL,
  `level` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grade_levels`
--

INSERT INTO `grade_levels` (`id`, `school_id`, `name`, `code`, `level`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Pre - Form one', 'P-F1', 0, 'Elementary school - First grade', '2025-05-31 09:06:31', '2025-06-21 07:29:40'),
(2, 1, 'Form One', 'F1', 1, 'Elementary school - First Level', '2025-05-31 09:17:55', '2025-06-21 07:31:44'),
(3, 1, 'Form Two', 'F2', 2, 'the second level form two', '2025-06-21 07:32:18', '2025-06-21 07:32:18');

-- --------------------------------------------------------

--
-- Table structure for table `health_records`
--

CREATE TABLE `health_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `record_date` date NOT NULL,
  `height` decimal(5,2) DEFAULT NULL COMMENT 'Height in cm',
  `weight` decimal(5,2) DEFAULT NULL COMMENT 'Weight in kg',
  `blood_group` varchar(5) DEFAULT NULL,
  `vision_left` varchar(10) DEFAULT NULL,
  `vision_right` varchar(10) DEFAULT NULL,
  `allergies` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`allergies`)),
  `medical_conditions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`medical_conditions`)),
  `immunizations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`immunizations`)),
  `last_checkup_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `health_records`
--

INSERT INTO `health_records` (`id`, `school_id`, `student_id`, `record_date`, `height`, `weight`, `blood_group`, `vision_left`, `vision_right`, `allergies`, `medical_conditions`, `immunizations`, `last_checkup_date`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 11, '2025-06-03', 145.50, 40.20, 'O+', '6/6', '6/9', '\"Peanuts\"', '\"Malaria\"', '\"river, MMR\"', '2025-05-26', 'Recommended regular inhaler usage', 5, '2025-06-22 11:20:59', '2025-06-22 11:20:59'),
(2, 1, 11, '2025-06-04', 150.20, 48.90, 'A-', '6/6', '6/6', NULL, NULL, NULL, '2025-05-27', 'Fit and healthy.', 5, '2025-06-22 11:22:13', '2025-06-22 11:22:13'),
(3, 1, 12, '2025-06-22', 160.00, 55.50, 'B+', '6/12', '6/6', '\"Dust, Pollen\"', '\"Eczema\"', '\"HPV, BCG\"', '2025-06-06', 'Needs follow-up with dermatologist.', 5, '2025-06-22 11:25:34', '2025-06-22 11:25:34');

-- --------------------------------------------------------

--
-- Table structure for table `hostels`
--

CREATE TABLE `hostels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('boys','girls','co-ed') NOT NULL,
  `address` text NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `warden_id` bigint(20) UNSIGNED DEFAULT NULL,
  `capacity` int(10) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hostels`
--

INSERT INTO `hostels` (`id`, `school_id`, `name`, `type`, `address`, `contact_number`, `warden_id`, `capacity`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Block A', 'boys', 'arond the south the school', '0657856790', 35, 10, 'can cove 500 students', 1, '2025-06-22 13:17:39', '2025-06-22 13:17:39'),
(2, 1, 'Block B', 'girls', 'south the school', '0657856791', 36, 10, 'for girsl', 1, '2025-06-22 13:18:28', '2025-06-22 13:21:47'),
(3, 1, 'Block C', 'co-ed', 'east the block', '065785678', 37, 100, 'both girls and boys', 1, '2025-06-22 13:19:22', '2025-06-22 13:19:22'),
(4, 1, 'Block D', 'boys', 'A direction', '0657856790', 35, 100, 'boys only', 1, '2025-06-22 13:20:30', '2025-06-22 13:20:30');

-- --------------------------------------------------------

--
-- Table structure for table `hostel_allocations`
--

CREATE TABLE `hostel_allocations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `hostel_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `bed_number` varchar(20) NOT NULL,
  `allocation_date` date NOT NULL,
  `deallocation_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hostel_allocations`
--

INSERT INTO `hostel_allocations` (`id`, `school_id`, `student_id`, `hostel_id`, `room_id`, `bed_number`, `allocation_date`, `deallocation_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 1, 1, '1', '2025-06-11', NULL, 1, '2025-06-22 14:02:40', '2025-06-22 14:02:40'),
(2, 1, 11, 1, 1, '2', '2025-06-19', NULL, 1, '2025-06-22 14:03:07', '2025-06-22 14:03:07'),
(3, 1, 10, 4, 2, '1', '2025-06-23', NULL, 1, '2025-06-22 14:03:41', '2025-06-22 14:03:41');

-- --------------------------------------------------------

--
-- Table structure for table `hostel_rooms`
--

CREATE TABLE `hostel_rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `hostel_id` bigint(20) UNSIGNED NOT NULL,
  `room_number` varchar(20) NOT NULL,
  `room_type` enum('single','double','dormitory','other') NOT NULL,
  `capacity` int(10) UNSIGNED NOT NULL,
  `current_occupancy` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `cost_per_bed` decimal(10,2) NOT NULL,
  `status` enum('available','occupied','maintenance') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hostel_rooms`
--

INSERT INTO `hostel_rooms` (`id`, `school_id`, `hostel_id`, `room_number`, `room_type`, `capacity`, `current_occupancy`, `cost_per_bed`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'A1', 'single', 2, 2, 0.00, 'available', '2025-06-22 13:35:03', '2025-06-22 14:04:09'),
(2, 1, 1, 'A2', 'single', 4, 1, 0.00, 'available', '2025-06-22 13:36:14', '2025-06-22 14:03:41'),
(4, 1, 2, 'B1', 'single', 4, 0, 0.00, 'available', '2025-06-22 13:42:30', '2025-06-22 13:42:30'),
(5, 1, 2, 'B2', 'single', 6, 0, 0.00, 'available', '2025-06-22 13:44:02', '2025-06-22 13:44:02'),
(6, 1, 3, 'C1', 'single', 6, 0, 0.00, 'available', '2025-06-22 13:44:52', '2025-06-22 13:44:52'),
(7, 1, 3, 'C2', 'single', 4, 0, 0.00, 'available', '2025-06-22 13:45:17', '2025-06-22 13:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_items`
--

CREATE TABLE `inventory_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `unit` varchar(20) NOT NULL DEFAULT 'piece',
  `minimum_quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `location` varchar(255) NOT NULL,
  `status` enum('available','under-maintenance','disposed') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transactions`
--

CREATE TABLE `inventory_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_type` enum('checkout','return','loss','damage') NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `transaction_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(50) NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `balance` decimal(10,2) NOT NULL,
  `status` enum('draft','issued','paid','partially_paid','overdue','cancelled') NOT NULL DEFAULT 'draft',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `fee_structure_id` bigint(20) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `tax_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_books`
--

CREATE TABLE `library_books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `edition` varchar(50) DEFAULT NULL,
  `year_published` smallint(5) UNSIGNED DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `available_quantity` int(10) UNSIGNED NOT NULL,
  `rack_number` varchar(50) DEFAULT NULL,
  `status` enum('available','lost','damaged') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_books`
--

INSERT INTO `library_books` (`id`, `school_id`, `isbn`, `title`, `author`, `publisher`, `edition`, `year_published`, `category`, `price`, `quantity`, `available_quantity`, `rack_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'ISN21467834', 'RAM DIAGRAMS', 'Pro. Msele', 'The University of Dodoma', 'Ed. 2', 2021, 'Programming', 5000.00, 8, 7, '346763', 'available', '2025-06-22 11:39:06', '2025-06-22 11:39:06'),
(2, 1, 'ISBN2664822222', 'VUKA UJANA SALAMA', 'Min. Furaha Kabage', 'CyberNova Solutions', 'Ed. 1', 2022, 'Reading Book', 8000.00, 20, 19, '366', 'available', '2025-06-22 11:41:16', '2025-06-22 11:53:35'),
(3, 1, 'ISBN123333', 'BASIC MATHEMATICS FOR FORM 4', 'TCU TANZANIA', 'CybeNova Solutions', 'ed. 3', 2000, 'B/MATHS', 3000.00, 15, 15, '55', 'available', '2025-06-22 11:43:38', '2025-06-22 11:54:23');

-- --------------------------------------------------------

--
-- Table structure for table `login_histories`
--

CREATE TABLE `login_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(255) NOT NULL,
  `device_info` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `recipient_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `status` enum('draft','sent','archived') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_18_154517_add_role_column_in_users_table', 1),
(5, '2025_05_18_155343_create_schools_table', 1),
(6, '2025_05_18_160841_add_tenant_id_column_in_users_table', 1),
(7, '2025_05_23_175120_create_personal_access_tokens_table', 2),
(8, '2025_05_23_221730_rename_tenant_id_to_modified_by_in_users_table', 3),
(9, '2025_05_23_222010_rename_tenant_id_to_modified_by_in_schools_table', 4),
(10, '2025_05_26_191622_add_school_id_to_users_table', 5),
(11, '2025_05_27_091330_create_login_histories_table', 6),
(12, '2025_05_27_091748_create_academic_years_table', 7),
(13, '2025_05_27_092028_create_grade_levels_table', 8),
(14, '2025_05_27_092609_create_room_table', 9),
(15, '2025_05_27_102809_create_subject_table', 10),
(16, '2025_05_27_103729_create_teachers_table', 11),
(17, '2025_05_27_111133_create_sections_table', 12),
(18, '2025_05_27_114843_create_students_table', 13),
(19, '2025_05_27_120102_create_students_table', 14),
(20, '2025_05_31_070022_create_parents_table', 15),
(21, '2025_05_31_070753_create_staff_table', 16),
(22, '2025_05_31_071049_create_classes_table', 17),
(23, '2025_05_31_071528_create_class_teachers_table', 18),
(24, '2025_05_31_071738_create_class_students_table', 19),
(25, '2025_05_31_072037_create_attendances_table', 20),
(26, '2025_05_31_072309_create_timetables_table', 21),
(27, '2025_05_31_072425_create_assignments_table', 21),
(28, '2025_05_31_072642_create_submissions_table', 21),
(29, '2025_05_31_072839_create_exam_types_table', 21),
(30, '2025_05_31_073031_create_grades_table', 22),
(31, '2025_05_31_073319_create_exams_table', 23),
(32, '2025_05_31_073322_create_exam_results_table', 23),
(33, '2025_05_31_073540_create_fee_structures_table', 23),
(34, '2025_05_31_073637_create_invoices_table', 23),
(35, '2025_05_31_073752_create_invoice_items_table', 23),
(36, '2025_05_31_073940_create_payment_methods_table', 23),
(37, '2025_05_31_074033_create_library_books_table', 23),
(38, '2025_05_31_074139_create_payments_table', 23),
(39, '2025_05_31_074242_create_book_loans_table', 23),
(40, '2025_05_31_074346_create_inventory_items_table', 23),
(41, '2025_05_31_074431_create_inventory_transactions_table', 23),
(42, '2025_05_31_074602_create_announcements_table', 23),
(43, '2025_05_31_074702_create_messages_table', 23),
(44, '2025_05_31_074757_create_events_table', 23),
(45, '2025_05_31_074847_create_notices_table', 23),
(46, '2025_05_31_074948_create_transportations_table', 24),
(47, '2025_05_31_075036_create_student_transports_table', 24),
(48, '2025_05_31_075125_create_hostels_table', 24),
(49, '2025_05_31_075333_create_hostel_rooms_table', 24),
(50, '2025_05_31_075508_create_hostel_allocations_table', 24),
(51, '2025_05_31_075621_create_achievements_table', 24),
(52, '2025_05_31_075704_create_health_records_table', 24),
(53, '2025_05_31_075850_create_behavior_records_table', 24),
(54, '2025_06_20_122655_create_parent_audit_logs_table', 25),
(55, '2025_06_20_130117_create_fee_payments_table', 25),
(56, '2025_06_20_154320_create_fee_payments_table', 26),
(57, '2025_06_20_155520_create_assigned_fees_table', 26),
(58, '2025_06_20_162433_create_fee_payments_table', 27),
(59, '2025_06_21_093201_create_semesters_table', 28),
(61, '2025_06_21_095808_create_semesters_table', 29),
(62, '2025_06_21_114953_create_subject_teacher_table', 30),
(63, '2025_06_21_175823_create_assessments_table', 31),
(64, '2025_06_22_150517_update_notices_table_for_documents', 32);

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `notice_date` date NOT NULL,
  `audience` enum('all','teachers','students','parents','staff') NOT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `school_id`, `title`, `topic`, `content`, `notice_date`, `audience`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Network Security', 'Network Security', 'notices/mF2umdDrAn0WfFayulHtPim1pN3yl0FAD5dpRAZ7.pdf', '2025-06-03', 'all', 'published', 5, '2025-06-22 12:16:54', '2025-06-22 12:23:46'),
(2, 1, 'transactions', 'Transactions', 'notices/V2Mdtibef1y03eVfmy872LOcfxEfCt5fN57t5ntL.pdf', '2025-06-03', 'all', 'published', 5, '2025-06-22 12:21:53', '2025-06-22 12:21:53');

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `education` varchar(100) DEFAULT NULL,
  `annual_income` decimal(12,2) DEFAULT NULL,
  `relation_type` enum('mother','father','guardian') NOT NULL,
  `company` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`user_id`, `school_id`, `student_id`, `occupation`, `education`, `annual_income`, `relation_type`, `company`, `created_at`, `updated_at`) VALUES
(30, 1, 10, 'Business Man', 'starndard 7', 4000.00, 'father', 'cybernova solutions', '2025-06-20 09:12:13', '2025-06-20 09:12:13'),
(31, 1, 12, 'Farming', 'starndard 7', 0.00, 'father', 'no', '2025-06-20 14:25:31', '2025-06-20 14:25:31');

-- --------------------------------------------------------

--
-- Table structure for table `parent_audit_logs`
--

CREATE TABLE `parent_audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `transaction_reference` varchar(100) DEFAULT NULL,
  `received_by` bigint(20) UNSIGNED NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('completed','pending','failed','refunded') NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `number` varchar(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `building` varchar(100) NOT NULL,
  `floor` varchar(10) NOT NULL,
  `capacity` int(11) NOT NULL,
  `room_type` enum('classroom','lab','office','library','other') NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `school_id`, `user_id`, `number`, `name`, `building`, `floor`, `capacity`, `room_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '100', 'Studing room', 'class', 'ground', 50, 'classroom', 1, '2025-06-21 10:03:10', '2025-06-21 10:10:32'),
(2, 1, 5, 'LRB 101', NULL, 'Class', 'ground', 38, 'classroom', 1, '2025-06-21 10:04:58', '2025-06-21 10:10:26'),
(3, 1, 5, 'A', 'A', 'A', 'G', 69, 'lab', 1, '2025-06-21 10:07:38', '2025-06-21 10:07:38');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `modified_by` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL DEFAULT 'YourCountry',
  `postal_code` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `established_date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `modified_by`, `name`, `code`, `address`, `city`, `state`, `country`, `postal_code`, `phone`, `email`, `website`, `logo`, `established_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Olive Green Secondary school', 'OLIVE2012', 'P.O.BOX 43 Kibondo', 'Dar Es Salaam', 'Africa', 'Tanzania', 'S.5330', '0657856790', 'olivegreen@gmail.com', 'http://127.0.0.1:8000/superadmin/create/schools/olivegreen', 'logos/7ZCLMlU2xoG4EWnBStpaIK9FRtZwuNndnN9pf4Wq.jpg', '2012-12-12', 1, '2025-05-23 18:59:56', '2025-05-23 18:59:56'),
(2, 1, 'Ahava Secondary school', 'AHAVA2018', 'P.O.BOX 43 Kibondo', 'Dar Es Salaam', 'Africa', 'Tanzania', 'S.5344', '0657123455', 'ahava@gmail.com', 'http://127.0.0.1:8000/superadmin/create/schools/olivegreen', 'logos/SgP46yUY4oRYv0z5A5SJbwWFHNCUUdXuL6ayrqlx.png', '2018-12-12', 1, '2025-05-23 19:04:27', '2025-05-23 19:04:27'),
(3, 1, 'Soya Secondary School', 'SOYA2010', 'P.O.BOX 43 Kibondo', 'DODOMA', 'Africa', 'Tanzania', 'S.5660', '0657675784', 'soya@gmail.com', 'http://127.0.0.1:8000/superadmin/create/schools/soyasecondari', 'logos/oWKlXwOTGq5rSYnJ0gJkpgKt0NMcSclGiYwFY8t2.jpg', '2010-11-11', 1, '2025-05-23 19:12:52', '2025-05-23 19:12:52');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(10) NOT NULL,
  `code` varchar(10) NOT NULL,
  `grade_id` bigint(20) UNSIGNED NOT NULL,
  `capacity` int(11) NOT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `class_teacher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `school_id`, `user_id`, `name`, `code`, `grade_id`, `capacity`, `room_id`, `class_teacher_id`, `academic_year_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 'A', 'FA1', 2, 50, 2, 32, 5, 1, '2025-06-21 12:56:09', '2025-06-21 12:57:14'),
(2, 1, 5, 'B', 'FB', 2, 30, 2, 32, 5, 1, '2025-06-21 12:58:24', '2025-06-21 12:58:24');

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('G58l5INmxHX2UwWirG9lrs8KUt5Lzl3aKibWTpH1', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVXJKazcyRHBlNjJOb2NqODk1SkFub2dPazFSTFVpUGtRZWc5RlNnNCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3NjaG9vbC9ldmVudHMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo2MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3VuYWxsb2NhdGVkLXN0dWRlbnRzP2dlbmRlcj0mc2VhcmNoPWplcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1750687296),
('jZu1x5kCXli3IHpQlSSMaf35dPuVMLRpCYCn6vrp', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidmpxOFpLeWJPNDd0WnlkM1g2NmhKMzN5S1RRckswN0RWNHh1WERGciI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3NjaG9vbC9ob3N0ZWwtcm9vbXMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo2NToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3NjaG9vbC9ob3N0ZWwtYWxsb2NhdGlvbnMvY3JlYXRlP3N0dWRlbnQ9MjEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNDt9', 1750687156);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `joining_date` date NOT NULL,
  `designation` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `qualification` varchar(100) DEFAULT NULL,
  `experience` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`user_id`, `school_id`, `employee_id`, `joining_date`, `designation`, `department`, `qualification`, `experience`, `status`, `created_at`, `updated_at`) VALUES
(19, 2, 'staff789', '2025-06-02', 'noo', 'jikoni', 'good', '2', 1, '2025-06-02 11:58:11', '2025-06-02 11:58:11'),
(20, 2, 'Employee123445', '2025-06-02', 'nothing', 'Biomedical', 'nothing', NULL, 0, '2025-06-02 12:20:17', '2025-06-02 12:20:17'),
(35, 1, 'Employee123455', '2025-05-26', 'nothing', 'staff member', 'aring students', '2 years', 1, '2025-06-22 13:13:11', '2025-06-22 13:13:11'),
(36, 1, 'Employee12345566', '2024-06-22', 'noo', 'girsl warden', 'caring girls and cancelling', '4 years', 1, '2025-06-22 13:14:47', '2025-06-22 13:14:47'),
(37, 1, 'Employee12345577', '2025-06-13', 'nooo', 'boys warden', '6years of work', 'cancelling', 1, '2025-06-22 13:16:02', '2025-06-22 13:16:02');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `admitted_by` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `admission_number` varchar(50) NOT NULL,
  `admission_date` date NOT NULL,
  `grade_id` bigint(20) UNSIGNED DEFAULT NULL,
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `roll_number` varchar(20) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `gender` char(10) NOT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `is_transport` tinyint(1) NOT NULL DEFAULT 0,
  `is_hostel` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('active','graduated','transferred') NOT NULL DEFAULT 'active',
  `previous_school_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`previous_school_info`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`user_id`, `admitted_by`, `school_id`, `admission_number`, `admission_date`, `grade_id`, `section_id`, `roll_number`, `date_of_birth`, `gender`, `blood_group`, `religion`, `nationality`, `is_transport`, `is_hostel`, `status`, `previous_school_info`, `created_at`, `updated_at`) VALUES
(10, 5, 1, 'OLIVE2012-536620', '2025-05-31', 1, NULL, NULL, '2025-05-31', 'male', 'A+', 'Christian', 'Tanzanian', 0, 0, 'active', '\"[]\"', '2025-05-31 12:25:19', '2025-05-31 12:25:19'),
(11, 5, 1, 'OLIVE2012-636120', '2025-05-31', 1, NULL, NULL, '2010-09-12', 'male', 'A+', 'Christian', 'Tanzanian', 0, 0, 'active', '\"[]\"', '2025-05-31 12:27:37', '2025-05-31 12:27:37'),
(12, 5, 1, 'OLIVE2012-610938', '2025-05-29', 2, NULL, NULL, '2008-02-21', 'female', 'O', 'Christian', 'Tanzanian', 0, 0, 'active', '\"[]\"', '2025-05-31 13:05:07', '2025-05-31 13:05:07'),
(15, 14, 2, 'AHAVA2018-901003', '2025-06-02', 1, NULL, NULL, '2010-12-23', 'female', 'B+', 'Islamic', 'Tanzanian', 0, 0, 'active', '\"[]\"', '2025-06-02 09:50:11', '2025-06-02 09:50:11'),
(21, 14, 2, 'AHAVA2018-887859', '2025-06-02', 1, NULL, NULL, '2008-02-22', 'female', 'O+', 'Christian', 'Tanzanian', 0, 0, 'active', '\"[]\"', '2025-06-02 13:20:58', '2025-06-02 13:20:58'),
(38, 5, 1, 'OLIVE2012-283086', '2025-06-04', 3, NULL, NULL, '2006-02-02', 'female', 'B+', 'Christian', 'Tanzanian', 0, 0, 'active', '\"[]\"', '2025-06-23 11:00:29', '2025-06-23 11:00:29');

-- --------------------------------------------------------

--
-- Table structure for table `student_transports`
--

CREATE TABLE `student_transports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `route_id` bigint(20) UNSIGNED NOT NULL,
  `stop_name` varchar(255) NOT NULL,
  `pickup_time` time NOT NULL,
  `drop_time` time NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `is_core` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `school_id`, `user_id`, `name`, `code`, `description`, `is_core`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 'Basic Mathematics', 'B/MATH\'S', 'The basic mathematics', 1, '2025-06-21 08:35:02', '2025-06-21 08:58:43'),
(2, 1, 5, 'Chemistry', 'CHEM', 'the chemistry for all stardard 1-4', 1, '2025-06-21 08:35:58', '2025-06-21 08:35:58'),
(4, 1, 5, 'Geography', 'GEO', 'the geographics one', 1, '2025-06-21 08:37:31', '2025-06-21 08:39:36'),
(5, 1, 5, 'Kiswahili', 'KSW', 'Kiswahili language', 1, '2025-06-21 08:38:16', '2025-06-21 08:38:16'),
(6, 1, 5, 'History', 'Hstory', 'The history', 0, '2025-06-21 08:40:36', '2025-06-21 08:40:36'),
(7, 1, 5, 'Physics', 'PYS', 'the phisics', 0, '2025-06-21 08:41:00', '2025-06-21 08:41:00');

-- --------------------------------------------------------

--
-- Table structure for table `subject_teacher`
--

CREATE TABLE `subject_teacher` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subject_teacher`
--

INSERT INTO `subject_teacher` (`id`, `subject_id`, `teacher_id`, `created_at`, `updated_at`) VALUES
(1, 1, 7, NULL, NULL),
(2, 1, 28, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `assignment_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `submission_date` datetime NOT NULL DEFAULT current_timestamp(),
  `file` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('submitted','late','missing') NOT NULL DEFAULT 'submitted',
  `graded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `joining_date` date NOT NULL,
  `qualification` varchar(100) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `experience` varchar(50) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `is_class_teacher` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`user_id`, `school_id`, `employee_id`, `joining_date`, `qualification`, `specialization`, `experience`, `department`, `is_class_teacher`, `status`, `created_at`, `updated_at`) VALUES
(16, 2, 'Employee1234', '2025-06-02', 'Degree in cyber security', 'Good in physics and science', '2', 'science', 0, 0, '2025-06-02 10:58:55', '2025-06-02 10:58:55'),
(17, 2, 'Teacher278', '2025-06-01', 'Diploma of science', 'Biology', '0', 'Biomedical', 0, 0, '2025-06-02 11:04:14', '2025-06-02 11:04:14'),
(18, 2, 'delete234', '2025-06-02', 'sdfghjk', 'sdfghjkl', '4', 'dfghjk/', 0, 0, '2025-06-02 11:09:21', '2025-06-02 11:09:21'),
(32, 1, 'Employee12341234fd', '2025-06-04', 'sddd', 'ddddd', '2', 'ddd', 1, 1, '2025-06-21 09:38:04', '2025-06-21 09:38:04'),
(33, 2, 'employee23455', '2025-06-03', 'sfsdg', 'sgsg', '4', 'sfsf', 1, 1, '2025-06-21 09:39:18', '2025-06-21 09:39:18'),
(34, 1, 'Employee12341234fdee', '2022-02-22', 'Chemistry', 'chemistery', '1', 'chemia', 1, 1, '2025-06-21 15:28:25', '2025-06-21 15:28:25');

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

CREATE TABLE `timetables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `day_of_week` smallint(5) UNSIGNED NOT NULL,
  `period_number` smallint(5) UNSIGNED NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `effective_from` date NOT NULL,
  `effective_to` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timetables`
--

INSERT INTO `timetables` (`id`, `school_id`, `class_id`, `day_of_week`, `period_number`, `start_time`, `end_time`, `room_id`, `teacher_id`, `academic_year_id`, `effective_from`, `effective_to`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, 2, '08:00:00', '09:20:00', NULL, 32, 5, '2025-06-20', '2025-06-20', 1, '2025-06-21 14:51:25', '2025-06-21 14:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `transportations`
--

CREATE TABLE `transportations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `route_name` varchar(255) NOT NULL,
  `vehicle_number` varchar(50) NOT NULL,
  `driver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attendant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_point` varchar(255) NOT NULL,
  `end_point` varchar(255) NOT NULL,
  `stops` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`stops`)),
  `schedule` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `school_id`, `name`, `email`, `email_verified_at`, `password`, `role`, `modified_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'The Super Admin', 'superadmin@example.com', NULL, '$2y$12$NnU2WbEU7hX7moqnOlV0xOy8fvj0dDtJhs0CWdYKQcrk5W2im7STS', 'super_admin', NULL, NULL, '2025-05-23 11:30:52', '2025-05-23 11:30:52'),
(2, NULL, 'Super Admin Two', 'superadmintwo@example.com', NULL, '$2y$12$peR2pjmHWIzC8pgVhU7UeOiIBJDynKLeDkjaU8w4ERE8YzAE6NQCS', 'user', NULL, NULL, '2025-05-23 11:32:54', '2025-05-23 11:32:54'),
(3, NULL, 'School Admin One', 'schooladmin1@example.com', NULL, '$2y$12$vtJlgF1SNg5bEPj26LPqnelJ8wekVWnalhdrosp7JkfU3Q3OaCUW.', 'user', NULL, NULL, '2025-05-23 11:33:40', '2025-05-23 11:33:40'),
(4, 1, 'Nuru Stephano Robert', 'joyce2@gmail.com', NULL, '$2y$12$wtssqWdV/ZKTN0WUy4WMMeVSw37k5JdBxCamX.fts.ih6rdF3FXFi', 'user', NULL, NULL, '2025-05-26 16:38:34', '2025-05-26 16:38:34'),
(5, 1, 'Admin One', 'adminone@gmail.com', NULL, '$2y$12$/intUMlAzbAaKlcUfxJHZem9AUWmPcK9izxIgh/qKY7SmvBuf1vfi', 'school_admin', NULL, NULL, '2025-05-26 17:05:08', '2025-05-26 17:05:08'),
(6, 1, 'Student one', 'studentone@gmail.com', NULL, '$2y$12$/BH31tunAzf.v/7rM9bhderTYerQlztn4//.gv8rVBhG9YbxuKWyG', 'student', NULL, NULL, '2025-05-27 02:33:42', '2025-05-27 02:33:42'),
(7, 1, 'Teacher one', 'teacherone@gmail.com', NULL, '$2y$12$IXt9DgXOm0e1q9s6QEtqS.O9ZajXmtwalJ/8lQ.7bCcBL8y/F3iju', 'teacher', NULL, NULL, '2025-05-27 02:58:06', '2025-05-27 02:58:06'),
(8, 1, 'Seth Stephano', 'set@gmail.com', NULL, '$2y$12$K8JXVz8XIkw2YTZb14vwFuPusTb3qdD8ozWeU7k/aKmCJTkHoyU.e', 'student', NULL, NULL, '2025-05-31 12:16:28', '2025-05-31 12:16:28'),
(9, 1, 'Seth Stephano', 'sethh@gmail.com', NULL, '$2y$12$8xv.ua2ikVBh0LPcbkjAEuXLcc1t26d609G2nSUIOuWN2L8mkKqvC', 'student', NULL, NULL, '2025-05-31 12:20:53', '2025-05-31 12:20:53'),
(10, 1, 'Seth Stephano', 'sethhh@gmail.com', NULL, '$2y$12$sKCPaiAntvX2b70PtI1SfOk0UMs9CgdgEcm91lNqbtwAqFBQ53YDu', 'student', NULL, NULL, '2025-05-31 12:25:19', '2025-05-31 12:25:19'),
(11, 1, 'Seth Stephano', 'sethhhh@gmail.com', NULL, '$2y$12$ZgBjCQ3lnO4F.OYTytO3X.SulG.5HF.Axk1.g4FalPFLZ9AQhWPp2', 'student', NULL, NULL, '2025-05-31 12:27:37', '2025-05-31 12:27:37'),
(12, 1, 'Marry Mussa', 'marry@gmail.com', NULL, '$2y$12$lZKn3TJwRn4ZX1d40BNbseY3BuK6TiI0PXlG3eaJol.HOj9Y7Vnt2', 'student', NULL, NULL, '2025-05-31 13:05:07', '2025-05-31 13:05:07'),
(13, 1, 'New Student School', 'newstudent@example.com', NULL, '$2y$12$3TMc/P.A8s0iQCLJa.5KK..L4U/76i.KaM1cwYHSaV0SnlNluU3Cm', 'student', NULL, NULL, '2025-06-02 09:42:43', '2025-06-02 09:42:43'),
(14, 2, 'Ahava Adminstrator', 'ahavaadmin@example.com', NULL, '$2y$12$AkuCiN/AbhYa2J.JzgC06egGUZkVHFcQe0Jdmxbr0aWNPRky7cnbq', 'school_admin', NULL, NULL, '2025-06-02 09:46:52', '2025-06-02 09:46:52'),
(15, 2, 'Ahava Student one', 'student100@example.com', NULL, '$2y$12$sI2rTJZQw/zcYtYk549Fq.DQ1aq6T8pjsuIrnWo/Vd1NiL6Nzroou', 'student', NULL, NULL, '2025-06-02 09:50:11', '2025-06-02 09:50:11'),
(16, 2, 'Teacher one Amizing', 'teacherone@example.com', NULL, '$2y$12$WAGclyBvXXJaKzAAEuoSVOK0vlpsmgQPItW3eCsqbg3fMAfKb566y', 'teacher', NULL, NULL, '2025-06-02 10:58:55', '2025-06-02 11:05:04'),
(17, 2, 'Teacher two', 'teachertwo@example.com', NULL, '$2y$12$spSvzDqZOrXKZqm5mbFN3Or8rgQX8MpMtxgrLy/RHyrEIZYFBI1g.', 'teacher', NULL, NULL, '2025-06-02 11:04:14', '2025-06-02 11:04:14'),
(18, 2, 'delete', 'delete@gmail.com', NULL, '$2y$12$axWrKocFV2UbaY78YPYq7uDIzfJ.QK0wi2YhzgIy5r4ERtepTiQeC', 'teacher', NULL, NULL, '2025-06-02 11:09:21', '2025-06-02 11:09:21'),
(19, 2, 'Staff Meber one', 'staff@gmail.com', NULL, '$2y$12$K/uYFZjoMPYoVlshYPCVZegvZXabBr1rJxGhbq31Uncfs/kgoFwPO', 'staff', NULL, NULL, '2025-06-02 11:58:11', '2025-06-02 11:58:11'),
(20, 2, 'ahava Staff Meber', 'stafftwo@gmail.com', NULL, '$2y$12$t.vtnu2xlb3j5ln1Cuc2P.7GMBvvVZbegt0gFzMvfTp7VHbbVr2JO', 'staff', NULL, NULL, '2025-06-02 12:20:17', '2025-06-02 12:20:17'),
(21, 2, 'Edisa Stephano', 'edisa@gmail.com', NULL, '$2y$12$CvxR2RWZ1r9MPyAbUHFzSez0XLwekmqp3XBc8s5SU0iksUHwBy112', 'student', NULL, NULL, '2025-06-02 13:20:58', '2025-06-02 13:20:58'),
(22, 2, 'Stephano Robert', 'steph@gmail.com', NULL, '$2y$12$E36VBfd7jl1He/BtKwXOfeAiINfT8oj9hK76GNu4WmpfMHzSLiw42', 'teacher', NULL, NULL, '2025-06-02 13:57:29', '2025-06-02 13:57:29'),
(23, 2, 'Stephano Robert', 'stephano@gmail.com', NULL, '$2y$12$A1embYtfQKrR9XN9cYM8c.WeCikoIWMTmA5aONJi4HUYWByizKUz2', 'teacher', NULL, NULL, '2025-06-02 13:58:06', '2025-06-02 13:58:06'),
(24, 2, 'Stephano Robert', 'stephano22@gmail.com', NULL, '$2y$12$ZsClvwV71yJVNwFjSiCgQOgwYwHM234BoTIlJsu0UQ/aoVXb0o0z.', 'teacher', NULL, NULL, '2025-06-02 13:58:47', '2025-06-02 13:58:47'),
(25, 2, 'Stephano Robert', 'stephano226@gmail.com', NULL, '$2y$12$RRV2AhtfaZxV88Lv3T/cBOxwgCGkAaSFErVi.J7kCU3DH3kHVQuWW', 'teacher', NULL, NULL, '2025-06-02 14:00:10', '2025-06-02 14:00:10'),
(26, 2, 'Stephano Robert', 'stephano226rr@gmail.com', NULL, '$2y$12$b/edVm3Y0nUze56ZIi3zA.Z52V4hFENvaNRTcvZVoTJUzR6Pn7kfW', 'teacher', NULL, NULL, '2025-06-02 14:00:38', '2025-06-02 14:00:38'),
(27, 2, 'Stephano Robert', 'stephano226rrdd@gmail.com', NULL, '$2y$12$GgfWlHk6ulC44TTzsKWVw.zmDmG4VTxAnrGd1Gk1CbmJ2UH49QR5i', 'teacher', NULL, NULL, '2025-06-02 14:08:37', '2025-06-02 14:08:37'),
(28, 1, 'Mussa Bahati', 'mussa@gmail.com', NULL, '$2y$12$JABsqp4aGc2A.llAQIWLZ..N/SUDabVgFYr7ST5zML9Zmn9K1QFeO', 'teacher', NULL, NULL, '2025-06-02 14:23:21', '2025-06-02 14:23:21'),
(29, 1, 'Daudi', 'daudi@gmail.com', NULL, '$2y$12$LPam1ZvOzijy6SmFYIi6TuO0IX.Gm9GhNh7MBhGjBVB2XqewfmflK', 'user', NULL, NULL, '2025-06-06 13:24:35', '2025-06-06 13:24:35'),
(30, 1, 'Stephano Robert', 'stephanoseth@gmail.com', NULL, '$2y$12$JydHjy5R.p3/psGLo2kyoup9PUWQ6j0j5yTUqOx/GIhT/z.qd6m96', 'parent', NULL, NULL, '2025-06-20 09:12:13', '2025-06-20 09:12:13'),
(31, 1, 'Mussa Mussa', 'mussamussa@gmail.com', NULL, '$2y$12$3J6UK0OtCxch9EX/EdYr3uJLQdFQ5HPRP5/PA4FYAVbW3wStNV5n.', 'parent', NULL, NULL, '2025-06-20 14:25:31', '2025-06-20 14:25:31'),
(32, 1, 'Teacher one', 'teacher13math@gmail.com', NULL, '$2y$12$BxDmN0LcUe1RHAc7Y9JhWOS3ffUovxucoaY0DOVmd3lF1lJbArhy2', 'teacher', NULL, NULL, '2025-06-21 09:38:04', '2025-06-21 09:38:04'),
(33, 2, 'Ahava Teacher', 'ahavateacher@example.com', NULL, '$2y$12$eWzOP8Y66gQ15RXfZ6qYz.2MOTOEzSYFHlx/.ROYI/UHImrZkW2TS', 'teacher', NULL, NULL, '2025-06-21 09:39:18', '2025-06-21 09:39:18'),
(34, 1, 'Olive Green TEacher', 'teacher2@gmail.com', NULL, '$2y$12$JPbpJZIRRKmtDNulw90qaOuF0BjeNHKdzhLUuYhX.65ufEGodZ09u', 'teacher', NULL, NULL, '2025-06-21 15:28:25', '2025-06-21 15:28:25'),
(35, 1, 'Warden Number one', 'warden1@gmail.com', NULL, '$2y$12$VBW2cghqxU1Y1jH/lIors.G1QYTrU31Ol6OBSacunbh9T4f3exo3e', 'staff', NULL, NULL, '2025-06-22 13:13:11', '2025-06-22 13:13:11'),
(36, 1, 'Girs Warden', 'warden2@gmail.com', NULL, '$2y$12$c/.toaTnq4/OrxYd2rcbfeA4LtfHWq311gEU0QG.1Hm/govo5miiu', 'staff', NULL, NULL, '2025-06-22 13:14:47', '2025-06-22 13:14:47'),
(37, 1, 'Boys Warden', 'warden3@gmail.com', NULL, '$2y$12$iKFv8n0Q4GFY2N6QA3X.IuE40TqTfrYLO8rtRS6OKgQOkTA8uhSTK', 'staff', NULL, NULL, '2025-06-22 13:16:02', '2025-06-22 13:16:02'),
(38, 1, 'Jesca Amani', 'jesca@gmail.com', NULL, '$2y$12$w6l8YhXCIALsoAu5v.S2H.uGRZzDgGI.igUPAp.p58hnn.DYuhPzO', 'student', NULL, NULL, '2025-06-23 11:00:29', '2025-06-23 11:00:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD PRIMARY KEY (`id`),
  ADD KEY `academic_years_school_id_index` (`school_id`);

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `achievements_student_id_foreign` (`student_id`),
  ADD KEY `achievements_awarded_by_foreign` (`awarded_by`),
  ADD KEY `achievements_school_id_category_index` (`school_id`,`category`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_created_by_foreign` (`created_by`),
  ADD KEY `announcements_school_id_audience_status_index` (`school_id`,`audience`,`status`);

--
-- Indexes for table `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessments_school_id_foreign` (`school_id`),
  ADD KEY `assessments_academic_year_id_foreign` (`academic_year_id`),
  ADD KEY `assessments_grade_id_foreign` (`grade_id`),
  ADD KEY `assessments_class_id_foreign` (`class_id`),
  ADD KEY `assessments_subject_id_foreign` (`subject_id`),
  ADD KEY `assessments_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignments_class_id_foreign` (`class_id`),
  ADD KEY `assignments_created_by_foreign` (`created_by`),
  ADD KEY `assignments_school_id_index` (`school_id`);

--
-- Indexes for table `behavior_records`
--
ALTER TABLE `behavior_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `behavior_records_student_id_foreign` (`student_id`),
  ADD KEY `behavior_records_reported_by_foreign` (`reported_by`),
  ADD KEY `behavior_records_resolved_by_foreign` (`resolved_by`),
  ADD KEY `behavior_records_school_id_incident_type_status_index` (`school_id`,`incident_type`,`status`);

--
-- Indexes for table `book_loans`
--
ALTER TABLE `book_loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_loans_book_id_foreign` (`book_id`),
  ADD KEY `book_loans_user_id_foreign` (`user_id`),
  ADD KEY `book_loans_school_id_index` (`school_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classes_academic_year_id_foreign` (`academic_year_id`),
  ADD KEY `classes_subject_id_foreign` (`subject_id`),
  ADD KEY `classes_grade_id_foreign` (`grade_id`),
  ADD KEY `classes_section_id_foreign` (`section_id`),
  ADD KEY `classes_teacher_id_foreign` (`teacher_id`),
  ADD KEY `classes_room_id_foreign` (`room_id`),
  ADD KEY `classes_school_id_index` (`school_id`);

--
-- Indexes for table `class_students`
--
ALTER TABLE `class_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `class_students_class_id_student_id_unique` (`class_id`,`student_id`),
  ADD KEY `class_students_student_id_foreign` (`student_id`),
  ADD KEY `class_students_school_id_index` (`school_id`);

--
-- Indexes for table `class_teachers`
--
ALTER TABLE `class_teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `class_teachers_class_id_teacher_id_unique` (`class_id`,`teacher_id`),
  ADD KEY `class_teachers_teacher_id_foreign` (`teacher_id`),
  ADD KEY `class_teachers_school_id_index` (`school_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_created_by_foreign` (`created_by`),
  ADD KEY `events_school_id_event_type_audience_status_index` (`school_id`,`event_type`,`audience`,`status`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exams_exam_type_id_foreign` (`exam_type_id`),
  ADD KEY `exams_academic_year_id_foreign` (`academic_year_id`),
  ADD KEY `exams_grade_id_foreign` (`grade_id`),
  ADD KEY `exams_subject_id_foreign` (`subject_id`),
  ADD KEY `exams_created_by_foreign` (`created_by`),
  ADD KEY `exams_school_id_index` (`school_id`);

--
-- Indexes for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exam_results_exam_id_student_id_unique` (`exam_id`,`student_id`),
  ADD KEY `exam_results_student_id_foreign` (`student_id`),
  ADD KEY `exam_results_published_by_foreign` (`published_by`),
  ADD KEY `exam_results_school_id_index` (`school_id`);

--
-- Indexes for table `exam_types`
--
ALTER TABLE `exam_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_types_school_id_index` (`school_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fee_payments`
--
ALTER TABLE `fee_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fee_payments_student_id_foreign` (`student_id`),
  ADD KEY `fee_payments_fee_structure_id_foreign` (`fee_structure_id`),
  ADD KEY `fee_payments_received_by_foreign` (`received_by`);

--
-- Indexes for table `fee_structures`
--
ALTER TABLE `fee_structures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fee_structures_grade_id_foreign` (`grade_id`),
  ADD KEY `fee_structures_academic_year_id_foreign` (`academic_year_id`),
  ADD KEY `fee_structures_school_id_index` (`school_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `grades_submission_id_student_id_unique` (`submission_id`,`student_id`),
  ADD KEY `grades_student_id_foreign` (`student_id`),
  ADD KEY `grades_class_id_foreign` (`class_id`),
  ADD KEY `grades_graded_by_foreign` (`graded_by`),
  ADD KEY `grades_school_id_index` (`school_id`);

--
-- Indexes for table `grade_levels`
--
ALTER TABLE `grade_levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grade_levels_school_id_index` (`school_id`);

--
-- Indexes for table `health_records`
--
ALTER TABLE `health_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `health_records_student_id_foreign` (`student_id`),
  ADD KEY `health_records_created_by_foreign` (`created_by`),
  ADD KEY `health_records_school_id_record_date_index` (`school_id`,`record_date`);

--
-- Indexes for table `hostels`
--
ALTER TABLE `hostels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hostels_warden_id_foreign` (`warden_id`),
  ADD KEY `hostels_school_id_type_status_index` (`school_id`,`type`,`status`);

--
-- Indexes for table `hostel_allocations`
--
ALTER TABLE `hostel_allocations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_bed` (`student_id`,`hostel_id`,`room_id`,`bed_number`),
  ADD KEY `hostel_allocations_hostel_id_foreign` (`hostel_id`),
  ADD KEY `hostel_allocations_room_id_foreign` (`room_id`),
  ADD KEY `hostel_allocations_school_id_index` (`school_id`);

--
-- Indexes for table `hostel_rooms`
--
ALTER TABLE `hostel_rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hostel_rooms_hostel_id_room_number_unique` (`hostel_id`,`room_number`),
  ADD KEY `hostel_rooms_school_id_status_index` (`school_id`,`status`);

--
-- Indexes for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_items_school_id_index` (`school_id`);

--
-- Indexes for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_transactions_item_id_foreign` (`item_id`),
  ADD KEY `inventory_transactions_user_id_foreign` (`user_id`),
  ADD KEY `inventory_transactions_school_id_index` (`school_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  ADD KEY `invoices_student_id_foreign` (`student_id`),
  ADD KEY `invoices_created_by_foreign` (`created_by`),
  ADD KEY `invoices_school_id_index` (`school_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  ADD KEY `invoice_items_fee_structure_id_foreign` (`fee_structure_id`),
  ADD KEY `invoice_items_school_id_index` (`school_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_books`
--
ALTER TABLE `library_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `library_books_school_id_index` (`school_id`);

--
-- Indexes for table `login_histories`
--
ALTER TABLE `login_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_histories_user_id_foreign` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_recipient_id_foreign` (`recipient_id`),
  ADD KEY `messages_school_id_sender_id_recipient_id_status_index` (`school_id`,`sender_id`,`recipient_id`,`status`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notices_created_by_foreign` (`created_by`),
  ADD KEY `notices_school_id_audience_status_index` (`school_id`,`audience`,`status`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `parents_student_id_foreign` (`student_id`),
  ADD KEY `parents_school_id_index` (`school_id`);

--
-- Indexes for table `parent_audit_logs`
--
ALTER TABLE `parent_audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_invoice_id_foreign` (`invoice_id`),
  ADD KEY `payments_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `payments_received_by_foreign` (`received_by`),
  ADD KEY `payments_school_id_index` (`school_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_methods_school_id_index` (`school_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_user_id_foreign` (`user_id`),
  ADD KEY `room_school_id_index` (`school_id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `schools_name_unique` (`name`),
  ADD UNIQUE KEY `schools_code_unique` (`code`),
  ADD KEY `schools_tenant_id_index` (`modified_by`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_user_id_foreign` (`user_id`),
  ADD KEY `sections_grade_id_foreign` (`grade_id`),
  ADD KEY `sections_room_id_foreign` (`room_id`),
  ADD KEY `sections_class_teacher_id_foreign` (`class_teacher_id`),
  ADD KEY `sections_academic_year_id_foreign` (`academic_year_id`),
  ADD KEY `sections_school_id_index` (`school_id`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `semesters_school_id_foreign` (`school_id`),
  ADD KEY `semesters_academic_year_id_foreign` (`academic_year_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `staff_employee_id_unique` (`employee_id`),
  ADD KEY `staff_school_id_index` (`school_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `students_admission_number_unique` (`admission_number`),
  ADD KEY `students_admitted_by_foreign` (`admitted_by`),
  ADD KEY `students_grade_id_foreign` (`grade_id`),
  ADD KEY `students_section_id_foreign` (`section_id`),
  ADD KEY `students_school_id_index` (`school_id`);

--
-- Indexes for table `student_transports`
--
ALTER TABLE `student_transports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_transports_student_id_route_id_unique` (`student_id`,`route_id`),
  ADD KEY `student_transports_route_id_foreign` (`route_id`),
  ADD KEY `student_transports_school_id_index` (`school_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_user_id_foreign` (`user_id`),
  ADD KEY `subject_school_id_index` (`school_id`);

--
-- Indexes for table `subject_teacher`
--
ALTER TABLE `subject_teacher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subject_teacher_subject_id_teacher_id_unique` (`subject_id`,`teacher_id`),
  ADD KEY `subject_teacher_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_assignment_submission` (`assignment_id`,`student_id`),
  ADD KEY `submissions_student_id_foreign` (`student_id`),
  ADD KEY `submissions_graded_by_foreign` (`graded_by`),
  ADD KEY `submissions_school_id_index` (`school_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `teachers_employee_id_unique` (`employee_id`),
  ADD KEY `teachers_school_id_index` (`school_id`);

--
-- Indexes for table `timetables`
--
ALTER TABLE `timetables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `timetable_unique` (`class_id`,`day_of_week`,`period_number`,`academic_year_id`),
  ADD KEY `timetables_room_id_foreign` (`room_id`),
  ADD KEY `timetables_teacher_id_foreign` (`teacher_id`),
  ADD KEY `timetables_academic_year_id_foreign` (`academic_year_id`),
  ADD KEY `timetables_school_id_index` (`school_id`);

--
-- Indexes for table `transportations`
--
ALTER TABLE `transportations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transportations_driver_id_foreign` (`driver_id`),
  ADD KEY `transportations_attendant_id_foreign` (`attendant_id`),
  ADD KEY `transportations_school_id_index` (`school_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_tenant_id_foreign` (`modified_by`),
  ADD KEY `users_school_id_foreign` (`school_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `behavior_records`
--
ALTER TABLE `behavior_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `book_loans`
--
ALTER TABLE `book_loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `class_students`
--
ALTER TABLE `class_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_teachers`
--
ALTER TABLE `class_teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_types`
--
ALTER TABLE `exam_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_payments`
--
ALTER TABLE `fee_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fee_structures`
--
ALTER TABLE `fee_structures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grade_levels`
--
ALTER TABLE `grade_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `health_records`
--
ALTER TABLE `health_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hostels`
--
ALTER TABLE `hostels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hostel_allocations`
--
ALTER TABLE `hostel_allocations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hostel_rooms`
--
ALTER TABLE `hostel_rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inventory_items`
--
ALTER TABLE `inventory_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_books`
--
ALTER TABLE `library_books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login_histories`
--
ALTER TABLE `login_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `parent_audit_logs`
--
ALTER TABLE `parent_audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_transports`
--
ALTER TABLE `student_transports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subject_teacher`
--
ALTER TABLE `subject_teacher`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timetables`
--
ALTER TABLE `timetables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transportations`
--
ALTER TABLE `transportations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD CONSTRAINT `academic_years_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `achievements`
--
ALTER TABLE `achievements`
  ADD CONSTRAINT `achievements_awarded_by_foreign` FOREIGN KEY (`awarded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `achievements_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `achievements_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `announcements_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assessments`
--
ALTER TABLE `assessments`
  ADD CONSTRAINT `assessments_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessments_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessments_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grade_levels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessments_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessments_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessments_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `teachers` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignments_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `behavior_records`
--
ALTER TABLE `behavior_records`
  ADD CONSTRAINT `behavior_records_reported_by_foreign` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `behavior_records_resolved_by_foreign` FOREIGN KEY (`resolved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `behavior_records_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `behavior_records_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `book_loans`
--
ALTER TABLE `book_loans`
  ADD CONSTRAINT `book_loans_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `library_books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_loans_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_loans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classes_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grade_levels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classes_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `classes_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classes_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classes_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classes_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `class_students`
--
ALTER TABLE `class_students`
  ADD CONSTRAINT `class_students_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_students_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_students_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `class_teachers`
--
ALTER TABLE `class_teachers`
  ADD CONSTRAINT `class_teachers_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_teachers_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_teachers_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `events_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `teachers` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_exam_type_id_foreign` FOREIGN KEY (`exam_type_id`) REFERENCES `exam_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grade_levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `exams_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD CONSTRAINT `exam_results_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_results_published_by_foreign` FOREIGN KEY (`published_by`) REFERENCES `teachers` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `exam_results_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_results_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_types`
--
ALTER TABLE `exam_types`
  ADD CONSTRAINT `exam_types_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_payments`
--
ALTER TABLE `fee_payments`
  ADD CONSTRAINT `fee_payments_fee_structure_id_foreign` FOREIGN KEY (`fee_structure_id`) REFERENCES `fee_structures` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_payments_received_by_foreign` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_payments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_structures`
--
ALTER TABLE `fee_structures`
  ADD CONSTRAINT `fee_structures_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_structures_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grade_levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fee_structures_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_graded_by_foreign` FOREIGN KEY (`graded_by`) REFERENCES `teachers` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `grade_levels`
--
ALTER TABLE `grade_levels`
  ADD CONSTRAINT `grade_levels_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `health_records`
--
ALTER TABLE `health_records`
  ADD CONSTRAINT `health_records_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `health_records_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `health_records_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `hostels`
--
ALTER TABLE `hostels`
  ADD CONSTRAINT `hostels_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hostels_warden_id_foreign` FOREIGN KEY (`warden_id`) REFERENCES `staff` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `hostel_allocations`
--
ALTER TABLE `hostel_allocations`
  ADD CONSTRAINT `hostel_allocations_hostel_id_foreign` FOREIGN KEY (`hostel_id`) REFERENCES `hostels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hostel_allocations_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `hostel_rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hostel_allocations_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hostel_allocations_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `hostel_rooms`
--
ALTER TABLE `hostel_rooms`
  ADD CONSTRAINT `hostel_rooms_hostel_id_foreign` FOREIGN KEY (`hostel_id`) REFERENCES `hostels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hostel_rooms_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD CONSTRAINT `inventory_items_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  ADD CONSTRAINT `inventory_transactions_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_transactions_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_fee_structure_id_foreign` FOREIGN KEY (`fee_structure_id`) REFERENCES `fee_structures` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_items_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `library_books`
--
ALTER TABLE `library_books`
  ADD CONSTRAINT `library_books_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `login_histories`
--
ALTER TABLE `login_histories`
  ADD CONSTRAINT `login_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_recipient_id_foreign` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notices`
--
ALTER TABLE `notices`
  ADD CONSTRAINT `notices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notices_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `parents_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `parents_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `parents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_received_by_foreign` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sections_class_teacher_id_foreign` FOREIGN KEY (`class_teacher_id`) REFERENCES `teachers` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sections_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grade_levels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sections_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sections_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sections_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `semesters`
--
ALTER TABLE `semesters`
  ADD CONSTRAINT `semesters_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `semesters_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_admitted_by_foreign` FOREIGN KEY (`admitted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grade_levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_transports`
--
ALTER TABLE `student_transports`
  ADD CONSTRAINT `student_transports_route_id_foreign` FOREIGN KEY (`route_id`) REFERENCES `transportations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_transports_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_transports_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subject_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subject_teacher`
--
ALTER TABLE `subject_teacher`
  ADD CONSTRAINT `subject_teacher_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subject_teacher_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissions_graded_by_foreign` FOREIGN KEY (`graded_by`) REFERENCES `teachers` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `submissions_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teachers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `timetables`
--
ALTER TABLE `timetables`
  ADD CONSTRAINT `timetables_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetables_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetables_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `timetables_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetables_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `transportations`
--
ALTER TABLE `transportations`
  ADD CONSTRAINT `transportations_attendant_id_foreign` FOREIGN KEY (`attendant_id`) REFERENCES `staff` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transportations_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `staff` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transportations_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_tenant_id_foreign` FOREIGN KEY (`modified_by`) REFERENCES `schools` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
