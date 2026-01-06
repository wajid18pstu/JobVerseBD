# Exam Question Types & Formats

## Overview
The new exam system supports **3 question types** across 4 exam categories:
1. **MCQ (Multiple Choice Questions)**
2. **Short Answer Questions**
3. **Coding Test Questions**

---

## 1. MCQ (Multiple Choice Questions)

### Format
- **4 Options:** A, B, C, D
- **Single Answer:** Only one correct option
- **Marks:** Typically 2 marks per question
- **Exam IDs:** Used in all exams (1, 2, 3, 4)

### Structure in Database
```
question_text: "What does TCP stand for?"
option_a: "Transfer Control Protocol"
option_b: "Transmission Control Protocol"
option_c: "Transfer Communication Protocol"
option_d: "Transmission Connection Protocol"
correct_option: "B"
marks: 2
question_type: "mcq"
```

### User Interface
```
Question 1: What does TCP stand for?

○ A. Transfer Control Protocol
○ B. Transmission Control Protocol (Selected)
○ C. Transfer Communication Protocol
○ D. Transmission Connection Protocol
```

### Scoring
- Correct answer: Full marks (2)
- Wrong/Unanswered: 0 marks

### Implementation
- Radio button selection
- Visual feedback when selected
- Question grid shows answered/unanswered status
- Navigation between questions

---

## 2. Short Answer Questions

### Format
- **Open-Ended:** Students type answer
- **Variable Length:** Answer can be few words to paragraphs
- **Marks:** Typically 3 marks per question
- **Exam IDs:** Exam 3 (Education & Training)

### Structure in Database
```
question_text: "Explain what is active learning and give one example"
option_a: "Passive listening in class"
option_b: "Student participation, discussion, and problem-solving (e.g., Group projects)"
option_c: "Reading textbooks silently"
option_d: "Watching lectures"
correct_option: "B"
marks: 3
question_type: "short_answer"
```

### User Interface
```
Question: Explain what is active learning and give one example

[Text input field for student answer]
[____________________________________________]
[____________________________________________]
[____________________________________________]
```

### Scoring
- **Manual/Automated Grading:**
  - Exact match: Full marks
  - Partial match: Partial marks
  - No match: 0 marks
- **Admin Panel:** Teachers can review and grade

### Implementation
- Textarea input for answers
- Answer storage in database
- Admin interface for manual grading
- Character limit can be set

---

## 3. Coding Test Questions

### Format
- **Problem-Solving:** Real-world coding scenarios
- **Code Snippets:** May include code to debug
- **Marks:** 3 marks per question
- **Exam IDs:** Exam 1 (IT, Engineering, Technical & Software)

### Types of Coding Questions

#### A. Write a Query
**Example:**
```
Question: Write a SQL query to find employees earning more than their manager:
```
**Answer Expected:**
```sql
SELECT e.name FROM employees e 
JOIN employees m ON e.manager_id = m.id 
WHERE e.salary > m.salary
```

#### B. Debug Code
**Example:**
```
Question: What is the bug in this code: 
for(int i=0; i<=10; i++) { array[i] = i; } 
(array size is 10)
```
**Expected Answer:**
```
Array index out of bounds (accessing index 10 when size is 10)
```

#### C. Network Troubleshooting
**Example:**
```
Question: A server is unreachable. What is the first step to diagnose?

Options: 
A. Check physical connection
B. Restart server immediately
C. Check DNS settings
D. Verify firewall rules
```

#### D. Software Testing Case Study
**Example:**
```
Question: What is the difference between unit testing and integration testing?

Expected Answer: Unit tests individual components; 
Integration tests combined components
```

#### E. ERP Workflow
**Example:**
```
Question: What is the typical order of purchase-to-pay cycle steps?

Expected Answer: Requisition → PO → Receipt → Invoice → Payment
```

### Structure in Database
```
question_text: "Write a SQL query to find employees earning more than their manager"
option_a: "Correct Query"
option_b: "Missing FROM clause"
option_c: "Incorrect JOIN condition"
option_d: "Invalid column reference"
correct_option: "A"
marks: 3
question_type: "coding"
category: "Coding Test - SQL Query"
```

### User Interface
```
Question: Write a SQL query to find employees earning more than their manager

[Code Editor with syntax highlighting]
┌─────────────────────────────────────────┐
│ SELECT ...                              │
│                                         │
│                                         │
│                                         │
└─────────────────────────────────────────┘

[Validate] [Submit Code]
```

### Scoring
- **Exact Match:** Full marks (3)
- **Partial Solution:** Partial marks
- **Incorrect:** 0 marks
- **Auto-Validation:** System checks code syntax and logic

### Implementation
- Code editor with syntax highlighting
- Language selection (SQL, Python, Java, C++, PHP)
- Code execution environment (if available)
- Comparison with expected output
- Admin can set partial marks

---

## Exam-Wise Question Distribution

### Exam 1: IT, Engineering & Technical
**Total: 40 questions, 100 marks, 90 minutes**

| Type | Count | Marks | Total |
|------|-------|-------|-------|
| MCQ | 25 | 2 each | 50 |
| Short Questions | 10 | 2 each | 20 |
| Coding Test | 5 | 3 each | 15 |
| **TOTAL** | **40** | - | **100** |

**Time Allocation:**
- MCQ: ~1.5 min per question = 37.5 minutes
- Short: ~2 min per question = 20 minutes
- Coding: ~5 min per question = 25 minutes
- Buffer: 7.5 minutes

### Exam 2: Banking, Finance & Corporate
**Total: 50 questions, 100 marks, 60 minutes**

| Type | Count | Marks | Total |
|------|-------|-------|-------|
| MCQ | 50 | 2 each | 100 |
| **TOTAL** | **50** | - | **100** |

**Time Allocation:**
- ~1 min per question = 50 minutes
- Review/Buffer: 10 minutes

### Exam 3: Education & Training
**Total: 45 questions, 100 marks, 75 minutes**

| Type | Count | Marks | Total |
|------|-------|-------|-------|
| MCQ | 30 | 2 each | 60 |
| Short Answer | 10 | 4 each | 40 |
| **TOTAL** | **40** | - | **100** |

**Time Allocation:**
- MCQ: ~1 min per question = 30 minutes
- Short Answer: ~3 min per question = 30 minutes
- Review/Buffer: 15 minutes

### Exam 4: General Jobs
**Total: 50 questions, 100 marks, 60 minutes**

| Type | Count | Marks | Total |
|------|-------|-------|-------|
| MCQ | 50 | 2 each | 100 |
| **TOTAL** | **50** | - | **100** |

**Time Allocation:**
- ~1 min per question = 50 minutes
- Review/Buffer: 10 minutes

---

## Answer Processing

### MCQ Processing
```php
1. Get selected option from user
2. Compare with correct_option in database
3. If match: marks = question marks
4. If not match: marks = 0
5. Store in exam_answers table
```

### Short Answer Processing
```php
1. Get text input from user
2. Store answer as text in database
3. Mark for manual review (initially)
4. OR use keyword matching for auto-grading
5. Store marks in exam_answers table
```

### Coding Test Processing
```php
1. Get code from code editor
2. Validate syntax
3. Execute and compare output
4. If output matches: Full marks
5. If partial: Apply partial marks logic
6. Store code and result in database
```

---

## Sample Question Templates

### MCQ Template
```
Question ID: auto
Exam ID: 1-4
Question Text: [Clear, concise question]
Option A: [Plausible distractor]
Option B: [Plausible distractor]
Option C: [Correct answer]
Option D: [Plausible distractor]
Correct Option: C
Marks: 2
Category: [Subject area]
Type: mcq
```

### Short Answer Template
```
Question ID: auto
Exam ID: 3
Question Text: [Open-ended question requiring explanation]
Option A: [Common wrong answer]
Option B: [Expected correct answer with key points]
Option C: [Alternative wrong answer]
Option D: [Another alternative]
Correct Option: B (most expected answer)
Marks: 3-4
Category: [Concept area]
Type: short_answer
```

### Coding Test Template
```
Question ID: auto
Exam ID: 1
Question Text: [Problem statement with clear requirements]
Option A: [Expected solution/Correct]
Option B: [Common error pattern]
Option C: [Logic error]
Option D: [Syntax error]
Correct Option: A
Marks: 3
Category: [Coding Test - Type]
Type: coding
```

---

## Grading Rubric

### MCQ & Coding
- **Binary Scoring:** Correct = Full marks, Incorrect = 0

### Short Answer
- **Full Marks (100%):** Answer includes all key points
- **3/4 Marks (75%):** Answer includes most key points
- **2/4 Marks (50%):** Answer includes some key points
- **1/4 Marks (25%):** Answer has minimal correct information
- **0 Marks (0%):** Wrong or no answer

---

## Future Enhancements

1. **Essay Questions:** Longer text responses
2. **Drag-and-Drop:** Match items or arrange sequences
3. **Image-Based:** Identify elements in images
4. **Video Questions:** Based on video content
5. **Interactive Simulations:** Real-world scenario simulations
6. **Auto-Scoring with AI:** ML-based answer evaluation
7. **Peer Review:** Student reviewing student answers

