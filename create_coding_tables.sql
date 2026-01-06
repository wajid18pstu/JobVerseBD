-- Create coding exam tables
CREATE TABLE IF NOT EXISTS coding_problems (
  problem_id int(11) NOT NULL AUTO_INCREMENT,
  exam_id int(11) NOT NULL,
  title varchar(255) NOT NULL,
  description longtext NOT NULL,
  difficulty varchar(50) NOT NULL DEFAULT 'medium',
  time_limit int(11) NOT NULL DEFAULT 2,
  memory_limit int(11) NOT NULL DEFAULT 256,
  sample_input longtext NOT NULL,
  sample_output longtext NOT NULL,
  explanation longtext,
  language_support varchar(255) NOT NULL DEFAULT 'python,cpp,java',
  points int(11) NOT NULL DEFAULT 10,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (problem_id),
  KEY exam_id (exam_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS test_cases (
  test_case_id int(11) NOT NULL AUTO_INCREMENT,
  problem_id int(11) NOT NULL,
  input longtext NOT NULL,
  expected_output longtext NOT NULL,
  is_sample tinyint(1) NOT NULL DEFAULT 0,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (test_case_id),
  KEY problem_id (problem_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS coding_submissions (
  submission_id int(11) NOT NULL AUTO_INCREMENT,
  seeker_id int(11) NOT NULL,
  problem_id int(11) NOT NULL,
  exam_id int(11) NOT NULL,
  code longtext NOT NULL,
  language varchar(50) NOT NULL,
  status varchar(50) NOT NULL DEFAULT 'pending',
  test_cases_passed int(11) NOT NULL DEFAULT 0,
  test_cases_total int(11) NOT NULL DEFAULT 0,
  execution_time float,
  memory_used int(11),
  error_message longtext,
  points_earned int(11) DEFAULT 0,
  submitted_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (submission_id),
  KEY seeker_id (seeker_id),
  KEY problem_id (problem_id),
  KEY exam_id (exam_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
