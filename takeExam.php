<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Take Exam - JobVerseBD</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="mcss/bootstrap.min.css" rel="stylesheet">
    <link href="mcss/style.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
        }

        .exam-container {
            background: white;
            min-height: 100vh;
            padding: 20px;
        }

        .exam-header {
            position: sticky;
            top: 0;
            background: white;
            padding: 15px;
            border-bottom: 2px solid #007bff;
            margin-bottom: 20px;
            z-index: 100;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .timer {
            font-size: 24px;
            font-weight: bold;
            color: #dc3545;
            text-align: center;
        }

        .exam-title {
            flex: 1;
            text-align: center;
            color: #333;
        }

        .progress-info {
            color: #666;
            font-size: 14px;
        }

        .question-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .question-number {
            color: #007bff;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .question-text {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .options-container {
            margin: 20px 0;
        }

        .option {
            display: block;
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 2px solid #ddd;
            border-radius: 5px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: left;
            font-size: 16px;
        }

        .option:hover {
            border-color: #007bff;
            background: #f8f9ff;
        }

        .option input[type="radio"] {
            margin-right: 10px;
        }

        .option input[type="radio"]:checked+label {
            color: #007bff;
            font-weight: 600;
        }

        .option.selected {
            border-color: #007bff;
            background: #e7f3ff;
        }

        .marks-info {
            background: #e7f3ff;
            padding: 10px 15px;
            border-radius: 5px;
            color: #007bff;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            gap: 10px;
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

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-primary:hover:not(:disabled) {
            background: #0056b3;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .question-grid {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px auto;
            max-width: 900px;
        }

        .question-grid h6 {
            margin-bottom: 15px;
            color: #333;
        }

        .grid-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(50px, 1fr));
            gap: 8px;
        }

        .grid-btn {
            padding: 10px;
            border: 2px solid #ddd;
            background: white;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .grid-btn:hover {
            border-color: #007bff;
        }

        .grid-btn.answered {
            background: #28a745;
            color: white;
            border-color: #28a745;
        }

        .grid-btn.unanswered {
            background: #fff3cd;
            border-color: #ffc107;
        }

        .grid-btn.current {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        .legend {
            display: flex;
            gap: 15px;
            margin-top: 10px;
            flex-wrap: wrap;
            font-size: 12px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .legend-box {
            width: 20px;
            height: 20px;
            border-radius: 3px;
            border: 2px solid;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="exam-container">
        <div class="exam-header">
            <div class="progress-info">
                <span id="questionProgress">Question 1 of 50</span>
            </div>
            <div class="exam-title">
                <h5 id="examName" style="margin: 0;">General Knowledge - Jobs & Career</h5>
            </div>
            <div class="timer" id="timer">60:00</div>
        </div>

        <div id="loadingSpinner" class="loading">
            <p>Loading exam...</p>
        </div>

        <div id="questionContainer" class="question-container" style="display: none;">
            <div class="marks-info" id="marksInfo">
                Each question carries <strong>2 marks</strong>
            </div>

            <div class="question-number" id="questionNumberDisplay">Question 1</div>
            <div class="question-text" id="questionText">Question text will appear here</div>

            <div class="options-container" id="optionsContainer">
                <!-- Options will be generated here -->
            </div>

            <div class="navigation-buttons">
                <button class="btn btn-primary" id="prevBtn" onclick="previousQuestion()" disabled>← Previous</button>
                <button class="btn btn-danger" id="submitBtn" onclick="submitExam()" style="display: none;">Submit Exam</button>
                <button class="btn btn-primary" id="nextBtn" onclick="nextQuestion()">Next →</button>
            </div>
        </div>

        <div class="question-grid" id="questionGrid" style="display: none;">
            <h6>Question Navigation (Click to jump to question)</h6>
            <div class="grid-buttons" id="gridButtons">
                <!-- Question grid buttons will be generated here -->
            </div>
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-box" style="background: #28a745; border-color: #28a745;"></div>
                    <span>Answered</span>
                </div>
                <div class="legend-item">
                    <div class="legend-box" style="background: #fff3cd; border-color: #ffc107;"></div>
                    <span>Unanswered</span>
                </div>
                <div class="legend-item">
                    <div class="legend-box" style="background: #007bff; border-color: #007bff;"></div>
                    <span>Current</span>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        const examId = new URLSearchParams(window.location.search).get('exam_id') || 1;
        let currentQuestion = 0;
        let exam = null;
        let questions = [];
        let answers = {};
        let startTime = null;
        let timerInterval = null;
        let examDuration = 60; // minutes

        function loadExam() {
            console.log('Loading exam with ID:', examId);
            fetch('getExamDetails.php?exam_id=' + examId)
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.text();
                })
                .then(text => {
                    console.log('Raw response:', text);
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        throw new Error('Invalid JSON response: ' + text);
                    }
                })
                .then(data => {
                    console.log('Parsed data:', data);
                    if (data.success) {
                        exam = data.exam;
                        questions = data.questions;
                        examDuration = exam.duration_minutes;
                        startTime = Date.now();

                        console.log('Exam loaded:', exam);
                        console.log('Questions count:', questions.length);

                        document.getElementById('examName').textContent = exam.exam_name;
                        document.getElementById('loadingSpinner').style.display = 'none';
                        document.getElementById('questionContainer').style.display = 'block';
                        document.getElementById('questionGrid').style.display = 'block';

                        initializeAnswers();
                        generateQuestionGrid();
                        displayQuestion(0);
                        startTimer();
                    } else {
                        throw new Error(data.message || 'Unknown error');
                    }
                })
                .catch(error => {
                    console.error('Error loading exam:', error);
                    document.getElementById('loadingSpinner').innerHTML = '<p style="color: red;">Error: ' + error.message + '</p>';
                });
        }

        function initializeAnswers() {
            for (let i = 0; i < questions.length; i++) {
                answers[questions[i].question_id] = null;
            }
        }

        function generateQuestionGrid() {
            const gridButtons = document.getElementById('gridButtons');
            gridButtons.innerHTML = '';
            for (let i = 0; i < questions.length; i++) {
                const btn = document.createElement('button');
                btn.className = 'grid-btn unanswered';
                btn.textContent = i + 1;
                btn.onclick = () => jumpToQuestion(i);
                gridButtons.appendChild(btn);
            }
        }

        function displayQuestion(index) {
            currentQuestion = index;
            const q = questions[index];

            document.getElementById('questionProgress').textContent = `Question ${index + 1} of ${questions.length}`;
            document.getElementById('questionNumberDisplay').textContent = `Question ${index + 1}`;
            document.getElementById('questionText').textContent = q.question_text;

            const optionsHtml = `
                <label class="option ${answers[q.question_id] === 'A' ? 'selected' : ''}">
                    <input type="radio" name="answer" value="A" ${answers[q.question_id] === 'A' ? 'checked' : ''} onchange="selectAnswer('A', ${q.question_id})">
                    <strong>A.</strong> ${q.options.A}
                </label>
                <label class="option ${answers[q.question_id] === 'B' ? 'selected' : ''}">
                    <input type="radio" name="answer" value="B" ${answers[q.question_id] === 'B' ? 'checked' : ''} onchange="selectAnswer('B', ${q.question_id})">
                    <strong>B.</strong> ${q.options.B}
                </label>
                <label class="option ${answers[q.question_id] === 'C' ? 'selected' : ''}">
                    <input type="radio" name="answer" value="C" ${answers[q.question_id] === 'C' ? 'checked' : ''} onchange="selectAnswer('C', ${q.question_id})">
                    <strong>C.</strong> ${q.options.C}
                </label>
                <label class="option ${answers[q.question_id] === 'D' ? 'selected' : ''}">
                    <input type="radio" name="answer" value="D" ${answers[q.question_id] === 'D' ? 'checked' : ''} onchange="selectAnswer('D', ${q.question_id})">
                    <strong>D.</strong> ${q.options.D}
                </label>
            `;

            document.getElementById('optionsContainer').innerHTML = optionsHtml;

            // Update navigation buttons
            document.getElementById('prevBtn').disabled = index === 0;
            document.getElementById('nextBtn').style.display = index === questions.length - 1 ? 'none' : 'block';
            document.getElementById('submitBtn').style.display = index === questions.length - 1 ? 'block' : 'none';

            // Update grid
            updateQuestionGrid();
        }

        function updateQuestionGrid() {
            const gridButtons = document.querySelectorAll('.grid-btn');
            gridButtons.forEach((btn, i) => {
                btn.classList.remove('current', 'answered', 'unanswered');
                if (i === currentQuestion) {
                    btn.classList.add('current');
                } else if (answers[questions[i].question_id] !== null) {
                    btn.classList.add('answered');
                } else {
                    btn.classList.add('unanswered');
                }
            });
        }

        function selectAnswer(option, questionId) {
            answers[questionId] = option;
            updateQuestionGrid();

            // Add visual feedback
            const options = document.querySelectorAll('.option');
            options.forEach(opt => {
                if (opt.querySelector('input').value === option) {
                    opt.classList.add('selected');
                } else {
                    opt.classList.remove('selected');
                }
            });
        }

        function nextQuestion() {
            if (currentQuestion < questions.length - 1) {
                displayQuestion(currentQuestion + 1);
                window.scrollTo(0, 0);
            }
        }

        function previousQuestion() {
            if (currentQuestion > 0) {
                displayQuestion(currentQuestion - 1);
                window.scrollTo(0, 0);
            }
        }

        function jumpToQuestion(index) {
            displayQuestion(index);
            window.scrollTo(0, 0);
        }

        function startTimer() {
            let timeLeft = examDuration * 60;

            timerInterval = setInterval(() => {
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;

                document.getElementById('timer').textContent = 
                    String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

                // Change color to red when time is running out
                if (timeLeft < 300) {
                    document.getElementById('timer').style.color = '#dc3545';
                }

                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    alert('Time is up! Your exam will be submitted automatically.');
                    submitExam();
                }
            }, 1000);
        }

        function submitExam() {
            if (!confirm('Are you sure you want to submit the exam? You cannot change your answers after submission.')) {
                return;
            }

            clearInterval(timerInterval);

            // Check if all questions are answered
            let answeredCount = 0;
            for (let id in answers) {
                if (answers[id] !== null) answeredCount++;
            }

            const submissionData = {
                exam_id: examId,
                answers: answers,
                time_taken: Math.floor((Date.now() - startTime) / 1000)
            };

            fetch('submitExam.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(submissionData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'examResults.php?result_id=' + data.result_id;
                    } else {
                        alert('Error submitting exam: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error submitting exam. Please try again.');
                });
        }

        // Load exam on page load
        loadExam();

        // Prevent accidental tab close
        window.onbeforeunload = function () {
            return 'Are you sure you want to leave? Your exam progress will be lost.';
        };
    </script>
</body>

</html>
