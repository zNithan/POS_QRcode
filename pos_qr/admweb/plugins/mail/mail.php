<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output
$mail->SMTPDebug = 3;
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'imit_smtp@isuzu01.onmicrosoft.com';                 // SMTP username
$mail->Password = 'MUh5NjVZj3J5';                           // SMTP password
$mail->SMTPSecure = 'TLS';                            // STARTTLS Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('imit_smtp@isuzu01.onmicrosoft.com', 'Admin KD');
$mail->addAddress('siwakorn@aosoft.co.th', 'Aosoft');     // Add a recipient
$mail->addAddress('info@aosoft.co.th');               // Name is optional
$mail->addReplyTo('imit_smtp@isuzu01.onmicrosoft.com', 'Admin KD');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

phpinfo();