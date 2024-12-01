<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load config file
require './config.php';

//Load composer's autoloader
require './vendor/autoload.php';

$mail = new PHPMailer(true); // Passing `true` enables exceptions

try {
    //Server settings
    $mail->SMTPDebug = $mailConfig['debug']; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = $mailConfig['host']; // Specify main and backup SMTP servers
    $mail->SMTPAuth = $mailConfig['smtp_auth']; // Enable SMTP authentication
    $mail->Username = $mailConfig['user']; // SMTP username
    $mail->Password = $mailConfig['password']; // SMTP password
    $mail->SMTPSecure = $mailConfig['smtp_secure']; // SMTP password
    $mail->Port = $mailConfig['port']; // SMTP password
    $mail->CharSet = 'utf-8';

    //Recipients
    $emailFrom = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $nameFrom = filter_input(INPUT_POST, 'name');

    $mail->setFrom($emailFrom, $nameFrom);
    $mail->addAddress($mailConfig['recipient'][0], $mailConfig['recipient'][1]); // Add a recipient
    $mail->addReplyTo($emailFrom, $nameFrom);

    //Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Wiadomość ze strony cafe44.pl';
    $mail->Body = "<div style='border: 1px solid black; padding: 20px;'><h2>Formularz Kontaktowy</h2>
                    <p><strong>Imię:</strong> {$nameFrom}</p>
                    <p><strong>Email:</strong> {$emailFrom}</p>
                    <p><strong>Wiadomość:</strong> " . filter_input(INPUT_POST, 'message') . "</p></div>";
    $mail->AltBody = "Imię: {$nameFrom}\nEmail: {$emailFrom}\nWiadomość: " . filter_input(INPUT_POST, 'message');

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}

header('Location: index.html');
