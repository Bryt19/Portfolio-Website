<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input data
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Validate input data
    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address";
    }

    if (empty($subject)) {
        $errors[] = "Subject is required";
    }

    if (empty($message)) {
        $errors[] = "Message is required";
    }

    if (empty($errors)) {
        // Recipient email address (replace with your email)
        $to = 'ac.bryt19@gmail.com';
        
        // Email subject
        $email_subject = "New message from: " . $name;
        
        // Construct the email body
        $email_body = "You have received a new message from your website contact form.\n\n";
        $email_body .= "Name: " . $name . "\n";
        $email_body .= "Email: " . $email . "\n";
        $email_body .= "Subject: " . $subject . "\n\n";
        $email_body .= "Message:\n" . $message . "\n";

        // Email headers
        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Send the email
        if (mail($to, $email_subject, $email_body, $headers)) {
            // If mail sent successfully, return success response
            echo json_encode([
                "success" => true,
                "message" => "Message sent successfully!"
            ]);
        } else {
            // If email fails to send, return failure response
            echo json_encode([
                "success" => false, 
                "message" => "There was an error sending the message. Please try again later."
            ]);
        }
    } else {
        // If validation fails, return error messages
        echo json_encode([
            "success" => false, 
            "message" => implode(", ", $errors)
        ]);
    }
} else {
    // If not POST request
    echo json_encode([
        "success" => false, 
        "message" => "Invalid request method"
    ]);
}
?>
