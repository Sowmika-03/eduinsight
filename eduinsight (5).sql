-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2026 at 07:40 AM
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
-- Database: `eduinsight`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_risk`
--

CREATE TABLE `academic_risk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `attendance_percentage` decimal(5,2) NOT NULL,
  `internal_marks` decimal(5,2) DEFAULT NULL,
  `external_marks` decimal(5,2) DEFAULT NULL,
  `risk_level` enum('Low Risk','Medium Risk','High Risk') NOT NULL DEFAULT 'Low Risk',
  `risk_description` varchar(255) DEFAULT NULL,
  `is_notified` tinyint(1) NOT NULL DEFAULT 0,
  `risk_score` double DEFAULT NULL,
  `recommendations` text DEFAULT NULL,
  `prediction_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_risk`
--

INSERT INTO `academic_risk` (`id`, `student_id`, `course_id`, `attendance_percentage`, `internal_marks`, `external_marks`, `risk_level`, `risk_description`, `is_notified`, `risk_score`, `recommendations`, `prediction_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 61.00, 32.00, 38.00, 'Medium Risk', NULL, 0, 0.74, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(2, 2, 1, 61.00, 20.00, 29.00, 'Medium Risk', NULL, 0, 0.1, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(3, 3, 1, 88.00, 39.00, 40.00, 'Medium Risk', NULL, 0, 0.23, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(4, 4, 1, 76.00, 22.00, 33.00, 'Medium Risk', NULL, 0, 0.53, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(5, 5, 1, 66.00, 26.00, 26.00, 'Medium Risk', NULL, 0, 0.25, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(6, 6, 1, 75.00, 30.00, 23.00, 'High Risk', NULL, 0, 0.59, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(7, 7, 1, 91.00, 26.00, 22.00, 'Medium Risk', NULL, 0, 0.19, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(8, 8, 1, 81.00, 36.00, 40.00, 'Medium Risk', NULL, 0, 0.64, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(9, 9, 1, 56.00, 25.00, 33.00, 'High Risk', NULL, 0, 0.77, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(10, 10, 1, 75.00, 34.00, 26.00, 'High Risk', NULL, 0, 0.71, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(11, 11, 1, 57.00, 23.00, 24.00, 'Low Risk', NULL, 0, 0.59, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(12, 12, 1, 67.00, 37.00, 27.00, 'Medium Risk', NULL, 0, 0.89, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(13, 13, 1, 55.00, 24.00, 23.00, 'High Risk', NULL, 0, 0.28, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(14, 14, 1, 55.00, 20.00, 39.00, 'High Risk', NULL, 0, 0.52, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(15, 15, 1, 54.00, 37.00, 44.00, 'Medium Risk', NULL, 0, 0.15, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(16, 16, 1, 88.00, 36.00, 37.00, 'Medium Risk', NULL, 0, 0.33, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(17, 17, 1, 95.00, 40.00, 36.00, 'Medium Risk', NULL, 0, 0.33, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(18, 18, 1, 74.00, 29.00, 23.00, 'Low Risk', NULL, 0, 0.61, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(19, 19, 1, 60.00, 35.00, 24.00, 'High Risk', NULL, 0, 0.71, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(20, 20, 1, 52.00, 33.00, 36.00, 'High Risk', NULL, 0, 0.28, '[\"Improve attendance\",\"Study harder\"]', '2026-03-09 04:04:23', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(21, 1, 1, 57.00, 16.00, 27.00, 'Medium Risk', 'Student has concerning attendance (57%) and average marks', 0, 0.52, '[\"Improve attendance immediately\",\"Meet with faculty advisor\",\"Increase study hours\",\"Form study groups\"]', '2026-03-11 07:27:10', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(22, 1, 2, 92.00, 33.00, 35.00, 'Low Risk', 'Student is performing well', 0, 0.3, '[\"Keep up the good work\"]', '2026-03-11 07:27:10', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(23, 2, 1, 75.00, 34.00, 40.00, 'Low Risk', 'Student is performing well with 75% attendance', 0, 0.32, '[]', '2026-03-11 07:27:10', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(24, 2, 2, 94.00, 21.00, 41.00, 'Low Risk', 'Student is performing well', 0, 0.27, '[\"Keep up the good work\"]', '2026-03-11 07:27:10', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(25, 3, 1, 89.00, 45.00, 43.00, 'Low Risk', 'Student is performing well with 89% attendance', 0, 0.36, '[]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(26, 3, 2, 92.00, 45.00, 37.00, 'Low Risk', 'Student is performing well', 0, 0.13, '[\"Keep up the good work\"]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(27, 4, 1, 73.00, 27.00, 33.00, 'Low Risk', 'Student is performing well with 73% attendance', 0, 0.63, '[]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(28, 4, 2, 92.00, 26.00, 31.00, 'Low Risk', 'Student is performing well', 0, 0.25, '[\"Keep up the good work\"]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(29, 5, 1, 39.00, 13.00, 13.00, 'High Risk', 'Student has very low attendance (39%) and poor marks', 0, 0.69, '[\"Improve attendance immediately\",\"Meet with faculty advisor\",\"Attend extra classes\",\"Get tutoring support\",\"Review previous exams\"]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(30, 5, 2, 87.00, 23.00, 24.00, 'Low Risk', 'Student is performing well', 0, 0.18, '[\"Keep up the good work\"]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(31, 6, 1, 68.00, 22.00, 30.00, 'Medium Risk', 'Student has concerning attendance (68%) and average marks', 0, 0.54, '[\"Increase study hours\",\"Form study groups\"]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(32, 6, 2, 74.00, 45.00, 45.00, 'Low Risk', 'Student is performing well', 0, 0.16, '[\"Keep up the good work\"]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(33, 7, 1, 82.00, 33.00, 30.00, 'Low Risk', 'Student is performing well with 82% attendance', 0, 0.9, '[]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(34, 7, 2, 74.00, 32.00, 23.00, 'Low Risk', 'Student is performing well', 0, 0.14, '[\"Keep up the good work\"]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(35, 8, 1, 94.00, 37.00, 46.00, 'Low Risk', 'Student is performing well with 94% attendance', 0, 0.8, '[]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(36, 8, 2, 80.00, 28.00, 36.00, 'Low Risk', 'Student is performing well', 0, 0.17, '[\"Keep up the good work\"]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(37, 9, 1, 62.00, 20.00, 35.00, 'Low Risk', 'Student is performing well with 62% attendance', 0, 0.6, '[]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(38, 9, 2, 84.00, 36.00, 34.00, 'Low Risk', 'Student is performing well', 0, 0.08, '[\"Keep up the good work\"]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(39, 10, 1, 44.00, 15.00, 14.00, 'High Risk', 'Student has very low attendance (44%) and poor marks', 0, 0.69, '[\"Improve attendance immediately\",\"Meet with faculty advisor\",\"Attend extra classes\",\"Get tutoring support\",\"Review previous exams\"]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(40, 10, 2, 75.00, 41.00, 28.00, 'Low Risk', 'Student is performing well', 0, 0.11, '[\"Keep up the good work\"]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(41, 11, 1, 57.00, 18.00, 28.00, 'Medium Risk', 'Student has concerning attendance (57%) and average marks', 0, 0.52, '[\"Improve attendance immediately\",\"Meet with faculty advisor\",\"Increase study hours\",\"Form study groups\"]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(42, 11, 2, 92.00, 23.00, 23.00, 'Low Risk', 'Student is performing well', 0, 0.13, '[\"Keep up the good work\"]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(43, 12, 1, 81.00, 28.00, 31.00, 'Low Risk', 'Student is performing well with 81% attendance', 0, 0.88, '[]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(44, 12, 2, 87.00, 42.00, 38.00, 'Low Risk', 'Student is performing well', 0, 0.13, '[\"Keep up the good work\"]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(45, 13, 1, 87.00, 42.00, 40.00, 'Low Risk', 'Student is performing well with 87% attendance', 0, 0.36, '[]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(46, 13, 2, 83.00, 20.00, 22.00, 'Low Risk', 'Student is performing well', 0, 0.26, '[\"Keep up the good work\"]', '2026-03-11 07:27:11', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(47, 14, 1, 75.00, 24.00, 21.00, 'Low Risk', 'Student is performing well with 75% attendance', 0, 0.23, '[]', '2026-03-11 07:27:12', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(48, 14, 2, 90.00, 36.00, 24.00, 'Low Risk', 'Student is performing well', 0, 0.12, '[\"Keep up the good work\"]', '2026-03-11 07:27:12', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(49, 15, 1, 55.00, 12.00, 6.00, 'High Risk', 'Student has very low attendance (55%) and poor marks', 0, 0.73, '[\"Improve attendance immediately\",\"Meet with faculty advisor\",\"Attend extra classes\",\"Get tutoring support\",\"Review previous exams\"]', '2026-03-11 07:27:12', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(50, 15, 2, 72.00, 45.00, 26.00, 'Low Risk', 'Student is performing well', 0, 0.22, '[\"Keep up the good work\"]', '2026-03-11 07:27:12', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(51, 16, 1, 61.00, 17.00, 24.00, 'Medium Risk', 'Student has concerning attendance (61%) and average marks', 0, 0.37, '[\"Increase study hours\",\"Form study groups\"]', '2026-03-11 07:27:12', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(52, 16, 2, 82.00, 42.00, 33.00, 'Low Risk', 'Student is performing well', 0, 0.06, '[\"Keep up the good work\"]', '2026-03-11 07:27:12', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(53, 17, 1, 77.00, 27.00, 38.00, 'Low Risk', 'Student is performing well with 77% attendance', 0, 0.67, '[]', '2026-03-11 07:27:12', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(54, 17, 2, 85.00, 20.00, 36.00, 'Low Risk', 'Student is performing well', 0, 0.18, '[\"Keep up the good work\"]', '2026-03-11 07:27:12', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(55, 18, 1, 94.00, 37.00, 41.00, 'Low Risk', 'Student is performing well with 94% attendance', 0, 0.13, '[]', '2026-03-11 07:27:12', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(56, 18, 2, 74.00, 23.00, 44.00, 'Low Risk', 'Student is performing well', 0, 0.05, '[\"Keep up the good work\"]', '2026-03-11 07:27:12', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(57, 19, 1, 58.00, 30.00, 20.00, 'Low Risk', 'Student is performing well with 58% attendance', 0, 0.31, '[\"Improve attendance immediately\",\"Meet with faculty advisor\"]', '2026-03-11 07:27:12', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(58, 19, 2, 73.00, 24.00, 35.00, 'Low Risk', 'Student is performing well', 0, 0.1, '[\"Keep up the good work\"]', '2026-03-11 07:27:12', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(59, 20, 1, 39.00, 10.00, 18.00, 'High Risk', 'Student has very low attendance (39%) and poor marks', 0, 0.83, '[\"Improve attendance immediately\",\"Meet with faculty advisor\",\"Attend extra classes\",\"Get tutoring support\",\"Review previous exams\"]', '2026-03-11 07:27:12', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(60, 20, 2, 72.00, 37.00, 25.00, 'Low Risk', 'Student is performing well', 0, 0.12, '[\"Keep up the good work\"]', '2026-03-11 07:27:12', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(61, 21, 1, 58.00, 20.00, 22.00, 'Medium Risk', 'Student has concerning attendance (58%) and average marks', 0, 0.88, '[\"Improve attendance immediately\",\"Meet with faculty advisor\",\"Increase study hours\",\"Form study groups\"]', '2026-03-11 07:27:12', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(62, 21, 2, 87.00, 20.00, 45.00, 'Low Risk', 'Student is performing well', 0, 0.18, '[\"Keep up the good work\"]', '2026-03-11 07:27:12', '2026-03-11 07:27:12', '2026-03-11 07:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `alert_type` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `severity` enum('low','medium','high') NOT NULL DEFAULT 'medium',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `alert_date` date NOT NULL,
  `action_taken` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`id`, `student_id`, `course_id`, `alert_type`, `message`, `severity`, `is_read`, `alert_date`, `action_taken`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 'low_attendance', 'Your attendance is below the required threshold. Please attend classes regularly.', 'low', 0, '2026-03-05', NULL, '2026-02-28 19:07:27', '2026-03-12 19:07:27'),
(2, 1, 5, 'missing_assignment', 'You have missed submitting an important assignment. Please complete and submit it.', 'high', 0, '2026-03-10', 'Notified via email', '2026-02-27 19:07:27', '2026-03-12 19:07:27'),
(3, 1, 6, 'low_attendance', 'Your attendance is below the required threshold. Please attend classes regularly.', 'high', 1, '2026-03-05', NULL, '2026-03-09 19:07:27', '2026-03-12 19:07:27'),
(4, 2, 6, 'missing_assignment', 'You have missed submitting an important assignment. Please complete and submit it.', 'low', 0, '2026-03-11', NULL, '2026-02-25 19:07:27', '2026-03-12 19:07:27'),
(5, 2, 5, 'low_marks', 'Your recent marks are below average. Consider seeking help from faculty members.', 'high', 0, '2026-02-28', NULL, '2026-03-04 19:07:27', '2026-03-12 19:07:27'),
(6, 2, 1, 'missing_assignment', 'You have missed submitting an important assignment. Please complete and submit it.', 'medium', 0, '2026-02-27', 'Notified via email', '2026-03-06 19:07:27', '2026-03-12 19:07:27'),
(7, 3, 5, 'missing_assignment', 'You have missed submitting an important assignment. Please complete and submit it.', 'medium', 1, '2026-02-27', 'Notified via email', '2026-03-03 19:07:27', '2026-03-12 19:07:27'),
(8, 3, 5, 'low_attendance', 'Your attendance is below the required threshold. Please attend classes regularly.', 'medium', 1, '2026-03-05', 'Notified via email', '2026-03-02 19:07:27', '2026-03-12 19:07:27'),
(9, 4, 5, 'low_marks', 'Your recent marks are below average. Consider seeking help from faculty members.', 'low', 1, '2026-03-07', NULL, '2026-03-07 19:07:27', '2026-03-12 19:07:27'),
(10, 4, 5, 'low_marks', 'Your recent marks are below average. Consider seeking help from faculty members.', 'medium', 0, '2026-03-06', 'Notified via email', '2026-03-09 19:07:27', '2026-03-12 19:07:27'),
(11, 5, 2, 'low_attendance', 'Your attendance is below the required threshold. Please attend classes regularly.', 'high', 1, '2026-03-02', 'Notified via email', '2026-02-26 19:07:27', '2026-03-12 19:07:27'),
(12, 5, 2, 'high_risk', 'Your academic performance shows signs of risk. Please meet with your faculty advisor.', 'low', 1, '2026-02-28', NULL, '2026-03-02 19:07:27', '2026-03-12 19:07:27'),
(13, 5, 2, 'low_attendance', 'Your attendance is below the required threshold. Please attend classes regularly.', 'low', 1, '2026-03-02', NULL, '2026-03-10 19:07:27', '2026-03-12 19:07:27'),
(14, 6, 6, 'high_risk', 'Your academic performance shows signs of risk. Please meet with your faculty advisor.', 'low', 1, '2026-03-12', NULL, '2026-03-03 19:07:27', '2026-03-12 19:07:27'),
(15, 6, 5, 'high_risk', 'Your academic performance shows signs of risk. Please meet with your faculty advisor.', 'high', 1, '2026-03-08', NULL, '2026-02-27 19:07:27', '2026-03-12 19:07:27'),
(16, 6, 6, 'high_risk', 'Your academic performance shows signs of risk. Please meet with your faculty advisor.', 'low', 1, '2026-03-10', 'Notified via email', '2026-03-05 19:07:27', '2026-03-12 19:07:27'),
(17, 7, 6, 'missing_assignment', 'You have missed submitting an important assignment. Please complete and submit it.', 'medium', 1, '2026-03-04', 'Notified via email', '2026-03-09 19:07:27', '2026-03-12 19:07:27'),
(18, 7, 7, 'low_attendance', 'Your attendance is below the required threshold. Please attend classes regularly.', 'low', 0, '2026-03-08', NULL, '2026-03-09 19:07:27', '2026-03-12 19:07:27'),
(19, 7, 6, 'low_attendance', 'Your attendance is below the required threshold. Please attend classes regularly.', 'medium', 1, '2026-02-28', 'Notified via email', '2026-03-05 19:07:27', '2026-03-12 19:07:27'),
(20, 8, 2, 'low_attendance', 'Your attendance is below the required threshold. Please attend classes regularly.', 'high', 0, '2026-02-28', NULL, '2026-03-07 19:07:27', '2026-03-12 19:07:27'),
(21, 8, 4, 'low_attendance', 'Your attendance is below the required threshold. Please attend classes regularly.', 'low', 1, '2026-03-05', NULL, '2026-03-04 19:07:27', '2026-03-12 19:07:27'),
(22, 9, 1, 'high_risk', 'Your academic performance shows signs of risk. Please meet with your faculty advisor.', 'low', 0, '2026-03-01', NULL, '2026-03-02 19:07:27', '2026-03-12 19:07:27'),
(23, 9, 3, 'low_attendance', 'Your attendance is below the required threshold. Please attend classes regularly.', 'low', 1, '2026-02-28', 'Notified via email', '2026-03-04 19:07:27', '2026-03-12 19:07:27'),
(24, 9, 4, 'low_marks', 'Your recent marks are below average. Consider seeking help from faculty members.', 'high', 1, '2026-02-28', 'Notified via email', '2026-03-04 19:07:27', '2026-03-12 19:07:27'),
(25, 10, 7, 'low_marks', 'Your recent marks are below average. Consider seeking help from faculty members.', 'low', 0, '2026-02-28', NULL, '2026-03-11 19:07:27', '2026-03-12 19:07:27'),
(26, 10, 3, 'low_attendance', 'Your attendance is below the required threshold. Please attend classes regularly.', 'high', 1, '2026-02-27', NULL, '2026-03-10 19:07:27', '2026-03-12 19:07:27');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `attendance_date` date NOT NULL,
  `status` enum('present','absent','late') NOT NULL DEFAULT 'absent',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `course_id`, `attendance_date`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-02-07', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(2, 1, 1, '2026-01-30', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(3, 1, 1, '2026-03-02', 'absent', 'Medical leave', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(4, 1, 1, '2026-03-08', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(5, 1, 1, '2026-02-25', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(6, 1, 1, '2026-02-19', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(7, 1, 1, '2026-02-22', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(8, 1, 1, '2026-02-01', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(9, 1, 1, '2026-02-08', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(10, 1, 1, '2026-01-29', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(11, 1, 1, '2026-03-03', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(12, 1, 1, '2026-01-25', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(13, 1, 1, '2026-02-07', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(14, 1, 1, '2026-01-17', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(15, 1, 1, '2026-02-09', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(16, 1, 1, '2026-02-14', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(17, 1, 1, '2026-01-19', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(18, 1, 1, '2026-02-14', 'absent', 'Medical leave', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(19, 1, 1, '2026-01-31', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(20, 1, 1, '2026-02-08', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(21, 1, 1, '2026-02-11', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(22, 1, 1, '2026-02-03', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(23, 1, 1, '2026-02-27', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(24, 1, 1, '2026-02-04', 'absent', 'Medical leave', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(25, 1, 1, '2026-02-11', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(26, 1, 1, '2026-01-10', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(27, 1, 1, '2026-03-10', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-12 19:33:12'),
(28, 1, 1, '2026-02-22', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(29, 1, 1, '2026-02-23', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(30, 1, 1, '2026-02-21', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(31, 1, 1, '2026-02-16', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(32, 1, 1, '2026-01-26', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(33, 1, 1, '2026-02-21', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(34, 1, 1, '2026-02-23', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(35, 1, 1, '2026-01-30', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(36, 1, 1, '2026-02-15', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(37, 1, 1, '2026-02-12', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(38, 1, 1, '2026-02-05', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(39, 1, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(40, 1, 1, '2026-02-19', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(41, 2, 1, '2026-02-23', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(42, 2, 1, '2026-02-03', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(43, 2, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(44, 2, 1, '2026-02-01', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(45, 2, 1, '2026-03-08', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(46, 2, 1, '2026-02-18', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(47, 2, 1, '2026-02-27', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(48, 2, 1, '2026-03-02', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(49, 2, 1, '2026-02-12', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(50, 2, 1, '2026-01-12', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(51, 2, 1, '2026-03-09', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(52, 2, 1, '2026-02-12', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(53, 2, 1, '2026-02-25', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(54, 2, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(55, 2, 1, '2026-02-11', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(56, 2, 1, '2026-03-02', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(57, 2, 1, '2026-01-16', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(58, 2, 1, '2026-02-28', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(59, 2, 1, '2026-02-11', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(60, 2, 1, '2026-02-13', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(61, 2, 1, '2026-01-20', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(62, 2, 1, '2026-01-15', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(63, 2, 1, '2026-01-31', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(64, 2, 1, '2026-02-27', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(65, 2, 1, '2026-01-16', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(66, 2, 1, '2026-03-02', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(67, 2, 1, '2026-01-18', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(68, 2, 1, '2026-01-27', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(69, 2, 1, '2026-03-07', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(70, 2, 1, '2026-01-10', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(71, 2, 1, '2026-01-15', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(72, 2, 1, '2026-01-11', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(73, 2, 1, '2026-01-23', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(74, 2, 1, '2026-02-15', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(75, 2, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(76, 2, 1, '2026-02-12', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(77, 2, 1, '2026-01-26', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(78, 2, 1, '2026-02-25', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(79, 2, 1, '2026-01-15', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(80, 2, 1, '2026-03-06', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(81, 3, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(82, 3, 1, '2026-02-17', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(83, 3, 1, '2026-02-24', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(84, 3, 1, '2026-01-19', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(85, 3, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(86, 3, 1, '2026-01-17', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(87, 3, 1, '2026-01-24', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(88, 3, 1, '2026-02-21', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(89, 3, 1, '2026-02-15', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(90, 3, 1, '2026-03-01', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(91, 3, 1, '2026-02-16', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(92, 3, 1, '2026-01-27', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(93, 3, 1, '2026-02-23', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(94, 3, 1, '2026-03-02', 'absent', 'Absent', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(95, 3, 1, '2026-02-02', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(96, 3, 1, '2026-02-15', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(97, 3, 1, '2026-03-10', 'late', 'Always Late', '2026-03-11 07:27:10', '2026-03-12 19:33:49'),
(98, 3, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(99, 3, 1, '2026-03-03', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(100, 3, 1, '2026-02-19', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(101, 3, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(102, 3, 1, '2026-03-06', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(103, 3, 1, '2026-02-25', 'present', 'Present', '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(104, 3, 1, '2026-02-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(105, 3, 1, '2026-02-17', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(106, 3, 1, '2026-02-23', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(107, 3, 1, '2026-02-27', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(108, 3, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(109, 3, 1, '2026-03-04', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(110, 3, 1, '2026-02-18', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(111, 3, 1, '2026-01-19', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(112, 3, 1, '2026-02-28', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(113, 3, 1, '2026-01-18', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(114, 3, 1, '2026-02-08', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(115, 3, 1, '2026-01-20', 'absent', 'Medical leave', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(116, 3, 1, '2026-02-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(117, 3, 1, '2026-02-25', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(118, 3, 1, '2026-01-18', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(119, 3, 1, '2026-02-18', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(120, 3, 1, '2026-02-17', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(121, 4, 1, '2026-03-06', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(122, 4, 1, '2026-01-23', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(123, 4, 1, '2026-02-26', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(124, 4, 1, '2026-02-19', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(125, 4, 1, '2026-03-08', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(126, 4, 1, '2026-02-05', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(127, 4, 1, '2026-02-06', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(128, 4, 1, '2026-02-12', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(129, 4, 1, '2026-03-01', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(130, 4, 1, '2026-03-01', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(131, 4, 1, '2026-02-03', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(132, 4, 1, '2026-01-18', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(133, 4, 1, '2026-02-24', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(134, 4, 1, '2026-02-22', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(135, 4, 1, '2026-01-31', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(136, 4, 1, '2026-02-09', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(137, 4, 1, '2026-03-04', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(138, 4, 1, '2026-02-28', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(139, 4, 1, '2026-03-07', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(140, 4, 1, '2026-02-25', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(141, 4, 1, '2026-02-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(142, 4, 1, '2026-02-19', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(143, 4, 1, '2026-03-08', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(144, 4, 1, '2026-01-20', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(145, 4, 1, '2026-01-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(146, 4, 1, '2026-02-01', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(147, 4, 1, '2026-03-09', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(148, 4, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(149, 4, 1, '2026-02-07', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(150, 4, 1, '2026-03-04', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(151, 4, 1, '2026-01-31', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(152, 4, 1, '2026-02-07', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(153, 4, 1, '2026-02-14', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(154, 4, 1, '2026-02-06', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(155, 4, 1, '2026-01-11', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(156, 4, 1, '2026-02-28', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(157, 4, 1, '2026-02-03', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(158, 4, 1, '2026-02-17', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(159, 4, 1, '2026-02-16', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(160, 4, 1, '2026-03-02', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(161, 5, 1, '2026-01-30', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(162, 5, 1, '2026-01-17', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(163, 5, 1, '2026-02-25', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(164, 5, 1, '2026-02-26', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(165, 5, 1, '2026-03-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(166, 5, 1, '2026-02-11', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(167, 5, 1, '2026-01-11', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(168, 5, 1, '2026-02-15', 'absent', 'Medical leave', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(169, 5, 1, '2026-02-24', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(170, 5, 1, '2026-02-09', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(171, 5, 1, '2026-02-05', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(172, 5, 1, '2026-02-25', 'absent', 'Medical leave', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(173, 5, 1, '2026-03-10', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(174, 5, 1, '2026-02-26', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(175, 5, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(176, 5, 1, '2026-03-02', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(177, 5, 1, '2026-01-25', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(178, 5, 1, '2026-01-11', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(179, 5, 1, '2026-02-19', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(180, 5, 1, '2026-03-04', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(181, 5, 1, '2026-01-15', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(182, 5, 1, '2026-02-21', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(183, 5, 1, '2026-02-24', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(184, 5, 1, '2026-01-31', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(185, 5, 1, '2026-02-06', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(186, 5, 1, '2026-02-11', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(187, 5, 1, '2026-01-22', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(188, 5, 1, '2026-01-21', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(189, 5, 1, '2026-01-22', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(190, 5, 1, '2026-01-20', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(191, 5, 1, '2026-01-16', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(192, 5, 1, '2026-02-18', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(193, 5, 1, '2026-01-10', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(194, 5, 1, '2026-03-01', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(195, 5, 1, '2026-02-15', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(196, 5, 1, '2026-02-01', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(197, 5, 1, '2026-01-29', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(198, 5, 1, '2026-01-18', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(199, 5, 1, '2026-03-08', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(200, 5, 1, '2026-01-16', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(201, 6, 1, '2026-02-08', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(202, 6, 1, '2026-02-05', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(203, 6, 1, '2026-02-24', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(204, 6, 1, '2026-01-31', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(205, 6, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(206, 6, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(207, 6, 1, '2026-01-14', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(208, 6, 1, '2026-01-27', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(209, 6, 1, '2026-03-04', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(210, 6, 1, '2026-02-08', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(211, 6, 1, '2026-02-10', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(212, 6, 1, '2026-03-05', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(213, 6, 1, '2026-01-28', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(214, 6, 1, '2026-02-06', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(215, 6, 1, '2026-02-05', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(216, 6, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(217, 6, 1, '2026-01-19', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(218, 6, 1, '2026-02-06', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(219, 6, 1, '2026-02-02', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(220, 6, 1, '2026-03-08', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(221, 6, 1, '2026-02-22', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(222, 6, 1, '2026-02-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(223, 6, 1, '2026-01-14', 'absent', 'Medical leave', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(224, 6, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(225, 6, 1, '2026-03-09', 'absent', 'Absenttttttttttttttttttttttttt', '2026-03-11 07:27:11', '2026-03-12 19:41:52'),
(226, 6, 1, '2026-01-21', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(227, 6, 1, '2026-01-21', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(228, 6, 1, '2026-03-03', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(229, 6, 1, '2026-01-11', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(230, 6, 1, '2026-02-01', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(231, 6, 1, '2026-01-19', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(232, 6, 1, '2026-02-19', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(233, 6, 1, '2026-01-12', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(234, 6, 1, '2026-02-06', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(235, 6, 1, '2026-02-19', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(236, 6, 1, '2026-02-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(237, 6, 1, '2026-02-15', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(238, 6, 1, '2026-02-06', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(239, 6, 1, '2026-01-10', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(240, 6, 1, '2026-01-28', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(241, 7, 1, '2026-02-22', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(242, 7, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(243, 7, 1, '2026-01-26', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(244, 7, 1, '2026-01-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(245, 7, 1, '2026-02-01', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(246, 7, 1, '2026-01-21', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(247, 7, 1, '2026-02-02', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(248, 7, 1, '2026-02-19', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(249, 7, 1, '2026-02-24', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(250, 7, 1, '2026-02-12', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(251, 7, 1, '2026-02-27', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(252, 7, 1, '2026-01-30', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(253, 7, 1, '2026-01-26', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(254, 7, 1, '2026-02-08', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(255, 7, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(256, 7, 1, '2026-02-26', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(257, 7, 1, '2026-02-16', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(258, 7, 1, '2026-01-23', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(259, 7, 1, '2026-01-15', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(260, 7, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(261, 7, 1, '2026-03-08', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(262, 7, 1, '2026-02-06', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(263, 7, 1, '2026-01-16', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(264, 7, 1, '2026-03-03', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(265, 7, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(266, 7, 1, '2026-01-14', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(267, 7, 1, '2026-03-05', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(268, 7, 1, '2026-02-15', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(269, 7, 1, '2026-02-12', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(270, 7, 1, '2026-01-19', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(271, 7, 1, '2026-02-20', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(272, 7, 1, '2026-03-01', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(273, 7, 1, '2026-02-09', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(274, 7, 1, '2026-02-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(275, 7, 1, '2026-02-23', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(276, 7, 1, '2026-01-25', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(277, 7, 1, '2026-02-07', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(278, 7, 1, '2026-01-14', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(279, 7, 1, '2026-03-06', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(280, 7, 1, '2026-02-20', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(281, 8, 1, '2026-03-05', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(282, 8, 1, '2026-03-05', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(283, 8, 1, '2026-03-01', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(284, 8, 1, '2026-01-23', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(285, 8, 1, '2026-02-17', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(286, 8, 1, '2026-02-20', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(287, 8, 1, '2026-01-12', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(288, 8, 1, '2026-01-30', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(289, 8, 1, '2026-01-14', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(290, 8, 1, '2026-02-02', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(291, 8, 1, '2026-02-26', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(292, 8, 1, '2026-02-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(293, 8, 1, '2026-02-22', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(294, 8, 1, '2026-02-15', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(295, 8, 1, '2026-01-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(296, 8, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(297, 8, 1, '2026-03-09', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(298, 8, 1, '2026-02-06', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(299, 8, 1, '2026-01-15', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(300, 8, 1, '2026-01-24', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(301, 8, 1, '2026-02-17', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(302, 8, 1, '2026-02-27', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(303, 8, 1, '2026-01-28', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(304, 8, 1, '2026-01-14', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(305, 8, 1, '2026-02-16', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(306, 8, 1, '2026-02-27', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(307, 8, 1, '2026-02-28', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(308, 8, 1, '2026-02-18', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(309, 8, 1, '2026-01-18', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(310, 8, 1, '2026-02-06', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(311, 8, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(312, 8, 1, '2026-01-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(313, 8, 1, '2026-01-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(314, 8, 1, '2026-02-28', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(315, 8, 1, '2026-02-12', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(316, 8, 1, '2026-02-08', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(317, 8, 1, '2026-02-09', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(318, 8, 1, '2026-03-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(319, 8, 1, '2026-02-05', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(320, 8, 1, '2026-02-28', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(321, 9, 1, '2026-02-14', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(322, 9, 1, '2026-02-07', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(323, 9, 1, '2026-02-19', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(324, 9, 1, '2026-01-19', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(325, 9, 1, '2026-02-20', 'absent', 'Medical leave', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(326, 9, 1, '2026-02-23', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(327, 9, 1, '2026-02-23', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(328, 9, 1, '2026-01-21', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(329, 9, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(330, 9, 1, '2026-02-19', 'absent', 'Medical leave', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(331, 9, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(332, 9, 1, '2026-03-08', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(333, 9, 1, '2026-01-15', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(334, 9, 1, '2026-02-25', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(335, 9, 1, '2026-01-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(336, 9, 1, '2026-02-13', 'absent', 'Medical leave', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(337, 9, 1, '2026-02-13', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(338, 9, 1, '2026-02-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(339, 9, 1, '2026-01-21', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(340, 9, 1, '2026-01-26', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(341, 9, 1, '2026-02-26', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(342, 9, 1, '2026-01-30', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(343, 9, 1, '2026-02-21', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(344, 9, 1, '2026-01-24', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(345, 9, 1, '2026-02-23', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(346, 9, 1, '2026-01-18', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(347, 9, 1, '2026-02-16', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(348, 9, 1, '2026-03-03', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(349, 9, 1, '2026-01-13', 'absent', 'Medical leave', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(350, 9, 1, '2026-02-05', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(351, 9, 1, '2026-02-03', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(352, 9, 1, '2026-02-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(353, 9, 1, '2026-01-28', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(354, 9, 1, '2026-02-26', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(355, 9, 1, '2026-02-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(356, 9, 1, '2026-02-27', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(357, 9, 1, '2026-02-21', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(358, 9, 1, '2026-02-16', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(359, 9, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(360, 9, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(361, 10, 1, '2026-02-24', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(362, 10, 1, '2026-01-18', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(363, 10, 1, '2026-02-24', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(364, 10, 1, '2026-01-12', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(365, 10, 1, '2026-02-12', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(366, 10, 1, '2026-03-09', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(367, 10, 1, '2026-02-09', 'absent', 'Medical leave', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(368, 10, 1, '2026-02-04', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(369, 10, 1, '2026-03-01', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(370, 10, 1, '2026-01-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(371, 10, 1, '2026-01-30', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(372, 10, 1, '2026-02-01', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(373, 10, 1, '2026-01-24', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(374, 10, 1, '2026-01-11', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(375, 10, 1, '2026-02-12', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(376, 10, 1, '2026-02-13', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(377, 10, 1, '2026-03-01', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(378, 10, 1, '2026-01-30', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(379, 10, 1, '2026-02-13', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(380, 10, 1, '2026-02-24', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(381, 10, 1, '2026-02-26', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(382, 10, 1, '2026-01-10', 'absent', 'Medical leave', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(383, 10, 1, '2026-02-12', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(384, 10, 1, '2026-03-03', 'absent', 'Medical leave', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(385, 10, 1, '2026-02-11', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(386, 10, 1, '2026-02-22', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(387, 10, 1, '2026-01-23', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(388, 10, 1, '2026-01-29', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(389, 10, 1, '2026-01-15', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(390, 10, 1, '2026-02-19', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(391, 10, 1, '2026-03-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(392, 10, 1, '2026-02-15', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(393, 10, 1, '2026-02-09', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(394, 10, 1, '2026-01-20', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(395, 10, 1, '2026-01-11', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(396, 10, 1, '2026-02-06', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(397, 10, 1, '2026-01-17', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(398, 10, 1, '2026-02-06', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(399, 10, 1, '2026-03-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(400, 10, 1, '2026-02-05', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(401, 11, 1, '2026-02-28', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(402, 11, 1, '2026-02-11', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(403, 11, 1, '2026-01-24', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(404, 11, 1, '2026-03-02', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(405, 11, 1, '2026-02-14', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(406, 11, 1, '2026-01-12', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(407, 11, 1, '2026-01-15', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(408, 11, 1, '2026-02-18', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(409, 11, 1, '2026-01-20', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(410, 11, 1, '2026-01-17', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(411, 11, 1, '2026-01-17', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(412, 11, 1, '2026-03-05', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(413, 11, 1, '2026-01-22', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(414, 11, 1, '2026-01-27', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(415, 11, 1, '2026-02-20', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(416, 11, 1, '2026-02-07', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(417, 11, 1, '2026-02-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(418, 11, 1, '2026-01-11', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(419, 11, 1, '2026-01-27', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(420, 11, 1, '2026-02-21', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(421, 11, 1, '2026-01-30', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(422, 11, 1, '2026-01-31', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(423, 11, 1, '2026-03-03', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(424, 11, 1, '2026-02-02', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(425, 11, 1, '2026-02-16', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(426, 11, 1, '2026-01-19', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(427, 11, 1, '2026-02-08', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(428, 11, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(429, 11, 1, '2026-01-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(430, 11, 1, '2026-03-05', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(431, 11, 1, '2026-03-05', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(432, 11, 1, '2026-02-13', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(433, 11, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(434, 11, 1, '2026-03-08', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(435, 11, 1, '2026-02-18', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(436, 11, 1, '2026-03-06', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(437, 11, 1, '2026-01-15', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(438, 11, 1, '2026-02-28', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(439, 11, 1, '2026-01-16', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(440, 11, 1, '2026-01-18', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(441, 12, 1, '2026-02-17', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(442, 12, 1, '2026-02-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(443, 12, 1, '2026-01-31', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(444, 12, 1, '2026-02-07', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(445, 12, 1, '2026-03-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(446, 12, 1, '2026-02-18', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(447, 12, 1, '2026-01-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(448, 12, 1, '2026-03-09', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(449, 12, 1, '2026-02-18', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(450, 12, 1, '2026-01-31', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(451, 12, 1, '2026-03-06', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(452, 12, 1, '2026-02-24', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(453, 12, 1, '2026-01-30', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(454, 12, 1, '2026-01-18', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(455, 12, 1, '2026-02-01', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(456, 12, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(457, 12, 1, '2026-02-07', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(458, 12, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(459, 12, 1, '2026-02-02', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(460, 12, 1, '2026-02-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(461, 12, 1, '2026-02-27', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(462, 12, 1, '2026-03-09', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(463, 12, 1, '2026-02-04', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(464, 12, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(465, 12, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(466, 12, 1, '2026-02-28', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(467, 12, 1, '2026-02-26', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(468, 12, 1, '2026-02-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(469, 12, 1, '2026-01-23', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(470, 12, 1, '2026-02-03', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(471, 12, 1, '2026-01-30', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(472, 12, 1, '2026-01-18', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(473, 12, 1, '2026-02-08', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(474, 12, 1, '2026-02-26', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(475, 12, 1, '2026-03-07', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(476, 12, 1, '2026-02-26', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(477, 12, 1, '2026-02-21', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(478, 12, 1, '2026-02-14', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(479, 12, 1, '2026-03-01', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(480, 12, 1, '2026-01-26', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(481, 13, 1, '2026-03-01', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(482, 13, 1, '2026-02-16', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(483, 13, 1, '2026-01-17', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(484, 13, 1, '2026-02-01', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(485, 13, 1, '2026-02-05', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(486, 13, 1, '2026-01-16', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(487, 13, 1, '2026-02-02', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(488, 13, 1, '2026-01-14', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(489, 13, 1, '2026-02-25', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(490, 13, 1, '2026-01-20', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(491, 13, 1, '2026-02-04', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(492, 13, 1, '2026-02-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(493, 13, 1, '2026-01-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(494, 13, 1, '2026-01-30', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(495, 13, 1, '2026-02-24', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(496, 13, 1, '2026-02-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(497, 13, 1, '2026-02-28', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(498, 13, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(499, 13, 1, '2026-01-22', 'absent', 'Medical leave', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(500, 13, 1, '2026-02-18', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(501, 13, 1, '2026-01-17', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(502, 13, 1, '2026-02-10', 'absent', 'Medical leave', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(503, 13, 1, '2026-03-02', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(504, 13, 1, '2026-02-12', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(505, 13, 1, '2026-02-06', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(506, 13, 1, '2026-01-14', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(507, 13, 1, '2026-01-30', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(508, 13, 1, '2026-02-20', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(509, 13, 1, '2026-01-21', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(510, 13, 1, '2026-02-04', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(511, 13, 1, '2026-03-01', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(512, 13, 1, '2026-03-01', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(513, 13, 1, '2026-01-12', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(514, 13, 1, '2026-02-27', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(515, 13, 1, '2026-02-09', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(516, 13, 1, '2026-02-23', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(517, 13, 1, '2026-01-28', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(518, 13, 1, '2026-02-14', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(519, 13, 1, '2026-02-25', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(520, 13, 1, '2026-03-05', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(521, 14, 1, '2026-01-11', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(522, 14, 1, '2026-02-05', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(523, 14, 1, '2026-02-20', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(524, 14, 1, '2026-02-20', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(525, 14, 1, '2026-02-11', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(526, 14, 1, '2026-01-23', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(527, 14, 1, '2026-02-23', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(528, 14, 1, '2026-03-10', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(529, 14, 1, '2026-02-25', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(530, 14, 1, '2026-02-25', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(531, 14, 1, '2026-01-14', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(532, 14, 1, '2026-02-17', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(533, 14, 1, '2026-01-14', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(534, 14, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(535, 14, 1, '2026-02-22', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(536, 14, 1, '2026-02-17', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(537, 14, 1, '2026-02-14', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11');
INSERT INTO `attendance` (`id`, `student_id`, `course_id`, `attendance_date`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(538, 14, 1, '2026-02-02', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(539, 14, 1, '2026-02-11', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(540, 14, 1, '2026-01-12', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(541, 14, 1, '2026-02-03', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(542, 14, 1, '2026-01-21', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(543, 14, 1, '2026-02-27', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(544, 14, 1, '2026-01-24', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(545, 14, 1, '2026-03-05', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(546, 14, 1, '2026-01-12', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(547, 14, 1, '2026-01-13', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(548, 14, 1, '2026-01-11', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(549, 14, 1, '2026-01-23', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(550, 14, 1, '2026-02-28', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(551, 14, 1, '2026-02-15', 'absent', 'Absent', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(552, 14, 1, '2026-01-17', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(553, 14, 1, '2026-01-19', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(554, 14, 1, '2026-02-15', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(555, 14, 1, '2026-01-16', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(556, 14, 1, '2026-02-14', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(557, 14, 1, '2026-02-17', 'present', 'Present', '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(558, 14, 1, '2026-02-03', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(559, 14, 1, '2026-02-25', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(560, 14, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(561, 15, 1, '2026-01-11', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(562, 15, 1, '2026-01-17', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(563, 15, 1, '2026-02-17', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(564, 15, 1, '2026-01-10', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(565, 15, 1, '2026-01-25', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(566, 15, 1, '2026-03-05', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(567, 15, 1, '2026-01-18', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(568, 15, 1, '2026-02-12', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(569, 15, 1, '2026-01-17', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(570, 15, 1, '2026-01-15', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(571, 15, 1, '2026-03-07', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(572, 15, 1, '2026-01-26', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(573, 15, 1, '2026-01-13', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(574, 15, 1, '2026-02-20', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(575, 15, 1, '2026-01-10', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(576, 15, 1, '2026-02-20', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(577, 15, 1, '2026-01-18', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(578, 15, 1, '2026-03-02', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(579, 15, 1, '2026-01-30', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(580, 15, 1, '2026-02-02', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(581, 15, 1, '2026-03-01', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(582, 15, 1, '2026-03-07', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(583, 15, 1, '2026-01-26', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(584, 15, 1, '2026-02-05', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(585, 15, 1, '2026-02-02', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(586, 15, 1, '2026-03-06', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(587, 15, 1, '2026-02-18', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(588, 15, 1, '2026-01-11', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(589, 15, 1, '2026-02-17', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(590, 15, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(591, 15, 1, '2026-01-13', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(592, 15, 1, '2026-03-06', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(593, 15, 1, '2026-02-18', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(594, 15, 1, '2026-01-13', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(595, 15, 1, '2026-02-28', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(596, 15, 1, '2026-01-21', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(597, 15, 1, '2026-02-12', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(598, 15, 1, '2026-01-19', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(599, 15, 1, '2026-01-17', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(600, 15, 1, '2026-02-05', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(601, 16, 1, '2026-01-31', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(602, 16, 1, '2026-02-13', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(603, 16, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(604, 16, 1, '2026-01-28', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(605, 16, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(606, 16, 1, '2026-02-09', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(607, 16, 1, '2026-01-16', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(608, 16, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(609, 16, 1, '2026-01-31', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(610, 16, 1, '2026-01-18', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(611, 16, 1, '2026-02-07', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(612, 16, 1, '2026-01-10', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(613, 16, 1, '2026-01-12', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(614, 16, 1, '2026-01-25', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(615, 16, 1, '2026-02-20', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(616, 16, 1, '2026-02-26', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(617, 16, 1, '2026-01-17', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(618, 16, 1, '2026-03-01', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(619, 16, 1, '2026-02-02', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(620, 16, 1, '2026-02-26', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(621, 16, 1, '2026-02-12', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(622, 16, 1, '2026-01-30', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(623, 16, 1, '2026-02-12', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(624, 16, 1, '2026-02-05', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(625, 16, 1, '2026-01-23', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(626, 16, 1, '2026-02-12', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(627, 16, 1, '2026-01-23', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(628, 16, 1, '2026-02-04', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(629, 16, 1, '2026-02-08', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(630, 16, 1, '2026-03-03', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(631, 16, 1, '2026-03-03', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(632, 16, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(633, 16, 1, '2026-01-10', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(634, 16, 1, '2026-01-14', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(635, 16, 1, '2026-02-10', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(636, 16, 1, '2026-02-25', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(637, 16, 1, '2026-01-23', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(638, 16, 1, '2026-02-14', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(639, 16, 1, '2026-03-06', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(640, 16, 1, '2026-02-04', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(641, 17, 1, '2026-02-05', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(642, 17, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(643, 17, 1, '2026-03-07', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(644, 17, 1, '2026-01-30', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(645, 17, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(646, 17, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(647, 17, 1, '2026-02-08', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(648, 17, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(649, 17, 1, '2026-02-02', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(650, 17, 1, '2026-02-24', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(651, 17, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(652, 17, 1, '2026-01-21', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(653, 17, 1, '2026-03-02', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(654, 17, 1, '2026-02-18', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(655, 17, 1, '2026-02-24', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(656, 17, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(657, 17, 1, '2026-01-27', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(658, 17, 1, '2026-03-01', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(659, 17, 1, '2026-02-06', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(660, 17, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(661, 17, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(662, 17, 1, '2026-02-04', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(663, 17, 1, '2026-02-05', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(664, 17, 1, '2026-02-25', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(665, 17, 1, '2026-02-18', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(666, 17, 1, '2026-02-07', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(667, 17, 1, '2026-01-14', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(668, 17, 1, '2026-02-14', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(669, 17, 1, '2026-03-04', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(670, 17, 1, '2026-02-04', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(671, 17, 1, '2026-03-09', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(672, 17, 1, '2026-01-29', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(673, 17, 1, '2026-01-26', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(674, 17, 1, '2026-03-10', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(675, 17, 1, '2026-02-13', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(676, 17, 1, '2026-01-16', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(677, 17, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(678, 17, 1, '2026-01-19', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(679, 17, 1, '2026-03-07', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(680, 17, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(681, 18, 1, '2026-01-23', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(682, 18, 1, '2026-02-15', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(683, 18, 1, '2026-03-08', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(684, 18, 1, '2026-01-15', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(685, 18, 1, '2026-02-23', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(686, 18, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(687, 18, 1, '2026-02-22', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(688, 18, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(689, 18, 1, '2026-01-17', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(690, 18, 1, '2026-03-01', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(691, 18, 1, '2026-02-06', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(692, 18, 1, '2026-01-12', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(693, 18, 1, '2026-02-28', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(694, 18, 1, '2026-01-10', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(695, 18, 1, '2026-02-02', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(696, 18, 1, '2026-01-24', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(697, 18, 1, '2026-01-19', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(698, 18, 1, '2026-03-03', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(699, 18, 1, '2026-02-13', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(700, 18, 1, '2026-02-19', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(701, 18, 1, '2026-03-09', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(702, 18, 1, '2026-02-20', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(703, 18, 1, '2026-01-10', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(704, 18, 1, '2026-02-04', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(705, 18, 1, '2026-01-24', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(706, 18, 1, '2026-02-05', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(707, 18, 1, '2026-01-25', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(708, 18, 1, '2026-01-21', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(709, 18, 1, '2026-02-09', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(710, 18, 1, '2026-03-07', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(711, 18, 1, '2026-01-17', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(712, 18, 1, '2026-02-03', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(713, 18, 1, '2026-02-08', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(714, 18, 1, '2026-01-23', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(715, 18, 1, '2026-02-25', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(716, 18, 1, '2026-02-23', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(717, 18, 1, '2026-03-10', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(718, 18, 1, '2026-02-20', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(719, 18, 1, '2026-02-15', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(720, 18, 1, '2026-01-25', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(721, 19, 1, '2026-02-14', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(722, 19, 1, '2026-03-05', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(723, 19, 1, '2026-02-17', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(724, 19, 1, '2026-03-06', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(725, 19, 1, '2026-03-03', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(726, 19, 1, '2026-02-18', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(727, 19, 1, '2026-03-03', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(728, 19, 1, '2026-02-10', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(729, 19, 1, '2026-02-14', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(730, 19, 1, '2026-03-09', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(731, 19, 1, '2026-03-01', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(732, 19, 1, '2026-02-15', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(733, 19, 1, '2026-02-13', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(734, 19, 1, '2026-02-12', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(735, 19, 1, '2026-01-20', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(736, 19, 1, '2026-01-27', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(737, 19, 1, '2026-03-09', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(738, 19, 1, '2026-02-27', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(739, 19, 1, '2026-01-31', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(740, 19, 1, '2026-02-15', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(741, 19, 1, '2026-02-16', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(742, 19, 1, '2026-01-26', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(743, 19, 1, '2026-01-28', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(744, 19, 1, '2026-01-31', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(745, 19, 1, '2026-03-04', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(746, 19, 1, '2026-01-10', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(747, 19, 1, '2026-01-14', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(748, 19, 1, '2026-02-28', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(749, 19, 1, '2026-02-18', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(750, 19, 1, '2026-02-16', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(751, 19, 1, '2026-02-17', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(752, 19, 1, '2026-03-07', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(753, 19, 1, '2026-02-03', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(754, 19, 1, '2026-02-20', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(755, 19, 1, '2026-02-26', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(756, 19, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(757, 19, 1, '2026-02-24', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(758, 19, 1, '2026-01-25', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(759, 19, 1, '2026-03-05', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(760, 19, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(761, 20, 1, '2026-01-14', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(762, 20, 1, '2026-02-05', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(763, 20, 1, '2026-02-09', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(764, 20, 1, '2026-01-10', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(765, 20, 1, '2026-02-01', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(766, 20, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(767, 20, 1, '2026-01-16', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(768, 20, 1, '2026-01-21', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(769, 20, 1, '2026-01-26', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(770, 20, 1, '2026-02-02', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(771, 20, 1, '2026-02-14', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(772, 20, 1, '2026-03-02', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(773, 20, 1, '2026-01-14', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(774, 20, 1, '2026-02-02', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(775, 20, 1, '2026-02-19', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(776, 20, 1, '2026-01-14', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(777, 20, 1, '2026-02-11', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(778, 20, 1, '2026-02-10', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(779, 20, 1, '2026-01-13', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(780, 20, 1, '2026-01-18', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(781, 20, 1, '2026-02-15', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(782, 20, 1, '2026-02-26', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(783, 20, 1, '2026-02-21', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(784, 20, 1, '2026-01-27', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(785, 20, 1, '2026-01-28', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(786, 20, 1, '2026-01-19', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(787, 20, 1, '2026-02-10', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(788, 20, 1, '2026-02-11', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(789, 20, 1, '2026-02-13', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(790, 20, 1, '2026-02-25', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(791, 20, 1, '2026-02-06', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(792, 20, 1, '2026-01-27', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(793, 20, 1, '2026-01-16', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(794, 20, 1, '2026-02-23', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(795, 20, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(796, 20, 1, '2026-01-18', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(797, 20, 1, '2026-01-27', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(798, 20, 1, '2026-01-28', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(799, 20, 1, '2026-01-16', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(800, 20, 1, '2026-02-17', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(801, 21, 1, '2026-01-10', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(802, 21, 1, '2026-01-29', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(803, 21, 1, '2026-03-07', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(804, 21, 1, '2026-02-06', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(805, 21, 1, '2026-02-15', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(806, 21, 1, '2026-02-04', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(807, 21, 1, '2026-02-18', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(808, 21, 1, '2026-03-10', 'present', 'prsent', '2026-03-11 07:27:12', '2026-03-13 03:53:51'),
(809, 21, 1, '2026-02-17', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(810, 21, 1, '2026-03-01', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(811, 21, 1, '2026-03-10', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(812, 21, 1, '2026-03-05', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(813, 21, 1, '2026-02-15', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(814, 21, 1, '2026-03-07', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(815, 21, 1, '2026-01-27', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(816, 21, 1, '2026-03-03', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(817, 21, 1, '2026-02-02', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(818, 21, 1, '2026-02-27', 'absent', 'Medical leave', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(819, 21, 1, '2026-02-18', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(820, 21, 1, '2026-03-05', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(821, 21, 1, '2026-02-10', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(822, 21, 1, '2026-01-31', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(823, 21, 1, '2026-02-23', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(824, 21, 1, '2026-02-20', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(825, 21, 1, '2026-01-22', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(826, 21, 1, '2026-01-28', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(827, 21, 1, '2026-02-03', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(828, 21, 1, '2026-02-01', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(829, 21, 1, '2026-02-19', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(830, 21, 1, '2026-03-10', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(831, 21, 1, '2026-01-28', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(832, 21, 1, '2026-02-08', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(833, 21, 1, '2026-01-19', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(834, 21, 1, '2026-03-03', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(835, 21, 1, '2026-01-15', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(836, 21, 1, '2026-02-17', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(837, 21, 1, '2026-03-07', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(838, 21, 1, '2026-03-04', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(839, 21, 1, '2026-03-03', 'present', 'Present', '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(840, 21, 1, '2026-01-19', 'absent', 'Absent', '2026-03-11 07:27:12', '2026-03-11 07:27:12');

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
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `credits` int(11) NOT NULL,
  `faculty_id` bigint(20) UNSIGNED NOT NULL,
  `semester` varchar(255) NOT NULL,
  `total_classes` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_name`, `description`, `credits`, `faculty_id`, `semester`, `total_classes`, `created_at`, `updated_at`) VALUES
(1, 'CS201', 'Database Systems', 'Learn advanced database concepts', 4, 1, '4', 40, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(2, 'CS202', 'Web Development', 'Modern web development techniques', 3, 2, '4', 35, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(3, 'MCA101', 'Data Structures and Algorithms', 'Advanced concepts in data structures and algorithm design', 4, 2, '1', 40, '2026-03-12 18:47:52', '2026-03-12 18:47:52'),
(4, 'MCA102', 'Database Management Systems', 'Relational and non-relational database concepts', 4, 2, '1', 40, '2026-03-12 18:47:52', '2026-03-12 18:47:52'),
(5, 'MCA103', 'Web Development Fundamentals', 'HTML, CSS, JavaScript and web frameworks', 3, 2, '1', 35, '2026-03-12 18:47:52', '2026-03-12 18:47:52'),
(6, 'MCA201', 'Advanced Java Programming', 'OOP concepts, design patterns, and enterprise Java', 4, 2, '2', 40, '2026-03-12 18:47:52', '2026-03-12 18:47:52'),
(7, 'MCA202', 'Software Engineering', 'Software development lifecycle, design patterns, and methodologies', 4, 2, '2', 40, '2026-03-12 18:47:52', '2026-03-12 18:47:52'),
(8, 'MCA203', 'Machine Learning Basics', 'Introduction to ML algorithms and applications', 3, 2, '2', 35, '2026-03-12 18:47:52', '2026-03-12 18:47:52');

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `status` enum('pending','sent','failed') NOT NULL DEFAULT 'pending',
  `error_message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_logs`
--

INSERT INTO `email_logs` (`id`, `sender_id`, `receiver_email`, `subject`, `message`, `status`, `error_message`, `created_at`, `updated_at`, `sent_at`) VALUES
(10, 1, 'wwwbvndksowmika@gmail.com', 'Academic Performance', 'Great job! Your consistent performance is commendable. Keep maintaining this excellence.', 'sent', NULL, '2026-03-12 11:44:40', '2026-03-12 11:44:40', '2026-03-12 11:44:40'),
(11, 27, 'wwwbvndksowmika@gmail.com', 'Exam Notification', 'The upcoming exam is scheduled on the announced date. Please prepare well and review all covered topics.', 'sent', NULL, '2026-03-12 12:10:05', '2026-03-12 12:10:05', '2026-03-12 12:10:05'),
(12, 27, 'kowshikboggavarapu@gmail.com', 'Assignment Reminder', 'Please submit your pending assignments by the deadline. Contact me if you need any clarification.', 'sent', NULL, '2026-03-12 17:45:23', '2026-03-12 17:45:23', '2026-03-12 17:45:23'),
(13, 1, 'kowshikboggavarapu@gmail.com', 'Low Grades Alert', 'Your recent grades are below average. I recommend meeting during office hours to discuss your progress.', 'sent', NULL, '2026-03-12 18:28:20', '2026-03-12 18:28:20', '2026-03-12 18:28:20'),
(14, 27, 'kowshikboggavarapu@gmail.com', 'Academic Performance', 'Great job! Your consistent performance is commendable. Keep maintaining this excellence.', 'sent', NULL, '2026-03-12 18:38:11', '2026-03-12 18:38:11', '2026-03-12 18:38:11'),
(15, 2, 'bvsaiganesh04@gmail.com', 'Class Announcement', 'Please note the important class announcement. Check your email regularly for course updates.', 'sent', NULL, '2026-03-12 19:31:24', '2026-03-12 19:31:24', '2026-03-12 19:31:24'),
(16, 27, 'bvsaiganesh9980@gmail.com', 'Academic Performance', 'Great job! Your consistent performance is commendable. Keep maintaining this excellence.', 'sent', NULL, '2026-03-12 20:23:00', '2026-03-12 20:23:00', '2026-03-12 20:23:00'),
(17, 27, 'wwwbvndksowmika@gmail.com', 'Exam Notification', 'The upcoming exam is scheduled on the announced date. Please prepare well and review all covered topics.', 'sent', NULL, '2026-03-13 03:50:33', '2026-03-13 03:50:33', '2026-03-13 03:50:33'),
(18, 27, 'wwwbvndksowmika@gmail.com', 'Exam Notification', 'The upcoming exam is scheduled on the announced date. Please prepare well and review all covered topics.', 'sent', NULL, '2026-03-13 03:50:42', '2026-03-13 03:50:42', '2026-03-13 03:50:42'),
(19, 1, 'wwwbvndksowmika@gmail.com', 'Exam Notification', 'The upcoming exam is scheduled on the announced date. Please prepare well and review all covered topics.', 'sent', NULL, '2026-03-13 09:52:37', '2026-03-13 09:52:37', '2026-03-13 09:52:37'),
(20, 1, 'wwwbvndksowmika@gmail.com', 'Exam Notification', 'The upcoming exam is scheduled on the announced date. Please prepare well and review all covered topics.', 'sent', NULL, '2026-03-13 09:52:46', '2026-03-13 09:52:46', '2026-03-13 09:52:46');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('enrolled','dropped','completed') NOT NULL DEFAULT 'enrolled',
  `enrollment_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `course_id`, `status`, `enrollment_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(2, 1, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(3, 2, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(4, 2, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(5, 3, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(6, 3, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(7, 4, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(8, 4, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(9, 5, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(10, 5, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(11, 6, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(12, 6, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(13, 7, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(14, 7, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(15, 8, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(16, 8, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(17, 9, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(18, 9, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(19, 10, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(20, 10, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(21, 11, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(22, 11, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(23, 12, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(24, 12, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(25, 13, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(26, 13, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(27, 14, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(28, 14, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(29, 15, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(30, 15, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(31, 16, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(32, 16, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(33, 17, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(34, 17, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(35, 18, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(36, 18, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(37, 19, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(38, 19, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(39, 20, 1, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(40, 20, 2, 'enrolled', '2025-12-09', '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(41, 22, 3, 'enrolled', '2026-03-13', '2026-03-12 18:47:52', '2026-03-12 18:47:52'),
(42, 22, 4, 'enrolled', '2026-03-13', '2026-03-12 18:47:52', '2026-03-12 18:47:52'),
(43, 22, 5, 'enrolled', '2026-03-13', '2026-03-12 18:47:52', '2026-03-12 18:47:52'),
(44, 22, 6, 'enrolled', '2026-03-13', '2026-03-12 18:47:52', '2026-03-12 18:47:52'),
(45, 22, 7, 'enrolled', '2026-03-13', '2026-03-12 18:47:52', '2026-03-12 18:47:52'),
(46, 22, 8, 'enrolled', '2026-03-13', '2026-03-12 18:47:52', '2026-03-12 18:47:52');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) NOT NULL,
  `experience_years` int(11) NOT NULL DEFAULT 0,
  `approval_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `max_students` int(11) NOT NULL DEFAULT 50,
  `rejection_reason` text DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `user_id`, `employee_id`, `department`, `specialization`, `qualification`, `experience_years`, `approval_status`, `max_students`, `rejection_reason`, `approved_at`, `approved_by`, `created_at`, `updated_at`, `department_id`) VALUES
(1, 2, 'FAC001', 'MCA', 'Database Systems', 'PhD Computer Science', 8, 'approved', 50, NULL, NULL, NULL, '2026-03-09 04:04:19', '2026-03-11 09:08:14', NULL),
(2, 3, 'FAC002', 'Computer Science', 'Web Development', 'Master of Technology', 5, 'approved', 50, NULL, NULL, NULL, '2026-03-09 04:04:19', '2026-03-11 09:08:14', NULL),
(3, 25, 'FAC025', 'Computer Science', 'General', 'Master of Technology', 5, 'approved', 50, NULL, NULL, NULL, '2026-03-11 08:50:34', '2026-03-11 09:08:14', NULL),
(5, 28, 'FAC010', 'MCA', 'Data Structures & Algorithms', 'Ph.D. in Computer Science', 12, 'approved', 50, NULL, NULL, NULL, '2026-03-12 19:45:14', '2026-03-12 19:45:14', NULL),
(6, 29, 'FAC011', 'MCA', 'Database Systems', 'M.Tech in Database Engineering', 10, 'approved', 50, NULL, NULL, NULL, '2026-03-12 19:45:14', '2026-03-12 19:45:14', NULL),
(7, 30, 'FAC012', 'MCA', 'Web Technologies', 'Ph.D. in Web Systems', 9, 'approved', 50, NULL, NULL, NULL, '2026-03-12 19:45:14', '2026-03-12 19:45:14', NULL),
(8, 31, 'FAC013', 'MCA', 'Software Engineering', 'M.Tech in Software Engineering', 8, 'approved', 50, NULL, NULL, NULL, '2026-03-12 19:45:15', '2026-03-12 19:45:15', NULL),
(9, 32, 'FAC014', 'MCA', 'Machine Learning', 'M.Tech in AI & Machine Learning', 7, 'approved', 50, NULL, NULL, NULL, '2026-03-12 19:45:15', '2026-03-12 19:45:15', NULL),
(10, 33, 'FAC015', 'MCA', 'Advanced Java Programming', 'B.Tech in Computer Science with Java Certification', 11, 'approved', 50, NULL, NULL, NULL, '2026-03-12 19:45:15', '2026-03-12 19:45:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_students`
--

CREATE TABLE `faculty_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `faculty_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_by_admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `assignment_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faculty_students`
--

INSERT INTO `faculty_students` (`id`, `faculty_id`, `student_id`, `assigned_by_admin_id`, `assigned_at`, `assignment_notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2026-03-11 14:43:28', NULL, '2026-03-11 09:13:28', '2026-03-11 09:13:28'),
(2, 1, 2, 1, '2026-03-11 14:43:28', NULL, '2026-03-11 09:13:28', '2026-03-11 09:13:28'),
(3, 1, 3, 1, '2026-03-11 14:43:29', NULL, '2026-03-11 09:13:29', '2026-03-11 09:13:29'),
(4, 1, 4, 1, '2026-03-11 14:43:29', NULL, '2026-03-11 09:13:29', '2026-03-11 09:13:29'),
(5, 1, 5, 1, '2026-03-11 14:43:29', NULL, '2026-03-11 09:13:29', '2026-03-11 09:13:29'),
(6, 1, 6, 1, '2026-03-11 14:43:29', NULL, '2026-03-11 09:13:29', '2026-03-11 09:13:29'),
(7, 1, 7, 1, '2026-03-11 14:43:29', NULL, '2026-03-11 09:13:29', '2026-03-11 09:13:29'),
(8, 1, 8, 1, '2026-03-11 14:43:29', NULL, '2026-03-11 09:13:29', '2026-03-11 09:13:29'),
(9, 1, 9, 1, '2026-03-11 14:43:29', NULL, '2026-03-11 09:13:29', '2026-03-11 09:13:29'),
(10, 1, 10, 1, '2026-03-11 14:43:29', NULL, '2026-03-11 09:13:29', '2026-03-11 09:13:29'),
(11, 2, 10, 1, '2026-03-11 14:44:20', NULL, '2026-03-11 09:14:20', '2026-03-11 09:14:20'),
(12, 2, 11, 1, '2026-03-11 14:44:20', NULL, '2026-03-11 09:14:20', '2026-03-11 09:14:20'),
(13, 2, 12, 1, '2026-03-11 14:44:20', NULL, '2026-03-11 09:14:20', '2026-03-11 09:14:20'),
(14, 2, 13, 1, '2026-03-11 14:44:20', NULL, '2026-03-11 09:14:20', '2026-03-11 09:14:20'),
(15, 2, 14, 1, '2026-03-11 14:44:20', NULL, '2026-03-11 09:14:20', '2026-03-11 09:14:20'),
(16, 2, 15, 1, '2026-03-11 14:44:20', NULL, '2026-03-11 09:14:20', '2026-03-11 09:14:20'),
(17, 2, 16, 1, '2026-03-11 14:44:20', NULL, '2026-03-11 09:14:20', '2026-03-11 09:14:20'),
(18, 2, 17, 1, '2026-03-11 14:44:20', NULL, '2026-03-11 09:14:20', '2026-03-11 09:14:20'),
(19, 2, 18, 1, '2026-03-11 14:44:20', NULL, '2026-03-11 09:14:20', '2026-03-11 09:14:20'),
(20, 2, 19, 1, '2026-03-11 14:44:20', NULL, '2026-03-11 09:14:20', '2026-03-11 09:14:20'),
(21, 2, 20, 1, '2026-03-11 14:44:20', NULL, '2026-03-11 09:14:20', '2026-03-11 09:14:20'),
(22, 3, 21, 1, '2026-03-11 14:44:37', NULL, '2026-03-11 09:14:37', '2026-03-11 09:14:37'),
(24, 3, 1, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(25, 3, 2, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(26, 3, 3, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(27, 3, 4, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(28, 3, 5, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(29, 3, 6, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(30, 3, 7, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(31, 3, 8, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(32, 3, 9, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(33, 3, 10, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(34, 3, 11, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(35, 3, 12, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(36, 3, 13, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(37, 3, 14, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(38, 3, 15, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(39, 3, 16, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(40, 3, 17, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(41, 3, 18, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(42, 3, 19, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(43, 3, 20, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02'),
(44, 3, 22, 1, '2026-03-11 14:45:02', NULL, '2026-03-11 09:15:02', '2026-03-11 09:15:02');

-- --------------------------------------------------------

--
-- Table structure for table `hods`
--

CREATE TABLE `hods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `experience_years` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hods`
--

INSERT INTO `hods` (`id`, `user_id`, `employee_id`, `department`, `specialization`, `qualification`, `experience_years`, `created_at`, `updated_at`) VALUES
(1, 27, 'HOD001', 'MCA', 'Computer Science Education', 'PhD Computer Science', 12, '2026-03-11 11:58:04', '2026-03-11 11:58:04');

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

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"bece7b88-555d-4578-b1ad-97fd6f8c4078\",\"displayName\":\"App\\\\Mail\\\\StudentNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:28:\\\"App\\\\Mail\\\\StudentNotification\\\":5:{s:12:\\\"emailSubject\\\";s:13:\\\"hi low attend\\\";s:12:\\\"emailMessage\\\";s:69:\\\"asdfghjkl;oiuytewqasdfghjkloiuyewqasdfghjklpoiuytrewqAXCVBNJKLKJHGFDS\\\";s:7:\\\"student\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Student\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"bvsaiganesh9980@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\",\"batchId\":null},\"createdAt\":1773231767,\"delay\":null}', 0, NULL, 1773231767, 1773231767),
(2, 'default', '{\"uuid\":\"53618fd6-c02e-48c8-9daf-eed69a15b450\",\"displayName\":\"App\\\\Mail\\\\StudentNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:28:\\\"App\\\\Mail\\\\StudentNotification\\\":5:{s:12:\\\"emailSubject\\\";s:13:\\\"hi low attend\\\";s:12:\\\"emailMessage\\\";s:76:\\\"asdfghjkldfghgfd;oiuytewqasdfghjkloiuyewqasdfghjklpoiuytrewqAXCVBNJKLKJHGFDS\\\";s:7:\\\"student\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Student\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"bvsaiganesh9980@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\",\"batchId\":null},\"createdAt\":1773231835,\"delay\":null}', 0, NULL, 1773231835, 1773231835),
(3, 'default', '{\"uuid\":\"3f2e3f37-4220-4bab-9e8d-455fe407d64a\",\"displayName\":\"App\\\\Mail\\\\StudentNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:28:\\\"App\\\\Mail\\\\StudentNotification\\\":5:{s:12:\\\"emailSubject\\\";s:13:\\\"hi low attend\\\";s:12:\\\"emailMessage\\\";s:83:\\\"asdfghjkldsadfgnhfghgfd;oiuytewqasdfghjkloiuyewqasdfghjklpoiuytrewqAXCVBNJKLKJHGFDS\\\";s:7:\\\"student\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Student\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"bvsaiganesh9980@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\",\"batchId\":null},\"createdAt\":1773231989,\"delay\":null}', 0, NULL, 1773231989, 1773231989),
(4, 'default', '{\"uuid\":\"f326c0c0-ee46-4cd2-ba08-8b1ed9cc322f\",\"displayName\":\"App\\\\Mail\\\\StudentNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:28:\\\"App\\\\Mail\\\\StudentNotification\\\":5:{s:12:\\\"emailSubject\\\";s:13:\\\"hi low attend\\\";s:12:\\\"emailMessage\\\";s:28:\\\"qwertyuioplkjdsawertyuknbvcx\\\";s:7:\\\"student\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Student\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"bvsaiganesh9980@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\",\"batchId\":null},\"createdAt\":1773232532,\"delay\":null}', 0, NULL, 1773232532, 1773232532);

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `internal_marks` decimal(5,2) DEFAULT NULL,
  `external_marks` decimal(5,2) DEFAULT NULL,
  `total_marks` decimal(5,2) DEFAULT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `assessment_type` varchar(255) NOT NULL,
  `mark_date` date NOT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`id`, `student_id`, `course_id`, `internal_marks`, `external_marks`, `total_marks`, `grade`, `assessment_type`, `mark_date`, `feedback`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 29.00, 27.00, 90.00, 'B', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(2, 1, 2, 39.00, 22.00, 62.00, 'C', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(3, 2, 1, 29.00, 24.00, 46.00, 'A', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(4, 2, 2, 31.00, 23.00, 71.00, 'F', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(5, 3, 1, 41.00, 24.00, 47.00, 'A', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(6, 3, 2, 25.00, 38.00, 72.00, 'A', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(7, 4, 1, 23.00, 25.00, 77.00, 'C', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(8, 4, 2, 38.00, 36.00, 42.00, 'D', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(9, 5, 1, 31.00, 38.00, 85.00, 'D', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(10, 5, 2, 40.00, 36.00, 42.00, 'C', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(11, 6, 1, 25.00, 38.00, 52.00, 'D', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(12, 6, 2, 29.00, 30.00, 72.00, 'B', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(13, 7, 1, 26.00, 39.00, 80.00, 'A', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(14, 7, 2, 42.00, 23.00, 80.00, 'D', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(15, 8, 1, 45.00, 34.00, 49.00, 'B', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(16, 8, 2, 29.00, 37.00, 82.00, 'D', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(17, 9, 1, 34.00, 45.00, 80.00, 'B', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(18, 9, 2, 44.00, 20.00, 90.00, 'A', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(19, 10, 1, 27.00, 33.00, 58.00, 'B', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(20, 10, 2, 36.00, 40.00, 69.00, 'D', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(21, 11, 1, 36.00, 20.00, 78.00, 'D', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(22, 11, 2, 25.00, 42.00, 90.00, 'A', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(23, 12, 1, 37.00, 29.00, 79.00, 'D', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(24, 12, 2, 30.00, 25.00, 50.00, 'C', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(25, 13, 1, 23.00, 28.00, 63.00, 'B', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(26, 13, 2, 43.00, 25.00, 87.00, 'C', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(27, 14, 1, 40.00, 44.00, 82.00, 'F', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(28, 14, 2, 22.00, 38.00, 90.00, 'A', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(29, 15, 1, 23.00, 23.00, 72.00, 'C', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(30, 15, 2, 41.00, 35.00, 51.00, 'B', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(31, 16, 1, 41.00, 33.00, 47.00, 'F', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(32, 16, 2, 20.00, 41.00, 59.00, 'F', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(33, 17, 1, 41.00, 37.00, 56.00, 'A', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(34, 17, 2, 41.00, 34.00, 90.00, 'B', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(35, 18, 1, 20.00, 28.00, 77.00, 'A', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(36, 18, 2, 38.00, 35.00, 85.00, 'A', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(37, 19, 1, 37.00, 24.00, 69.00, 'C', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(38, 19, 2, 39.00, 21.00, 47.00, 'B', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(39, 20, 1, 24.00, 22.00, 52.00, 'C', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(40, 20, 2, 27.00, 38.00, 65.00, 'A', 'midterm', '2026-01-09', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(41, 1, 1, 16.00, 27.00, 41.00, 'D', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(42, 1, 2, 33.00, 35.00, 86.00, 'B', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(43, 2, 1, 34.00, 40.00, 60.00, 'B', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(44, 2, 2, 21.00, 41.00, 83.00, 'D', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:10', '2026-03-11 07:27:10'),
(45, 3, 1, 45.00, 43.00, 80.00, 'A', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(46, 3, 2, 45.00, 37.00, 45.00, 'C', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(47, 4, 1, 27.00, 33.00, 58.00, 'C', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(48, 4, 2, 26.00, 31.00, 56.00, 'A', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(49, 5, 1, 13.00, 13.00, 32.00, 'F', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(50, 5, 2, 23.00, 24.00, 83.00, 'B', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(51, 6, 1, 22.00, 30.00, 39.00, 'D', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(52, 6, 2, 45.00, 45.00, 83.00, 'D', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(53, 7, 1, 33.00, 30.00, 69.00, 'B', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(54, 7, 2, 32.00, 23.00, 71.00, 'B', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(55, 8, 1, 37.00, 46.00, 80.00, 'A', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(56, 8, 2, 28.00, 36.00, 70.00, 'A', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(57, 9, 1, 20.00, 35.00, 47.00, 'C', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(58, 9, 2, 36.00, 34.00, 65.00, 'B', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(59, 10, 1, 15.00, 14.00, 33.00, 'F', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(60, 10, 2, 41.00, 28.00, 68.00, 'A', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(61, 11, 1, 18.00, 28.00, 43.00, 'D', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(62, 11, 2, 23.00, 23.00, 62.00, 'C', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(63, 12, 1, 28.00, 31.00, 72.00, 'B', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(64, 12, 2, 42.00, 38.00, 79.00, 'D', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(65, 13, 1, 42.00, 40.00, 85.00, 'A', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(66, 13, 2, 20.00, 22.00, 51.00, 'B', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:11', '2026-03-11 07:27:11'),
(67, 14, 1, 24.00, 21.00, 43.00, 'C', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(68, 14, 2, 36.00, 24.00, 64.00, 'A', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(69, 15, 1, 12.00, 6.00, 35.00, 'F', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(70, 15, 2, 45.00, 26.00, 77.00, 'D', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(71, 16, 1, 17.00, 24.00, 39.00, 'D', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(72, 16, 2, 42.00, 33.00, 79.00, 'C', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(73, 17, 1, 27.00, 38.00, 72.00, 'B', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(74, 17, 2, 20.00, 36.00, 41.00, 'D', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(75, 18, 1, 37.00, 41.00, 82.00, 'A', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(76, 18, 2, 23.00, 44.00, 60.00, 'C', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(77, 19, 1, 30.00, 20.00, 51.00, 'C', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(78, 19, 2, 24.00, 35.00, 74.00, 'A', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(79, 20, 1, 10.00, 18.00, 16.00, 'F', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(80, 20, 2, 37.00, 25.00, 51.00, 'B', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(81, 21, 1, 20.00, 22.00, 37.00, 'D', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:12', '2026-03-11 07:27:12'),
(82, 21, 2, 20.00, 45.00, 43.00, 'A', 'midterm', '2026-02-11', NULL, '2026-03-11 07:27:12', '2026-03-11 07:27:12');

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
(1, '2024_01_01_000001_create_roles_table', 1),
(2, '2024_01_01_000002_create_users_table', 1),
(3, '2024_01_01_000003_create_faculty_table', 1),
(4, '2024_01_01_000004_create_students_table', 1),
(5, '2024_01_01_000005_create_courses_table', 1),
(6, '2024_01_01_000006_create_enrollments_table', 1),
(7, '2024_01_01_000007_create_marks_table', 1),
(8, '2024_01_01_000008_create_attendance_table', 1),
(9, '2024_01_01_000009_create_academic_risk_table', 1),
(10, '2024_01_01_000010_create_alerts_table', 1),
(11, '2024_01_01_000011_create_nl_queries_table', 1),
(12, '2024_01_01_000012_create_password_reset_tokens_table', 1),
(13, '2024_01_01_000013_create_sessions_table', 1),
(14, '2024_01_01_000014_add_parent_email_to_students_table', 2),
(15, '2024_01_01_000015_create_email_logs_table', 2),
(16, '2024_01_01_000016_create_query_results_table', 2),
(17, '2024_01_01_000017_add_risk_notification_fields_to_academic_risk_table', 2),
(18, '2026_03_11_122156_create_jobs_table', 3),
(19, '2026_03_11_142358_create_cache_table', 4),
(20, '2026_03_11_143000_add_approval_fields_to_faculty_table', 5),
(21, '2026_03_11_143001_create_faculty_students_table', 5),
(22, '2026_03_11_144500_fix_faculty_students_columns', 6),
(23, '2024_01_01_000011_create_hods_table', 7),
(25, '2026_03_12_setup_demo_credentials', 8),
(26, '2026_03_13_add_mca_courses', 9),
(27, '2026_03_13_fix_mca_department', 10),
(28, '2026_03_13_add_dummy_alerts', 11),
(29, '2026_03_13_add_dummy_faculty', 12),
(30, '2026_03_13_convert_all_to_mca', 13);

-- --------------------------------------------------------

--
-- Table structure for table `nl_queries`
--

CREATE TABLE `nl_queries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `natural_language_query` text NOT NULL,
  `generated_sql` text DEFAULT NULL,
  `query_result` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`query_result`)),
  `query_results_formatted` longtext DEFAULT NULL,
  `result_columns` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`result_columns`)),
  `result_count` int(11) NOT NULL DEFAULT 0,
  `show_sql_to_user` tinyint(1) NOT NULL DEFAULT 0,
  `query_status` enum('success','error','pending') NOT NULL DEFAULT 'pending',
  `error_message` text DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  `query_intent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nl_queries`
--

INSERT INTO `nl_queries` (`id`, `user_id`, `natural_language_query`, `generated_sql`, `query_result`, `query_results_formatted`, `result_columns`, `result_count`, `show_sql_to_user`, `query_status`, `error_message`, `execution_time`, `query_intent`, `created_at`, `updated_at`) VALUES
(8, 1, 'show students with attendance below 60%', '\r\n            SELECT DISTINCT s.id, u.name, c.course_name, \r\n                   COUNT(CASE WHEN a.status = \'present\' THEN 1 END) * 100.0 / COUNT(*) as attendance_percentage\r\n            FROM students s\r\n            JOIN users u ON s.user_id = u.id\r\n            JOIN attendance a ON s.id = a.student_id\r\n            JOIN courses c ON a.course_id = c.id\r\n            GROUP BY s.id, u.name, c.course_name\r\n            HAVING attendance_percentage < 60\r\n            ORDER BY attendance_percentage ASC\r\n        ', '\"[{\\\"id\\\":10,\\\"name\\\":\\\"Student 10\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"32.50000\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Student 5\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"35.00000\\\"},{\\\"id\\\":20,\\\"name\\\":\\\"Student 20\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"45.00000\\\"},{\\\"id\\\":15,\\\"name\\\":\\\"Student 15\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"47.50000\\\"},{\\\"id\\\":1,\\\"name\\\":\\\"Student 1\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"50.00000\\\"}]\"', '[{\"id\":10,\"name\":\"Student 10\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"32.50000\"},{\"id\":5,\"name\":\"Student 5\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"35.00000\"},{\"id\":20,\"name\":\"Student 20\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"45.00000\"},{\"id\":15,\"name\":\"Student 15\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"47.50000\"},{\"id\":1,\"name\":\"Student 1\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"50.00000\"}]', '[\"id\",\"name\",\"course_name\",\"attendance_percentage\"]', 5, 1, 'success', NULL, 0, 'search', '2026-03-11 08:47:24', '2026-03-11 08:47:24'),
(9, 2, 'show top performing students', '\r\n            SELECT DISTINCT s.id, u.name, c.course_name, \r\n                   COUNT(CASE WHEN a.status = \'present\' THEN 1 END) * 100.0 / COUNT(*) as attendance_percentage\r\n            FROM students s\r\n            JOIN users u ON s.user_id = u.id\r\n            JOIN attendance a ON s.id = a.student_id\r\n            JOIN courses c ON a.course_id = c.id\r\n            GROUP BY s.id, u.name, c.course_name\r\n            HAVING attendance_percentage < 60\r\n            ORDER BY attendance_percentage ASC\r\n        ', '\"[{\\\"id\\\":10,\\\"name\\\":\\\"Student 10\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"32.50000\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Student 5\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"35.00000\\\"},{\\\"id\\\":20,\\\"name\\\":\\\"Student 20\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"45.00000\\\"},{\\\"id\\\":15,\\\"name\\\":\\\"Student 15\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"47.50000\\\"},{\\\"id\\\":1,\\\"name\\\":\\\"Student 1\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"50.00000\\\"}]\"', '[{\"id\":10,\"name\":\"Student 10\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"32.50000\"},{\"id\":5,\"name\":\"Student 5\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"35.00000\"},{\"id\":20,\"name\":\"Student 20\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"45.00000\"},{\"id\":15,\"name\":\"Student 15\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"47.50000\"},{\"id\":1,\"name\":\"Student 1\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"50.00000\"}]', '[\"id\",\"name\",\"course_name\",\"attendance_percentage\"]', 5, 0, 'success', NULL, 0, 'search', '2026-03-11 10:28:42', '2026-03-11 10:28:42'),
(10, 2, 'list students failing in database course', '\r\n            SELECT DISTINCT s.id, u.name, c.course_name, \r\n                   COUNT(CASE WHEN a.status = \'present\' THEN 1 END) * 100.0 / COUNT(*) as attendance_percentage\r\n            FROM students s\r\n            JOIN users u ON s.user_id = u.id\r\n            JOIN attendance a ON s.id = a.student_id\r\n            JOIN courses c ON a.course_id = c.id\r\n            GROUP BY s.id, u.name, c.course_name\r\n            HAVING attendance_percentage < 60\r\n            ORDER BY attendance_percentage ASC\r\n        ', '\"[{\\\"id\\\":10,\\\"name\\\":\\\"Student 10\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"32.50000\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Student 5\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"35.00000\\\"},{\\\"id\\\":20,\\\"name\\\":\\\"Student 20\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"45.00000\\\"},{\\\"id\\\":15,\\\"name\\\":\\\"Student 15\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"47.50000\\\"},{\\\"id\\\":1,\\\"name\\\":\\\"Student 1\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"50.00000\\\"}]\"', '[{\"id\":10,\"name\":\"Student 10\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"32.50000\"},{\"id\":5,\"name\":\"Student 5\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"35.00000\"},{\"id\":20,\"name\":\"Student 20\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"45.00000\"},{\"id\":15,\"name\":\"Student 15\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"47.50000\"},{\"id\":1,\"name\":\"Student 1\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"50.00000\"}]', '[\"id\",\"name\",\"course_name\",\"attendance_percentage\"]', 5, 0, 'success', NULL, 0, 'search', '2026-03-11 11:34:20', '2026-03-11 11:34:20'),
(11, 1, 'show students with attendance below 60%', '\r\n            SELECT DISTINCT s.id, u.name, c.course_name, \r\n                   COUNT(CASE WHEN a.status = \'present\' THEN 1 END) * 100.0 / COUNT(*) as attendance_percentage\r\n            FROM students s\r\n            JOIN users u ON s.user_id = u.id\r\n            JOIN attendance a ON s.id = a.student_id\r\n            JOIN courses c ON a.course_id = c.id\r\n            GROUP BY s.id, u.name, c.course_name\r\n            HAVING attendance_percentage < 60\r\n            ORDER BY attendance_percentage ASC\r\n        ', '\"[{\\\"id\\\":10,\\\"name\\\":\\\"Student 10\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"32.50000\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Student 5\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"35.00000\\\"},{\\\"id\\\":20,\\\"name\\\":\\\"Student 20\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"45.00000\\\"},{\\\"id\\\":15,\\\"name\\\":\\\"Student 15\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"47.50000\\\"},{\\\"id\\\":1,\\\"name\\\":\\\"Student 1\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"50.00000\\\"}]\"', '[{\"id\":10,\"name\":\"Student 10\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"32.50000\"},{\"id\":5,\"name\":\"Student 5\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"35.00000\"},{\"id\":20,\"name\":\"Student 20\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"45.00000\"},{\"id\":15,\"name\":\"Student 15\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"47.50000\"},{\"id\":1,\"name\":\"Student 1\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"50.00000\"}]', '[\"id\",\"name\",\"course_name\",\"attendance_percentage\"]', 5, 1, 'success', NULL, 0, 'search', '2026-03-12 11:09:54', '2026-03-12 11:09:54'),
(12, 3, 'students with marks below 40', '\r\n            SELECT s.id, u.name, c.course_name, m.total_marks, m.grade\r\n            FROM students s\r\n            JOIN users u ON s.user_id = u.id\r\n            JOIN marks m ON s.id = m.student_id\r\n            JOIN courses c ON m.course_id = c.id\r\n            WHERE m.total_marks < 0\r\n            ORDER BY m.total_marks ASC\r\n        ', '\"[]\"', '[]', '[]', 0, 0, 'success', NULL, 1, 'search', '2026-03-12 17:51:49', '2026-03-12 17:51:49'),
(13, 2, 'show students with attendance below 60%', '\r\n            SELECT DISTINCT s.id, u.name, c.course_name, \r\n                   COUNT(CASE WHEN a.status = \'present\' THEN 1 END) * 100.0 / COUNT(*) as attendance_percentage\r\n            FROM students s\r\n            JOIN users u ON s.user_id = u.id\r\n            JOIN attendance a ON s.id = a.student_id\r\n            JOIN courses c ON a.course_id = c.id\r\n            GROUP BY s.id, u.name, c.course_name\r\n            HAVING attendance_percentage < 60\r\n            ORDER BY attendance_percentage ASC\r\n        ', '\"[{\\\"id\\\":10,\\\"name\\\":\\\"Student 10\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"32.50000\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Jessi\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"35.00000\\\"},{\\\"id\\\":20,\\\"name\\\":\\\"Student 20\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"45.00000\\\"},{\\\"id\\\":15,\\\"name\\\":\\\"Student 15\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"47.50000\\\"},{\\\"id\\\":1,\\\"name\\\":\\\"Ganesh BUdati\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"50.00000\\\"}]\"', '[{\"id\":10,\"name\":\"Student 10\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"32.50000\"},{\"id\":5,\"name\":\"Jessi\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"35.00000\"},{\"id\":20,\"name\":\"Student 20\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"45.00000\"},{\"id\":15,\"name\":\"Student 15\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"47.50000\"},{\"id\":1,\"name\":\"Ganesh BUdati\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"50.00000\"}]', '[\"id\",\"name\",\"course_name\",\"attendance_percentage\"]', 5, 0, 'success', NULL, 0, 'search', '2026-03-12 17:58:52', '2026-03-12 17:58:52'),
(14, 1, 'show top performing students', '\r\n            SELECT DISTINCT s.id, u.name, c.course_name, \r\n                   COUNT(CASE WHEN a.status = \'present\' THEN 1 END) * 100.0 / COUNT(*) as attendance_percentage\r\n            FROM students s\r\n            JOIN users u ON s.user_id = u.id\r\n            JOIN attendance a ON s.id = a.student_id\r\n            JOIN courses c ON a.course_id = c.id\r\n            GROUP BY s.id, u.name, c.course_name\r\n            HAVING attendance_percentage < 60\r\n            ORDER BY attendance_percentage ASC\r\n        ', '\"[{\\\"id\\\":10,\\\"name\\\":\\\"Student 10\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"32.50000\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Jessi\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"35.00000\\\"},{\\\"id\\\":20,\\\"name\\\":\\\"Student 20\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"45.00000\\\"},{\\\"id\\\":15,\\\"name\\\":\\\"Student 15\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"47.50000\\\"},{\\\"id\\\":1,\\\"name\\\":\\\"Ganesh BUdati\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"50.00000\\\"}]\"', '[{\"id\":10,\"name\":\"Student 10\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"32.50000\"},{\"id\":5,\"name\":\"Jessi\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"35.00000\"},{\"id\":20,\"name\":\"Student 20\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"45.00000\"},{\"id\":15,\"name\":\"Student 15\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"47.50000\"},{\"id\":1,\"name\":\"Ganesh BUdati\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"50.00000\"}]', '[\"id\",\"name\",\"course_name\",\"attendance_percentage\"]', 5, 1, 'success', NULL, 0, 'search', '2026-03-12 18:29:42', '2026-03-12 18:29:42'),
(15, 1, '\"Show students with attendance below 60%\"', '\r\n            SELECT DISTINCT s.id, u.name, c.course_name, \r\n                   COUNT(CASE WHEN a.status = \'present\' THEN 1 END) * 100.0 / COUNT(*) as attendance_percentage\r\n            FROM students s\r\n            JOIN users u ON s.user_id = u.id\r\n            JOIN attendance a ON s.id = a.student_id\r\n            JOIN courses c ON a.course_id = c.id\r\n            GROUP BY s.id, u.name, c.course_name\r\n            HAVING attendance_percentage < 60\r\n            ORDER BY attendance_percentage ASC\r\n        ', '\"[{\\\"id\\\":10,\\\"name\\\":\\\"Student 10\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"32.50000\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Student 5\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"35.00000\\\"},{\\\"id\\\":20,\\\"name\\\":\\\"Student 20\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"45.00000\\\"},{\\\"id\\\":15,\\\"name\\\":\\\"Student 15\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"47.50000\\\"},{\\\"id\\\":1,\\\"name\\\":\\\"Ganesh Budati\\\",\\\"course_name\\\":\\\"Database Systems\\\",\\\"attendance_percentage\\\":\\\"52.50000\\\"}]\"', '[{\"id\":10,\"name\":\"Student 10\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"32.50000\"},{\"id\":5,\"name\":\"Student 5\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"35.00000\"},{\"id\":20,\"name\":\"Student 20\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"45.00000\"},{\"id\":15,\"name\":\"Student 15\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"47.50000\"},{\"id\":1,\"name\":\"Ganesh Budati\",\"course_name\":\"Database Systems\",\"attendance_percentage\":\"52.50000\"}]', '[\"id\",\"name\",\"course_name\",\"attendance_percentage\"]', 5, 1, 'success', NULL, 0, 'search', '2026-03-13 03:48:39', '2026-03-13 03:48:39'),
(16, 1, '\"Students with marks below 40\"', '\r\n            SELECT s.id, u.name, c.course_name, m.total_marks, m.grade\r\n            FROM students s\r\n            JOIN users u ON s.user_id = u.id\r\n            JOIN marks m ON s.id = m.student_id\r\n            JOIN courses c ON m.course_id = c.id\r\n            WHERE m.total_marks < 0\r\n            ORDER BY m.total_marks ASC\r\n        ', '\"[]\"', '[]', '[]', 0, 1, 'success', NULL, 7, 'search', '2026-03-13 09:53:19', '2026-03-13 09:53:19');

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
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'System administrator with full access', '2026-03-09 04:04:19', '2026-03-09 04:04:19'),
(2, 'Faculty', 'faculty', 'Faculty member who teaches courses', '2026-03-09 04:04:19', '2026-03-09 04:04:19'),
(3, 'Student', 'student', 'Student enrolled in courses', '2026-03-09 04:04:19', '2026-03-09 04:04:19'),
(4, 'Parent', 'parent', 'Parent of a student', '2026-03-09 04:04:19', '2026-03-09 04:04:19'),
(8, 'Head of Department', 'hod', 'Head of Department managing faculty and courses', '2026-03-11 11:58:04', '2026-03-11 11:58:04');

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
('82h1jSmNfDtMU7Edk4zNhzJQomG6lQOF9HS540Si', 27, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOXZDTGVqeTB0OHdmeWZkbHNOSEJMelF1MXQ3dUhoemxoU2hnY2FWdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob2QvYW5hbHl0aWNzIjtzOjU6InJvdXRlIjtzOjEzOiJob2QuYW5hbHl0aWNzIjt9czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI3O30=', 1773251739),
('fVTBAa3qXnAYi3tqmvJCiqdbYwZtvRr9qqaYIPuA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.110.0 Chrome/142.0.7444.265 Electron/39.6.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ2RWR3RlS2pKUW04blo3MlcyY2dqMDdXcXZqUnpDZ29HOFZHZlJTZCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2hvZC9hbmFseXRpY3MiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1773251721);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `admission_year` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `batch` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `student_id`, `admission_year`, `semester`, `program`, `batch`, `parent_id`, `parent_email`, `created_at`, `updated_at`) VALUES
(1, 4, 'STU00001', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(2, 5, 'STU00002', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(3, 6, 'STU00003', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(4, 7, 'STU00004', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(5, 8, 'STU00005', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(6, 9, 'STU00006', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(7, 10, 'STU00007', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(8, 11, 'STU00008', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(9, 12, 'STU00009', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(10, 13, 'STU00010', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(11, 14, 'STU00011', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(12, 15, 'STU00012', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(13, 16, 'STU00013', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(14, 17, 'STU00014', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(15, 18, 'STU00015', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(16, 19, 'STU00016', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(17, 20, 'STU00017', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(18, 21, 'STU00018', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(19, 22, 'STU00019', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(20, 23, 'STU00020', '2023', '4', 'MCA', '2023-2027', NULL, NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(21, 24, 'STU00024', '2023', '4', 'MCA', '2023-2027', NULL, 'parent@example.com', '2026-03-11 06:49:39', '2026-03-11 06:49:39'),
(22, 26, 'STU00026', '2023', '4', 'MCA', '2023-2027', NULL, 'parent@example.com', '2026-03-11 08:53:31', '2026-03-11 08:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role_id`, `phone`, `address`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@eduinsight.com', NULL, '$2y$12$BnNwoS6ZP/zzLymBrur58u59jMBOOP9EiPNcgYo7shcYN2fmMArhS', 1, NULL, NULL, 'active', NULL, '2026-03-09 04:04:19', '2026-03-09 04:04:19'),
(2, 'Dr. John Smith', 'john.smith@eduinsight.com', NULL, '$2y$12$uPUmL.gswFVXu4Suv6Xe9e8i2Ci3PDNZX5chsDHKz/uXVL4HdJBiW', 2, '555-1001', NULL, 'active', NULL, '2026-03-09 04:04:19', '2026-03-09 04:04:19'),
(3, 'Prof. Sarah Johnson', 'sarah.johnson@eduinsight.com', NULL, '$2y$12$644jLAyPt7gcaSSldSSnaOP3gMc5yfzNFDjLKiLBgLp3L8hWsHXHu', 2, '555-1002', NULL, 'active', NULL, '2026-03-09 04:04:19', '2026-03-09 04:04:19'),
(4, 'Ganesh Budati', 'bvsaiganesh04@gmail.com', NULL, '$2y$12$dd8CWL7w1cpjRsQ8YmprZuuEaz5pqUnapwuhFFXoT9IYrJ6ELewBq', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:19', '2026-03-09 04:04:19'),
(5, 'Sowmika', 'wwwbvndksowmika@gmail.com', NULL, '$2y$12$YCe6OsmZZ4kWZcUY84XISuMkgjJjVTPV68EsJkOD0BpBhoUf7h/2m', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:20', '2026-03-09 04:04:20'),
(6, 'kowshik', 'kowshikboggavarapu@gmail.com', NULL, '$2y$12$nRPDzKtVQQthQpEqhx05D.X7zGXVLzWOkE52JcmsY2WZJ/Pgl9K5q', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:20', '2026-03-09 04:04:20'),
(7, 'Bvsaiganesh', 'bvsaiganesh9980@gmail.com', NULL, '$2y$12$b5UdEBB8KKUfkIYw5SOApuaSrppWM.Bf4PqKPYL9ueFUu0e6uNSvm', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:20', '2026-03-09 04:04:20'),
(8, 'Student 5', 'jessi@eduinsight.com', NULL, '$2y$12$vV2vrP8TqA4YO0AkoTCLJuWV2gTnAzq6fhkBtBteB/vQttkhG0Pya', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:20', '2026-03-09 04:04:20'),
(9, 'Venkat', 'student6@eduinsight.com', NULL, '$2y$12$R2RIVZN1tZcIFmp9un4pHeEbH8WYYzhYOXVJYePWJw3ektyRtZLOm', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:20', '2026-03-09 04:04:20'),
(10, 'Student 7', 'student7@eduinsight.com', NULL, '$2y$12$/q.B25RlVcRDFYc0lSgDl.3TxzpsU3mwxKnyGD7EOCREkexDd8AD6', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:21', '2026-03-09 04:04:21'),
(11, 'Student 8', 'student8@eduinsight.com', NULL, '$2y$12$8TNJ5gU0cE2yNKhwnNUUMu3pbjo7ZRrRUQCS/kdQKD3f9t7MkNLXy', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:21', '2026-03-09 04:04:21'),
(12, 'Student 9', 'student9@eduinsight.com', NULL, '$2y$12$vT9nFoFbnDsq2bk9z3GY1eBqp7KM5L6g60Cx9XdV9S.XUCV9lKPpy', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:21', '2026-03-09 04:04:21'),
(13, 'Student 10', 'student10@eduinsight.com', NULL, '$2y$12$ZgejEIwaY6c4Si4wFYYPCOSLcj3SApz.SfoZYjWlC9eqYH4KJFNFa', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:21', '2026-03-09 04:04:21'),
(14, 'Student 11', 'student11@eduinsight.com', NULL, '$2y$12$MhgRNvQqyLmpu0TRZbTQSexx/aPZwPU6ui1fgm2EtWaBl8iqA6Ria', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:21', '2026-03-09 04:04:21'),
(15, 'Student 12', 'student12@eduinsight.com', NULL, '$2y$12$qJWs5UAJ2qh7gMn4s7ycUuSS2HMRKL1eKhGfKThkibzWtWcCLHG4u', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:21', '2026-03-09 04:04:21'),
(16, 'Student 13', 'student13@eduinsight.com', NULL, '$2y$12$sjbtmn576kUiikWKs.tmrenfcvo6Jo95elsSKqrFzquSk4azQyA/e', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:22', '2026-03-09 04:04:22'),
(17, 'Student 14', 'student14@eduinsight.com', NULL, '$2y$12$4j/RdiTh//THbFw7SG.o/eW6uHQDzo9G0DMXtKOk7DC6aZknQuIOK', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:22', '2026-03-09 04:04:22'),
(18, 'Student 15', 'student15@eduinsight.com', NULL, '$2y$12$g7Z2i9H6wSTTPN22wkisQOwi82R5iNfi.7ubKtW5FZZoIhWA.QbUa', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:22', '2026-03-09 04:04:22'),
(19, 'Student 16', 'student16@eduinsight.com', NULL, '$2y$12$FbB68PcI/aTMfh9Ihnmr1OoS6dEzJ.7joCeoo9ZfM1gNWR8.i1Gom', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:22', '2026-03-09 04:04:22'),
(20, 'Student 17', 'student17@eduinsight.com', NULL, '$2y$12$ArQWtFKuWRT92b6tyOyymei26ZwdMxl965VIYI4BmdHOQwHukZs9W', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:22', '2026-03-09 04:04:22'),
(21, 'Student 18', 'student18@eduinsight.com', NULL, '$2y$12$wJDZzEd3QElSDp7Drxcaj.kT7NE/RQnq7FRqGuatGh8MC1qRObPr.', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(22, 'Student 19', 'student19@eduinsight.com', NULL, '$2y$12$QxXzDtoKw6zgcnBbBIjSquZykctb5NKtmqbxpvERnZK0PNtqcO0Mi', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(23, 'Student 20', 'student20@eduinsight.com', NULL, '$2y$12$ywcgSZd39aRreLAQ21DZ5eWMfnRunLnQm0tmSmP4hJs4vKtZJ4gdq', 3, NULL, NULL, 'active', NULL, '2026-03-09 04:04:23', '2026-03-09 04:04:23'),
(24, 'Saiganesh', 'bvsaigash9980@gmail.com', NULL, '$2y$12$AEw7JE00APGqURxz8AplhO/GC4rm9GO3MvTbdfBmKKnWmr/1M5seq', 3, NULL, NULL, 'active', NULL, '2026-03-11 06:49:39', '2026-03-11 06:49:39'),
(25, 'Kowshik', 'faculty@eduinsight.com', NULL, '$2y$12$.harjD4H2X1bXj0AOqhCku8XmNWs/93T6DP7cFy3oyxdlqclQ635i', 2, NULL, NULL, 'active', NULL, '2026-03-11 08:50:34', '2026-03-11 08:50:34'),
(26, 'Student Member', 'student@eduinsight.com', NULL, '$2y$12$.eVmT15s8qutS2bvkuvuJ.USD6uRX3V8JbbbVRyMv3fI74xVbq0F2', 3, NULL, NULL, 'active', NULL, '2026-03-11 08:53:31', '2026-03-11 08:53:31'),
(27, 'Prof. Michael Chen', 'hod@eduinsight.com', NULL, '$2y$12$7YfVylONoiEnuOKeriZjbOGDRHv0PQ/uW7yBlu9.KA2ynRfeDOibi', 8, '555-1000', NULL, 'active', NULL, '2026-03-11 11:58:04', '2026-03-11 11:58:04'),
(28, 'Dr. Rajesh Kumar', 'rajesh.kumar@eduinsight.com', NULL, '$2y$12$yvnbTCoOexI3YMAjYiZRtuupq0CLW9XIq2tBU668wop0wvsMleCk.', 2, NULL, NULL, 'active', NULL, '2026-03-12 19:44:08', '2026-03-12 19:45:14'),
(29, 'Prof. Priya Singh', 'priya.singh@eduinsight.com', NULL, '$2y$12$cWhsdV5SCf2YLZAoFyKamuNrrxz2j/A50qDN91WUXGYelIkb9Fo2u', 2, NULL, NULL, 'active', NULL, '2026-03-12 19:45:14', '2026-03-12 19:45:14'),
(30, 'Dr. Arun Patel', 'arun.patel@eduinsight.com', NULL, '$2y$12$/aVlOzvuUZgfcrakA1qx3.TQaO2UXL4nIJeyLgbEUOF.z17JOTdse', 2, NULL, NULL, 'active', NULL, '2026-03-12 19:45:14', '2026-03-12 19:45:14'),
(31, 'Mrs. Maya Sharma', 'maya.sharma@eduinsight.com', NULL, '$2y$12$8wRCaIFbLiw4tNsM//JimugriZrNADa/vnKLxk1BJz4FfLLeLPGP2', 2, NULL, NULL, 'active', NULL, '2026-03-12 19:45:15', '2026-03-12 19:45:15'),
(32, 'Prof. Vikram Desai', 'vikram.desai@eduinsight.com', NULL, '$2y$12$S5hANTPMbJpIAvvaGI9TZe2C7QdkRjEAHLputRs5.zOs4hdfcRJSa', 2, NULL, NULL, 'active', NULL, '2026-03-12 19:45:15', '2026-03-12 19:45:15'),
(33, 'Dr. Anjali Gupta', 'anjali.gupta@eduinsight.com', NULL, '$2y$12$ROfuDo0fYzUz5FiAN8BefOaLoGOZxujsgUkN/b/6pkKSWQDChfCk.', 2, NULL, NULL, 'active', NULL, '2026-03-12 19:45:15', '2026-03-12 19:45:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_risk`
--
ALTER TABLE `academic_risk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `academic_risk_student_id_foreign` (`student_id`),
  ADD KEY `academic_risk_course_id_foreign` (`course_id`);

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alerts_student_id_foreign` (`student_id`),
  ADD KEY `alerts_course_id_foreign` (`course_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_student_id_foreign` (`student_id`),
  ADD KEY `attendance_course_id_foreign` (`course_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_course_code_unique` (`course_code`),
  ADD KEY `courses_faculty_id_foreign` (`faculty_id`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_logs_sender_id_index` (`sender_id`),
  ADD KEY `email_logs_receiver_email_index` (`receiver_email`),
  ADD KEY `email_logs_sent_at_index` (`sent_at`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enrollments_student_id_course_id_unique` (`student_id`,`course_id`),
  ADD KEY `enrollments_course_id_foreign` (`course_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faculty_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `faculty_employee_id_unique` (`employee_id`),
  ADD KEY `faculty_department_id_foreign` (`department_id`);

--
-- Indexes for table `faculty_students`
--
ALTER TABLE `faculty_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faculty_students_faculty_id_student_id_unique` (`faculty_id`,`student_id`),
  ADD KEY `faculty_students_student_id_foreign` (`student_id`),
  ADD KEY `faculty_students_assigned_by_admin_id_foreign` (`assigned_by_admin_id`);

--
-- Indexes for table `hods`
--
ALTER TABLE `hods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hods_employee_id_unique` (`employee_id`),
  ADD KEY `hods_user_id_foreign` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marks_student_id_foreign` (`student_id`),
  ADD KEY `marks_course_id_foreign` (`course_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nl_queries`
--
ALTER TABLE `nl_queries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nl_queries_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `students_student_id_unique` (`student_id`),
  ADD KEY `students_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_risk`
--
ALTER TABLE `academic_risk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=841;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `faculty_students`
--
ALTER TABLE `faculty_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `hods`
--
ALTER TABLE `hods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `nl_queries`
--
ALTER TABLE `nl_queries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `academic_risk`
--
ALTER TABLE `academic_risk`
  ADD CONSTRAINT `academic_risk_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `academic_risk_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `alerts_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD CONSTRAINT `email_logs_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `hods` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `faculty_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `faculty_students`
--
ALTER TABLE `faculty_students`
  ADD CONSTRAINT `faculty_students_assigned_by_admin_id_foreign` FOREIGN KEY (`assigned_by_admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `faculty_students_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `faculty_students_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hods`
--
ALTER TABLE `hods`
  ADD CONSTRAINT `hods_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `marks_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marks_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nl_queries`
--
ALTER TABLE `nl_queries`
  ADD CONSTRAINT `nl_queries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
