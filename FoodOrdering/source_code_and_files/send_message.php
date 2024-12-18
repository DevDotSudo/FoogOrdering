<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "ericdavecalaor1245@gmail.com";
    $subject = "New Message from Contact Form";
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $headers = "From: " . $email . "\r\n" .
               "Reply-To: " . $email . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    $email_body = "You have received a new message from the user $fullname.\n".
                  "Here is the message:\n$message";

    if (mail($to, $subject, $email_body, $headers)) {
        echo "<script>alert('Message sent successfully!'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Message delivery failed.'); window.location.href = 'index.php';</script>";
    }
}
?>
