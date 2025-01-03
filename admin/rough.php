<?php
require 'db.php';  // Database connection
require '../vendor/autoload.php'; // Include Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect the form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $otherName = $_POST['otherName'] ?? null;
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $placeOfBirth = $_POST['placeOfBirth'];
    $religion = $_POST['region'];
    $lga = $_POST['lga'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $referral = $_POST['referral'];

    // Insert into the database
    $sql = "INSERT INTO users (first_name, last_name, other_name, dob, email, phone, address, place_of_birth, religion, lga, state_of_origin, country_of_origin, referral) 
            VALUES (:first_name, :last_name, :other_name, :dob, :email, :phone, :address, :place_of_birth, :religion, :lga, :state_of_origin, :country_of_origin, :referral)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':first_name' => $firstName,
        ':last_name' => $lastName,
        ':other_name' => $otherName,
        ':dob' => $dob,
        ':email' => $email,
        ':phone' => $phone,
        ':address' => $address,
        ':place_of_birth' => $placeOfBirth,
        ':religion' => $religion,
        ':lga' => $lga,
        ':state_of_origin' => $state,
        ':country_of_origin' => $country,
        ':referral' => $referral
    ]);

    // Send a confirmation email using PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';  // Use your SMTP server, e.g., 'smtp.gmail.com'
        $mail->SMTPAuth = true;
        $mail->Username = 'your_username';  // Replace with your SMTP username
        $mail->Password = 'your_password';  // Replace with your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;  // SMTP port

        // Recipients
        $mail->setFrom(' debysfoundation@gmail.com', 'debysfoundation.org');  // Set the sender email
        $mail->addAddress($email);  // Recipient's email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Registration Confirmation';
        $mail->Body    = '<h1>Welcome ' . $firstName . ' ' . $lastName . '</h1><p>Thank you for registering on our website!</p>';

        $mail->send();
        echo "User registered and email sent successfully!";
    } catch (Exception $e) {
        echo "User registered, but email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

} else {
    echo "Invalid request method.";
}
?>
; For Win32 only.
; https://php.net/smtp
SMTP=localhost
; https://php.net/smtp-port
smtp_port=25

; For Win32 only.
; https://php.net/sendmail-from
;sendmail_from = me@example.com