-- Create messages table to store contact form submissions
CREATE TABLE IF NOT EXISTS messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  userName VARCHAR(255) NOT NULL,
  userEmail VARCHAR(255) NOT NULL,
  subject VARCHAR(255) NOT NULL,
  content LONGTEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  is_read INT DEFAULT 0,
  INDEX (created_at),
  INDEX (is_read)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
