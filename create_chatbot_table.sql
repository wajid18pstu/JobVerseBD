-- Create chatbot conversation history table
CREATE TABLE IF NOT EXISTS chatbot_conversations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    session_id VARCHAR(255) NOT NULL,
    user_message VARCHAR(1000) NOT NULL,
    bot_response VARCHAR(2000) NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_ip VARCHAR(50),
    INDEX(session_id),
    INDEX(timestamp)
);

-- Create chatbot FAQs table
CREATE TABLE IF NOT EXISTS chatbot_faqs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    question VARCHAR(500) NOT NULL,
    answer VARCHAR(2000) NOT NULL,
    category VARCHAR(100),
    keywords VARCHAR(500),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE,
    INDEX(category),
    INDEX(is_active)
);

-- Insert sample FAQ data
INSERT INTO chatbot_faqs (question, answer, category, keywords) VALUES
('How do I register on JobVerseBD?', 'To register on JobVerseBD, click on the "Sign Up" button on the homepage and fill in your details. Choose whether you want to register as a Job Seeker or Employer. Verify your email and start using the platform.', 'Registration', 'register, signup, account, create account'),
('How do I post a job?', 'If you are an employer, go to your account dashboard and click on "Post a Job". Fill in the job details including title, description, requirements, and salary. Review and publish your job posting.', 'Jobs', 'post job, create job, job posting'),
('How do I apply for a job?', 'Log in to your account as a Job Seeker. Browse available jobs and click on any job you are interested in. Click the "Apply" button and submit your application along with your resume.', 'Jobs', 'apply job, application, submit application'),
('What is the coding exam feature?', 'The coding exam feature allows employers to assess technical skills of job seekers. Job seekers can practice coding problems and take timed exams as part of the application process.', 'Coding Exam', 'coding exam, test, assessment, practice'),
('How do I reset my password?', 'Click on "Forgot Password" on the login page. Enter your email address and you will receive a password reset link. Click the link and set a new password.', 'Account', 'password reset, forgot password, password change'),
('How do I contact support?', 'You can contact us through the Contact page. Fill in your query and we will get back to you as soon as possible. You can also email us or call our support team.', 'Support', 'contact, support, help, assistance'),
('What is the payment system?', 'We use a secure payment gateway (SSL Commerz) to process payments. All transactions are encrypted and secure. Premium features and services can be accessed through this payment system.', 'Payment', 'payment, billing, subscription, premium'),
('How do I view my application status?', 'Log in to your account and go to "My Applications" or "Applied Jobs". Here you can see all your applications and their current status.', 'Application', 'application status, view applications, applied jobs'),
('Can I edit my profile?', 'Yes, you can edit your profile by going to your Account page and clicking "Edit Profile". Update your information and save the changes.', 'Account', 'profile, edit profile, update profile'),
('What is a saved job?', 'You can save jobs to view them later. Click the heart icon on a job listing to save it. Access your saved jobs from your dashboard.', 'Jobs', 'saved job, save job, favorites, bookmark')
ON DUPLICATE KEY UPDATE question=question;
