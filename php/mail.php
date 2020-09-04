<?php
require "PHPMailer/PHPMailerAutoload.php";
function smtpmailer($to, $from, $from_name, $subject, $body)
    {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true; 
 
        $mail->SMTPSecure = 'ssl'; 
        $mail->Host = 'mail.olivemed.co.ke';
        $mail->Port = 465;  
        $mail->Username = 'request@olivemed.co.ke';
        $mail->Password = '0liveMed!';   
   
        $mail->IsHTML(true);
        $mail->From=$from;
        $mail->FromName=$from_name;
        $mail->Sender=$from;
        $mail->AddReplyTo($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
        $res = $mail->send();
        if(!$res)
        {
            return false; 
        }
        else 
        {
            return true;
        }
    }
    
?>
