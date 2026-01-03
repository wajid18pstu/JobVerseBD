-- Exam System Tables

-- Table structure for exams
CREATE TABLE IF NOT EXISTS `exams` (
  `exam_id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_name` varchar(255) NOT NULL,
  `description` text,
  `total_questions` int(11) NOT NULL DEFAULT 50,
  `total_marks` int(11) NOT NULL DEFAULT 100,
  `passing_marks` int(11) NOT NULL DEFAULT 50,
  `duration_minutes` int(11) NOT NULL DEFAULT 60,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for exam questions
CREATE TABLE IF NOT EXISTS `exam_questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`question_id`),
  FOREIGN KEY (`exam_id`) REFERENCES `exams`(`exam_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for exam results (answers submitted by users)
CREATE TABLE IF NOT EXISTS `exam_results` (
  `result_id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `seeker_id` int(11) NOT NULL,
  `total_marks_obtained` int(11) NOT NULL DEFAULT 0,
  `total_marks_possible` int(11) NOT NULL DEFAULT 100,
  `percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `status` enum('passed', 'failed', 'incomplete') NOT NULL DEFAULT 'incomplete',
  `started_at` datetime DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `time_taken_seconds` int(11) DEFAULT 0,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`result_id`),
  FOREIGN KEY (`exam_id`) REFERENCES `exams`(`exam_id`) ON DELETE CASCADE,
  FOREIGN KEY (`seeker_id`) REFERENCES `seeker`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `unique_attempt` (`exam_id`, `seeker_id`, `submitted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for exam answers (individual answer tracking)
CREATE TABLE IF NOT EXISTS `exam_answers` (
  `answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `result_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_option` char(1) DEFAULT NULL COMMENT 'A, B, C, D, or NULL if not answered',
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `marks_obtained` int(11) NOT NULL DEFAULT 0,
  `answered_at` datetime DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`answer_id`),
  FOREIGN KEY (`result_id`) REFERENCES `exam_results`(`result_id`) ON DELETE CASCADE,
  FOREIGN KEY (`question_id`) REFERENCES `exam_questions`(`question_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default exam
INSERT INTO `exams` (`exam_name`, `description`, `total_questions`, `total_marks`, `passing_marks`, `duration_minutes`, `is_active`) 
VALUES ('General Knowledge - Jobs & Career', 'Test your knowledge about job search, interview tips, resume writing, workplace ethics, and career planning', 50, 100, 50, 60, 1);
