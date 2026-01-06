-- Remove 1 question from Banking (exam_id=2: 51 -> 50)
DELETE FROM exam_questions WHERE exam_id = 2 ORDER BY question_id DESC LIMIT 1;

-- Add 2 questions for Education (exam_id=3: 48 -> 50)
INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(3, 'What is the primary purpose of formative assessment in education?', 'To assign final grades to students', 'To provide feedback and improve learning during the instructional process', 'To compare students with national standards', 'To determine class rankings', 'B', 2, 'assessment', 'mcq'),
(3, 'Which teaching method is most effective for developing critical thinking skills?', 'Lecture-based learning', 'Rote memorization', 'Problem-based learning and inquiry', 'Passive note-taking', 'C', 2, 'pedagogy', 'mcq');

-- Add 1 question for General Jobs (exam_id=4: 49 -> 50)
INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(4, 'What is the importance of teamwork in a workplace environment?', 'It reduces individual productivity', 'It promotes collaboration, efficiency, and better problem-solving', 'It eliminates the need for leadership', 'It creates unnecessary competition', 'B', 2, 'workplace_skills', 'mcq');
