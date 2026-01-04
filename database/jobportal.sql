-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2026 at 05:28 PM
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
-- Database: `jobportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'Shafayat Hossain Chowdhury', 'shafayat18@cse.pstu.ac.bd', '2002033');

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE `employer` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`id`, `name`, `email`, `password`, `logo`) VALUES
(31, 'wajidd', 'wajidd@gmail.com', 'wajidd@gmail.com', 'employer_31_1759162202.jpg'),
(32, 'shafayat', 'shafayat@gmail.com', 'shafayat@gmail.com', 'employer_32_1758784688.png'),
(34, 'rabby@gmail.com', 'rabby@gmail.com', 'rabby@gmail.com', 'employer_34_1764508938.jpg'),
(35, '', '', '', NULL),
(36, 'adnan', 'wajid567765@gmail.com', '$2y$10$pKVWYjMagIEQqAj64JdKf.0oCJKyr2ajAuDpUrOdlAcVNxHuBbiDG', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `exam_id` int(11) NOT NULL,
  `exam_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `total_questions` int(11) NOT NULL DEFAULT 50,
  `total_marks` int(11) NOT NULL DEFAULT 100,
  `passing_marks` int(11) NOT NULL DEFAULT 50,
  `duration_minutes` int(11) NOT NULL DEFAULT 60,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`exam_id`, `exam_name`, `description`, `total_questions`, `total_marks`, `passing_marks`, `duration_minutes`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'General Knowledge - Jobs & Career', 'Test your knowledge about job search, interview tips, resume writing, workplace ethics, and career planning', 50, 100, 50, 60, 1, '2026-01-03 05:00:20', '2026-01-03 05:00:20');

-- --------------------------------------------------------

--
-- Table structure for table `exam_answers`
--

CREATE TABLE `exam_answers` (
  `answer_id` int(11) NOT NULL,
  `result_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_option` char(1) DEFAULT NULL COMMENT 'A, B, C, D, or NULL if not answered',
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `marks_obtained` int(11) NOT NULL DEFAULT 0,
  `answered_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_answers`
--

INSERT INTO `exam_answers` (`answer_id`, `result_id`, `question_id`, `selected_option`, `is_correct`, `marks_obtained`, `answered_at`, `created_at`) VALUES
(1, 1, 1, 'C', 0, 0, '2026-01-03 11:25:49', '2026-01-03 05:25:49'),
(2, 1, 2, 'C', 1, 2, '2026-01-03 11:25:49', '2026-01-03 05:25:49'),
(3, 1, 3, 'D', 0, 0, '2026-01-03 11:25:49', '2026-01-03 05:25:49'),
(4, 1, 4, 'C', 0, 0, '2026-01-03 11:25:49', '2026-01-03 05:25:49'),
(5, 1, 5, 'C', 1, 2, '2026-01-03 11:25:49', '2026-01-03 05:25:49'),
(6, 1, 6, 'D', 0, 0, '2026-01-03 11:25:49', '2026-01-03 05:25:49'),
(7, 1, 7, 'B', 1, 2, '2026-01-03 11:25:49', '2026-01-03 05:25:49'),
(8, 1, 8, 'B', 0, 0, '2026-01-03 11:25:49', '2026-01-03 05:25:49'),
(9, 1, 9, 'C', 0, 0, '2026-01-03 11:25:49', '2026-01-03 05:25:49'),
(10, 1, 10, 'C', 1, 2, '2026-01-03 11:25:49', '2026-01-03 05:25:49'),
(11, 1, 11, 'C', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(12, 1, 12, 'B', 1, 2, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(13, 1, 13, 'C', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(14, 1, 14, 'C', 1, 2, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(15, 1, 15, 'D', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(16, 1, 16, 'B', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(17, 1, 17, 'C', 1, 2, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(18, 1, 18, 'C', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(19, 1, 19, 'C', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(20, 1, 20, 'C', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(21, 1, 21, 'C', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(22, 1, 22, 'C', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(23, 1, 23, 'C', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(24, 1, 24, 'C', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(25, 1, 25, 'D', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(26, 1, 26, 'C', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(27, 1, 27, 'B', 1, 2, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(28, 1, 28, 'C', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(29, 1, 29, 'C', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(30, 1, 30, 'C', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(31, 1, 31, 'C', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(32, 1, 32, 'B', 1, 2, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(33, 1, 33, 'C', 0, 0, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(34, 1, 34, 'B', 1, 2, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(35, 1, 35, 'B', 1, 2, '2026-01-03 11:25:50', '2026-01-03 05:25:50'),
(36, 1, 36, 'C', 0, 0, '2026-01-03 11:25:51', '2026-01-03 05:25:51'),
(37, 1, 37, 'C', 0, 0, '2026-01-03 11:25:51', '2026-01-03 05:25:51'),
(38, 1, 38, 'B', 1, 2, '2026-01-03 11:25:51', '2026-01-03 05:25:51'),
(39, 1, 39, 'B', 1, 2, '2026-01-03 11:25:51', '2026-01-03 05:25:51'),
(40, 1, 40, 'C', 0, 0, '2026-01-03 11:25:51', '2026-01-03 05:25:51'),
(41, 1, 41, 'A', 0, 0, '2026-01-03 11:25:51', '2026-01-03 05:25:51'),
(42, 1, 42, 'B', 1, 2, '2026-01-03 11:25:51', '2026-01-03 05:25:51'),
(43, 1, 43, 'C', 0, 0, '2026-01-03 11:25:51', '2026-01-03 05:25:51'),
(44, 1, 44, 'B', 1, 2, '2026-01-03 11:25:51', '2026-01-03 05:25:51'),
(45, 1, 45, 'B', 1, 2, '2026-01-03 11:25:51', '2026-01-03 05:25:51'),
(46, 1, 46, 'D', 0, 0, '2026-01-03 11:25:51', '2026-01-03 05:25:51'),
(47, 1, 47, 'D', 0, 0, '2026-01-03 11:25:51', '2026-01-03 05:25:51'),
(48, 1, 48, 'C', 0, 0, '2026-01-03 11:25:51', '2026-01-03 05:25:51'),
(49, 1, 49, 'C', 0, 0, '2026-01-03 11:25:51', '2026-01-03 05:25:51'),
(50, 1, 50, 'C', 0, 0, '2026-01-03 11:25:51', '2026-01-03 05:25:51'),
(51, 2, 1, 'B', 1, 2, '2026-01-03 11:41:06', '2026-01-03 05:41:06'),
(52, 2, 2, 'B', 0, 0, '2026-01-03 11:41:06', '2026-01-03 05:41:06'),
(53, 2, 3, 'C', 0, 0, '2026-01-03 11:41:06', '2026-01-03 05:41:06'),
(54, 2, 4, 'C', 0, 0, '2026-01-03 11:41:06', '2026-01-03 05:41:06'),
(55, 2, 5, 'B', 0, 0, '2026-01-03 11:41:06', '2026-01-03 05:41:06'),
(56, 2, 6, 'C', 0, 0, '2026-01-03 11:41:06', '2026-01-03 05:41:06'),
(57, 2, 7, 'D', 0, 0, '2026-01-03 11:41:06', '2026-01-03 05:41:06'),
(58, 2, 8, 'C', 1, 2, '2026-01-03 11:41:06', '2026-01-03 05:41:06'),
(59, 2, 9, 'C', 0, 0, '2026-01-03 11:41:06', '2026-01-03 05:41:06'),
(60, 2, 10, 'D', 0, 0, '2026-01-03 11:41:06', '2026-01-03 05:41:06'),
(61, 2, 11, 'B', 1, 2, '2026-01-03 11:41:06', '2026-01-03 05:41:06'),
(62, 2, 12, 'B', 1, 2, '2026-01-03 11:41:06', '2026-01-03 05:41:06'),
(63, 2, 13, 'D', 0, 0, '2026-01-03 11:41:06', '2026-01-03 05:41:06'),
(64, 2, 14, 'C', 1, 2, '2026-01-03 11:41:06', '2026-01-03 05:41:06'),
(65, 2, 15, 'D', 0, 0, '2026-01-03 11:41:06', '2026-01-03 05:41:06'),
(66, 2, 16, 'C', 1, 2, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(67, 2, 17, 'C', 1, 2, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(68, 2, 18, 'C', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(69, 2, 19, 'C', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(70, 2, 20, 'A', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(71, 2, 21, 'C', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(72, 2, 22, 'C', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(73, 2, 23, 'B', 1, 2, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(74, 2, 24, 'C', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(75, 2, 25, 'C', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(76, 2, 26, 'D', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(77, 2, 27, 'D', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(78, 2, 28, 'C', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(79, 2, 29, 'D', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(80, 2, 30, 'C', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(81, 2, 31, 'C', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(82, 2, 32, 'D', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(83, 2, 33, 'C', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(84, 2, 34, 'B', 1, 2, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(85, 2, 35, 'C', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(86, 2, 36, 'D', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(87, 2, 37, 'D', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(88, 2, 38, 'C', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(89, 2, 39, 'C', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(90, 2, 40, 'B', 1, 2, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(91, 2, 41, 'C', 0, 0, '2026-01-03 11:41:07', '2026-01-03 05:41:07'),
(92, 2, 42, 'C', 0, 0, '2026-01-03 11:41:08', '2026-01-03 05:41:08'),
(93, 2, 43, 'D', 0, 0, '2026-01-03 11:41:08', '2026-01-03 05:41:08'),
(94, 2, 44, 'D', 0, 0, '2026-01-03 11:41:08', '2026-01-03 05:41:08'),
(95, 2, 45, 'B', 1, 2, '2026-01-03 11:41:08', '2026-01-03 05:41:08'),
(96, 2, 46, 'B', 1, 2, '2026-01-03 11:41:08', '2026-01-03 05:41:08'),
(97, 2, 47, 'C', 0, 0, '2026-01-03 11:41:08', '2026-01-03 05:41:08'),
(98, 2, 48, 'C', 0, 0, '2026-01-03 11:41:08', '2026-01-03 05:41:08'),
(99, 2, 49, 'C', 0, 0, '2026-01-03 11:41:08', '2026-01-03 05:41:08'),
(100, 2, 50, 'C', 0, 0, '2026-01-03 11:41:08', '2026-01-03 05:41:08');

-- --------------------------------------------------------

--
-- Table structure for table `exam_questions`
--

CREATE TABLE `exam_questions` (
  `question_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` char(1) NOT NULL COMMENT 'A, B, C, or D',
  `marks` int(11) NOT NULL DEFAULT 2,
  `category` varchar(100) DEFAULT NULL COMMENT 'Job search, Resume, Interview, Workplace, etc.',
  `question_order` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_questions`
--

INSERT INTO `exam_questions` (`question_id`, `exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_order`, `created_at`) VALUES
(1, 1, 'What is the best way to start your job search?', 'Post your resume on social media', 'Identify target companies and roles', 'Apply to every job you find', 'Wait for companies to contact you', 'B', 2, 'Job Search', 1, '2026-01-03 05:00:21'),
(2, 1, 'Which of the following is NOT a good job search resource?', 'LinkedIn', 'Industry-specific job boards', 'Random online forums', 'Company career pages', 'C', 2, 'Job Search', 2, '2026-01-03 05:00:21'),
(3, 1, 'How many jobs should you typically apply for per day?', 'Apply to as many as possible', 'Quality over quantity - apply to relevant roles', '100+ applications', 'Only 1 job per day', 'B', 2, 'Job Search', 3, '2026-01-03 05:00:21'),
(4, 1, 'What does \"networking\" mean in job search context?', 'Creating social media accounts', 'Building professional relationships and connections', 'Playing video games online', 'Watching job videos', 'B', 2, 'Job Search', 4, '2026-01-03 05:00:21'),
(5, 1, 'Which platform is best for professional networking?', 'Instagram', 'TikTok', 'LinkedIn', 'Snapchat', 'C', 2, 'Job Search', 5, '2026-01-03 05:00:21'),
(6, 1, 'How important is it to customize your resume for each job?', 'Not important - use the same resume', 'Very important - tailor it to the job description', 'Only for senior positions', 'Only for entry-level jobs', 'B', 2, 'Job Search', 6, '2026-01-03 05:00:21'),
(7, 1, 'What is an informational interview?', 'A formal job interview', 'A casual conversation to learn about a role/industry', 'A test of your knowledge', 'A video call with HR', 'B', 2, 'Job Search', 7, '2026-01-03 05:00:21'),
(8, 1, 'How far back should your work history go on a resume?', '20 years', '10-15 years', 'Only last 5-10 years of relevant experience', 'Since you were born', 'C', 2, 'Job Search', 8, '2026-01-03 05:00:21'),
(9, 1, 'What should you do before attending a job fair?', 'Nothing special', 'Research companies, prepare resumes, dress professionally', 'Wear casual clothes', 'Go without any planning', 'B', 2, 'Job Search', 9, '2026-01-03 05:00:21'),
(10, 1, 'How should you follow up after applying online?', 'Don\'t follow up at all', 'Wait a month then email', 'Follow up after 1-2 weeks if appropriate', 'Call repeatedly', 'C', 2, 'Job Search', 10, '2026-01-03 05:00:21'),
(11, 1, 'What should be the length of a resume for someone with 5 years of experience?', '1 page', '2-3 pages', '5+ pages', 'No specific length matters', 'B', 2, 'Resume', 11, '2026-01-03 05:00:21'),
(12, 1, 'How should you format your resume?', 'Lots of colors and fancy fonts', 'Clean, professional, easy to read', 'Handwritten', 'As long as possible', 'B', 2, 'Resume', 12, '2026-01-03 05:00:21'),
(13, 1, 'What is the best way to describe your work experience?', 'List daily tasks', 'Use action verbs and quantify achievements', 'Write a paragraph story', 'Use vague descriptions', 'B', 2, 'Resume', 13, '2026-01-03 05:00:21'),
(14, 1, 'Should you include a career objective in your resume?', 'Always', 'Never', 'Only if it\'s targeted to the specific role', 'Only for entry-level', 'C', 2, 'Resume', 14, '2026-01-03 05:00:21'),
(15, 1, 'How should you handle employment gaps on your resume?', 'Ignore them', 'Briefly explain them in a cover letter', 'List fake jobs', 'Leave blank spaces', 'B', 2, 'Resume', 15, '2026-01-03 05:00:21'),
(16, 1, 'What should come first in your resume?', 'References', 'Work experience', 'Contact information and professional summary', 'Education', 'C', 2, 'Resume', 16, '2026-01-03 05:00:21'),
(17, 1, 'Is it good to include a photo in your resume?', 'Always include a photo', 'Never include a photo', 'Only if the job requires it', 'Photos should be mandatory', 'C', 2, 'Resume', 17, '2026-01-03 05:00:21'),
(18, 1, 'What action verbs should you use in your resume?', 'Passive verbs like \"was\", \"got\"', 'Strong verbs like \"led\", \"managed\", \"developed\"', 'Adjectives only', 'It doesn\'t matter', 'B', 2, 'Resume', 18, '2026-01-03 05:00:21'),
(19, 1, 'How should you list your education?', 'From oldest to newest', 'From newest to oldest (most recent first)', 'Alphabetically', 'By city', 'B', 2, 'Resume', 19, '2026-01-03 05:00:21'),
(20, 1, 'Should you include hobbies and interests on your resume?', 'Never', 'Only if highly relevant to the job', 'Always', 'Only if you have space', 'B', 2, 'Resume', 20, '2026-01-03 05:00:21'),
(21, 1, 'What should you do before an interview?', 'Show up 5 minutes late', 'Research the company thoroughly', 'Don\'t prepare at all', 'Practice lying', 'B', 2, 'Interview', 21, '2026-01-03 05:00:21'),
(22, 1, 'How early should you arrive for an interview?', '10 minutes before', '15-20 minutes before', '1 hour before', 'Right on time or a few minutes early', 'B', 2, 'Interview', 22, '2026-01-03 05:00:21'),
(23, 1, 'What is the best way to answer \"Tell me about yourself\"?', 'Your entire life story', 'Brief summary of your background, skills, and career goals', 'Random facts', 'Talk about your family', 'B', 2, 'Interview', 23, '2026-01-03 05:00:21'),
(24, 1, 'How should you handle a difficult interview question?', 'Leave blank', 'Take a pause, think, and answer honestly', 'Make something up', 'Get angry', 'B', 2, 'Interview', 24, '2026-01-03 05:00:21'),
(25, 1, 'What should you wear to a professional interview?', 'Casual gym clothes', 'Business formal or business casual depending on company culture', 'Trendy party outfit', 'Whatever is comfortable', 'B', 2, 'Interview', 25, '2026-01-03 05:00:21'),
(26, 1, 'What does STAR method stand for in interviews?', 'Start, Teach, Act, Report', 'Situation, Task, Action, Result', 'Simple, Thorough, Accurate, Real', 'Story, Theme, Address, Response', 'B', 2, 'Interview', 26, '2026-01-03 05:00:21'),
(27, 1, 'How should you answer the question \"What is your biggest weakness?\"?', 'Say you have no weaknesses', 'Mention a real weakness but show how you\'re improving', 'List many weaknesses', 'Refuse to answer', 'B', 2, 'Interview', 27, '2026-01-03 05:00:21'),
(28, 1, 'Should you ask questions at the end of an interview?', 'No, questions show lack of knowledge', 'Yes, ask thoughtful questions about the role and company', 'Only if the interviewer is friendly', 'Questions are a waste of time', 'B', 2, 'Interview', 28, '2026-01-03 05:00:21'),
(29, 1, 'What is a \"behavioral interview\"?', 'An interview about your behavior', 'An interview using past experiences to predict future performance', 'A casual chat', 'An interview about psychology', 'B', 2, 'Interview', 29, '2026-01-03 05:00:21'),
(30, 1, 'How should you follow up after an interview?', 'Don\'t follow up', 'Send a thank-you email within 24 hours', 'Follow up every day', 'Call multiple times', 'B', 2, 'Interview', 30, '2026-01-03 05:00:21'),
(31, 1, 'What is professional etiquette?', 'Being rude to colleagues', 'Following rules of professional conduct and respect', 'Ignoring work dress codes', 'Being late frequently', 'B', 2, 'Workplace', 31, '2026-01-03 05:00:21'),
(32, 1, 'How should you respond to critical feedback at work?', 'Get defensive and angry', 'Listen, stay calm, and look for constructive points', 'Ignore it completely', 'Spread rumors about the feedback giver', 'B', 2, 'Workplace', 32, '2026-01-03 05:00:21'),
(33, 1, 'What should you do if you make a mistake at work?', 'Hide it and hope no one notices', 'Admit it, apologize, and suggest a solution', 'Blame someone else', 'Leave your job immediately', 'B', 2, 'Workplace', 33, '2026-01-03 05:00:21'),
(34, 1, 'How should you handle email communication at work?', 'Write in all caps and use slang', 'Keep emails professional, clear, and concise', 'Send emails at any time without consideration', 'Use lots of emojis and abbreviations', 'B', 2, 'Workplace', 34, '2026-01-03 05:00:21'),
(35, 1, 'What is the importance of work-life balance?', 'It\'s not important at all', 'Essential for mental health and productivity', 'Only for lazy employees', 'A myth created by HR', 'B', 2, 'Workplace', 35, '2026-01-03 05:00:21'),
(36, 1, 'How should you address your manager in a meeting?', 'Call them by their first name informally', 'Use their title (Mr., Ms., Dr.) until invited to do otherwise', 'Use a nickname', 'Ignore them and don\'t speak', 'B', 2, 'Workplace', 36, '2026-01-03 05:00:21'),
(37, 1, 'What should you do if a colleague is not contributing to a team project?', 'Complete silence and ignore it', 'Talk to them privately first, then escalate if needed', 'Publicly criticize them', 'Do all their work', 'B', 2, 'Workplace', 37, '2026-01-03 05:00:21'),
(38, 1, 'How should you dress for work?', 'Whatever you feel like wearing', 'Follow the company dress code and culture', 'Wear workout clothes', 'Dress provocatively', 'B', 2, 'Workplace', 38, '2026-01-03 05:00:21'),
(39, 1, 'What is the impact of being consistently late to work?', 'It doesn\'t matter', 'It damages credibility and professionalism', 'It shows independence', 'It\'s a sign of hard work', 'B', 2, 'Workplace', 39, '2026-01-03 05:00:21'),
(40, 1, 'How should you handle confidential information at work?', 'Share it with friends on social media', 'Keep it confidential and follow company policy', 'Tell everyone you know', 'Post it online', 'B', 2, 'Workplace', 40, '2026-01-03 05:00:21'),
(41, 1, 'What should you research before negotiating salary?', 'Nothing - just ask for a high number', 'Market rates for your role, experience, and location', 'What your friends earn', 'Random salary websites', 'B', 2, 'Salary', 41, '2026-01-03 05:00:21'),
(42, 1, 'When is the best time to negotiate salary?', 'After you start working', 'During the offer stage before accepting', 'A year into the job', 'During your first performance review', 'B', 2, 'Salary', 42, '2026-01-03 05:00:21'),
(43, 1, 'What does \"total compensation\" include?', 'Only base salary', 'Salary, bonuses, benefits, insurance, retirement plans, etc.', 'Only bonuses', 'Only vacation days', 'B', 2, 'Salary', 43, '2026-01-03 05:00:21'),
(44, 1, 'What are common employee benefits?', 'Only a paycheck', 'Health insurance, retirement plans, paid time off, etc.', 'Just free coffee', 'Nothing extra', 'B', 2, 'Salary', 44, '2026-01-03 05:00:21'),
(45, 1, 'How often should you review your salary expectations?', 'Never', 'Annually and when taking new roles', 'Every month', 'Only when angry', 'B', 2, 'Salary', 45, '2026-01-03 05:00:21'),
(46, 1, 'What should you do if you feel underpaid?', 'Accept it forever', 'Research market rates and discuss with your manager', 'Immediately quit', 'Complain to everyone', 'B', 2, 'Salary', 46, '2026-01-03 05:00:21'),
(47, 1, 'What is a 401(k)?', 'A type of password', 'A retirement savings plan offered by employers', 'A job code', 'A health insurance plan', 'B', 2, 'Salary', 47, '2026-01-03 05:00:21'),
(48, 1, 'Should you discuss salary with colleagues?', 'No, it\'s taboo', 'Yes, salary transparency helps identify pay discrimination', 'Never under any circumstances', 'Only with management', 'B', 2, 'Salary', 48, '2026-01-03 05:00:21'),
(49, 1, 'What is a \"signing bonus\"?', 'A musical award', 'Money given upon accepting and starting a new job', 'A bonus for perfect attendance', 'An annual incentive', 'B', 2, 'Salary', 49, '2026-01-03 05:00:21'),
(50, 1, 'How should you handle salary discussions with a recruiter?', 'Tell them your lowest possible expectation', 'Research your worth and provide a realistic range', 'Refuse to discuss it', 'Ask for double what the job is worth', 'B', 2, 'Salary', 50, '2026-01-03 05:00:21');

-- --------------------------------------------------------

--
-- Table structure for table `exam_results`
--

CREATE TABLE `exam_results` (
  `result_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `seeker_id` int(11) NOT NULL,
  `total_marks_obtained` int(11) NOT NULL DEFAULT 0,
  `total_marks_possible` int(11) NOT NULL DEFAULT 100,
  `percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `status` enum('passed','failed','incomplete') NOT NULL DEFAULT 'incomplete',
  `started_at` datetime DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `time_taken_seconds` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_results`
--

INSERT INTO `exam_results` (`result_id`, `exam_id`, `seeker_id`, `total_marks_obtained`, `total_marks_possible`, `percentage`, `status`, `started_at`, `submitted_at`, `time_taken_seconds`, `created_at`) VALUES
(1, 1, 51, 32, 100, 32.00, 'failed', '2026-01-03 06:23:31', '2026-01-03 06:25:49', 138, '2026-01-03 05:25:49'),
(2, 1, 51, 24, 100, 24.00, 'failed', '2026-01-03 06:39:43', '2026-01-03 06:41:06', 83, '2026-01-03 05:41:06');

-- --------------------------------------------------------

--
-- Table structure for table `jobsapplied`
--

CREATE TABLE `jobsapplied` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `pid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `status` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jobsapplied`
--

INSERT INTO `jobsapplied` (`id`, `date`, `pid`, `sid`, `status`) VALUES
(36, '2023-04-15', 40, 36, 'Accepted'),
(38, '2023-04-15', 43, 36, 'Rejected'),
(39, '2023-04-19', 43, 43, 'Applied'),
(40, '2023-04-19', 41, 40, 'Applied'),
(41, '2023-04-19', 8, 36, 'Applied'),
(42, '2023-04-19', 41, 38, 'Applied'),
(43, '2023-04-19', 8, 38, 'Applied'),
(44, '2023-04-19', 44, 38, 'Rejected'),
(45, '2025-09-22', 45, 44, 'Accepted'),
(46, '2025-09-25', 46, 45, 'Applied'),
(47, '2025-09-29', 46, 44, 'Applied'),
(48, '2025-09-29', 46, 46, 'Applied'),
(49, '2025-11-28', 48, 48, 'Accepted'),
(50, '2025-11-30', 49, 49, 'Applied'),
(51, '2025-12-01', 50, 49, 'Applied'),
(52, '2025-12-01', 55, 49, 'Applied'),
(53, '2025-12-01', 55, 50, 'Applied'),
(54, '2025-12-02', 56, 49, 'Applied'),
(55, '2026-01-03', 48, 51, 'Applied'),
(56, '2026-01-03', 55, 51, 'Applied'),
(57, '2026-01-03', 57, 51, 'Applied');

-- --------------------------------------------------------

--
-- Table structure for table `job_payments`
--

CREATE TABLE `job_payments` (
  `id` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `payment_id` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `job_type` varchar(50) NOT NULL DEFAULT 'white_collar',
  `amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(50) NOT NULL DEFAULT 'pending',
  `admin_status` varchar(50) NOT NULL DEFAULT 'pending',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_confirmed_date` timestamp NULL DEFAULT NULL,
  `admin_notes` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_payments`
--

INSERT INTO `job_payments` (`id`, `pid`, `payment_id`, `eid`, `job_type`, `amount`, `payment_status`, `admin_status`, `created_date`, `admin_confirmed_date`, `admin_notes`) VALUES
(1, NULL, 1, 34, 'white_collar', 500.00, 'pending', 'pending', '2025-12-01 15:47:01', NULL, NULL),
(2, NULL, 2, 34, 'white_collar', 500.00, 'pending', 'pending', '2025-12-01 15:47:42', NULL, NULL),
(3, NULL, 3, 34, 'white_collar', 500.00, 'pending', 'pending', '2025-12-01 16:03:56', NULL, NULL),
(4, NULL, 4, 34, 'white_collar', 500.00, 'confirmed', 'pending', '2025-12-01 16:12:05', NULL, NULL),
(5, NULL, 5, 34, 'white_collar', 500.00, 'confirmed', 'pending', '2025-12-01 16:13:20', NULL, NULL),
(6, NULL, 6, 34, 'white_collar', 500.00, 'confirmed', 'pending', '2025-12-01 16:13:35', NULL, NULL),
(10, NULL, 10, 34, 'white_collar', 500.00, 'confirmed', 'pending', '2025-12-01 16:40:19', NULL, NULL),
(12, 55, 12, 34, 'white_collar', 500.00, 'confirmed', 'approved', '2025-12-01 16:45:19', '2025-12-01 16:46:38', NULL),
(13, 56, 13, 34, 'blue_collar', 200.00, 'confirmed', 'approved', '2025-12-02 10:21:31', '2026-01-03 07:11:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logpost`
--

CREATE TABLE `logpost` (
  `lpid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `category` varchar(500) NOT NULL,
  `industry` varchar(500) NOT NULL,
  `role` varchar(100) NOT NULL,
  `employmentType` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL,
  `action` varchar(500) NOT NULL,
  `cdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logpost`
--

INSERT INTO `logpost` (`lpid`, `pid`, `eid`, `name`, `category`, `industry`, `role`, `employmentType`, `status`, `action`, `cdate`) VALUES
(7, 40, 4, 'Product Manager', 'Business Intelligence Jobs', 'IT-Software , Software Services', 'Lead', 'Permanent', 'Open', 'INSERTED', '2023-02-02 10:46:59'),
(8, 41, 29, 'Graphic Designer', 'Graphic Designer Jobs', 'Animation , Gaming', 'Intern', 'Permanent', 'Open', 'INSERTED', '2023-02-02 10:53:40'),
(9, 42, 28, 'Python Developer', 'IT Jobs', 'IT-Software , Software Services', 'Asst. Python Developer ', 'Permanent', 'Open', 'INSERTED', '2023-02-02 11:03:24'),
(10, 6, 14, 'Team Lead (Technical)', 'IT Jobs', 'IT-Software , Software Services', 'Team Lead', 'Permanent', 'open', 'UPDATED', '2023-02-02 11:07:48'),
(11, 8, 16, 'Accounts Manager', 'Accounting Jobs', 'Accounting , Finance', 'Accounts Manager', 'Permanent', 'open', 'UPDATED', '2023-02-02 11:09:58'),
(12, 43, 30, 'Software Engineer', 'IT Jobs', 'IT-Software , Software Services', 'Backend Engg.', 'Permanent', 'Open', 'INSERTED', '2023-04-15 03:22:03'),
(13, 6, 14, 'Team Lead (Technical)', 'IT Jobs', 'IT-Software , Software Services', 'Team Lead', 'Permanent', 'open', 'UPDATED', '2023-04-19 13:58:53'),
(14, 8, 16, 'Accounts Manager', 'Accounting Jobs', 'Accounting , Finance', 'Accounts Manager', 'Permanent', 'open', 'UPDATED', '2023-04-19 13:59:02'),
(15, 40, 4, 'Product Manager', 'Business Intelligence Jobs', 'IT-Software , Software Services', 'Lead', 'Permanent', 'Open', 'UPDATED', '2023-04-19 13:59:06'),
(16, 41, 29, 'Graphic Designer', 'Graphic Designer Jobs', 'Animation , Gaming', 'Intern', 'Permanent', 'Open', 'UPDATED', '2023-04-19 13:59:11'),
(17, 42, 28, 'Python Developer', 'IT Jobs', 'IT-Software , Software Services', 'Asst. Python Developer ', 'Permanent', 'Open', 'UPDATED', '2023-04-19 13:59:17'),
(18, 44, 11, 'Backend Intern', 'System Programming Jobs', 'IT-Software , Software Services', 'Intern', 'Permanent', 'Open', 'INSERTED', '2023-04-19 15:13:19'),
(19, 45, 31, 'App developer', 'Engineering Jobs', 'IT-Software , Software Services', 'App developer', 'Permanent', 'Open', 'INSERTED', '2025-09-22 22:04:53'),
(20, 46, 32, 'softwaree engineer', 'Engineering Jobs', 'IT-Software , Software Services', 'Software Engineer', 'Permanent', 'Open', 'INSERTED', '2025-09-25 13:19:03'),
(21, 47, 33, 'CSE Engineer', 'Engineering Jobs', 'IT-Hardware & Networking', 'Software Engineer', 'Permanent', 'Open', 'INSERTED', '2025-11-26 23:17:04'),
(22, 48, 34, 'Data Analyst', 'Analytics Jobs', 'Textiles , Garments , Accessories', 'data scientist', 'Permanent', 'Open', 'INSERTED', '2025-11-28 19:40:47'),
(23, 49, 34, 'Data Scientist', 'Engineering Jobs', 'Broadcasting', 'data scientist', '???????', '????', 'INSERTED', '2025-11-30 15:34:25'),
(24, 49, 34, 'Data Scientist', '- All Job Postings -', 'Accounting , Finance', 'data scientist', '???????', '????', 'UPDATED', '2025-11-30 15:35:02'),
(25, 50, 34, 'driver', 'driver', 'Other', 'driver', 'Permanent', 'Open', 'INSERTED', '2025-12-01 14:21:12'),
(26, 50, 34, 'driver', 'driver', 'Other', 'driver', 'Permanent', 'Open', 'DELETED', '2025-12-01 15:09:42'),
(27, 51, 34, '', '', '', '', '', 'open', 'INSERTED', '2025-12-01 22:14:44'),
(28, 52, 34, '', '', '', '', '', 'open', 'INSERTED', '2025-12-01 22:17:43'),
(29, 51, 34, '', '', '', '', '', 'open', 'UPDATED', '2025-12-01 22:21:37'),
(30, 52, 34, '', '', '', '', '', 'open', 'UPDATED', '2025-12-01 22:21:41'),
(31, 49, 34, 'Data Scientist', '- All Job Postings -', 'Accounting , Finance', 'data scientist', '???????', '????', 'DELETED', '2025-12-01 22:30:53'),
(32, 52, 34, '', '', '', '', '', 'open', 'DELETED', '2025-12-01 22:34:30'),
(33, 51, 34, '', '', '', '', '', 'open', 'DELETED', '2025-12-01 22:34:32'),
(34, 53, 34, '', '', '', '', '', 'open', 'INSERTED', '2025-12-01 22:36:58'),
(35, 53, 34, '', '', '', '', '', 'open', 'DELETED', '2025-12-01 22:39:27'),
(36, 54, 34, '', '', '', '', '', 'open', 'INSERTED', '2025-12-01 22:41:07'),
(37, 54, 34, '', '', '', '', '', 'open', 'UPDATED', '2025-12-01 22:41:53'),
(38, 54, 34, '', '', '', '', '', 'open', 'DELETED', '2025-12-01 22:44:31'),
(39, 55, 34, 'tution', '', 'Accounting , Finance', 'tution', 'Permanent', 'open', 'INSERTED', '2025-12-01 22:45:19'),
(40, 55, 34, 'tution', '', 'Accounting , Finance', 'tution', 'Permanent', 'open', 'UPDATED', '2025-12-01 22:46:38'),
(41, 56, 34, 'day labor', '', 'Accounting , Finance', 'labor', 'Permanent', 'open', 'INSERTED', '2025-12-02 16:21:31'),
(42, 57, 34, 'HR', '', 'Accounting , Finance', 'HR', 'Permanent', 'open', 'INSERTED', '2026-01-03 13:10:50'),
(43, 57, 34, 'HR', '', 'Accounting , Finance', 'HR', 'Permanent', 'open', 'UPDATED', '2026-01-03 13:11:47'),
(44, 56, 34, 'day labor', '', 'Accounting , Finance', 'labor', 'Permanent', 'open', 'UPDATED', '2026-01-03 13:11:50'),
(45, 57, 34, 'HR', '', 'Accounting , Finance', 'HR', 'Permanent', 'open', 'DELETED', '2026-01-04 22:25:13');

-- --------------------------------------------------------

--
-- Table structure for table `otp_verification`
--

CREATE TABLE `otp_verification` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `user_type` enum('employer','seeker') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `attempts` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `eid` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) DEFAULT 'BDT',
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `validated_date` timestamp NULL DEFAULT NULL,
  `validation_response` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `transaction_id`, `eid`, `amount`, `currency`, `status`, `payment_date`, `validated_date`, `validation_response`) VALUES
(1, 'JOB3417646040219292', 34, 500.00, 'BDT', 'pending', '2025-12-01 15:47:01', NULL, NULL),
(2, 'JOB3417646040622852', 34, 500.00, 'BDT', 'pending', '2025-12-01 15:47:42', NULL, NULL),
(3, 'JOB3417646050356150', 34, 500.00, 'BDT', 'pending', '2025-12-01 16:03:55', NULL, NULL),
(4, 'JOB3417646055258415', 34, 500.00, 'BDT', 'validated', '2025-12-01 16:12:05', '2025-12-01 16:12:05', NULL),
(5, 'JOB3417646056006190', 34, 500.00, 'BDT', 'validated', '2025-12-01 16:13:20', '2025-12-01 16:13:20', NULL),
(6, 'JOB3417646056156834', 34, 500.00, 'BDT', 'validated', '2025-12-01 16:13:35', '2025-12-01 16:13:35', NULL),
(7, 'JOB3417646056849333', 34, 500.00, 'BDT', 'validated', '2025-12-01 16:14:44', '2025-12-01 16:14:44', NULL),
(8, 'JOB3417646058637773', 34, 500.00, 'BDT', 'validated', '2025-12-01 16:17:43', '2025-12-01 16:17:43', NULL),
(9, 'JOB3417646070184049', 34, 500.00, 'BDT', 'validated', '2025-12-01 16:36:58', '2025-12-01 16:36:58', NULL),
(10, 'JOB3417646072199336', 34, 500.00, 'BDT', 'validated', '2025-12-01 16:40:19', '2025-12-01 16:40:19', NULL),
(11, 'JOB3417646072671810', 34, 500.00, 'BDT', 'validated', '2025-12-01 16:41:07', '2025-12-01 16:41:07', NULL),
(12, 'JOB3417646075194121', 34, 500.00, 'BDT', 'validated', '2025-12-01 16:45:19', '2025-12-01 16:45:19', NULL),
(13, 'JOB3417646708907310', 34, 200.00, 'BDT', 'validated', '2025-12-02 10:21:30', '2025-12-02 10:21:30', NULL),
(14, 'JOB3417674242509921', 34, 500.00, 'BDT', 'validated', '2026-01-03 07:10:50', '2026-01-03 07:10:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `eid` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `category` varchar(500) NOT NULL,
  `minexp` varchar(100) NOT NULL,
  `desc` varchar(5000) NOT NULL,
  `salary` varchar(200) NOT NULL,
  `industry` varchar(500) NOT NULL,
  `role` varchar(500) NOT NULL,
  `employmentType` varchar(500) NOT NULL,
  `status` varchar(100) NOT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `payment_status` varchar(50) NOT NULL DEFAULT 'unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `date`, `eid`, `name`, `category`, `minexp`, `desc`, `salary`, `industry`, `role`, `employmentType`, `status`, `payment_id`, `payment_status`) VALUES
(6, '2023-01-04 18:30:00', 14, 'Team Lead (Technical)', 'IT Jobs', '8', 'Aid a group of programmers.', '100000-150000', 'IT-Software , Software Services', 'Team Lead', 'Permanent', 'open', NULL, 'unpaid'),
(8, '2023-01-04 18:30:00', 16, 'Accounts Manager', 'Accounting Jobs', '6', 'Experience with accounting software. General Math skills.', '70000-80000', 'Accounting , Finance', 'Accounts Manager', 'Permanent', 'open', NULL, 'unpaid'),
(40, '2023-02-01 18:30:00', 4, 'Product Manager', 'Business Intelligence Jobs', '3', 'Communication Skills, Technical Knowledge', '40000-60000', 'IT-Software , Software Services', 'Lead', 'Permanent', 'Open', NULL, 'unpaid'),
(41, '2023-02-01 18:30:00', 29, 'Graphic Designer', 'Graphic Designer Jobs', '3', '3D Animation, Adobe products.', '30000-50000', 'Animation , Gaming', 'Intern', 'Permanent', 'Open', NULL, 'unpaid'),
(42, '2023-02-01 18:30:00', 28, 'Python Developer', 'IT Jobs', '2', 'Proficiency in Python, Test software components', '40000-60000', 'IT-Software , Software Services', 'Asst. Python Developer ', 'Permanent', 'Open', NULL, 'unpaid'),
(43, '2023-04-14 18:30:00', 30, 'Software Engineer', 'IT Jobs', '3 years', 'B.Tech', '20000', 'IT-Software , Software Services', 'Backend Engg', 'Permanent', 'Open', NULL, 'unpaid'),
(44, '2023-04-18 18:30:00', 11, 'Backend Intern', 'System Programming Jobs', '1-1.5 years', 'MERN', '25000 - 30000', 'IT-Software , Software Services', 'Intern', 'Permanent', 'Open', NULL, 'unpaid'),
(45, '2025-09-21 18:00:00', 31, 'App developer', 'Engineering Jobs', '2 years', 'BSc Engg', '30000', 'IT-Software , Software Services', 'App developer', 'Permanent', 'Open', NULL, 'unpaid'),
(46, '2025-09-24 18:00:00', 32, 'softwaree engineer', 'Engineering Jobs', '2 years', 'CGPA atleast 3.00', 'negotiable', 'IT-Software , Software Services', 'Software Engineer', 'Permanent', 'Open', NULL, 'unpaid'),
(47, '2025-11-25 18:00:00', 33, 'CSE Engineer', 'Engineering Jobs', 'BSC(ENGG)in CSE', 'CGPA atleast 3.00', '25,000', 'IT-Hardware & Networking', 'Software Engineer', 'Permanent', 'Open', NULL, 'unpaid'),
(48, '2025-11-27 18:00:00', 34, 'Data Analyst', 'Analytics Jobs', '2 years', 'CGPA atleast 3.00', 'negotiable', 'Textiles , Garments , Accessories', 'data scientist', 'Permanent', 'Open', NULL, 'unpaid'),
(55, '2025-12-01 16:45:19', 34, 'tution', '', '1 years', 'good teaching skills', '10000', 'Accounting , Finance', 'tution', 'Permanent', 'open', NULL, 'unpaid'),
(56, '2025-12-02 10:21:31', 34, 'day labor', '', '1', 'experienced', 'negotiable', 'Accounting , Finance', 'labor', 'Permanent', 'open', NULL, 'unpaid');

--
-- Triggers `post`
--
DELIMITER $$
CREATE TRIGGER `Existing Row Deleted` AFTER DELETE ON `post` FOR EACH ROW INSERT INTO logpost VALUES(null, OLD.id, OLD.eid, OLD.name, OLD.category, OLD.industry, OLD.role, OLD.employmentType, OLD.status, 'DELETED', NOW())
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Existing Row Updated` AFTER UPDATE ON `post` FOR EACH ROW INSERT INTO logpost VALUES(null, NEW.id, NEW.eid, NEW.name, NEW.category, NEW.industry, NEW.role, NEW.employmentType, NEW.status, 'UPDATED', NOW())
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `New Row Inserted` AFTER INSERT ON `post` FOR EACH ROW INSERT INTO logpost VALUES(null, NEW.id, NEW.eid, NEW.name, NEW.category, NEW.industry, NEW.role, NEW.employmentType, NEW.status, 'INSERTED', NOW())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `seeker`
--

CREATE TABLE `seeker` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `qualification` varchar(500) NOT NULL,
  `dob` date NOT NULL,
  `skills` varchar(2000) NOT NULL,
  `resume` varchar(500) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `linkedin_profile` varchar(255) DEFAULT NULL,
  `cv_file` varchar(255) DEFAULT NULL,
  `certificates` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `seeker`
--

INSERT INTO `seeker` (`id`, `name`, `email`, `password`, `qualification`, `dob`, `skills`, `resume`, `profile_image`, `linkedin_profile`, `cv_file`, `certificates`) VALUES
(36, 'Nishit Killa', 'nishit@gmail.com', 'password', 'BE', '2001-06-21', 'C++, JAVA', '', NULL, NULL, NULL, NULL),
(37, 'Tushar Jain', 'tushar@gmail.com', 'password', 'BE', '2001-07-04', 'HTML, CSS, JS', '', NULL, NULL, NULL, NULL),
(38, 'Sreeleena Ganguli', 'sreeleena@gmail.com', 'password', 'MTech', '2001-09-05', 'Backend Engg.', '', NULL, NULL, NULL, NULL),
(39, 'Riteek Rakesh', 'riteek@gmail.com', 'password', 'BE', '2001-06-02', 'Circuit Design', '', NULL, NULL, NULL, NULL),
(40, 'Sayantan Podder', 'sayantan@gmail.com', 'password', 'BE', '1995-07-19', 'Machine Learning', '', NULL, NULL, NULL, NULL),
(41, 'Sampurna Ghosh', 'sampurna@gmail.com', 'password', 'B.Sc.', '1995-11-23', 'Physiotherapy', '', NULL, NULL, NULL, NULL),
(42, 'Rahul Adhikary', 'rahul@gmail.com', 'password', 'BBA', '1991-08-12', 'International Business', '', NULL, NULL, NULL, NULL),
(43, 'Mariam Meerza', 'mariam@gmail.com', 'password', 'BE', '1998-03-07', 'Computer Applications', '', NULL, NULL, NULL, NULL),
(44, 'tanvir', 'tanvir@gmail.com', 'tanvir@gmail.com', 'bsc engg', '2000-01-01', 'flutter', '', 'seeker_44_1759161703.png', 'https://www.facebook.com/chowdhury.wajid/', 'cv_44_1759161959.pdf', '[\"cert_44_1759164012_0.pdf\",\"cert_44_1759164012_1.pdf\",\"cert_44_1759164012_2.pdf\",\"cert_44_1759164012_3.pdf\"]'),
(45, 'akib', 'akib@gmail.com', 'akib@gmail.com', 'BSc', '2001-12-24', 'flutter,dart,firebase', '', NULL, NULL, NULL, NULL),
(49, 'wajid', 'wajid567765@gmail.com', 'wajid567765@gmail.com', 'BSc', '2025-11-30', 'flutter,dart,firebase', '', 'seeker_49_1764495452.jpg', 'https://www.facebook.com/chowdhury.wajid/', 'cv_49_1764669391.pdf', '[\"cert_49_1764495483_0.pdf\"]'),
(50, 'kafi', 'kafi@gmail.com', 'kafi@gmail.com', 'BSC', '2025-12-01', 'teaching', '', NULL, NULL, NULL, NULL),
(51, 'nafis@gmail.com', 'nafis@gmail.com', 'nafis@gmail.com', 'BSc', '2026-01-03', 'flutter,dart,firebase', '', 'seeker_51_1767416507.jpg', 'https://www.facebook.com/chowdhury.wajid/', 'cv_51_1767416554.pdf', '[\"cert_51_1767416554_0.pdf\"]'),
(52, 'tarif@gmail.com', 'tarif@gmail.com', 'tarif@gmail.com', 'bsc', '2026-01-03', 'flutter', '', NULL, NULL, NULL, NULL),
(53, 'karan', 'shafayat18@cse.pstu.ac.bd', '$2y$10$JcFEc/TwzEKpQv3H.YnGWu95m/B2ayG4DK6IeYJGq9wC4I2VSq0Ki', 'BSc', '2026-01-04', 'python', '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `totalposts`
--

CREATE TABLE `totalposts` (
  `AllPosts` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `totalposts`
--

INSERT INTO `totalposts` (`AllPosts`) VALUES
(7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `SeekersAndEmployers` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`SeekersAndEmployers`) VALUES
(19);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employer`
--
ALTER TABLE `employer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`exam_id`);

--
-- Indexes for table `exam_answers`
--
ALTER TABLE `exam_answers`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `result_id` (`result_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD PRIMARY KEY (`result_id`),
  ADD UNIQUE KEY `unique_attempt` (`exam_id`,`seeker_id`,`submitted_at`),
  ADD KEY `seeker_id` (`seeker_id`);

--
-- Indexes for table `jobsapplied`
--
ALTER TABLE `jobsapplied`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobapplied_seekerFK` (`sid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `job_payments`
--
ALTER TABLE `job_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eid` (`eid`),
  ADD KEY `idx_pid` (`pid`),
  ADD KEY `idx_payment_id` (`payment_id`),
  ADD KEY `idx_payment_status` (`payment_status`),
  ADD KEY `idx_admin_status` (`admin_status`);

--
-- Indexes for table `logpost`
--
ALTER TABLE `logpost`
  ADD PRIMARY KEY (`lpid`);

--
-- Indexes for table `otp_verification`
--
ALTER TABLE `otp_verification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `expires_at` (`expires_at`),
  ADD KEY `idx_email_type` (`email`,`user_type`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `idx_transaction_id` (`transaction_id`),
  ADD KEY `idx_eid` (`eid`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `employer_postFK` (`eid`);

--
-- Indexes for table `seeker`
--
ALTER TABLE `seeker`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employer`
--
ALTER TABLE `employer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam_answers`
--
ALTER TABLE `exam_answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `exam_questions`
--
ALTER TABLE `exam_questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobsapplied`
--
ALTER TABLE `jobsapplied`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `job_payments`
--
ALTER TABLE `job_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `logpost`
--
ALTER TABLE `logpost`
  MODIFY `lpid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `otp_verification`
--
ALTER TABLE `otp_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `seeker`
--
ALTER TABLE `seeker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exam_answers`
--
ALTER TABLE `exam_answers`
  ADD CONSTRAINT `exam_answers_ibfk_1` FOREIGN KEY (`result_id`) REFERENCES `exam_results` (`result_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `exam_questions` (`question_id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD CONSTRAINT `exam_questions_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD CONSTRAINT `exam_results_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_results_ibfk_2` FOREIGN KEY (`seeker_id`) REFERENCES `seeker` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_payments`
--
ALTER TABLE `job_payments`
  ADD CONSTRAINT `job_payments_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `job_payments_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`),
  ADD CONSTRAINT `job_payments_ibfk_3` FOREIGN KEY (`eid`) REFERENCES `employer` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`eid`) REFERENCES `employer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
