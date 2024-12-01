<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load config file
require './config.php';

//Load composer's autoloader
require './vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    // $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = $mailConfig['host'];                   // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $mailConfig['user'];                 // SMTP username
    $mail->Password = $mailConfig['password'];                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = $mailConfig['port'];                           // SMTP password
    $mail->CharSet = 'utf-8';

    //Recipients
    $emailFrom = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $nameFrom = filter_input(INPUT_POST, 'name');

    $mail->setFrom($emailFrom, $nameFrom);
    $mail->addAddress($mailConfig['recipient'][0], $mailConfig['recipient'][1]);     // Add a recipient
    //$mail->addAddress('contact@example.com');               // Name is optional
    $mail->addReplyTo($emailFrom, $nameFrom);
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Wiadomość ze strony cafe44.pl';
    $mail->Body = filter_input(INPUT_POST, 'message');
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}

header('Location: index.html');
