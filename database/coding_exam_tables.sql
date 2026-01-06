-- Database structure for coding test exam system

-- Create coding_problems table
CREATE TABLE IF NOT EXISTS `coding_problems` (
  `problem_id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `difficulty` enum('easy','medium','hard') NOT NULL DEFAULT 'medium',
  `time_limit` int(11) NOT NULL DEFAULT 2,
  `memory_limit` int(11) NOT NULL DEFAULT 256,
  `sample_input` longtext NOT NULL,
  `sample_output` longtext NOT NULL,
  `explanation` longtext,
  `language_support` varchar(255) NOT NULL DEFAULT 'python,cpp,java',
  `points` int(11) NOT NULL DEFAULT 10,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`problem_id`),
  KEY `exam_id` (`exam_id`),
  FOREIGN KEY (`exam_id`) REFERENCES `exams`(`exam_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create test_cases table
CREATE TABLE IF NOT EXISTS `test_cases` (
  `test_case_id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL,
  `input` longtext NOT NULL,
  `expected_output` longtext NOT NULL,
  `is_sample` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`test_case_id`),
  KEY `problem_id` (`problem_id`),
  FOREIGN KEY (`problem_id`) REFERENCES `coding_problems`(`problem_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create coding_submissions table
CREATE TABLE IF NOT EXISTS `coding_submissions` (
  `submission_id` int(11) NOT NULL AUTO_INCREMENT,
  `seeker_id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `code` longtext NOT NULL,
  `language` varchar(50) NOT NULL,
  `status` enum('pending','accepted','wrong_answer','runtime_error','time_limit_exceeded','compilation_error','partial') NOT NULL DEFAULT 'pending',
  `test_cases_passed` int(11) NOT NULL DEFAULT 0,
  `test_cases_total` int(11) NOT NULL DEFAULT 0,
  `execution_time` float,
  `memory_used` int(11),
  `error_message` longtext,
  `points_earned` int(11) DEFAULT 0,
  `submitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`submission_id`),
  KEY `seeker_id` (`seeker_id`),
  KEY `problem_id` (`problem_id`),
  KEY `exam_id` (`exam_id`),
  FOREIGN KEY (`seeker_id`) REFERENCES `jobseeker`(`jid`) ON DELETE CASCADE,
  FOREIGN KEY (`problem_id`) REFERENCES `coding_problems`(`problem_id`) ON DELETE CASCADE,
  FOREIGN KEY (`exam_id`) REFERENCES `exams`(`exam_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add new coding exam to exams table
INSERT INTO `exams` (`exam_name`, `exam_description`, `exam_category`, `exam_type`, `total_questions`, `total_marks`, `passing_marks`, `duration_minutes`, `status`) 
VALUES ('Coding Challenge', 'Solve programming problems like on Codeforces. Solve real-world coding challenges with multiple test cases.', 'coding', 'Coding Problems', 5, 100, 50, 180, 1)
ON DUPLICATE KEY UPDATE exam_name = exam_name;

-- Sample coding problems

INSERT INTO `coding_problems` (`exam_id`, `title`, `description`, `difficulty`, `time_limit`, `memory_limit`, `sample_input`, `sample_output`, `explanation`, `language_support`, `points`) 
VALUES 
(5, 'Sum of Two Numbers', 'Given two integers A and B, find their sum.\n\nInput Format:\nFirst line contains two space-separated integers A and B\n\nOutput Format:\nPrint the sum of A and B\n\nConstraints:\n1 ≤ A, B ≤ 10^9', 2, 2, 256, '5 10', '15', 'Simply add A and B and print the result.', 'python,cpp,java', 10),
(5, 'Reverse a String', 'Given a string S, reverse it and print it.\n\nInput Format:\nFirst line contains a string S\n\nOutput Format:\nPrint the reversed string\n\nConstraints:\n1 ≤ length of S ≤ 1000', 2, 1, 256, 'hello', 'olleh', 'Use string reversal operations to reverse the input string.', 'python,cpp,java', 10),
(5, 'Count Vowels', 'Given a string S, count the number of vowels in it.\n\nInput Format:\nFirst line contains a string S\n\nOutput Format:\nPrint the count of vowels (a, e, i, o, u)\n\nConstraints:\n1 ≤ length of S ≤ 10000', 2, 1, 256, 'programming', '3', 'Iterate through each character and count vowels.', 'python,cpp,java', 10),
(5, 'Fibonacci Series', 'Given N, print the first N Fibonacci numbers.\n\nInput Format:\nFirst line contains integer N\n\nOutput Format:\nPrint N Fibonacci numbers separated by space\n\nConstraints:\n1 ≤ N ≤ 50', 2, 1, 256, '7', '0 1 1 2 3 5 8', 'Use the Fibonacci formula where F(n) = F(n-1) + F(n-2), with F(0)=0 and F(1)=1.', 'python,cpp,java', 15),
(5, 'Find Largest Element', 'Given an array of N integers, find the largest element.\n\nInput Format:\nFirst line contains N\nSecond line contains N space-separated integers\n\nOutput Format:\nPrint the largest element\n\nConstraints:\n1 ≤ N ≤ 10^5\n-10^9 ≤ elements ≤ 10^9', 2, 1, 256, '5\n3 7 2 9 1', '9', 'Compare all elements and find the maximum value.', 'python,cpp,java', 15);

-- Sample test cases for each problem
-- Problem 1: Sum of Two Numbers
INSERT INTO `test_cases` (`problem_id`, `input`, `expected_output`, `is_sample`) 
VALUES 
(1, '5 10', '15', 1),
(1, '100 200', '300', 0),
(1, '-5 5', '0', 0),
(1, '1000000000 1000000000', '2000000000', 0);

-- Problem 2: Reverse a String
INSERT INTO `test_cases` (`problem_id`, `input`, `expected_output`, `is_sample`) 
VALUES 
(2, 'hello', 'olleh', 1),
(2, 'world', 'dlrow', 0),
(2, 'a', 'a', 0),
(2, 'coding', 'gnidoc', 0);

-- Problem 3: Count Vowels
INSERT INTO `test_cases` (`problem_id`, `input`, `expected_output`, `is_sample`) 
VALUES 
(3, 'programming', '3', 1),
(3, 'hello', '2', 0),
(3, 'aeiou', '5', 0),
(3, 'bcdfg', '0', 0);

-- Problem 4: Fibonacci Series
INSERT INTO `test_cases` (`problem_id`, `input`, `expected_output`, `is_sample`) 
VALUES 
(4, '7', '0 1 1 2 3 5 8', 1),
(4, '1', '0', 0),
(4, '10', '0 1 1 2 3 5 8 13 21 34', 0);

-- Problem 5: Find Largest Element
INSERT INTO `test_cases` (`problem_id`, `input`, `expected_output`, `is_sample`) 
VALUES 
(5, '5\n3 7 2 9 1', '9', 1),
(5, '3\n-5 -2 -10', '-2', 0),
(5, '1\n42', '42', 0),
(5, '4\n100 50 75 80', '100', 0);
