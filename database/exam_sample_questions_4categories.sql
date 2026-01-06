-- Sample Questions for 4 Exam Categories in JobVerseBD

-- ========================================
-- EXAM 1: IT, Engineering, Technical & Software Sector (MCQ + Short Questions + Coding Test)
-- ========================================

-- Programming Questions
INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(1, 'Which of the following is a compiled language?', 'Python', 'C++', 'JavaScript', 'Ruby', 'B', 2, 'Programming', 'mcq'),
(1, 'What is the output of this Python code: print(2 ** 3)?', '5', '6', '8', '9', 'C', 2, 'Programming', 'mcq'),
(1, 'In Java, which keyword is used to define a constant?', 'const', 'constant', 'final', 'static', 'C', 2, 'Programming', 'mcq'),
(1, 'What does OOP stand for?', 'Object Oriented Programming', 'Object Ordering Programming', 'Objective Oriented Process', 'Object Organization Programming', 'A', 2, 'Programming', 'mcq'),
(1, 'Which of the following is NOT a programming paradigm?', 'Functional', 'Procedural', 'Objective', 'Object-Oriented', 'C', 2, 'Programming', 'mcq');

-- Data Structures & Algorithms
INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(1, 'What is the time complexity of binary search?', 'O(n)', 'O(log n)', 'O(n^2)', 'O(1)', 'B', 2, 'Data Structures & Algorithms', 'mcq'),
(1, 'Which data structure uses LIFO principle?', 'Queue', 'Stack', 'Tree', 'Graph', 'B', 2, 'Data Structures & Algorithms', 'mcq'),
(1, 'What is the space complexity of a recursive Fibonacci function?', 'O(1)', 'O(n)', 'O(n^2)', 'O(2^n)', 'D', 2, 'Data Structures & Algorithms', 'mcq'),
(1, 'Which sorting algorithm has the best average time complexity?', 'Bubble Sort', 'Merge Sort', 'Selection Sort', 'Insertion Sort', 'B', 2, 'Data Structures & Algorithms', 'mcq'),
(1, 'What is the main advantage of using Hash Tables?', 'Fast sorting', 'O(1) average lookup time', 'No memory overhead', 'Better cache performance', 'B', 2, 'Data Structures & Algorithms', 'mcq');

-- Database & SQL
INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(1, 'Which SQL command is used to create a new database?', 'MAKE DATABASE', 'CREATE DATABASE', 'NEW DATABASE', 'ADD DATABASE', 'B', 2, 'Database (SQL, DBMS)', 'mcq'),
(1, 'What does ACID stand for in database systems?', 'Atomicity, Consistency, Isolation, Durability', 'Accuracy, Consistency, Integration, Duration', 'Activity, Concurrency, Interaction, Data', 'Authorization, Certification, Identity, Data', 'A', 2, 'Database (SQL, DBMS)', 'mcq'),
(1, 'Which type of join returns all rows from both tables?', 'INNER JOIN', 'LEFT JOIN', 'FULL OUTER JOIN', 'CROSS JOIN', 'C', 2, 'Database (SQL, DBMS)', 'mcq'),
(1, 'What is a primary key in a database?', 'A key that opens the database', 'A field with unique values for each record', 'The first column in a table', 'The most important data column', 'B', 2, 'Database (SQL, DBMS)', 'mcq'),
(1, 'Which index type is best for range queries?', 'Hash Index', 'B-tree Index', 'Bitmap Index', 'Function Index', 'B', 2, 'Database (SQL, DBMS)', 'mcq');

-- Computer Networks
INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(1, 'What does TCP stand for?', 'Transfer Control Protocol', 'Transmission Control Protocol', 'Transfer Communication Protocol', 'Transmission Connection Protocol', 'B', 2, 'Computer Networks', 'mcq'),
(1, 'Which layer of the OSI model handles routing?', 'Data Link Layer', 'Network Layer', 'Transport Layer', 'Application Layer', 'B', 2, 'Computer Networks', 'mcq'),
(1, 'What is the purpose of a firewall?', 'To speed up internet', 'To protect network from unauthorized access', 'To store data', 'To create viruses', 'B', 2, 'Computer Networks', 'mcq'),
(1, 'Which protocol is used for secure web communication?', 'HTTP', 'HTTPS', 'FTP', 'SMTP', 'B', 2, 'Computer Networks', 'mcq'),
(1, 'What is the default port number for HTTP?', '21', '80', '443', '8080', 'B', 2, 'Computer Networks', 'mcq');

-- Operating Systems
INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(1, 'What is a process in an operating system?', 'A program stored on disk', 'An instance of a running program', 'A type of file', 'A hardware component', 'B', 2, 'Operating Systems', 'mcq'),
(1, 'Which scheduling algorithm gives equal time to each process?', 'FCFS', 'Round Robin', 'Priority Scheduling', 'SJF', 'B', 2, 'Operating Systems', 'mcq'),
(1, 'What is deadlock in OS?', 'A system crash', 'A situation where processes cannot proceed', 'A type of lock', 'A memory issue', 'B', 2, 'Operating Systems', 'mcq'),
(1, 'What is virtual memory?', 'Memory on external drives', 'An extension of physical memory using disk storage', 'Memory used only for games', 'Temporary browser memory', 'B', 2, 'Operating Systems', 'mcq'),
(1, 'Which of these is a real-time operating system?', 'Linux', 'Windows', 'VxWorks', 'macOS', 'C', 2, 'Operating Systems', 'mcq');

-- Web Technologies
INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(1, 'What does REST stand for?', 'Relational State Transfer', 'Representational State Transfer', 'Remote State Transfer', 'Response State Transfer', 'B', 2, 'Web Technologies', 'mcq'),
(1, 'Which of the following is a frontend framework?', 'Django', 'Spring Boot', 'React', 'Express.js', 'C', 2, 'Web Technologies', 'mcq'),
(1, 'What is the purpose of CSS?', 'To structure web pages', 'To add styling and layout', 'To handle server requests', 'To create databases', 'B', 2, 'Web Technologies', 'mcq'),
(1, 'Which HTTP method is used to update a resource in REST?', 'POST', 'PUT', 'GET', 'DELETE', 'B', 2, 'Web Technologies', 'mcq'),
(1, 'What does MVC stand for?', 'Model View Controller', 'Model Variable Component', 'Memory Virtual Cache', 'Multi View Component', 'A', 2, 'Web Technologies', 'mcq');

-- Short Answer / Coding Questions
INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(1, 'Write a SQL query to find employees earning more than their manager: SELECT e.name FROM employees e JOIN employees m ON e.manager_id = m.id WHERE e.salary > m.salary', 'Correct Query', 'Missing FROM clause', 'Incorrect JOIN condition', 'Invalid column reference', 'A', 3, 'Coding Test - SQL Query', 'coding'),
(1, 'What is the bug in this code: for(int i=0; i<=10; i++) { array[i] = i; } (array size is 10)', 'Array index out of bounds', 'Syntax error', 'Logic error in loop', 'No error', 'A', 3, 'Coding Test - Debug Code', 'coding'),
(1, 'Network troubleshooting: A server is unreachable. What is the first step to diagnose?', 'Check physical connection', 'Restart server immediately', 'Check DNS settings', 'Verify firewall rules', 'A', 3, 'Coding Test - Network Troubleshooting', 'coding'),
(1, 'Software testing: What is the difference between unit testing and integration testing?', 'Unit tests individual components; Integration tests combined components', 'They are the same', 'Unit testing is obsolete', 'Integration testing finds more bugs', 'A', 3, 'Coding Test - Software Testing', 'coding'),
(1, 'ERP workflow: What is the typical order of purchase-to-pay cycle steps?', 'Requisition → PO → Receipt → Invoice → Payment', 'Receipt → Requisition → PO → Invoice → Payment', 'PO → Requisition → Receipt → Invoice → Payment', 'Payment → Invoice → PO → Receipt → Requisition', 'A', 3, 'Coding Test - ERP Workflow', 'coding');

-- ========================================
-- EXAM 2: Banking, Finance & Corporate Sector (MCQ Only)
-- ========================================

INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(2, 'What is the primary function of a bank?', 'To issue currency', 'To accept deposits and provide loans', 'To manage stock markets', 'To set interest rates', 'B', 2, 'General Banking', 'mcq'),
(2, 'What does KYC stand for in banking?', 'Know Your Client', 'Know Your Code', 'Key Yield Commission', 'Know Your Credit', 'A', 2, 'General Banking', 'mcq'),
(2, 'Which organization regulates banks in Bangladesh?', 'Ministry of Finance', 'Bangladesh Bank', 'BAFSA', 'Stock Exchange', 'B', 2, 'General Banking', 'mcq'),
(2, 'What is the role of the central bank?', 'Provide retail banking services', 'Regulate monetary policy', 'Offer investment advice', 'Manage stock portfolios', 'B', 2, 'General Banking', 'mcq'),
(2, 'What is an overdraft in banking?', 'Excess payment', 'A temporary loan when account balance is insufficient', 'A type of savings account', 'Interest on deposits', 'B', 2, 'General Banking', 'mcq');

INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(2, 'What is the accounting equation?', 'Assets = Liabilities + Equity', 'Revenue - Expense = Profit', 'Assets - Liabilities = Debt', 'Income = Expense + Profit', 'A', 2, 'Accounting Principles', 'mcq'),
(2, 'What is depreciation?', 'Decrease in asset value over time', 'Loss of money', 'Tax reduction', 'Profit decrease', 'A', 2, 'Accounting Principles', 'mcq'),
(2, 'Which statement shows a companys financial position?', 'Income Statement', 'Balance Sheet', 'Cash Flow Statement', 'Trial Balance', 'B', 2, 'Accounting Principles', 'mcq'),
(2, 'What is a journal entry?', 'A daily business record', 'Recording of financial transactions', 'Employee diary', 'Business plan document', 'B', 2, 'Accounting Principles', 'mcq'),
(2, 'What does GAAP stand for?', 'General Accounting and Audit Principles', 'Generally Accepted Accounting Principles', 'Global Accounting Application Process', 'General Accounts and Payroll', 'B', 2, 'Accounting Principles', 'mcq');

INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(2, 'What is ROI?', 'Return on Investment', 'Rate of Interest', 'Revenue on Income', 'Return over Installment', 'A', 2, 'Financial Management', 'mcq'),
(2, 'What is the purpose of financial forecasting?', 'To predict future financial outcomes', 'To record past transactions', 'To audit accounts', 'To compute taxes', 'A', 2, 'Financial Management', 'mcq'),
(2, 'What is cash flow?', 'Money in your bank account', 'Movement of money in and out of business', 'Interest earned', 'Profit from sales', 'B', 2, 'Financial Management', 'mcq'),
(2, 'What is working capital?', 'Capital used in business operations', 'Long-term investments', 'Owner equity', 'Loan amount', 'A', 2, 'Financial Management', 'mcq'),
(2, 'What is break-even point?', 'Highest profit', 'Point where revenue equals costs', 'Lowest expense', 'Maximum sales', 'B', 2, 'Financial Management', 'mcq');

INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(2, 'What does GDP stand for?', 'Gross Domestic Product', 'Gross Development Program', 'Global Domestic Profit', 'Gross Data Product', 'A', 2, 'Economics (Basic)', 'mcq'),
(2, 'What is inflation?', 'Increase in prices of goods and services', 'Deflation of currency', 'Increase in production', 'Market expansion', 'A', 2, 'Economics (Basic)', 'mcq'),
(2, 'What is the primary role of the Bangladesh Bank?', 'Issue passports', 'Regulate monetary policy', 'Provide credit cards', 'Sell government bonds', 'B', 2, 'Bangladesh Banking System', 'mcq'),
(2, 'What is corporate governance?', 'Rules governing corporation operations', 'Corporate tax system', 'Employee management', 'Business location', 'A', 2, 'Corporate Governance', 'mcq'),
(2, 'What is the primary function of HR department?', 'Manage company finances', 'Recruit, train, and manage employees', 'Produce goods', 'Sell products', 'B', 2, 'HR Management', 'mcq');

INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(2, 'What is office management?', 'Managing office supplies', 'Coordinating office operations and resources', 'Cleaning the office', 'Scheduling meetings', 'B', 2, 'Office Management', 'mcq'),
(2, 'What is business planning?', 'Creating company strategy and goals', 'Scheduling employees', 'Maintaining office', 'Managing inventory', 'A', 2, 'Corporate Planning', 'mcq'),
(2, 'What does effective communication require?', 'Speaking loudly', 'Clarity, listening, and feedback', 'Using difficult words', 'Written communication only', 'B', 2, 'Business Communication', 'mcq'),
(2, 'What is organizational behavior?', 'How employees are managed', 'Study of people and groups in organization', 'Company policies', 'HR practices', 'B', 2, 'Organizational Behavior', 'mcq'),
(2, 'What is quantitative aptitude?', 'Ability to solve numerical problems', 'Language skills', 'Technical skills', 'Soft skills', 'A', 2, 'Quantitative Aptitude', 'mcq');

INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(2, 'What is data interpretation?', 'Converting numbers into meaningful information', 'Storing data', 'Deleting data', 'Copying data', 'A', 2, 'Data Interpretation', 'mcq'),
(2, 'What is analytical reasoning?', 'Logical thinking and problem solving', 'Reading books', 'Public speaking', 'Time management', 'A', 2, 'Analytical Reasoning', 'mcq'),
(2, 'Which of these is a correct sentence?', 'He dont go to office', 'She go to school daily', 'They works hard', 'The dog runs quickly', 'D', 2, 'English Grammar & Comprehension', 'mcq'),
(2, 'What is a synonym for proficient?', 'Slow', 'Skilled', 'Lazy', 'Weak', 'B', 2, 'English Grammar & Comprehension', 'mcq'),
(2, 'In MS Excel, what does SUM function do?', 'Finds average', 'Adds numbers in a range', 'Counts cells', 'Finds maximum', 'B', 2, 'MS Word, Excel, PowerPoint', 'mcq');

INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(2, 'What should be included in a professional email?', 'Casual greetings only', 'Greeting, purpose, closing', 'Emojis and slang', 'Only subject line', 'B', 2, 'Email & Office Etiquette', 'mcq'),
(2, 'What is basic IT knowledge essential for?', 'Office work efficiency', 'Playing games', 'Learning coding', 'Nothing important', 'A', 2, 'Basic IT Knowledge', 'mcq');

-- ========================================
-- EXAM 3: Education & Training Sector (MCQ + Short Answer)
-- ========================================

INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(3, 'What is the capital of Bangladesh?', 'Chittagong', 'Dhaka', 'Sylhet', 'Khulna', 'B', 2, 'School-level Subjects', 'mcq'),
(3, 'What is 15% of 200?', '20', '25', '30', '35', 'C', 2, 'School-level Subjects', 'mcq'),
(3, 'Which scientist discovered gravity?', 'Einstein', 'Newton', 'Galileo', 'Tesla', 'B', 2, 'School-level Subjects', 'mcq'),
(3, 'What is photosynthesis?', 'Decay of organisms', 'Process by which plants make food', 'Breaking down of rocks', 'Formation of soil', 'B', 2, 'School-level Subjects', 'mcq'),
(3, 'What is the chemical formula for water?', 'H3O', 'H2O', 'HO2', 'O2H', 'B', 2, 'School-level Subjects', 'mcq');

INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(3, 'What is the main purpose of teaching methodology?', 'To assign homework', 'To create effective teaching and learning strategies', 'To punish students', 'To make classes boring', 'B', 2, 'Teaching Methodology', 'mcq'),
(3, 'What is classroom management?', 'Cleaning the classroom', 'Creating conducive learning environment', 'Decorating walls', 'Maintaining furniture', 'B', 2, 'Teaching Methodology', 'mcq'),
(3, 'What does Bloom\'s Taxonomy focus on?', 'Plant classification', 'Cognitive levels of learning', 'Animal behavior', 'Historical events', 'B', 2, 'Teaching Methodology', 'mcq'),
(3, 'What is child psychology?', 'Psychology of animals', 'Study of child behavior and development', 'Psychology of adults', 'Study of plants', 'B', 2, 'Child Psychology', 'mcq'),
(3, 'What is continuous assessment?', 'Final exams only', 'Ongoing evaluation of student learning', 'Quarterly exams', 'Annual testing', 'B', 2, 'Assessment & Evaluation', 'mcq');

INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(3, 'What does NCTB stand for?', 'National College Teaching Board', 'National Curriculum and Textbook Board', 'National Curriculum Teaching Bureau', 'National College Textbook Bureau', 'B', 2, 'Curriculum Knowledge', 'mcq'),
(3, 'Which of these is part of the Bangladesh Constitution?', 'Independence Day', 'Fundamental Rights', 'National Anthem', 'Government structure', 'B', 2, 'Bangladesh Affairs', 'mcq'),
(3, 'What is the language of instruction in primary schools of Bangladesh?', 'English', 'Bengali', 'Urdu', 'Arabic', 'B', 2, 'Bangladesh Affairs', 'mcq'),
(3, 'What is the main goal of education policy?', 'To earn money', 'To develop human resources and society', 'To reduce expenses', 'To build buildings', 'B', 2, 'Education Policy', 'mcq'),
(3, 'What is English proficiency essential for?', 'Entertainment', 'Global communication and career opportunities', 'Playing games', 'Sleeping', 'B', 2, 'English Language Skills', 'mcq');

-- Short Answer Questions for Education Exam
INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(3, 'Explain what is active learning and give one example', 'Passive listening in class', 'Student participation, discussion, and problem-solving (e.g., Group projects)', 'Reading textbooks silently', 'Watching lectures', 'B', 3, 'Teaching Methodology - Short Answer', 'short_answer'),
(3, 'What are the key differences between formative and summative assessment?', 'No difference', 'Formative is ongoing feedback; Summative is final evaluation', 'Formative is final; Summative is ongoing', 'Both are same thing', 'B', 3, 'Assessment & Evaluation - Short Answer', 'short_answer'),
(3, 'Describe Piaget\'s theory of cognitive development', 'Theory about animal behavior', 'Stages of child cognitive development (Sensorimotor, Preoperational, Concrete, Formal)', 'Theory about emotions', 'Theory about languages', 'B', 3, 'Child Psychology - Short Answer', 'short_answer'),
(3, 'What role does a teacher play in promoting inclusivity in the classroom?', 'Ignoring diverse needs', 'Ensuring all students feel valued and accommodating different learning styles', 'Treating everyone the same', 'Focusing only on bright students', 'B', 3, 'Classroom Management - Short Answer', 'short_answer'),
(3, 'Explain the importance of critical thinking in education', 'It is not important', 'Developing ability to analyze, evaluate, and solve problems independently', 'Just memorizing facts', 'Following instructions blindly', 'B', 3, 'Education Policy - Short Answer', 'short_answer');

-- ========================================
-- EXAM 4: General Jobs Category (MCQ Only)
-- ========================================

INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(4, 'What is the capital of India?', 'Mumbai', 'Delhi', 'Bangalore', 'Chennai', 'B', 2, 'Bangladesh & World Affairs', 'mcq'),
(4, 'Which country is not in South Asia?', 'Bangladesh', 'Nepal', 'Myanmar', 'Sri Lanka', 'C', 2, 'Bangladesh & World Affairs', 'mcq'),
(4, 'Who is the current Prime Minister of Bangladesh (as of knowledge cutoff)?', 'Sheikh Hasina', 'Khaleda Zia', 'Rajon Pal', 'Fakhrul Islam', 'A', 2, 'Bangladesh & World Affairs', 'mcq'),
(4, 'What is the primary language spoken in Bangladesh?', 'English', 'Bengali', 'Urdu', 'Hindi', 'B', 2, 'Bangladesh & World Affairs', 'mcq'),
(4, 'Which international organization is Bangladesh a member of?', 'NATO', 'SAARC', 'EU', 'OPEC', 'B', 2, 'Bangladesh & World Affairs', 'mcq');

INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(4, 'Who won the last World Cup in cricket?', 'India', 'Australia', 'England', 'Pakistan', 'B', 2, 'Current Affairs', 'mcq'),
(4, 'What is a trending topic in technology?', 'Floppy disks', 'Artificial Intelligence', 'Typewriters', 'Landline phones', 'B', 2, 'Current Affairs', 'mcq'),
(4, 'What is a web browser?', 'Internet connection device', 'Software to view web pages', 'Internet service provider', 'Email service', 'B', 2, 'Basic ICT', 'mcq'),
(4, 'What does CPU stand for?', 'Central Processing Unit', 'Central Processor Unit', 'Computer Processing Unit', 'Central Program Unit', 'A', 2, 'Basic ICT', 'mcq'),
(4, 'What is the function of a keyboard?', 'Display information', 'Input data and commands', 'Store files', 'Process data', 'B', 2, 'Basic ICT', 'mcq');

INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(4, 'What causes seasons on Earth?', 'Distance from sun', 'Tilt of Earth\'s axis', 'Gravity', 'Atmosphere', 'B', 2, 'Everyday Science', 'mcq'),
(4, 'What is the process of water evaporation?', 'Water freezing', 'Liquid water changing to vapor', 'Dissolving in soil', 'Water filtering', 'B', 2, 'Everyday Science', 'mcq'),
(4, 'If A=2, B=4, then A+B=?', '4', '6', '8', '2', 'B', 2, 'Numerical Ability', 'mcq'),
(4, 'What is 20% of 500?', '50', '100', '150', '200', 'B', 2, 'Numerical Ability', 'mcq'),
(4, 'If a train travels 60 km/h for 2 hours, how far does it travel?', '30 km', '60 km', '90 km', '120 km', 'D', 2, 'Numerical Ability', 'mcq');

INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(4, 'What is logical reasoning?', 'Reading long passages', 'Using logic to solve problems and find patterns', 'Memorizing facts', 'Just guessing', 'B', 2, 'Logical Reasoning', 'mcq'),
(4, 'What comes next in the series: 2, 4, 6, 8, ?', '9', '10', '11', '12', 'B', 2, 'Logical Reasoning', 'mcq'),
(4, 'You are a salesperson and a customer is angry. What should you do?', 'Argue with customer', 'Listen to complaint, apologize, offer solution', 'Ignore customer', 'Hang up', 'B', 2, 'Sales Scenario & Customer Handling', 'mcq'),
(4, 'What is the most important in customer service?', 'Selling more products', 'Customer satisfaction and solving their problems', 'Minimizing costs', 'Quick transactions', 'B', 2, 'Sales Scenario & Customer Handling', 'mcq'),
(4, 'Safety rules in workplace are important for?', 'Punishing employees', 'Protecting worker health and preventing accidents', 'Saving money', 'Controlling employees', 'B', 2, 'Safety & Security Rules', 'mcq');

INSERT INTO `exam_questions` (`exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `category`, `question_type`) VALUES
(4, 'In a hotel, what is hospitality?', 'Providing only food', 'Welcoming guests warmly and providing excellent service', 'Selling rooms', 'Managing accounts', 'B', 2, 'Hospitality Etiquette', 'mcq'),
(4, 'What is proper greeting etiquette?', 'Ignoring people', 'Greeting with respect and appropriate body language', 'Speaking loudly', 'Using informal language', 'B', 2, 'Hospitality Etiquette', 'mcq'),
(4, 'Which sentence is correctly written in English?', 'He go to school', 'She goes to school', 'They goes to office', 'We is going home', 'B', 2, 'Email Writing & Comprehension', 'mcq'),
(4, 'What should be the tone of a professional email?', 'Casual and informal', 'Formal, clear, and respectful', 'Angry and rude', 'Too friendly', 'B', 2, 'Email Writing & Comprehension', 'mcq'),
(4, 'What is the main idea of a paragraph called?', 'Topic sentence', 'Supporting detail', 'Conclusion', 'Introduction', 'A', 2, 'Email Writing & Comprehension', 'mcq');
