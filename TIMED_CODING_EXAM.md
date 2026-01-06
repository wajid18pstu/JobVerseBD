# Timed Coding Exam System - Implementation Summary

## New Features Added

### 1. **5-Minute Timer Per Problem**
- Each problem has a 5-minute countdown timer
- Timer displays in the top-right corner of the exam interface
- Timer changes color as time runs out:
  - **Normal (blue)**: 5:00 - 1:01
  - **Warning (orange)**: 1:00 - 0:31  
  - **Danger (red, pulsing)**: 0:30 - 0:00

### 2. **Automatic Problem Advancement**
- **When timer expires**: Automatically moves to next problem with 0 points for current problem
- **When all tests pass**: Automatically advances to next problem after submission
- **Manual continuation**: For failed/partial solutions, users can click next problem in the problems list

### 3. **Score Tracking System**
- **Per-Problem Scoring**: 
  - Sum of Two Numbers: 10 points
  - Reverse a String: 10 points
  - Count Vowels: 10 points
  - Fibonacci Series: 15 points
  - Find Largest Element: 15 points
  - **Total: 60 points max**

- **Real-time Score Display**: Current score shown in exam header (Problem X/5, Score X/60)

### 4. **Exam Session Management**
- Uses PHP sessions to track:
  - `$_SESSION['coding_exam_started']` - Exam start timestamp
  - `$_SESSION['coding_exam_scores']` - Array of scores per problem index
  - `$_SESSION['coding_current_problem']` - Current problem being solved

### 5. **Final Results Page**
After completing all 5 problems:
- **Displays:**
  - Total Score with visual progress circle (e.g., 45/60)
  - Problems Solved count (e.g., 3/5)
  - Time Taken in HH:MM:SS format
  - Pass/Fail Status (pass if ≥ 50 points)
- **Stores:** Results in `coding_exam_results` table
- **Auto-redirect:** Back to dashboard available

### 6. **Database Integration**
New table: `coding_exam_results`
```sql
result_id (PRIMARY KEY)
seeker_id (FK to users)
exam_id = 5
total_score (0-60)
max_score = 60
problems_solved (0-5)
total_problems = 5
time_taken_seconds (tracked for performance analytics)
completed_at (TIMESTAMP)
```

### 7. **Exam Results Display**
- Updated `getExamResults.php` to fetch both traditional and coding exam results
- Coding results shown in seekerAccount.php exam results table with:
  - Exam Name: "Coding Challenge Exam"
  - Score: e.g., "45 / 60"
  - Percentage: e.g., "75%"
  - Status: "passed" or "failed"
  - Date Submitted
  - Time Taken (formatted as 1h 23m 45s)
  - Additional detail row: "Problems Solved: 3 / 5"

## Files Created

1. **codingExamTimed.php** (500+ lines)
   - Main exam interface with 5-min timer per problem
   - Problem list with status indicators (active/solved/unsolved)
   - Code editor with language selection
   - Real-time score tracking
   - Final results page

2. **submitCodingExamTimed.php** (250+ lines)
   - Handles code submissions
   - Executes code in Python/C++/Java
   - Tests against all test cases
   - Determines auto-advance flag
   - Stores results in database

3. **createCodingResultsTable.php**
   - One-time setup script to create `coding_exam_results` table
   - Already executed and verified

## Files Modified

1. **seekerAccount.php**
   - Updated exam card button link: `codingExam.php` → `codingExamTimed.php`
   - Updated exam results display to show coding exam scores
   - Added special formatting for coding exam time display

2. **getExamResults.php**
   - Added query to fetch `coding_exam_results`
   - Merged results with traditional exam results
   - Added `is_coding` flag to differentiate exam types
   - Sorts all results by submission date

## How It Works

### User Flow
1. User clicks "Start Coding Challenge Exam" button
2. System initializes session variables and redirects to `codingExamTimed.php?prob_index=0`
3. **For each of 5 problems:**
   - 5-minute timer starts
   - User writes code and selects language
   - User clicks "Submit & Test Code"
   - Code is executed against test cases
   - If all pass: Auto-advance to next problem
   - If timer expires: Auto-advance with 0 points
   - If user manually clicks next problem: Advance with current score
4. After problem 5 is solved or skipped:
   - Redirect to results page
   - Display final score, time taken, problems solved
   - Store result in `coding_exam_results` table
   - Clear session variables
5. User can return to dashboard
6. Exam results visible in seekerAccount.php "Your Exam Results" section

### Code Execution
- **Python**: Direct execution with stdin input redirection
- **C++**: Compiled with g++ then executed
- **Java**: Compiled with javac then executed with java
- All executions in isolated temp directories
- Automatic cleanup of temp files

### Timing
- Timer uses client-side JavaScript with server timestamp reference
- Server-side fallback if client timer diverges
- Accurate to within 1 second

## Testing Checklist

- [ ] Navigate to `codingExamTimed.php`
- [ ] Verify 5-minute timer displays and counts down
- [ ] Submit passing solution → Should auto-advance
- [ ] Submit failing solution → Should stay on problem
- [ ] Wait for timer to expire → Should auto-advance with 0 points
- [ ] Complete all 5 problems → Should show results page
- [ ] Verify results stored in database
- [ ] Check exam results display in seekerAccount.php
- [ ] Verify scores and time calculations are correct

## Performance Notes

- Session-based tracking allows multiple simultaneous exams
- Timer synchronized via server timestamp
- Database writes optimized with prepared statements
- Temp files cleaned up immediately after execution
