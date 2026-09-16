<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request.");
}

$name    = htmlspecialchars(trim($_POST["name"] ?? ""));
$phone   = htmlspecialchars(trim($_POST["phone"] ?? ""));
$email   = filter_var(trim($_POST["email"] ?? ""), FILTER_SANITIZE_EMAIL);
$address = htmlspecialchars(trim($_POST["address"] ?? ""));
$message = htmlspecialchars(trim($_POST["message"] ?? ""));
$consent = isset($_POST["consent"]);

if (!$name || !$email || !$consent) {
    exit("Please complete all required fields.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Please enter a valid email address.");
}

$to = "info@certifiwise.com";

$subject = "New Contact Form Enquiry";

$body = "New enquiry received from your website:\n\n";
$body .= "Name: " . $name . "\n";
$body .= "Phone: " . $phone . "\n";
$body .= "Email: " . $email . "\n";
$body .= "Address: " . $address . "\n\n";
$body .= "Message:\n" . $message . "\n";

$headers = "From: Website Contact Form <info@certifiwise.com>\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (mail($to, $subject, $body, $headers)) {
    header("Location: thank-you.html");
    exit;
} else {
    echo "Sorry, your message could not be sent. Please try again.";
}

?>
