-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2026 at 07:57 PM
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
-- Table structure for table `coding_exam_results`
--

CREATE TABLE `coding_exam_results` (
  `result_id` int(11) NOT NULL,
  `seeker_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `total_score` int(11) NOT NULL DEFAULT 0,
  `max_score` int(11) NOT NULL DEFAULT 100,
  `problems_solved` int(11) NOT NULL DEFAULT 0,
  `total_problems` int(11) NOT NULL DEFAULT 5,
  `time_taken_seconds` int(11) DEFAULT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coding_exam_results`
--

INSERT INTO `coding_exam_results` (`result_id`, `seeker_id`, `exam_id`, `total_score`, `max_score`, `problems_solved`, `total_problems`, `time_taken_seconds`, `completed_at`) VALUES
(1, 49, 5, 60, 100, 5, 5, 128, '2026-01-06 18:33:50'),
(2, 49, 5, 60, 60, 5, 5, 683, '2026-01-06 18:46:34');

-- --------------------------------------------------------

--
-- Table structure for table `coding_problems`
--

CREATE TABLE `coding_problems` (
  `problem_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `difficulty` varchar(50) NOT NULL DEFAULT 'medium',
  `time_limit` int(11) NOT NULL DEFAULT 2,
  `memory_limit` int(11) NOT NULL DEFAULT 256,
  `sample_input` longtext NOT NULL,
  `sample_output` longtext NOT NULL,
  `explanation` longtext DEFAULT NULL,
  `language_support` varchar(255) NOT NULL DEFAULT 'python,cpp,java',
  `points` int(11) NOT NULL DEFAULT 10,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coding_problems`
--

INSERT INTO `coding_problems` (`problem_id`, `exam_id`, `title`, `description`, `difficulty`, `time_limit`, `memory_limit`, `sample_input`, `sample_output`, `explanation`, `language_support`, `points`, `created_at`) VALUES
(1, 5, 'Sum of Two Numbers', 'Given two integers A and B, find their sum.\n\nInput Format:\nFirst line contains two space-separated integers A and B\n\nOutput Format:\nPrint the sum of A and B\n\nConstraints:\n1 ≤ A, B ≤ 10^9', 'easy', 2, 256, '5 10', '15', 'Simply add A and B and print the result.', 'python,cpp,java', 10, '2026-01-06 17:01:54'),
(2, 5, 'Reverse a String', 'Given a string S, reverse it and print it.\n\nInput Format:\nFirst line contains a string S\n\nOutput Format:\nPrint the reversed string\n\nConstraints:\n1 ≤ length of S ≤ 1000', 'easy', 2, 256, 'hello', 'olleh', 'Use string reversal operations to reverse the input string.', 'python,cpp,java', 10, '2026-01-06 17:01:54'),
(3, 5, 'Count Vowels', 'Given a string S, count the number of vowels in it.\n\nInput Format:\nFirst line contains a string S\n\nOutput Format:\nPrint the count of vowels (a, e, i, o, u)\n\nConstraints:\n1 ≤ length of S ≤ 10000', 'easy', 2, 256, 'programming', '3', 'Iterate through each character and count vowels.', 'python,cpp,java', 10, '2026-01-06 17:01:54'),
(4, 5, 'Fibonacci Series', 'Given N, print the first N Fibonacci numbers.\n\nInput Format:\nFirst line contains integer N\n\nOutput Format:\nPrint N Fibonacci numbers separated by space\n\nConstraints:\n1 ≤ N ≤ 50', 'medium', 2, 256, '7', '0 1 1 2 3 5 8', 'Use the Fibonacci formula where F(n) = F(n-1) + F(n-2), with F(0)=0 and F(1)=1.', 'python,cpp,java', 15, '2026-01-06 17:01:54'),
(5, 5, 'Find Largest Element', 'Given an array of N integers, find the largest element.\n\nInput Format:\nFirst line contains N\nSecond line contains N space-separated integers\n\nOutput Format:\nPrint the largest element\n\nConstraints:\n1 ≤ N ≤ 10^5\n-10^9 ≤ elements ≤ 10^9', 'easy', 2, 256, '5\n3 7 2 9 1', '9', 'Compare all elements and find the maximum value.', 'python,cpp,java', 15, '2026-01-06 17:01:54');

-- --------------------------------------------------------

--
-- Table structure for table `coding_submissions`
--

CREATE TABLE `coding_submissions` (
  `submission_id` int(11) NOT NULL,
  `seeker_id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `code` longtext NOT NULL,
  `language` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `test_cases_passed` int(11) NOT NULL DEFAULT 0,
  `test_cases_total` int(11) NOT NULL DEFAULT 0,
  `execution_time` float DEFAULT NULL,
  `memory_used` int(11) DEFAULT NULL,
  `error_message` longtext DEFAULT NULL,
  `points_earned` int(11) DEFAULT 0,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coding_submissions`
--

INSERT INTO `coding_submissions` (`submission_id`, `seeker_id`, `problem_id`, `exam_id`, `code`, `language`, `status`, `test_cases_passed`, `test_cases_total`, `execution_time`, `memory_used`, `error_message`, `points_earned`, `submitted_at`) VALUES
(1, 49, 2, 5, 's = input()\r\nprint(s[::-1])', 'python', '0', 4, 4, NULL, NULL, '', 0, '2026-01-06 17:51:18'),
(2, 49, 3, 5, 's = input()\r\nvowels = \"aeiouAEIOU\"\r\ncount = sum(1 for c in s if c in vowels)\r\nprint(count)', 'python', '0', 4, 4, NULL, NULL, '', 0, '2026-01-06 17:52:17'),
(3, 49, 4, 5, 'n = int(input())\r\na, b = 0, 1\r\nresult = []\r\nfor i in range(n):\r\n    result.append(a)\r\n    a, b = b, a + b\r\nprint(\' \'.join(map(str, result)))', 'python', '0', 3, 3, NULL, NULL, '', 0, '2026-01-06 17:52:49'),
(4, 49, 5, 5, 'n = int(input())\r\narr = list(map(int, input().split()))\r\nprint(max(arr))', 'python', '0', 4, 4, NULL, NULL, '', 0, '2026-01-06 17:53:18'),
(5, 49, 1, 5, 'd', 'python', '0', 0, 4, NULL, NULL, '', 0, '2026-01-06 18:02:56'),
(6, 49, 1, 5, 'a, b = map(int, input().split())\r\nprint(a + b)', 'python', '0', 4, 4, NULL, NULL, '', 0, '2026-01-06 18:03:06'),
(7, 49, 1, 5, 'a, b = map(int, input().split())\r\nprint(a + b)', 'python', '0', 4, 4, NULL, NULL, '', 0, '2026-01-06 18:16:40'),
(8, 49, 2, 5, 's = input()\r\nprint(s[::-1])\r\n', 'python', '0', 4, 4, NULL, NULL, '', 0, '2026-01-06 18:17:33'),
(9, 49, 3, 5, 's = input()\r\nvowels = \"aeiouAEIOU\"\r\ncount = sum(1 for c in s if c in vowels)\r\nprint(count)', 'python', '0', 4, 4, NULL, NULL, '', 0, '2026-01-06 18:17:57'),
(10, 49, 4, 5, 'n = int(input())\r\na, b = 0, 1\r\nresult = []\r\nfor i in range(n):\r\n    result.append(a)\r\n    a, b = b, a + b\r\nprint(\' \'.join(map(str, result)))', 'python', '0', 3, 3, NULL, NULL, '', 0, '2026-01-06 18:18:24'),
(11, 49, 5, 5, 'n = int(input())\r\narr = list(map(int, input().split()))\r\nprint(max(arr))', 'python', '0', 4, 4, NULL, NULL, '', 0, '2026-01-06 18:18:49'),
(12, 49, 1, 5, 'a, b = map(int, input().split())\r\nprint(a + b)', 'python', '0', 4, 4, NULL, NULL, '', 10, '2026-01-06 18:32:31'),
(13, 49, 2, 5, 's = input()\r\nprint(s[::-1])', 'python', '0', 4, 4, NULL, NULL, '', 10, '2026-01-06 18:32:55'),
(14, 49, 3, 5, 's = input()\r\nvowels = \"aeiouAEIOU\"\r\ncount = sum(1 for c in s if c in vowels)\r\nprint(count)', 'python', '0', 4, 4, NULL, NULL, '', 10, '2026-01-06 18:33:12'),
(15, 49, 4, 5, 'n = int(input())\r\na, b = 0, 1\r\nresult = []\r\nfor i in range(n):\r\n    result.append(a)\r\n    a, b = b, a + b\r\nprint(\' \'.join(map(str, result)))', 'python', '0', 3, 3, NULL, NULL, '', 15, '2026-01-06 18:33:32'),
(16, 49, 5, 5, 'n = int(input())\r\narr = list(map(int, input().split()))\r\nprint(max(arr))', 'python', '0', 4, 4, NULL, NULL, '', 15, '2026-01-06 18:33:48'),
(17, 49, 1, 5, 'a, b = map(int, input().split())\r\nprint(a + b)', 'python', '0', 4, 4, NULL, NULL, '', 10, '2026-01-06 18:45:34'),
(18, 49, 2, 5, 's = input()\r\nprint(s[::-1])', 'python', '0', 4, 4, NULL, NULL, '', 10, '2026-01-06 18:45:48'),
(19, 49, 3, 5, 's = input()\r\nvowels = \"aeiouAEIOU\"\r\ncount = sum(1 for c in s if c in vowels)\r\nprint(count)', 'python', '0', 4, 4, NULL, NULL, '', 10, '2026-01-06 18:46:03'),
(20, 49, 4, 5, 'n = int(input())\r\na, b = 0, 1\r\nresult = []\r\nfor i in range(n):\r\n    result.append(a)\r\n    a, b = b, a + b\r\nprint(\' \'.join(map(str, result)))', 'python', '0', 3, 3, NULL, NULL, '', 15, '2026-01-06 18:46:19'),
(21, 49, 5, 5, 'n = int(input())\r\narr = list(map(int, input().split()))\r\nprint(max(arr))', 'python', '0', 4, 4, NULL, NULL, '', 15, '2026-01-06 18:46:32');

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
  `exam_category` varchar(50) DEFAULT NULL COMMENT 'it, banking, education, general',
  `exam_type` varchar(100) DEFAULT NULL COMMENT 'MCQ, MCQ+Short, MCQ+Coding, etc.',
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

INSERT INTO `exams` (`exam_id`, `exam_name`, `exam_category`, `exam_type`, `description`, `total_questions`, `total_marks`, `passing_marks`, `duration_minutes`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'IT, Engineering, Technical & Software Sector', 'it', 'MCQ', 'Comprehensive exam covering Programming, Data Structures, Databases, Networks, and more', 50, 100, 50, 60, 1, '2026-01-06 16:25:23', '2026-01-06 16:25:23'),
(2, 'Banking, Finance & Corporate Sector', 'banking', 'MCQ', 'Exam on General Banking, Accounting, Financial Management, and Corporate Knowledge', 50, 100, 50, 60, 1, '2026-01-06 16:25:23', '2026-01-06 16:25:23'),
(3, 'Education & Training Sector', 'education', 'MCQ', 'Assessment on School Subjects, Teaching Methodology, Psychology, and Education Policy', 50, 100, 50, 60, 1, '2026-01-06 16:25:23', '2026-01-06 16:25:23'),
(4, 'General Jobs Category', 'general', 'MCQ', 'General knowledge exam for Sales, Marketing, Security, Hotel, Logistics and similar roles', 50, 100, 50, 60, 1, '2026-01-06 16:25:23', '2026-01-06 16:25:23'),
(5, 'Coding Challenge', 'coding', 'Coding Problems', NULL, 5, 100, 50, 180, 1, '2026-01-06 17:01:54', '2026-01-06 17:01:54');

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
  `question_type` varchar(50) DEFAULT 'mcq' COMMENT 'mcq, short_answer, coding',
  `question_order` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_questions`
--

INSERT INTO `exam_questions` (`question_id`, `exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`, `question_order`, `created_at`) VALUES
(51, 1, 'Which of the following is a compiled language?', 'Python', 'C++', 'JavaScript', 'Ruby', 'B', 2, 'Programming', 'mcq', NULL, '2026-01-06 16:25:23'),
(52, 1, 'What is the output of this Python code: print(2 ** 3)?', '5', '6', '8', '9', 'C', 2, 'Programming', 'mcq', NULL, '2026-01-06 16:25:23'),
(53, 1, 'In Java, which keyword is used to define a constant?', 'const', 'constant', 'final', 'static', 'C', 2, 'Programming', 'mcq', NULL, '2026-01-06 16:25:23'),
(54, 1, 'What does OOP stand for?', 'Object Oriented Programming', 'Object Ordering Programming', 'Objective Oriented Process', 'Object Organization Programming', 'A', 2, 'Programming', 'mcq', NULL, '2026-01-06 16:25:23'),
(55, 1, 'Which of the following is NOT a programming paradigm?', 'Functional', 'Procedural', 'Objective', 'Object-Oriented', 'C', 2, 'Programming', 'mcq', NULL, '2026-01-06 16:25:23'),
(56, 1, 'What is the time complexity of binary search?', 'O(n)', 'O(log n)', 'O(n^2)', 'O(1)', 'B', 2, 'Data Structures & Algorithms', 'mcq', NULL, '2026-01-06 16:25:23'),
(57, 1, 'Which data structure uses LIFO principle?', 'Queue', 'Stack', 'Tree', 'Graph', 'B', 2, 'Data Structures & Algorithms', 'mcq', NULL, '2026-01-06 16:25:23'),
(58, 1, 'What is the space complexity of a recursive Fibonacci function?', 'O(1)', 'O(n)', 'O(n^2)', 'O(2^n)', 'D', 2, 'Data Structures & Algorithms', 'mcq', NULL, '2026-01-06 16:25:23'),
(59, 1, 'Which sorting algorithm has the best average time complexity?', 'Bubble Sort', 'Merge Sort', 'Selection Sort', 'Insertion Sort', 'B', 2, 'Data Structures & Algorithms', 'mcq', NULL, '2026-01-06 16:25:23'),
(60, 1, 'What is the main advantage of using Hash Tables?', 'Fast sorting', 'O(1) average lookup time', 'No memory overhead', 'Better cache performance', 'B', 2, 'Data Structures & Algorithms', 'mcq', NULL, '2026-01-06 16:25:23'),
(61, 1, 'Which SQL command is used to create a new database?', 'MAKE DATABASE', 'CREATE DATABASE', 'NEW DATABASE', 'ADD DATABASE', 'B', 2, 'Database (SQL, DBMS)', 'mcq', NULL, '2026-01-06 16:25:23'),
(62, 1, 'What does ACID stand for in database systems?', 'Atomicity, Consistency, Isolation, Durability', 'Accuracy, Consistency, Integration, Duration', 'Activity, Concurrency, Interaction, Data', 'Authorization, Certification, Identity, Data', 'A', 2, 'Database (SQL, DBMS)', 'mcq', NULL, '2026-01-06 16:25:23'),
(63, 1, 'Which type of join returns all rows from both tables?', 'INNER JOIN', 'LEFT JOIN', 'FULL OUTER JOIN', 'CROSS JOIN', 'C', 2, 'Database (SQL, DBMS)', 'mcq', NULL, '2026-01-06 16:25:23'),
(64, 1, 'What is a primary key in a database?', 'A key that opens the database', 'A field with unique values for each record', 'The first column in a table', 'The most important data column', 'B', 2, 'Database (SQL, DBMS)', 'mcq', NULL, '2026-01-06 16:25:23'),
(65, 1, 'Which index type is best for range queries?', 'Hash Index', 'B-tree Index', 'Bitmap Index', 'Function Index', 'B', 2, 'Database (SQL, DBMS)', 'mcq', NULL, '2026-01-06 16:25:23'),
(66, 1, 'What does TCP stand for?', 'Transfer Control Protocol', 'Transmission Control Protocol', 'Transfer Communication Protocol', 'Transmission Connection Protocol', 'B', 2, 'Computer Networks', 'mcq', NULL, '2026-01-06 16:25:23'),
(67, 1, 'Which layer of the OSI model handles routing?', 'Data Link Layer', 'Network Layer', 'Transport Layer', 'Application Layer', 'B', 2, 'Computer Networks', 'mcq', NULL, '2026-01-06 16:25:23'),
(68, 1, 'What is the purpose of a firewall?', 'To speed up internet', 'To protect network from unauthorized access', 'To store data', 'To create viruses', 'B', 2, 'Computer Networks', 'mcq', NULL, '2026-01-06 16:25:23'),
(69, 1, 'Which protocol is used for secure web communication?', 'HTTP', 'HTTPS', 'FTP', 'SMTP', 'B', 2, 'Computer Networks', 'mcq', NULL, '2026-01-06 16:25:23'),
(70, 1, 'What is the default port number for HTTP?', '21', '80', '443', '8080', 'B', 2, 'Computer Networks', 'mcq', NULL, '2026-01-06 16:25:23'),
(71, 1, 'What is a process in an operating system?', 'A program stored on disk', 'An instance of a running program', 'A type of file', 'A hardware component', 'B', 2, 'Operating Systems', 'mcq', NULL, '2026-01-06 16:25:23'),
(72, 1, 'Which scheduling algorithm gives equal time to each process?', 'FCFS', 'Round Robin', 'Priority Scheduling', 'SJF', 'B', 2, 'Operating Systems', 'mcq', NULL, '2026-01-06 16:25:23'),
(73, 1, 'What is deadlock in OS?', 'A system crash', 'A situation where processes cannot proceed', 'A type of lock', 'A memory issue', 'B', 2, 'Operating Systems', 'mcq', NULL, '2026-01-06 16:25:23'),
(74, 1, 'What is virtual memory?', 'Memory on external drives', 'An extension of physical memory using disk storage', 'Memory used only for games', 'Temporary browser memory', 'B', 2, 'Operating Systems', 'mcq', NULL, '2026-01-06 16:25:23'),
(75, 1, 'Which of these is a real-time operating system?', 'Linux', 'Windows', 'VxWorks', 'macOS', 'C', 2, 'Operating Systems', 'mcq', NULL, '2026-01-06 16:25:23'),
(76, 1, 'What does REST stand for?', 'Relational State Transfer', 'Representational State Transfer', 'Remote State Transfer', 'Response State Transfer', 'B', 2, 'Web Technologies', 'mcq', NULL, '2026-01-06 16:25:23'),
(77, 1, 'Which of the following is a frontend framework?', 'Django', 'Spring Boot', 'React', 'Express.js', 'C', 2, 'Web Technologies', 'mcq', NULL, '2026-01-06 16:25:23'),
(78, 1, 'What is the purpose of CSS?', 'To structure web pages', 'To add styling and layout', 'To handle server requests', 'To create databases', 'B', 2, 'Web Technologies', 'mcq', NULL, '2026-01-06 16:25:23'),
(79, 1, 'Which HTTP method is used to update a resource in REST?', 'POST', 'PUT', 'GET', 'DELETE', 'B', 2, 'Web Technologies', 'mcq', NULL, '2026-01-06 16:25:23'),
(80, 1, 'What does MVC stand for?', 'Model View Controller', 'Model Variable Component', 'Memory Virtual Cache', 'Multi View Component', 'A', 2, 'Web Technologies', 'mcq', NULL, '2026-01-06 16:25:23'),
(81, 1, 'What is an API?', 'A type of computer', 'A set of rules for software communication', 'A programming language', 'A database type', 'B', 2, 'Web Technologies', 'mcq', NULL, '2026-01-06 16:25:23'),
(82, 1, 'What is cloud computing?', 'Computing with clouds', 'Delivering computing services over internet', 'Local computer storage', 'Mobile computing only', 'B', 2, 'Software Engineering', 'mcq', NULL, '2026-01-06 16:25:23'),
(83, 1, 'What is version control?', 'Checking software versions', 'Managing changes to code over time', 'Testing different versions', 'Naming files', 'B', 2, 'Software Engineering', 'mcq', NULL, '2026-01-06 16:25:23'),
(84, 1, 'What does Git do?', 'Makes programs run', 'Manages source code versions', 'Compiles code', 'Finds bugs', 'B', 2, 'Software Engineering', 'mcq', NULL, '2026-01-06 16:25:23'),
(85, 1, 'What is unit testing?', 'Testing entire application', 'Testing individual components or functions', 'Testing servers', 'Testing documentation', 'B', 2, 'Software Engineering', 'mcq', NULL, '2026-01-06 16:25:23'),
(86, 1, 'What is the purpose of debugging?', 'Adding more bugs', 'Finding and fixing errors in code', 'Making code slower', 'Changing variable names', 'B', 2, 'Software Engineering', 'mcq', NULL, '2026-01-06 16:25:23'),
(87, 1, 'What is a pointer in C?', 'A data type', 'A variable storing memory address', 'A pointing device', 'A direction indicator', 'B', 2, 'Programming', 'mcq', NULL, '2026-01-06 16:25:23'),
(88, 1, 'What is polymorphism in OOP?', 'Multiple inheritance', 'Methods with same name but different behavior', 'Data encapsulation', 'Variable declaration', 'B', 2, 'Programming', 'mcq', NULL, '2026-01-06 16:25:23'),
(89, 1, 'What is inheritance in OOP?', 'Getting money from parents', 'Classes acquiring properties from parent classes', 'Creating new objects', 'Deleting objects', 'B', 2, 'Programming', 'mcq', NULL, '2026-01-06 16:25:23'),
(90, 1, 'What is encapsulation in OOP?', 'Packing items', 'Bundling data and methods within classes', 'Hiding files', 'Creating loops', 'B', 2, 'Programming', 'mcq', NULL, '2026-01-06 16:25:23'),
(91, 1, 'What is a closure in JavaScript?', 'A way to close files', 'A function having access to outer function variables', 'Error handling mechanism', 'Loop termination', 'B', 2, 'Programming', 'mcq', NULL, '2026-01-06 16:25:23'),
(92, 1, 'What is CRUD in database operations?', 'Not following rules', 'Create, Read, Update, Delete', 'Computer Running User Data', 'Cryptography Resource Data', 'B', 2, 'Database (SQL, DBMS)', 'mcq', NULL, '2026-01-06 16:25:23'),
(93, 1, 'What is normalization in databases?', 'Making data normal', 'Organizing data to reduce redundancy', 'Creating backups', 'Deleting records', 'B', 2, 'Database (SQL, DBMS)', 'mcq', NULL, '2026-01-06 16:25:23'),
(94, 1, 'What is the purpose of an index in databases?', 'Listing documents', 'Speeding up data retrieval', 'Organizing folders', 'Storing metadata', 'B', 2, 'Database (SQL, DBMS)', 'mcq', NULL, '2026-01-06 16:25:23'),
(95, 1, 'What is a transaction in database?', 'A business deal', 'A sequence of operations treated as a single unit', 'A type of table', 'A SQL command', 'B', 2, 'Database (SQL, DBMS)', 'mcq', NULL, '2026-01-06 16:25:23'),
(96, 1, 'What is IP address?', 'Important Person address', 'Internet Protocol address', 'Internal Process address', 'Internet Port address', 'B', 2, 'Computer Networks', 'mcq', NULL, '2026-01-06 16:25:23'),
(97, 1, 'What is a router?', 'A woodworking tool', 'A device that directs data packets between networks', 'A type of server', 'A programming language', 'B', 2, 'Computer Networks', 'mcq', NULL, '2026-01-06 16:25:23'),
(98, 1, 'What is bandwidth?', 'A band that plays music', 'The maximum data transfer rate of a connection', 'Internet speed only', 'A type of cable', 'B', 2, 'Computer Networks', 'mcq', NULL, '2026-01-06 16:25:23'),
(99, 1, 'What is latency?', 'Being late to work', 'The time delay in data transmission', 'Download speed', 'Internet connection', 'B', 2, 'Computer Networks', 'mcq', NULL, '2026-01-06 16:25:23'),
(100, 1, 'What is encryption?', 'Making text larger', 'Converting data into code to prevent unauthorized access', 'Deleting sensitive data', 'Creating passwords', 'B', 2, 'Software Engineering', 'mcq', NULL, '2026-01-06 16:25:23'),
(101, 2, 'What is the primary function of a bank?', 'To issue currency', 'To accept deposits and provide loans', 'To manage stock markets', 'To set interest rates', 'B', 2, 'General Banking', 'mcq', NULL, '2026-01-06 16:25:24'),
(102, 2, 'What does KYC stand for in banking?', 'Know Your Client', 'Know Your Code', 'Key Yield Commission', 'Know Your Credit', 'A', 2, 'General Banking', 'mcq', NULL, '2026-01-06 16:25:24'),
(103, 2, 'Which organization regulates banks in Bangladesh?', 'Ministry of Finance', 'Bangladesh Bank', 'BAFSA', 'Stock Exchange', 'B', 2, 'General Banking', 'mcq', NULL, '2026-01-06 16:25:24'),
(104, 2, 'What is the role of the central bank?', 'Provide retail banking services', 'Regulate monetary policy', 'Offer investment advice', 'Manage stock portfolios', 'B', 2, 'General Banking', 'mcq', NULL, '2026-01-06 16:25:24'),
(105, 2, 'What is an overdraft in banking?', 'Excess payment', 'A temporary loan when account balance is insufficient', 'A type of savings account', 'Interest on deposits', 'B', 2, 'General Banking', 'mcq', NULL, '2026-01-06 16:25:24'),
(106, 2, 'What is the accounting equation?', 'Assets = Liabilities + Equity', 'Revenue - Expense = Profit', 'Assets - Liabilities = Debt', 'Income = Expense + Profit', 'A', 2, 'Accounting Principles', 'mcq', NULL, '2026-01-06 16:25:24'),
(107, 2, 'What is depreciation?', 'Decrease in asset value over time', 'Loss of money', 'Tax reduction', 'Profit decrease', 'A', 2, 'Accounting Principles', 'mcq', NULL, '2026-01-06 16:25:24'),
(108, 2, 'Which statement shows a company financial position?', 'Income Statement', 'Balance Sheet', 'Cash Flow Statement', 'Trial Balance', 'B', 2, 'Accounting Principles', 'mcq', NULL, '2026-01-06 16:25:24'),
(109, 2, 'What is a journal entry?', 'A daily business record', 'Recording of financial transactions', 'Employee diary', 'Business plan document', 'B', 2, 'Accounting Principles', 'mcq', NULL, '2026-01-06 16:25:24'),
(110, 2, 'What does GAAP stand for?', 'General Accounting and Audit Principles', 'Generally Accepted Accounting Principles', 'Global Accounting Application Process', 'General Accounts and Payroll', 'B', 2, 'Accounting Principles', 'mcq', NULL, '2026-01-06 16:25:24'),
(111, 2, 'What is ROI?', 'Return on Investment', 'Rate of Interest', 'Revenue on Income', 'Return over Installment', 'A', 2, 'Financial Management', 'mcq', NULL, '2026-01-06 16:25:24'),
(112, 2, 'What is the purpose of financial forecasting?', 'To predict future financial outcomes', 'To record past transactions', 'To audit accounts', 'To compute taxes', 'A', 2, 'Financial Management', 'mcq', NULL, '2026-01-06 16:25:24'),
(113, 2, 'What is cash flow?', 'Money in your bank account', 'Movement of money in and out of business', 'Interest earned', 'Profit from sales', 'B', 2, 'Financial Management', 'mcq', NULL, '2026-01-06 16:25:24'),
(114, 2, 'What is working capital?', 'Capital used in business operations', 'Long-term investments', 'Owner equity', 'Loan amount', 'A', 2, 'Financial Management', 'mcq', NULL, '2026-01-06 16:25:24'),
(115, 2, 'What is break-even point?', 'Highest profit', 'Point where revenue equals costs', 'Lowest expense', 'Maximum sales', 'B', 2, 'Financial Management', 'mcq', NULL, '2026-01-06 16:25:24'),
(116, 2, 'What does GDP stand for?', 'Gross Domestic Product', 'Gross Development Program', 'Global Domestic Profit', 'Gross Data Product', 'A', 2, 'Economics (Basic)', 'mcq', NULL, '2026-01-06 16:25:24'),
(117, 2, 'What is inflation?', 'Increase in prices of goods and services', 'Deflation of currency', 'Increase in production', 'Market expansion', 'A', 2, 'Economics (Basic)', 'mcq', NULL, '2026-01-06 16:25:24'),
(118, 2, 'What is the primary role of Bangladesh Bank?', 'Issue passports', 'Regulate monetary policy', 'Provide credit cards', 'Sell government bonds', 'B', 2, 'Bangladesh Banking System', 'mcq', NULL, '2026-01-06 16:25:24'),
(119, 2, 'What is corporate governance?', 'Rules governing corporation operations', 'Corporate tax system', 'Employee management', 'Business location', 'A', 2, 'Corporate Governance', 'mcq', NULL, '2026-01-06 16:25:24'),
(120, 2, 'What is the primary function of HR department?', 'Manage company finances', 'Recruit, train, and manage employees', 'Produce goods', 'Sell products', 'B', 2, 'HR Management', 'mcq', NULL, '2026-01-06 16:25:24'),
(121, 2, 'What is office management?', 'Managing office supplies', 'Coordinating office operations and resources', 'Cleaning the office', 'Scheduling meetings', 'B', 2, 'Office Management', 'mcq', NULL, '2026-01-06 16:25:24'),
(122, 2, 'What is business planning?', 'Creating company strategy and goals', 'Scheduling employees', 'Maintaining office', 'Managing inventory', 'A', 2, 'Corporate Planning', 'mcq', NULL, '2026-01-06 16:25:24'),
(123, 2, 'What does effective communication require?', 'Speaking loudly', 'Clarity, listening, and feedback', 'Using difficult words', 'Written communication only', 'B', 2, 'Business Communication', 'mcq', NULL, '2026-01-06 16:25:24'),
(124, 2, 'What is organizational behavior?', 'How employees are managed', 'Study of people and groups in organization', 'Company policies', 'HR practices', 'B', 2, 'Organizational Behavior', 'mcq', NULL, '2026-01-06 16:25:24'),
(125, 2, 'What is quantitative aptitude?', 'Ability to solve numerical problems', 'Language skills', 'Technical skills', 'Soft skills', 'A', 2, 'Quantitative Aptitude', 'mcq', NULL, '2026-01-06 16:25:24'),
(126, 2, 'What is data interpretation?', 'Converting numbers into meaningful information', 'Storing data', 'Deleting data', 'Copying data', 'A', 2, 'Data Interpretation', 'mcq', NULL, '2026-01-06 16:25:24'),
(127, 2, 'What is analytical reasoning?', 'Logical thinking and problem solving', 'Reading books', 'Public speaking', 'Time management', 'A', 2, 'Analytical Reasoning', 'mcq', NULL, '2026-01-06 16:25:24'),
(128, 2, 'Which sentence is correctly written?', 'He dont go to office', 'She go to school daily', 'They works hard', 'The dog runs quickly', 'D', 2, 'English Grammar & Comprehension', 'mcq', NULL, '2026-01-06 16:25:24'),
(129, 2, 'What is a synonym for proficient?', 'Slow', 'Skilled', 'Lazy', 'Weak', 'B', 2, 'English Grammar & Comprehension', 'mcq', NULL, '2026-01-06 16:25:24'),
(130, 2, 'In MS Excel, what does SUM function do?', 'Finds average', 'Adds numbers in a range', 'Counts cells', 'Finds maximum', 'B', 2, 'MS Word, Excel, PowerPoint', 'mcq', NULL, '2026-01-06 16:25:24'),
(131, 2, 'What should be included in a professional email?', 'Casual greetings only', 'Greeting, purpose, closing', 'Emojis and slang', 'Only subject line', 'B', 2, 'Email & Office Etiquette', 'mcq', NULL, '2026-01-06 16:25:24'),
(132, 2, 'What is basic IT knowledge essential for?', 'Office work efficiency', 'Playing games', 'Learning coding', 'Nothing important', 'A', 2, 'Basic IT Knowledge', 'mcq', NULL, '2026-01-06 16:25:24'),
(133, 2, 'What is dividend in banking?', 'Division operation', 'Profit distribution to shareholders', 'Bank deposit', 'Loan disbursement', 'B', 2, 'General Banking', 'mcq', NULL, '2026-01-06 16:25:24'),
(134, 2, 'What does EMI stand for?', 'Electronic Money Investment', 'Equated Monthly Installment', 'Easy Money Investment', 'Electronic Monthly Income', 'B', 2, 'Financial Management', 'mcq', NULL, '2026-01-06 16:25:24'),
(135, 2, 'What is reconciliation in accounting?', 'Making peace', 'Matching accounts to verify accuracy', 'Recording transactions', 'Closing accounts', 'B', 2, 'Accounting Principles', 'mcq', NULL, '2026-01-06 16:25:24'),
(136, 2, 'What does NPA stand for in banking?', 'New Product Announcement', 'Non-Performing Asset', 'Net Profit Amount', 'New Payment Authorization', 'B', 2, 'General Banking', 'mcq', NULL, '2026-01-06 16:25:24'),
(137, 2, 'Which bank is the oldest in Bangladesh?', 'DutchBangla', 'Sonali Bank', 'BRAC Bank', 'Dhaka Bank', 'B', 2, 'General Banking', 'mcq', NULL, '2026-01-06 16:25:24'),
(138, 2, 'What is goodwill in accounting?', 'Moral character', 'Excess price paid over fair value', 'Customer satisfaction', 'Employee welfare', 'B', 2, 'Accounting Principles', 'mcq', NULL, '2026-01-06 16:25:24'),
(139, 2, 'What does a credit balance indicate?', 'Money owed from company', 'Money owed to company', 'Cash received', 'Expense item', 'A', 2, 'Accounting Principles', 'mcq', NULL, '2026-01-06 16:25:24'),
(140, 2, 'What is minimum balance in savings account?', 'No minimum', 'Minimum as per bank policy', '1000 TK only', '5000 TK always', 'B', 2, 'General Banking', 'mcq', NULL, '2026-01-06 16:25:24'),
(141, 2, 'What is a credit note?', 'A note from creditors', 'A document reducing payable amount', 'A bank note', 'Interest payment', 'B', 2, 'Accounting Principles', 'mcq', NULL, '2026-01-06 16:25:24'),
(142, 2, 'What is market segmentation?', 'Dividing market into groups', 'Selling products', 'Advertising method', 'Distribution channel', 'A', 2, 'Business Communication', 'mcq', NULL, '2026-01-06 16:25:24'),
(143, 2, 'What is the primary goal of HR?', 'Hiring only', 'Managing human resources effectively', 'Firing employees', 'Setting salaries', 'B', 2, 'HR Management', 'mcq', NULL, '2026-01-06 16:25:24'),
(144, 2, 'What is team building?', 'Construction activity', 'Activities to improve team cohesion', 'Building office space', 'Hiring process', 'B', 2, 'Organizational Behavior', 'mcq', NULL, '2026-01-06 16:25:24'),
(145, 2, 'What is business ethics?', 'No importance', 'Building trust and reputation', 'Just following law', 'Earning profit only', 'B', 2, 'Corporate Governance', 'mcq', NULL, '2026-01-06 16:25:24'),
(146, 2, 'What is the purpose of budgeting?', 'Spending money randomly', 'Planning and controlling finances', 'Reducing costs only', 'Increasing revenue', 'B', 2, 'Financial Management', 'mcq', NULL, '2026-01-06 16:25:24'),
(147, 2, 'What is an asset?', 'A liability', 'A resource with economic value', 'An expense', 'A loss', 'B', 2, 'Accounting Principles', 'mcq', NULL, '2026-01-06 16:25:24'),
(148, 2, 'What is a liability?', 'An asset', 'An obligation to pay or provide service', 'Income', 'A profit', 'B', 2, 'Accounting Principles', 'mcq', NULL, '2026-01-06 16:25:24'),
(149, 2, 'What is equity?', 'Equal treatment', 'Owner stake in the business', 'Liabilities only', 'Assets only', 'B', 2, 'Accounting Principles', 'mcq', NULL, '2026-01-06 16:25:24'),
(150, 2, 'What is interest rate?', 'Being interested in something', 'Percentage charged on borrowed money', 'Tax calculation', 'Inflation rate', 'B', 2, 'Financial Management', 'mcq', NULL, '2026-01-06 16:25:24'),
(152, 3, 'What is the capital of Bangladesh?', 'Chittagong', 'Dhaka', 'Sylhet', 'Khulna', 'B', 2, 'School-level Subjects', 'mcq', NULL, '2026-01-06 16:25:24'),
(153, 3, 'What is 15% of 200?', '20', '25', '30', '35', 'C', 2, 'School-level Subjects', 'mcq', NULL, '2026-01-06 16:25:24'),
(154, 3, 'Which scientist discovered gravity?', 'Einstein', 'Newton', 'Galileo', 'Tesla', 'B', 2, 'School-level Subjects', 'mcq', NULL, '2026-01-06 16:25:24'),
(155, 3, 'What is photosynthesis?', 'Decay of organisms', 'Process by which plants make food', 'Breaking down of rocks', 'Formation of soil', 'B', 2, 'School-level Subjects', 'mcq', NULL, '2026-01-06 16:25:24'),
(156, 3, 'What is the chemical formula for water?', 'H3O', 'H2O', 'HO2', 'O2H', 'B', 2, 'School-level Subjects', 'mcq', NULL, '2026-01-06 16:25:24'),
(157, 3, 'What is the main purpose of teaching methodology?', 'To assign homework', 'To create effective teaching and learning strategies', 'To punish students', 'To make classes boring', 'B', 2, 'Teaching Methodology', 'mcq', NULL, '2026-01-06 16:25:24'),
(158, 3, 'What is classroom management?', 'Cleaning the classroom', 'Creating conducive learning environment', 'Decorating walls', 'Maintaining furniture', 'B', 2, 'Teaching Methodology', 'mcq', NULL, '2026-01-06 16:25:24'),
(159, 3, 'What does Bloom\'s Taxonomy focus on?', 'Plant classification', 'Cognitive levels of learning', 'Animal behavior', 'Historical events', 'B', 2, 'Teaching Methodology', 'mcq', NULL, '2026-01-06 16:25:24'),
(160, 3, 'What is child psychology?', 'Psychology of animals', 'Study of child behavior and development', 'Psychology of adults', 'Study of plants', 'B', 2, 'Child Psychology', 'mcq', NULL, '2026-01-06 16:25:24'),
(161, 3, 'What is continuous assessment?', 'Final exams only', 'Ongoing evaluation of student learning', 'Quarterly exams', 'Annual testing', 'B', 2, 'Assessment & Evaluation', 'mcq', NULL, '2026-01-06 16:25:24'),
(162, 3, 'What does NCTB stand for?', 'National College Teaching Board', 'National Curriculum and Textbook Board', 'National Curriculum Teaching Bureau', 'National College Textbook Bureau', 'B', 2, 'Curriculum Knowledge', 'mcq', NULL, '2026-01-06 16:25:24'),
(163, 3, 'Which of these is part of Bangladesh Constitution?', 'Independence Day', 'Fundamental Rights', 'National Anthem', 'Government structure', 'B', 2, 'Bangladesh Affairs', 'mcq', NULL, '2026-01-06 16:25:24'),
(164, 3, 'What is the language of instruction in Bangladesh schools?', 'English', 'Bengali', 'Urdu', 'Arabic', 'B', 2, 'Bangladesh Affairs', 'mcq', NULL, '2026-01-06 16:25:24'),
(165, 3, 'What is the main goal of education policy?', 'To earn money', 'To develop human resources and society', 'To reduce expenses', 'To build buildings', 'B', 2, 'Education Policy', 'mcq', NULL, '2026-01-06 16:25:24'),
(166, 3, 'What is English proficiency essential for?', 'Entertainment', 'Global communication and career opportunities', 'Playing games', 'Sleeping', 'B', 2, 'English Language Skills', 'mcq', NULL, '2026-01-06 16:25:24'),
(167, 3, 'What is the capital of India?', 'Mumbai', 'Delhi', 'Bangalore', 'Chennai', 'B', 2, 'School-level Subjects', 'mcq', NULL, '2026-01-06 16:25:24'),
(168, 3, 'What is the Pythagorean theorem?', 'a+b=c', 'a2+b2=c2', 'a-b=c', 'a×b=c', 'B', 2, 'School-level Subjects', 'mcq', NULL, '2026-01-06 16:25:24'),
(169, 3, 'Who was the first President of Bangladesh?', 'Sheikh Mujibur Rahman', 'Ziaur Rahman', 'Hussain Muhammad Ershad', 'A.K. Fazlul Haque', 'A', 2, 'Bangladesh Affairs', 'mcq', NULL, '2026-01-06 16:25:24'),
(170, 3, 'What is the structure of an atom?', 'Protons and electrons only', 'Protons, neutrons, and electrons', 'Neutrons only', 'Electrons only', 'B', 2, 'School-level Subjects', 'mcq', NULL, '2026-01-06 16:25:24'),
(171, 3, 'What is the SI unit of force?', 'Kilogram', 'Newton', 'Joule', 'Watt', 'B', 2, 'School-level Subjects', 'mcq', NULL, '2026-01-06 16:25:24'),
(172, 3, 'What is cooperative learning?', 'Learning alone', 'Learning in groups to achieve common goals', 'Competing with peers', 'Learning from books only', 'B', 2, 'Teaching Methodology', 'mcq', NULL, '2026-01-06 16:25:24'),
(173, 3, 'What is Piaget\'s theory about?', 'Animal behavior', 'Stages of cognitive development', 'Physics laws', 'Chemistry basics', 'B', 2, 'Child Psychology', 'mcq', NULL, '2026-01-06 16:25:24'),
(174, 3, 'What is scaffolding in education?', 'Building structures', 'Providing temporary support to learners', 'Making tests harder', 'Reducing class size', 'B', 2, 'Teaching Methodology', 'mcq', NULL, '2026-01-06 16:25:24'),
(175, 3, 'What is the purpose of formative assessment?', 'Only grading students', 'Providing ongoing feedback for improvement', 'Punishing wrong answers', 'Final evaluation only', 'B', 2, 'Assessment & Evaluation', 'mcq', NULL, '2026-01-06 16:25:24'),
(176, 3, 'What are the learning domains in Bloom\'s?', 'Cognitive, Affective, Psychomotor', 'Mental and Physical', 'Theory and Practice', 'Knowledge and Skills', 'A', 2, 'Assessment & Evaluation', 'mcq', NULL, '2026-01-06 16:25:24'),
(177, 3, 'What does ICT stand for in education?', 'Information, Communication, Technology', 'Integrated Computer Training', 'Interactive Classroom Teaching', 'International Computer Toolkit', 'A', 2, 'HSC / Degree-level Subjects', 'mcq', NULL, '2026-01-06 16:25:24'),
(178, 3, 'What is the role of a teacher in student-centered learning?', 'Deliver lectures only', 'Facilitate and guide student learning', 'Control all activities', 'Give all answers', 'B', 2, 'Teaching Methodology', 'mcq', NULL, '2026-01-06 16:25:24'),
(179, 3, 'What are multiple intelligences?', 'Different types of IQ tests', 'Different ways people are intelligent', 'Computer intelligences', 'Artificial intelligences', 'B', 2, 'Child Psychology', 'mcq', NULL, '2026-01-06 16:25:24'),
(180, 3, 'What is inclusive education?', 'Education for rich only', 'Education for all students including those with disabilities', 'Private school education', 'Urban education only', 'B', 2, 'Education Policy', 'mcq', NULL, '2026-01-06 16:25:24'),
(181, 3, 'What are benefits of project-based learning?', 'Wasting time', 'Developing critical thinking and collaboration', 'Memorizing facts', 'Following textbooks', 'B', 2, 'Teaching Methodology', 'mcq', NULL, '2026-01-06 16:25:24'),
(182, 3, 'What is active learning?', 'Passive listening', 'Student participation and engagement in learning', 'Reading textbooks', 'Watching lectures', 'B', 2, 'Teaching Methodology', 'mcq', NULL, '2026-01-06 16:25:24'),
(183, 3, 'What is summative assessment?', 'Ongoing feedback', 'Final evaluation of student learning', 'Quarterly exams', 'Monthly testing', 'B', 2, 'Assessment & Evaluation', 'mcq', NULL, '2026-01-06 16:25:24'),
(184, 3, 'What is Maslow\'s hierarchy of needs?', 'List of food items', 'Pyramid of human needs from basic to self-actualization', 'Classroom rules', 'Student discipline', 'B', 2, 'Child Psychology', 'mcq', NULL, '2026-01-06 16:25:24'),
(185, 3, 'What is constructivism in education?', 'Building schools', 'Students construct knowledge through experience', 'Traditional teaching', 'Lecture-based learning', 'B', 2, 'Teaching Methodology', 'mcq', NULL, '2026-01-06 16:25:24'),
(186, 3, 'What is differentiated instruction?', 'All students learn the same way', 'Tailoring instruction to meet diverse learning needs', 'Advanced students only', 'Slow learners only', 'B', 2, 'Teaching Methodology', 'mcq', NULL, '2026-01-06 16:25:24'),
(187, 3, 'What is the purpose of feedback?', 'Criticizing students', 'Helping students improve their learning', 'Finding faults', 'Complaining', 'B', 2, 'Assessment & Evaluation', 'mcq', NULL, '2026-01-06 16:25:24'),
(188, 3, 'What is motivation in learning?', 'Not needed', 'The drive to learn and achieve goals', 'Only for exams', 'Fear of punishment', 'B', 2, 'Child Psychology', 'mcq', NULL, '2026-01-06 16:25:24'),
(189, 3, 'What is peer assessment?', 'Teacher assessment only', 'Students evaluating each other\'s work', 'Self-evaluation only', 'Parent assessment', 'B', 2, 'Assessment & Evaluation', 'mcq', NULL, '2026-01-06 16:25:24'),
(190, 3, 'What is zone of proximal development?', 'School location', 'Gap between what student can do alone and with help', 'Classroom boundaries', 'School premises', 'B', 2, 'Child Psychology', 'mcq', NULL, '2026-01-06 16:25:24'),
(191, 3, 'What is metacognition?', 'Thinking without thought', 'Thinking about one\'s own thinking', 'Fast thinking', 'Slow thinking', 'B', 2, 'Teaching Methodology', 'mcq', NULL, '2026-01-06 16:25:24'),
(192, 3, 'What is experiential learning?', 'Just reading', 'Learning through direct experience', 'Only theoretical', 'No practice', 'B', 2, 'Teaching Methodology', 'mcq', NULL, '2026-01-06 16:25:24'),
(193, 3, 'What is growth mindset?', 'Fixed abilities', 'Belief that abilities can be developed', 'Talent is permanent', 'Intelligence is fixed', 'B', 2, 'Child Psychology', 'mcq', NULL, '2026-01-06 16:25:24'),
(194, 3, 'What is blended learning?', 'Only online learning', 'Combination of in-person and online learning', 'Only classroom', 'Only textbooks', 'B', 2, 'Teaching Methodology', 'mcq', NULL, '2026-01-06 16:25:24'),
(195, 3, 'What is learning objective?', 'Random goals', 'Specific outcome students should achieve', 'Teacher goals', 'School targets', 'B', 2, 'Curriculum Knowledge', 'mcq', NULL, '2026-01-06 16:25:24'),
(196, 3, 'What is the role of play in education?', 'Wasting time', 'Developing skills and knowledge naturally', 'Not important', 'Only for young children', 'B', 2, 'Child Psychology', 'mcq', NULL, '2026-01-06 16:25:24'),
(197, 3, 'What is student-centered learning?', 'Teacher is center', 'Student\'s needs and interests are central', 'Textbook centered', 'Exam centered', 'B', 2, 'Teaching Methodology', 'mcq', NULL, '2026-01-06 16:25:24'),
(198, 3, 'What is inquiry-based learning?', 'Just giving answers', 'Students asking questions and investigating', 'Passive learning', 'Memorization', 'B', 2, 'Teaching Methodology', 'mcq', NULL, '2026-01-06 16:25:24'),
(199, 3, 'What is the importance of assessment?', 'No importance', 'Measuring and evaluating student progress', 'Just for grades', 'Only for final exams', 'B', 2, 'Assessment & Evaluation', 'mcq', NULL, '2026-01-06 16:25:24'),
(200, 4, 'What is the capital of India?', 'Mumbai', 'Delhi', 'Bangalore', 'Chennai', 'B', 2, 'Bangladesh & World Affairs', 'mcq', NULL, '2026-01-06 16:25:24'),
(201, 4, 'Which country is not in South Asia?', 'Bangladesh', 'Nepal', 'Myanmar', 'Sri Lanka', 'C', 2, 'Bangladesh & World Affairs', 'mcq', NULL, '2026-01-06 16:25:24'),
(202, 4, 'Who is the current Prime Minister of Bangladesh?', 'Sheikh Hasina', 'Khaleda Zia', 'Rajon Pal', 'Fakhrul Islam', 'A', 2, 'Bangladesh & World Affairs', 'mcq', NULL, '2026-01-06 16:25:24'),
(203, 4, 'What is the primary language spoken in Bangladesh?', 'English', 'Bengali', 'Urdu', 'Hindi', 'B', 2, 'Bangladesh & World Affairs', 'mcq', NULL, '2026-01-06 16:25:24'),
(204, 4, 'Which international organization is Bangladesh a member of?', 'NATO', 'SAARC', 'EU', 'OPEC', 'B', 2, 'Bangladesh & World Affairs', 'mcq', NULL, '2026-01-06 16:25:24'),
(205, 4, 'Who won the last World Cup in cricket?', 'India', 'Australia', 'England', 'Pakistan', 'B', 2, 'Current Affairs', 'mcq', NULL, '2026-01-06 16:25:24'),
(206, 4, 'What is a trending topic in technology?', 'Floppy disks', 'Artificial Intelligence', 'Typewriters', 'Landline phones', 'B', 2, 'Current Affairs', 'mcq', NULL, '2026-01-06 16:25:24'),
(207, 4, 'What is a web browser?', 'Internet connection device', 'Software to view web pages', 'Internet service provider', 'Email service', 'B', 2, 'Basic ICT', 'mcq', NULL, '2026-01-06 16:25:24'),
(208, 4, 'What does CPU stand for?', 'Central Processing Unit', 'Central Processor Unit', 'Computer Processing Unit', 'Central Program Unit', 'A', 2, 'Basic ICT', 'mcq', NULL, '2026-01-06 16:25:24'),
(209, 4, 'What is the function of a keyboard?', 'Display information', 'Input data and commands', 'Store files', 'Process data', 'B', 2, 'Basic ICT', 'mcq', NULL, '2026-01-06 16:25:24'),
(210, 4, 'What causes seasons on Earth?', 'Distance from sun', 'Tilt of Earth\'s axis', 'Gravity', 'Atmosphere', 'B', 2, 'Everyday Science', 'mcq', NULL, '2026-01-06 16:25:24'),
(211, 4, 'What is the process of water evaporation?', 'Water freezing', 'Liquid water changing to vapor', 'Dissolving in soil', 'Water filtering', 'B', 2, 'Everyday Science', 'mcq', NULL, '2026-01-06 16:25:24'),
(212, 4, 'If A=2, B=4, then A+B=?', '4', '6', '8', '2', 'B', 2, 'Numerical Ability', 'mcq', NULL, '2026-01-06 16:25:24'),
(213, 4, 'What is 20% of 500?', '50', '100', '150', '200', 'B', 2, 'Numerical Ability', 'mcq', NULL, '2026-01-06 16:25:24'),
(214, 4, 'If a train travels 60 km/h for 2 hours, how far does it travel?', '30 km', '60 km', '90 km', '120 km', 'D', 2, 'Numerical Ability', 'mcq', NULL, '2026-01-06 16:25:24'),
(215, 4, 'What is logical reasoning?', 'Reading long passages', 'Using logic to solve problems and find patterns', 'Memorizing facts', 'Just guessing', 'B', 2, 'Logical Reasoning', 'mcq', NULL, '2026-01-06 16:25:24'),
(216, 4, 'What comes next in the series: 2, 4, 6, 8, ?', '9', '10', '11', '12', 'B', 2, 'Logical Reasoning', 'mcq', NULL, '2026-01-06 16:25:24'),
(217, 4, 'You are a salesperson and a customer is angry. What should you do?', 'Argue with customer', 'Listen to complaint, apologize, offer solution', 'Ignore customer', 'Hang up', 'B', 2, 'Sales Scenario & Customer Handling', 'mcq', NULL, '2026-01-06 16:25:24'),
(218, 4, 'What is the most important in customer service?', 'Selling more products', 'Customer satisfaction and solving their problems', 'Minimizing costs', 'Quick transactions', 'B', 2, 'Sales Scenario & Customer Handling', 'mcq', NULL, '2026-01-06 16:25:24'),
(219, 4, 'Safety rules in workplace are important for?', 'Punishing employees', 'Protecting worker health and preventing accidents', 'Saving money', 'Controlling employees', 'B', 2, 'Safety & Security Rules', 'mcq', NULL, '2026-01-06 16:25:24'),
(220, 4, 'In a hotel, what is hospitality?', 'Providing only food', 'Welcoming guests warmly and providing excellent service', 'Selling rooms', 'Managing accounts', 'B', 2, 'Hospitality Etiquette', 'mcq', NULL, '2026-01-06 16:25:24'),
(221, 4, 'What is proper greeting etiquette?', 'Ignoring people', 'Greeting with respect and appropriate body language', 'Speaking loudly', 'Using informal language', 'B', 2, 'Hospitality Etiquette', 'mcq', NULL, '2026-01-06 16:25:24'),
(222, 4, 'Which sentence is correctly written in English?', 'He go to school', 'She goes to school', 'They goes to office', 'We is going home', 'B', 2, 'Email Writing & Comprehension', 'mcq', NULL, '2026-01-06 16:25:24'),
(223, 4, 'What should be the tone of a professional email?', 'Casual and informal', 'Formal, clear, and respectful', 'Angry and rude', 'Too friendly', 'B', 2, 'Email Writing & Comprehension', 'mcq', NULL, '2026-01-06 16:25:24'),
(224, 4, 'What is the main idea of a paragraph called?', 'Topic sentence', 'Supporting detail', 'Conclusion', 'Introduction', 'A', 2, 'Email Writing & Comprehension', 'mcq', NULL, '2026-01-06 16:25:24'),
(225, 4, 'What is emergency response procedure?', 'Doing nothing', 'Systematic steps to handle emergencies safely', 'Running away', 'Calling help randomly', 'B', 2, 'Safety & Security Rules', 'mcq', NULL, '2026-01-06 16:25:24'),
(226, 4, 'What is basic fire safety?', 'Playing with fire', 'Knowing escape routes and using fire extinguishers', 'Leaving doors open', 'Ignoring alarms', 'B', 2, 'Safety & Security Rules', 'mcq', NULL, '2026-01-06 16:25:24'),
(227, 4, 'How should you handle a difficult customer?', 'Be rude back', 'Remain calm, listen, and find solution', 'Refuse service', 'Blame them', 'B', 2, 'Sales Scenario & Customer Handling', 'mcq', NULL, '2026-01-06 16:25:24'),
(228, 4, 'What is the importance of punctuality at work?', 'No importance', 'Shows professionalism and reliability', 'Wastes time', 'Only managers need it', 'B', 2, 'Hospitality Etiquette', 'mcq', NULL, '2026-01-06 16:25:24'),
(229, 4, 'What does problem-solving require?', 'Ignoring issues', 'Analyzing, planning, and implementing solutions', 'Passing buck', 'Waiting for help', 'B', 2, 'Situation-based Questions', 'mcq', NULL, '2026-01-06 16:25:24'),
(230, 4, 'What is the role of communication in teamwork?', 'Not needed', 'Essential for coordination and understanding', 'Only for meetings', 'One-way only', 'B', 2, 'Situation-based Questions', 'mcq', NULL, '2026-01-06 16:25:24'),
(231, 4, 'What is ethical behavior at work?', 'Breaking rules secretly', 'Acting with integrity and honesty', 'Doing whatever profits', 'Following rules when caught', 'B', 2, 'Situation-based Questions', 'mcq', NULL, '2026-01-06 16:25:24'),
(232, 4, 'How to handle workplace conflict?', 'Ignore and hope it resolves', 'Address calmly, listen to all sides, find compromise', 'Take sides', 'Make it public', 'B', 2, 'Situation-based Questions', 'mcq', NULL, '2026-01-06 16:25:24'),
(233, 4, 'What is time management?', 'Working all day', 'Efficiently organizing and prioritizing tasks', 'Avoiding work', 'Doing things quickly', 'B', 2, 'Situation-based Questions', 'mcq', NULL, '2026-01-06 16:25:24'),
(234, 4, 'What is active listening?', 'Hearing words only', 'Fully engaging with what someone is saying', 'Thinking of response while listening', 'Waiting for turn to speak', 'B', 2, 'Sales Scenario & Customer Handling', 'mcq', NULL, '2026-01-06 16:25:24'),
(235, 4, 'How to build professional relationships?', 'Being aloof', 'Being respectful, reliable, and communicative', 'Using people', 'Being dishonest', 'B', 2, 'Hospitality Etiquette', 'mcq', NULL, '2026-01-06 16:25:24'),
(236, 4, 'What is cross-cultural communication?', 'Using multiple languages', 'Understanding and respecting different cultures', 'Avoiding other cultures', 'Speaking loudly', 'B', 2, 'Hospitality Etiquette', 'mcq', NULL, '2026-01-06 16:25:24'),
(237, 4, 'What is the importance of feedback?', 'Criticizing only', 'Helping others improve and showing appreciation', 'Finding faults', 'Complaining', 'B', 2, 'Sales Scenario & Customer Handling', 'mcq', NULL, '2026-01-06 16:25:24'),
(238, 4, 'What is professional appearance?', 'Any clothing is fine', 'Dressing appropriately for your role and organization', 'Expensive clothes only', 'Fashion is all that matters', 'B', 2, 'Hospitality Etiquette', 'mcq', NULL, '2026-01-06 16:25:24'),
(239, 4, 'How should you handle stress at work?', 'Ignore it completely', 'Use healthy coping mechanisms and seek support', 'Work harder', 'Blame others', 'B', 2, 'Situation-based Questions', 'mcq', NULL, '2026-01-06 16:25:24'),
(240, 4, 'What is the key to success in customer-facing roles?', 'Making sales only', 'Providing great service and building relationships', 'Being pushy', 'Ignoring customer feedback', 'B', 2, 'Sales Scenario & Customer Handling', 'mcq', NULL, '2026-01-06 16:25:24'),
(241, 4, 'What is the largest planet in our solar system?', 'Saturn', 'Jupiter', 'Neptune', 'Venus', 'B', 2, 'Everyday Science', 'mcq', NULL, '2026-01-06 16:25:24'),
(242, 4, 'What is the speed of light?', '100,000 km/s', '300,000 km/s', '500,000 km/s', '1,000,000 km/s', 'B', 2, 'Everyday Science', 'mcq', NULL, '2026-01-06 16:25:24'),
(243, 4, 'What is the percentage formula?', '(Part/Whole) × 100', 'Whole/Part × 100', 'Part × Whole / 100', 'Whole - Part × 100', 'A', 2, 'Numerical Ability', 'mcq', NULL, '2026-01-06 16:25:24'),
(244, 4, 'What is the value of Pi (approximately)?', '2.14', '3.14', '4.14', '5.14', 'B', 2, 'Numerical Ability', 'mcq', NULL, '2026-01-06 16:25:24'),
(245, 4, 'If you spend 25% of 800 TK, how much do you have left?', '200 TK', '600 TK', '400 TK', '300 TK', 'B', 2, 'Numerical Ability', 'mcq', NULL, '2026-01-06 16:25:24'),
(246, 4, 'What comes next: 5, 10, 15, 20, ?', '25', '30', '35', '40', 'A', 2, 'Logical Reasoning', 'mcq', NULL, '2026-01-06 16:25:24'),
(247, 4, 'If A > B and B > C, then which statement is true?', 'C > A', 'A > C', 'A = C', 'B > A', 'B', 2, 'Logical Reasoning', 'mcq', NULL, '2026-01-06 16:25:24'),
(248, 4, 'What is the best way to respond to criticism?', 'Get defensive', 'Listen, reflect, and learn from it', 'Ignore it', 'Blame the person', 'B', 2, 'Situation-based Questions', 'mcq', NULL, '2026-01-06 16:25:24'),
(249, 3, 'What is the primary purpose of formative assessment in education?', 'To assign final grades to students', 'To provide feedback and improve learning during the instructional process', 'To compare students with national standards', 'To determine class rankings', 'B', 2, 'assessment', 'mcq', NULL, '2026-01-06 16:39:04'),
(250, 3, 'Which teaching method is most effective for developing critical thinking skills?', 'Lecture-based learning', 'Rote memorization', 'Problem-based learning and inquiry', 'Passive note-taking', 'C', 2, 'pedagogy', 'mcq', NULL, '2026-01-06 16:39:04'),
(253, 4, 'What is the importance of teamwork in workplace?', 'Reduces productivity', 'Promotes collaboration and efficiency', 'Eliminates leadership needs', 'Creates unnecessary competition', 'B', 2, 'workplace_skills', 'mcq', NULL, '2026-01-06 16:39:21');

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
(57, '2026-01-03', 57, 51, 'Applied'),
(58, '2026-01-07', 48, 49, 'Applied');

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
-- Table structure for table `test_cases`
--

CREATE TABLE `test_cases` (
  `test_case_id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `input` longtext NOT NULL,
  `expected_output` longtext NOT NULL,
  `is_sample` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_cases`
--

INSERT INTO `test_cases` (`test_case_id`, `problem_id`, `input`, `expected_output`, `is_sample`, `created_at`) VALUES
(1, 1, '5 10', '15', 1, '2026-01-06 17:01:54'),
(2, 1, '100 200', '300', 0, '2026-01-06 17:01:54'),
(3, 1, '-5 5', '0', 0, '2026-01-06 17:01:54'),
(4, 1, '1000000000 1000000000', '2000000000', 0, '2026-01-06 17:01:54'),
(5, 2, 'hello', 'olleh', 1, '2026-01-06 17:01:55'),
(6, 2, 'world', 'dlrow', 0, '2026-01-06 17:01:55'),
(7, 2, 'a', 'a', 0, '2026-01-06 17:01:55'),
(8, 2, 'coding', 'gnidoc', 0, '2026-01-06 17:01:55'),
(9, 3, 'programming', '3', 1, '2026-01-06 17:01:55'),
(10, 3, 'hello', '2', 0, '2026-01-06 17:01:55'),
(11, 3, 'aeiou', '5', 0, '2026-01-06 17:01:55'),
(12, 3, 'bcdfg', '0', 0, '2026-01-06 17:01:55'),
(13, 4, '7', '0 1 1 2 3 5 8', 1, '2026-01-06 17:01:55'),
(14, 4, '1', '0', 0, '2026-01-06 17:01:55'),
(15, 4, '10', '0 1 1 2 3 5 8 13 21 34', 0, '2026-01-06 17:01:55'),
(16, 5, '5\n3 7 2 9 1', '9', 1, '2026-01-06 17:01:55'),
(17, 5, '3\n-5 -2 -10', '-2', 0, '2026-01-06 17:01:55'),
(18, 5, '1\n42', '42', 0, '2026-01-06 17:01:55'),
(19, 5, '4\n100 50 75 80', '100', 0, '2026-01-06 17:01:55');

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
-- Indexes for table `coding_exam_results`
--
ALTER TABLE `coding_exam_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `seeker_id` (`seeker_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `coding_problems`
--
ALTER TABLE `coding_problems`
  ADD PRIMARY KEY (`problem_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `coding_submissions`
--
ALTER TABLE `coding_submissions`
  ADD PRIMARY KEY (`submission_id`),
  ADD KEY `seeker_id` (`seeker_id`),
  ADD KEY `problem_id` (`problem_id`),
  ADD KEY `exam_id` (`exam_id`);

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
-- Indexes for table `test_cases`
--
ALTER TABLE `test_cases`
  ADD PRIMARY KEY (`test_case_id`),
  ADD KEY `problem_id` (`problem_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coding_exam_results`
--
ALTER TABLE `coding_exam_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coding_problems`
--
ALTER TABLE `coding_problems`
  MODIFY `problem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coding_submissions`
--
ALTER TABLE `coding_submissions`
  MODIFY `submission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `employer`
--
ALTER TABLE `employer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exam_answers`
--
ALTER TABLE `exam_answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `exam_questions`
--
ALTER TABLE `exam_questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobsapplied`
--
ALTER TABLE `jobsapplied`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

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
-- AUTO_INCREMENT for table `test_cases`
--
ALTER TABLE `test_cases`
  MODIFY `test_case_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
