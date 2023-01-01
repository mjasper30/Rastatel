<?php
//ini_set('display_errors', 1);
require __DIR__.'/PHPMailer/src/Exception.php';
require __DIR__.'/PHPMailer/src/PHPMailer.php';
require __DIR__.'/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();

try {
// $mail->SMTPSecure='ssl';
 //Server settings
 //$mail->SMTPDebug = 2; // Enable verbose debug output
 $mail->isSMTP(); // Set mailer to use SMTP
 $mail->Host = 'mail.ucc-csd-bscs.com'; // Specify main and backup SMTP servers
 $mail->SMTPAuth = true; // Enable SMTP authentication
 $mail->Username = 'rastatel.hotel@ucc-csd-bscs.com'; // SMTP username
 $mail->Password = '?Di[+tVh19D,'; // SMTP password
 $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, [ICODE]ssl[/ICODE] also accepted
 $mail->Port = 465; // TCP port to connect to


 $mail->setFrom('rastatel.hotel@ucc-csd-bscs.com');
 $mail->addAddress($emailsave); // Add a recipient imagbanua112@gmail.com
 $mail->addReplyTo('');
 $mail->addCC('');
 $mail->addBCC('');


//Attachments
$mail->addAttachment('');//Add attachments


 $mail->isHTML(true); // Set email format to HTML
 $mail->Subject = 'Rastatel OTP';
 $mail->Body = "Good day! " . $name . " Your booking number is " . $booknum . "<br>" . "To confirm your booking please present this to the hotel to confirm your booking. Thank You";
 $mail->AltBody = 'OTP Testing';
 $mail->send();
 //echo 'Message has been sent <br>';
 $save_result = save_mail($mail);
 if ($save_result) {
     echo "Message saved!";
 }

} catch (Exception $e) {
 echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


//Function to call which uses the PHP imap_*() functions to save messages
function save_mail($mail) {
    //You can change 'Sent Mail' to any other folder or tag
    //Use imap_getmailboxes($imapStream, '/imap/ssl') to retrieve a list of available folders or tags
    $path = "{mail.ucc-csd-bscs.com:993/imap/ssl}INBOX.sent";
    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);
    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);
    return $result;
}

?>