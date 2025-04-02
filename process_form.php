<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate input data
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // Recipient email address (replace with your email)
        $to = 'rojersbrianna5@gmail.com';
        
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
            echo json_encode(["success" => true]);
        } else {
            // If email fails to send, return failure response
            echo json_encode(["success" => false, "message" => "There was an error sending the message."]);
        }
    } else {
        // If validation fails, return an error message
        echo json_encode(["success" => false, "message" => "Please fill in all the fields correctly."]);
    }
}
?>
