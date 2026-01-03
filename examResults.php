<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Exam Results - JobVerseBD</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="mcss/bootstrap.min.css" rel="stylesheet">
    <link href="mcss/style.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
        }

        .results-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .result-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .result-header {
            padding: 40px 30px;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .result-header.passed {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .result-header h2 {
            font-size: 36px;
            margin: 0 0 10px 0;
            font-weight: 700;
        }

        .result-status {
            font-size: 18px;
            margin: 10px 0;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 2px;
        }

        .score-display {
            font-size: 48px;
            font-weight: 700;
            margin: 20px 0;
        }

        .score-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            padding: 30px;
            background: #f8f9fa;
        }

        .detail-box {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .detail-label {
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .detail-value {
            font-size: 28px;
            font-weight: 700;
            color: #667eea;
        }

        .answer-review {
            padding: 30px;
        }

        .answer-review h4 {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }

        .answer-item {
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #ddd;
        }

        .answer-item.correct {
            border-left-color: #28a745;
            background: #f0fff4;
        }

        .answer-item.incorrect {
            border-left-color: #dc3545;
            background: #fff5f5;
        }

        .question-number {
            color: #667eea;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .question-text {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #333;
        }

        .answer-options {
            margin: 12px 0;
            font-size: 14px;
        }

        .option-display {
            padding: 8px;
            margin: 4px 0;
            border-radius: 4px;
            background: white;
        }

        .option-selected {
            border-left: 4px solid #667eea;
            padding-left: 12px;
            font-weight: 600;
        }

        .option-correct {
            border-left: 4px solid #28a745;
            padding-left: 12px;
            color: #28a745;
            font-weight: 600;
        }

        .marks-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }

        .marks-badge.correct {
            background: #d4edda;
            color: #155724;
        }

        .marks-badge.incorrect {
            background: #f8d7da;
            color: #721c24;
        }

        .buttons-container {
            padding: 30px;
            text-align: center;
            background: #f8f9fa;
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
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
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(118, 75, 162, 0.3);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #545b62;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .certificate {
            background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
            padding: 30px;
            border-radius: 10px;
            color: white;
            text-align: center;
            margin: 20px 0;
            display: none;
        }

        .certificate.show {
            display: block;
        }

        .certificate h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        @media print {
            body {
                background: white;
            }
            .buttons-container {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="results-container">
        <div id="loadingSpinner" class="loading">
            <p>Loading results...</p>
        </div>

        <div id="resultsContent" style="display: none;">
            <div class="result-card">
                <div class="result-header" id="resultHeader">
                    <h2 id="resultMessage">Excellent Performance!</h2>
                    <div class="result-status" id="resultStatus">PASSED</div>
                    <div class="score-display">
                        <span id="scorePercentage">85%</span>
                    </div>
                    <p style="margin: 0;">You have successfully passed the exam!</p>
                </div>

                <div class="score-details">
                    <div class="detail-box">
                        <div class="detail-label">Marks Obtained</div>
                        <div class="detail-value" id="marksObtained">85/100</div>
                    </div>
                    <div class="detail-box">
                        <div class="detail-label">Correct Answers</div>
                        <div class="detail-value" id="correctCount">42/50</div>
                    </div>
                    <div class="detail-box">
                        <div class="detail-label">Passing Marks</div>
                        <div class="detail-value" id="passingMarks">50</div>
                    </div>
                    <div class="detail-box">
                        <div class="detail-label">Time Taken</div>
                        <div class="detail-value" id="timeTaken">45 min</div>
                    </div>
                </div>

                <div id="certificateSection"></div>

                <div class="answer-review">
                    <h4>📝 Answer Review</h4>
                    <div id="answersContainer">
                        <!-- Answers will be loaded here -->
                    </div>
                </div>

                <div class="buttons-container">
                    <button class="btn btn-primary" onclick="printResults()">🖨️ Print Results</button>
                    <button class="btn btn-primary" onclick="downloadResults()">📥 Download PDF</button>
                    <button class="btn btn-secondary" onclick="goToDashboard()">Back to Dashboard</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        const resultId = new URLSearchParams(window.location.search).get('result_id');

        function formatTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;

            if (hours > 0) {
                return `${hours}h ${minutes}m`;
            } else if (minutes > 0) {
                return `${minutes}m ${secs}s`;
            } else {
                return `${secs}s`;
            }
        }

        function loadResults() {
            console.log('Loading result with ID:', resultId);
            fetch('getExamResult.php?result_id=' + resultId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response error: ' + response.status);
                    }
                    return response.text();
                })
                .then(text => {
                    console.log('Raw response:', text);
                    return JSON.parse(text);
                })
                .then(data => {
                    console.log('Parsed data:', data);
                    if (data.success) {
                        displayResults(data.result, data.answers);
                    } else {
                        throw new Error(data.message || 'Failed to load results');
                    }
                })
                .catch(error => {
                    console.error('Error loading results:', error);
                    document.getElementById('loadingSpinner').innerHTML = '<p style="color: red;">Error: ' + error.message + '</p>';
                });
        }

        function displayResults(result, answers) {
            const passed = result.status === 'passed';
            const percentage = parseFloat(result.percentage);
            const resultHeader = document.querySelector('.result-header');

            console.log('Result status:', result.status);
            console.log('Percentage:', percentage);
            console.log('Passed:', passed);

            // Update header styling based on pass/fail
            if (passed) {
                resultHeader.classList.add('passed');
                document.getElementById('resultMessage').textContent = '🎉 Congratulations!';
            } else {
                resultHeader.classList.remove('passed');
                document.getElementById('resultMessage').textContent = '📚 Better Luck Next Time';
            }

            // Update status
            document.getElementById('resultStatus').textContent = result.status.toUpperCase();

            // Update message text (conditional)
            const messageP = resultHeader.querySelector('p');
            if (passed) {
                messageP.textContent = 'You have successfully passed the exam!';
            } else {
                messageP.textContent = 'You did not pass this time. Try again to score higher!';
            }

            // Update scores
            document.getElementById('scorePercentage').textContent = percentage.toFixed(1) + '%';
            document.getElementById('marksObtained').textContent = result.total_marks_obtained + '/' + result.total_marks_possible;
            document.getElementById('correctCount').textContent = answers.filter(a => a.is_correct == 1).length + '/' + answers.length;
            document.getElementById('passingMarks').textContent = result.passing_marks;
            document.getElementById('timeTaken').textContent = formatTime(result.time_taken_seconds);

            // Show certificate if passed
            if (passed) {
                const certificateHtml = `
                    <div class="certificate show">
                        <h3>🏆 Certificate of Achievement</h3>
                        <p>This is to certify that you have successfully completed the General Knowledge - Jobs & Career Exam</p>
                        <p style="font-size: 14px;">Score: ${percentage.toFixed(1)}%</p>
                    </div>
                `;
                document.getElementById('certificateSection').innerHTML = certificateHtml;
            } else {
                document.getElementById('certificateSection').innerHTML = '';
            }

            // Display answers
            displayAnswers(answers);

            document.getElementById('loadingSpinner').style.display = 'none';
            document.getElementById('resultsContent').style.display = 'block';
        }

        function displayAnswers(answers) {
            const container = document.getElementById('answersContainer');
            container.innerHTML = '';

            answers.forEach((ans, index) => {
                const isCorrect = ans.is_correct == 1;
                const answerClass = isCorrect ? 'correct' : 'incorrect';
                const statusIcon = isCorrect ? '✓' : '✗';
                const marksClass = isCorrect ? 'correct' : 'incorrect';

                const optionsHtml = `
                    <div class="option-display ${ans.selected_option === 'A' ? 'option-selected' : ''}">
                        ${ans.selected_option === 'A' ? '<strong>Your Answer:</strong>' : ''} <strong>A.</strong> ${ans.option_a}
                    </div>
                    <div class="option-display ${ans.selected_option === 'B' ? 'option-selected' : ''}">
                        ${ans.selected_option === 'B' ? '<strong>Your Answer:</strong>' : ''} <strong>B.</strong> ${ans.option_b}
                    </div>
                    <div class="option-display ${ans.selected_option === 'C' ? 'option-selected' : ''}">
                        ${ans.selected_option === 'C' ? '<strong>Your Answer:</strong>' : ''} <strong>C.</strong> ${ans.option_c}
                    </div>
                    <div class="option-display ${ans.selected_option === 'D' ? 'option-selected' : ''}">
                        ${ans.selected_option === 'D' ? '<strong>Your Answer:</strong>' : ''} <strong>D.</strong> ${ans.option_d}
                    </div>
                    <div class="option-display option-correct">
                        <strong>Correct Answer:</strong> <strong>${ans.correct_option}.</strong>
                    </div>
                `;

                const answerHtml = `
                    <div class="answer-item ${answerClass}">
                        <div class="question-number">${statusIcon} Question ${index + 1}</div>
                        <div class="question-text">${ans.question_text}</div>
                        <div class="answer-options">${optionsHtml}</div>
                        <span class="marks-badge ${marksClass}">${isCorrect ? '+' : ''}${ans.marks_obtained}/${ans.marks} marks</span>
                    </div>
                `;

                container.innerHTML += answerHtml;
            });
        }

        function printResults() {
            window.print();
        }

        function downloadResults() {
            alert('PDF download feature coming soon!');
        }

        function goToDashboard() {
            window.location.href = 'seekerAccount.php';
        }

        // Load results on page load
        loadResults();
    </script>
</body>

</html>
