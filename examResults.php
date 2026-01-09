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

        /* Certificate Styles */
        .certificate-container {
            display: none;
            margin: 20px 0;
        }

        .certificate-container.show {
            display: block;
        }

        .certificate-document {
            background: white;
            border: 8px solid #d4af37;
            border-radius: 15px;
            padding: 60px;
            text-align: center;
            page-break-after: avoid;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            position: relative;
            margin: 20px 0;
        }

        .certificate-document::before {
            content: '';
            position: absolute;
            top: 20px;
            right: 20px;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, #FFD700, #FFA500);
            border-radius: 50%;
            opacity: 0.2;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        }

        .certificate-header {
            margin-bottom: 30px;
            border-bottom: 3px solid #d4af37;
            padding-bottom: 20px;
        }

        .certificate-title {
            font-size: 48px;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .certificate-subtitle {
            color: #666;
            font-size: 16px;
            margin-top: 10px;
            font-style: italic;
        }

        .certificate-content {
            margin: 40px 0;
            font-size: 18px;
            line-height: 1.8;
            color: #333;
        }

        .cert-to {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .cert-name {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            text-decoration: underline;
            text-decoration-style: wavy;
            text-decoration-color: #d4af37;
            margin: 20px 0;
            letter-spacing: 1px;
        }

        .cert-message {
            font-size: 16px;
            color: #333;
            margin: 20px 0;
            line-height: 1.6;
        }

        .cert-achievement {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 30px;
            border-radius: 10px;
            margin: 30px 0;
            font-weight: 600;
            font-size: 18px;
        }

        .cert-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin: 30px 0;
            text-align: left;
        }

        .cert-detail-item {
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 8px;
            border-left: 4px solid #d4af37;
        }

        .cert-detail-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .cert-detail-value {
            font-size: 18px;
            color: #1a1a1a;
            font-weight: 700;
        }

        .cert-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 3px solid #d4af37;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .cert-signature {
            text-align: center;
        }

        .signature-line {
            border-bottom: 2px solid #333;
            margin: 5px 0 10px 0;
            height: 5px;
        }

        .signature-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .cert-seal {
            text-align: center;
            font-size: 60px;
            margin: 20px 0;
            opacity: 0.3;
        }

        .certificate-buttons {
            margin-top: 20px;
            text-align: center;
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .certificate-buttons button {
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #d4af37;
            background: white;
            color: #667eea;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .certificate-buttons button:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
        }

        @media print {
            body {
                background: white;
            }
            .buttons-container {
                display: none;
            }
            .answer-review {
                display: none;
            }
            .certificate-buttons {
                display: none;
            }
            .certificate-document {
                box-shadow: none;
                border: 5px solid #d4af37;
                page-break-after: always;
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

                <div class="answer-review">
                    <h4>📝 Answer Review</h4>
                    <div id="answersContainer">
                        <!-- Answers will be loaded here -->
                    </div>
                </div>

                <div id="certificateContainer" class="certificate-container"></div>

                <div class="buttons-container">
                    <button id="generateCertBtn" class="btn btn-primary" onclick="generateCertificate()" style="display: none;">🏆 Generate Certificate</button>
                    <button class="btn btn-primary" onclick="downloadResults()">📥 Download PDF</button>
                    <button class="btn btn-secondary" onclick="goToDashboard()">Back to Dashboard</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        const resultId = new URLSearchParams(window.location.search).get('result_id');
        let currentResult = null;
        let currentAnswers = null;

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
                        currentResult = data.result;
                        currentAnswers = data.answers;
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
                document.getElementById('generateCertBtn').style.display = 'inline-block';
            } else {
                resultHeader.classList.remove('passed');
                document.getElementById('resultMessage').textContent = '📚 Better Luck Next Time';
                document.getElementById('generateCertBtn').style.display = 'none';
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

        function generateCertificate() {
            if (!currentResult) return;

            const percentage = parseFloat(currentResult.percentage);
            const correctCount = currentAnswers.filter(a => a.is_correct == 1).length;
            const totalQuestions = currentAnswers.length;
            const currentDate = new Date();
            const formattedDate = currentDate.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });

            const certificateHtml = `
                <div class="certificate-document" id="certificatePDF">
                    <div class="cert-seal">🏅</div>
                    <div class="certificate-header">
                        <h1 class="certificate-title">Certificate of Achievement</h1>
                        <p class="certificate-subtitle">This is to certify that</p>
                    </div>

                    <div class="certificate-content">
                        <div class="cert-name">${currentResult.full_name || 'Candidate Name'}</div>
                        
                        <div class="cert-message">
                            has successfully completed and passed the comprehensive examination conducted by
                            <strong>JobVerseBD</strong>
                        </div>

                        <div class="cert-achievement">
                            ✨ Score: ${percentage.toFixed(1)}% ✨
                        </div>

                        <div class="cert-details">
                            <div class="cert-detail-item">
                                <div class="cert-detail-label">Marks Obtained</div>
                                <div class="cert-detail-value">${currentResult.total_marks_obtained}/${currentResult.total_marks_possible}</div>
                            </div>
                            <div class="cert-detail-item">
                                <div class="cert-detail-label">Passing Marks</div>
                                <div class="cert-detail-value">${currentResult.passing_marks}</div>
                            </div>
                            <div class="cert-detail-item">
                                <div class="cert-detail-label">Correct Answers</div>
                                <div class="cert-detail-value">${correctCount}/${totalQuestions}</div>
                            </div>
                            <div class="cert-detail-item">
                                <div class="cert-detail-label">Certificate Date</div>
                                <div class="cert-detail-value">${formattedDate}</div>
                            </div>
                        </div>

                        <p style="margin-top: 30px; font-style: italic; color: #666;">
                            This certificate is awarded in recognition of outstanding performance and commitment to professional excellence.
                        </p>
                    </div>

                    <div class="cert-footer" style="grid-template-columns: 1fr;">
                        <div class="cert-signature">
                            <img src="img/seal.png" alt="Seal" style="height: 200px; margin-bottom: 5px;">
                            <div class="signature-line"></div>
                            <div class="signature-title" style="margin-top: 0;">Authorized by JobVerseBD</div>
                        </div>
                    </div>
                </div>

                <div class="certificate-buttons">
                    <button onclick="printCertificate()">🖨️ Print Certificate</button>
                    <button onclick="downloadCertificatePDF(event)">📥 Download PDF</button>
                </div>
            `;

            const container = document.getElementById('certificateContainer');
            container.innerHTML = certificateHtml;
            container.classList.add('show');

            // Scroll to certificate
            setTimeout(() => {
                container.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }

        function printCertificate() {
            const certElement = document.getElementById('certificatePDF');
            if (certElement) {
                const printWindow = window.open('', '', 'width=1200,height=800');
                printWindow.document.write('<html><head><title>Certificate</title>');
                printWindow.document.write('<style>');
                printWindow.document.write(document.querySelector('style').innerHTML);
                printWindow.document.write('</style></head><body>');
                printWindow.document.write(certElement.outerHTML);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                setTimeout(() => {
                    printWindow.print();
                }, 250);
            }
        }

        function downloadCertificatePDF(event) {
            const certElement = document.getElementById('certificatePDF');
            if (!certElement) {
                alert('Certificate not found. Please generate the certificate first.');
                return;
            }

            try {
                // Show a loading indicator
                const btn = event ? event.target : document.querySelector('[onclick*="downloadCertificatePDF"]');
                const originalText = btn.innerHTML;
                btn.innerHTML = '⏳ Generating PDF...';
                btn.disabled = true;

                const fileName = `Certificate_${currentResult.full_name || 'Candidate'}_${new Date().getTime()}.pdf`;
                
                // Use html2canvas to convert element to image
                html2canvas(certElement, {
                    allowTaint: true,
                    useCORS: true,
                    scale: 2,
                    logging: false,
                    backgroundColor: '#ffffff'
                }).then(canvas => {
                    try {
                        // Get jsPDF properly from the window object
                        const jsPDFConstructor = window.jspdf ? window.jspdf.jsPDF : window.jsPDF;
                        
                        if (!jsPDFConstructor) {
                            throw new Error('jsPDF library not loaded. Please refresh the page.');
                        }
                        
                        const imgData = canvas.toDataURL('image/png');
                        const pdf = new jsPDFConstructor({
                            orientation: 'portrait',
                            unit: 'mm',
                            format: 'a4'
                        });
                        
                        const imgWidth = 210; // A4 width in mm
                        const imgHeight = (canvas.height * imgWidth) / canvas.width;
                        let heightLeft = imgHeight;
                        let position = 0;
                        
                        // Add image to PDF
                        pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                        heightLeft -= 297; // A4 height in mm
                        
                        // Add additional pages if needed
                        while (heightLeft >= 0) {
                            position = heightLeft - imgHeight;
                            pdf.addPage();
                            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                            heightLeft -= 297;
                        }
                        
                        pdf.save(fileName);
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                        console.log('PDF downloaded successfully');
                    } catch (pdfError) {
                        console.error('PDF creation error:', pdfError);
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                        alert('Error creating PDF: ' + pdfError.message);
                    }
                }).catch(canvasError => {
                    console.error('Canvas rendering error:', canvasError);
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    alert('Error rendering certificate: ' + canvasError.message);
                });

            } catch (error) {
                console.error('Error:', error);
                alert('Error downloading certificate: ' + error.message);
                if (event && event.target) {
                    event.target.disabled = false;
                    event.target.innerHTML = '📥 Download PDF';
                }
            }
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
