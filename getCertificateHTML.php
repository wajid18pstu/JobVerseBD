<?php
session_start();
require_once 'connect.php';

header('Content-Type: application/json');

// Get result ID from request
$result_id = isset($_GET['result_id']) ? intval($_GET['result_id']) : 0;

if (!$result_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid result ID']);
    die;
}

// Fetch result data
$query = "SELECT er.*, s.name 
          FROM exam_results er 
          LEFT JOIN seeker s ON er.seeker_id = s.id 
          WHERE er.result_id = ?
          LIMIT 1";

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $result_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!$result) {
    echo json_encode(['success' => false, 'message' => 'Result not found']);
    die;
}

// Check if passed
if ($result['status'] !== 'passed') {
    echo json_encode(['success' => false, 'message' => 'Certificate can only be generated for passed exams']);
    die;
}

// Get correct count
$query = "SELECT COUNT(*) as correct_count FROM exam_answers WHERE result_id = ? AND is_correct = 1";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $result_id);
$stmt->execute();
$correct = $stmt->get_result()->fetch_assoc();

// Get total questions
$query = "SELECT COUNT(*) as total FROM exam_answers WHERE result_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $result_id);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc();

$percentage = floatval($result['percentage']);
$correctCount = $correct['correct_count'];
$totalQuestions = $total['total'];
$formattedDate = date('F j, Y', strtotime($result['created_at']));

// Generate HTML for PDF
$html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            padding: 20px;
        }
        .certificate-document {
            background: white;
            border: 8px solid #d4af37;
            border-radius: 15px;
            padding: 60px 40px;
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            position: relative;
            page-break-after: avoid;
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
            display: table;
            width: 100%;
            margin: 30px 0;
            border-collapse: collapse;
        }
        .cert-detail-item {
            display: table-cell;
            background: #f8f9fa;
            padding: 15px 20px;
            border: 1px solid #ddd;
            border-left: 4px solid #d4af37;
            width: 25%;
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
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        .cert-signature {
            display: table-cell;
            text-align: center;
            width: 50%;
            padding: 20px;
        }
        .signature-line {
            border-bottom: 2px solid #333;
            margin: 40px 20px 10px 20px;
            height: 60px;
        }
        .signature-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }
        .cert-seal {
            font-size: 50px;
            margin: 20px 0;
        }
        .disclaimer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-style: italic;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="certificate-document">
        <div class="cert-seal">🏅</div>
        <div class="certificate-header">
            <h1 class="certificate-title">Certificate of Achievement</h1>
            <p class="certificate-subtitle">This is to certify that</p>
        </div>

        <div class="certificate-content">
            <div class="cert-name">{$result['name']}</div>
            
            <div class="cert-message">
                has successfully completed and passed the comprehensive examination conducted by
                <strong>JobVerseBD</strong>
            </div>

            <div class="cert-achievement">
                ✨ Score: {$percentage}% ✨
            </div>

            <table class="cert-details">
                <tr>
                    <td class="cert-detail-item">
                        <div class="cert-detail-label">Marks Obtained</div>
                        <div class="cert-detail-value">{$result['total_marks_obtained']}/{$result['total_marks_possible']}</div>
                    </td>
                    <td class="cert-detail-item">
                        <div class="cert-detail-label">Passing Marks</div>
                        <div class="cert-detail-value">{$result['passing_marks']}</div>
                    </td>
                    <td class="cert-detail-item">
                        <div class="cert-detail-label">Correct Answers</div>
                        <div class="cert-detail-value">{$correctCount}/{$totalQuestions}</div>
                    </td>
                    <td class="cert-detail-item">
                        <div class="cert-detail-label">Certificate Date</div>
                        <div class="cert-detail-value">{$formattedDate}</div>
                    </td>
                </tr>
            </table>

            <p style="margin-top: 30px; font-style: italic; color: #666;">
                This certificate is awarded in recognition of outstanding performance and commitment to professional excellence.
            </p>
        </div>

        <div class="cert-footer">
            <div class="cert-signature">
                <div class="cert-seal">🔐</div>
                <div class="signature-line"></div>
                <div class="signature-title">Authorized by JobVerseBD</div>
            </div>
            <div class="cert-signature">
                <div style="font-size: 40px; margin: 20px 0;">📜</div>
                <div class="signature-line"></div>
                <div class="signature-title">Certificate of Achievement</div>
            </div>
        </div>

        <div class="disclaimer">
            Certificate ID: {$result_id} | Generated on {$formattedDate}
        </div>
    </div>
</body>
</html>
HTML;

// Output HTML
echo json_encode([
    'success' => true,
    'html' => $html,
    'filename' => 'Certificate_' . str_replace(' ', '_', $result['name']) . '_' . time() . '.pdf'
]);
?>
