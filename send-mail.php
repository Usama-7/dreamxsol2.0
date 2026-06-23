<?php
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// Honeypot — bots often fill hidden fields
if (!empty($_POST['website'] ?? '')) {
    echo json_encode(['success' => true, 'message' => 'Message sent successfully.']);
    exit;
}

$name    = trim(strip_tags($_POST['name'] ?? ''));
$email   = trim($_POST['email'] ?? '');
$subject = trim(strip_tags($_POST['subject'] ?? 'Website contact form'));
$message = trim(strip_tags($_POST['message'] ?? ''));

if ($name === '' || $email === '' || $message === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

if (strlen($name) > 120 || strlen($email) > 200 || strlen($subject) > 200 || strlen($message) > 5000) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'One or more fields are too long.']);
    exit;
}

$to = 'info@dreamxsol.com';
$mailSubject = 'DreamX Contact: ' . $subject;

$body  = "New contact form submission\r\n\r\n";
$body .= "Name: {$name}\r\n";
$body .= "Email: {$email}\r\n";
$body .= "Subject: {$subject}\r\n\r\n";
$body .= "Message:\r\n{$message}\r\n";

$headers  = "From: DreamX Website <noreply@dreamxsol.com>\r\n";
$headers .= "Reply-To: {$name} <{$email}>\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

$sent = @mail($to, $mailSubject, $body, $headers);

if ($sent) {
    echo json_encode(['success' => true, 'message' => 'Message sent successfully.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to send email. Please try again or email us directly at info@dreamxsol.com.']);
}
