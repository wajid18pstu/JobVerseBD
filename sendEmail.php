<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function configureMailer(PHPMailer $mail)
{
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Username = 'wajid567765@gmail.com';
    $mail->Password = 'vdcw jixs sqiv lung';
    $mail->Port = 465;
    $mail->setFrom('wajid567765@gmail.com', 'JobVerseBD');
}

if (isset($_POST['send_email'])) {
    $to_email = $_POST['to_email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $applicant_name = $_POST['applicant_name'];
    
    $mail = new PHPMailer(true);

    try {
        configureMailer($mail);

        // Recipients
        $mail->addAddress($to_email, $applicant_name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Email sent successfully']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => "Email could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
    exit();
}

if (isset($_POST['send_default_email'])) {
    $to_email = $_POST['to_email'];
    $applicant_name = $_POST['applicant_name'];
    $job_title = $_POST['job_title'];
    
    $subject = "Interview Invitation for $job_title position";
    $message = "Dear $applicant_name,<br><br>"
             . "Thank you for applying for the position of $job_title. We are pleased to inform you that you have been selected for an interview.<br><br>"
             . "Our hiring team was impressed with your qualifications and experience. We would like to schedule an interview with you to discuss this opportunity further.<br><br>"
             . "We will contact you shortly with specific interview details.<br><br>"
             . "Best regards,<br>"
             . "JobVerseBD Team";
    
    $mail = new PHPMailer(true);

    try {
        configureMailer($mail);

        // Recipients
        $mail->addAddress($to_email, $applicant_name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Email sent successfully']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => "Email could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
    exit();
}
?>