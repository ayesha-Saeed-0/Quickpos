<?php

// Only allow POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /../index.php");
    exit;
}

// Collect form data safely
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$message = trim($_POST["message"] ?? "");

// Errors array
$errors = [];

// Validate fields
if ($name === "") {
    $errors[] = "Name is required";
}
if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Valid email is required";
}
if ($message === "") {
    $errors[] = "Message is required";
}

// If any validation failed → redirect with error
if (!empty($errors)) {
    $errorText = urlencode(implode(", ", $errors));
    header("Location: /../index.php?error=$errorText");
    exit;
}

// Try to send email (may fail on localhost)
$to = "support@quickpos.com";  // For assignment purposes only
$subject = "New Contact Message From Website";
$body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

$headers = "From: noreply@quickpos.com\r\nReply-To: $email";

$mailSent = false;

// Try sending email (usually disabled on local PHP)
if (function_exists("mail")) {
    $mailSent = mail($to, $subject, $body, $headers);
}

// If mail() fails → save data to log file (this is allowed in assignments)
if (!$mailSent) {
    $logFile = __DIR__ . "/messages.log";
    $entry = date("Y-m-d H:i:s") . " | $name | $email | $message\n";
    file_put_contents($logFile, $entry, FILE_APPEND);
}

// Redirect to thank-you page
header("Location: /../thank-you.html");
exit;
