<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Exam Instructions - JobVerseBD</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="mcss/bootstrap.min.css" rel="stylesheet">
    <link href="mcss/style.css" rel="stylesheet">
    <style>
        .instructions-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .exam-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
        }

        .exam-header h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .exam-header p {
            color: #666;
            font-size: 16px;
        }

        .instruction-section {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            border-radius: 5px;
        }

        .instruction-section h5 {
            color: #007bff;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .instruction-section ul {
            margin: 0;
            padding-left: 20px;
        }

        .instruction-section li {
            margin: 8px 0;
            color: #555;
        }

        .exam-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin: 20px 0;
            padding: 20px;
            background: #e7f3ff;
            border-radius: 5px;
        }

        .info-box {
            text-align: center;
        }

        .info-box p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        .info-box h5 {
            margin: 5px 0 0 0;
            color: #007bff;
            font-size: 20px;
        }

        .buttons-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-start {
            background: #007bff;
            color: white;
        }

        .btn-start:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 86, 179, 0.3);
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
        }

        .btn-cancel:hover {
            background: #545b62;
        }

        .warning-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }

        .success-box {
            background: #d4edda;
            border: 1px solid #28a745;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            color: #155724;
        }
    </style>
</head>

<body>
    <div class="container mt-5 mb-5">
        <div class="instructions-container">
            <div class="exam-header">
                <h2 id="examName">General Knowledge - Jobs & Career</h2>
                <p id="examDescription">Test your knowledge about job search, interview tips, and career planning</p>
            </div>

            <div class="exam-info">
                <div class="info-box">
                    <p>Total Questions</p>
                    <h5 id="totalQuestions">50</h5>
                </div>
                <div class="info-box">
                    <p>Total Marks</p>
                    <h5 id="totalMarks">100</h5>
                </div>
                <div class="info-box">
                    <p>Passing Marks</p>
                    <h5 id="passingMarks">50</h5>
                </div>
                <div class="info-box">
                    <p>Duration</p>
                    <h5 id="duration">60 <span style="font-size: 14px;">min</span></h5>
                </div>
            </div>

            <div class="success-box">
                <strong>✓ Good News!</strong> You need to score at least <span id="passingMarksText">50 marks</span> to pass this exam.
            </div>

            <div class="instruction-section">
                <h5>📋 Exam Guidelines</h5>
                <ul>
                    <li>This exam consists of 50 multiple-choice questions</li>
                    <li>Each question carries 2 marks</li>
                    <li>Total exam duration is 60 minutes</li>
                    <li>You cannot go back to previous questions once answered</li>
                    <li>The exam will auto-submit if time runs out</li>
                </ul>
            </div>

            <div class="instruction-section">
                <h5>❓ Question Format</h5>
                <ul>
                    <li>Each question has 4 options: A, B, C, D</li>
                    <li>Select only one correct answer</li>
                    <li>You must answer all questions before submission</li>
                    <li>Unanswered questions will be marked as incorrect</li>
                </ul>
            </div>

            <div class="instruction-section">
                <h5>⏱️ Timer & Navigation</h5>
                <ul>
                    <li>A countdown timer will be displayed during the exam</li>
                    <li>You can navigate between questions using Next and Previous buttons</li>
                    <li>Current question number will be displayed</li>
                    <li>Do not refresh the page during the exam</li>
                </ul>
            </div>

            <div class="instruction-section">
                <h5>✅ Submission & Results</h5>
                <ul>
                    <li>Click Submit button to finish the exam</li>
                    <li>Your results will be displayed immediately</li>
                    <li>You will see your score and detailed answer review</li>
                    <li>Your result will be saved in your profile</li>
                </ul>
            </div>

            <div class="warning-box">
                <strong>⚠️ Important:</strong> Do not close the browser during the exam. Ensure a stable internet connection. Your exam data is auto-saved.
            </div>

            <div class="buttons-container">
                <button class="btn btn-start" onclick="startExam()">Start Exam</button>
                <button class="btn btn-cancel" onclick="goBack()">Back to Dashboard</button>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        const examId = new URLSearchParams(window.location.search).get('exam_id') || 1;

        function loadExamDetails() {
            fetch('getExamDetails.php?exam_id=' + examId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const exam = data.exam;
                        document.getElementById('examName').textContent = exam.exam_name;
                        document.getElementById('examDescription').textContent = exam.description;
                        document.getElementById('totalQuestions').textContent = exam.total_questions;
                        document.getElementById('totalMarks').textContent = exam.total_marks;
                        document.getElementById('passingMarks').textContent = exam.passing_marks;
                        document.getElementById('passingMarksText').textContent = exam.passing_marks + ' marks';
                        document.getElementById('duration').textContent = exam.duration_minutes + ' min';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function startExam() {
            window.location.href = 'takeExam.php?exam_id=' + examId;
        }

        function goBack() {
            window.history.back();
        }

        loadExamDetails();
    </script>
</body>

</html>
