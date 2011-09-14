<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function send_email($recipient, $sender, $subject, $message)
{
    require_once("phpmailer/class.phpmailer.php");

    $mail = new PHPMailer();
    $body = $message;
    $mail->IsSMTP();
    $mail->FromName = "Bargain Philippines";
    $mail->From = $sender;
    $mail->Subject = $subject;
    $mail->AltBody = strip_tags($message);
    $mail->MsgHTML($body);
    $mail->AddAddress($recipient);
    if ( ! $mail->Send())
    {
        echo 'Failed to Send';
    }
    else
    {
        echo 'Mail Sent';
    }
}
?> 