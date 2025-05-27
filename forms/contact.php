<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "smartbusnavigation@gmail.com";
    $subject = filter_var($_POST["subject"], FILTER_SANITIZE_STRING);
    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST["message"], FILTER_SANITIZE_STRING);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email address.";
        exit;
    }

    // Prepare email headers and body
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $body = "You have received a new message from your website contact form.\n\n".
            "Name: $name\n".
            "Email: $email\n".
            "Subject: $subject\n\n".
            "Message:\n$message\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        http_response_code(200);
        echo "Your message has been sent. Thank you!";
    } else {
        http_response_code(500);
        echo "Sorry, something went wrong. Please try again later.";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
