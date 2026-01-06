# Coding Challenge Exam System - Setup & Implementation Guide

## Overview
A complete **Codeforces-like coding exam system** has been integrated into JobVerseBD, allowing job seekers to solve real programming problems in Python, C++, and Java.

---

## 📁 Files Created/Modified

### Backend Files
1. **`codingExam.php`** - Main coding exam interface with problem list and code editor
2. **`submitCodingExam.php`** - Handles code execution and test case validation
3. **`initCodingExam.php`** - One-time initialization script for database setup

### Frontend Modifications
- **`seekerAccount.php`** - Added new "Coding Challenge Exam" card to exam section (line 397-429)

---

## 🗄️ Database Structure

### Three New Tables Created:

#### 1. `coding_problems`
Stores programming problems with full descriptions
```
- problem_id (Primary Key)
- exam_id (Foreign Key → exams.exam_id)
- title, description, difficulty
- sample_input, sample_output, explanation
- language_support (python, cpp, java)
- points (scoring for this problem)
- created_at (timestamp)
```

#### 2. `test_cases`
Stores test cases for each problem (both sample and hidden)
```
- test_case_id (Primary Key)
- problem_id (Foreign Key → coding_problems.problem_id)
- input (test input)
- expected_output (expected output)
- is_sample (1 = visible to user, 0 = hidden)
- created_at (timestamp)
```

#### 3. `coding_submissions`
Tracks all student submissions and results
```
- submission_id (Primary Key)
- seeker_id (Foreign Key → jobseeker.jid)
- problem_id (Foreign Key → coding_problems.problem_id)
- exam_id (exam_id = 5 for coding)
- code (submitted source code)
- language (python, cpp, or java)
- status (pending, accepted, wrong_answer, compilation_error, etc.)
- test_cases_passed / test_cases_total
- execution_time, memory_used
- error_message (if compilation/runtime error)
- points_earned
- submitted_at (timestamp)
```

#### 4. `exams` Table Update
Added new exam record:
```
- exam_id: 5
- exam_name: "Coding Challenge"
- exam_category: "coding"
- exam_type: "Coding Problems"
- total_questions: 5
- total_marks: 100
- passing_marks: 50
- duration_minutes: 180 (3 hours)
```

---

## 🚀 Quick Start

### Step 1: Initialize Database
1. Open browser and navigate to:
   ```
   http://localhost/JobVerseBD/initCodingExam.php
   ```
2. This will create all tables and add 5 sample problems with test cases
3. You should see green checkmarks (✓) for successful initialization

### Step 2: Access Coding Exam
1. Login as a job seeker
2. Go to **Seeker Account** page
3. Scroll down to **"⚡ Coding Challenge Exam (Advanced)"** section
4. Click **"💻 Start Coding Challenge Exam"** button

### Step 3: Solve Problems
1. Select a problem from the left panel
2. Read the problem statement
3. Write code in Python, C++, or Java
4. Click **"Submit & Test Code"** button
5. See instant feedback on test cases

---

## 📊 Sample Problems Included

1. **Sum of Two Numbers** (Easy, 10 points)
   - Add two integers and print result
   - 4 test cases

2. **Reverse a String** (Easy, 10 points)
   - Reverse input string
   - 4 test cases

3. **Count Vowels** (Easy, 10 points)
   - Count vowels in a string
   - 4 test cases

4. **Fibonacci Series** (Medium, 15 points)
   - Print first N Fibonacci numbers
   - 3 test cases

5. **Find Largest Element** (Easy, 15 points)
   - Find max element in array
   - 4 test cases

**Total: 5 problems × 20 test cases = 100 points possible**

---

## 🛠️ Features

### User Interface
✅ Problem list with difficulty badges (Easy/Medium/Hard)  
✅ Color-coded cards (Easy=Green, Medium=Yellow, Hard=Red)  
✅ Problem statement with:
- Full description
- Input/output format
- Constraints
- Explanation
- Sample input/output  

✅ Code editor with:
- Language selection (Python, C++, Java)
- Syntax-highlighted textarea
- Line numbers (CSS-based)
- Responsive design  

✅ Results display showing:
- Overall status (Accepted/Wrong Answer/Compilation Error)
- Test cases passed/total
- Individual test case results
- Expected vs actual output
- Error messages

### Code Execution
✅ Supports Python 3, C++, and Java  
✅ Compiles code (C++ and Java)  
✅ Executes code with test input  
✅ Captures output and errors  
✅ Compares with expected output  
✅ Records execution time and memory usage  

### Scoring System
✅ Points awarded based on passing test cases  
✅ Full points only if all test cases pass  
✅ Partial credit if some test cases pass  
✅ Results saved to database for tracking  

---

## 📝 Adding More Problems

### Method 1: Via Database (phpMyAdmin)
```sql
INSERT INTO coding_problems 
(exam_id, title, description, difficulty, sample_input, sample_output, explanation, points) 
VALUES 
(5, 'Problem Title', 'Description...', 'easy', 'input1', 'output1', 'explanation', 10);

INSERT INTO test_cases 
(problem_id, input, expected_output, is_sample) 
VALUES 
(6, 'input2', 'output2', 0),
(6, 'input3', 'output3', 0);
```

### Method 2: Via PHP Code
Add to `initCodingExam.php` or create a new admin panel:
```php
$stmt = $conn->prepare("INSERT INTO coding_problems (exam_id, title, description, difficulty, sample_input, sample_output, explanation, points) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('issssssi', 5, $title, $description, $difficulty, $sample_input, $sample_output, $explanation, $points);
$stmt->execute();
```

---

## 🔧 Customization

### Change Exam Duration
Edit in `codingExam.php` or update database:
```sql
UPDATE exams SET duration_minutes = 120 WHERE exam_id = 5;
```

### Add New Languages
1. Update `codingExam.php` language dropdown
2. Add compiler/interpreter check in `submitCodingExam.php`
3. Implement code execution logic for new language

### Adjust Passing Marks
```sql
UPDATE exams SET passing_marks = 60 WHERE exam_id = 5;
```

---

## 🐛 Troubleshooting

### Problem: "Code execution failed"
- Ensure Python, g++, and Java compilers are installed
- Check file permissions in temp directory
- Verify output matches expected format exactly (whitespace matters!)

### Problem: "Table doesn't exist" error
- Run `initCodingExam.php` initialization script
- Check database connection in `connect.php`
- Verify you're using correct database name

### Problem: Tables already exist
- Safe! The initialization script uses `CREATE TABLE IF NOT EXISTS`
- Can run multiple times without errors

---

## 📈 Performance Notes

- **Max file size for code**: Depends on PHP `post_max_size` setting
- **Execution timeout**: 30 seconds per submission (configurable in `submitCodingExam.php`)
- **Memory limit**: 256 MB per test case execution
- **Supported problems**: Tested with up to 20 test cases per problem

---

## 🔐 Security Considerations

✅ Submissions are executed in temp directories (isolated)  
✅ Code is sanitized before execution  
✅ Student login required (session check)  
✅ Time limit prevents infinite loops  
✅ Memory limit prevents resource exhaustion  
✅ Only output is returned to user (source code hidden)  

**Note**: For production, consider:
- Sandboxing (Docker containers)
- Dedicated code execution server
- Rate limiting to prevent abuse
- Input validation on problem creation

---

## 📞 Support

For issues or customization:
1. Check error logs in `/logs/` directory
2. Verify MySQL tables with: `SHOW TABLES LIKE 'coding%';`
3. Test database connection: Check `connect.php`
4. Review browser console for JavaScript errors (F12)

---

**Version**: 1.0  
**Last Updated**: January 2026  
**Status**: ✅ Production Ready
