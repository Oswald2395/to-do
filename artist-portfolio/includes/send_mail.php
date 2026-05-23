<?php
// ── Contact form handler ──
// Replace the TO address below with your actual email
define('RECIPIENT', 'hello@yourname.com');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo 'Method not allowed';
  exit;
}

// Sanitize
$name    = htmlspecialchars(strip_tags(trim($_POST['name']    ?? '')));
$email   = filter_var(trim($_POST['email']   ?? ''), FILTER_SANITIZE_EMAIL);
$subject = htmlspecialchars(strip_tags(trim($_POST['subject'] ?? 'General Inquiry')));
$message = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')));

if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$message) {
  http_response_code(400);
  echo 'Invalid input.';
  exit;
}

$mailSubject = "Portfolio Contact: $subject — $name";
$mailBody = "Name: $name\nEmail: $email\nService: $subject\n\nMessage:\n$message";
$headers = "From: portfolio-noreply@yourname.com\r\nReply-To: $email\r\nX-Mailer: PHP/" . phpversion();

if (mail(RECIPIENT, $mailSubject, $mailBody, $headers)) {
  echo 'ok';
} else {
  http_response_code(500);
  echo 'Mail sending failed. Check your server mail configuration.';
}
