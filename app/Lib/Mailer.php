<?php
namespace App\Lib;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use App\Config;

/**
 *
 */
class Mailer extends PHPMailer
{
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);

        //Server settings
        $this->mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output
        $this->mail->isSMTP();                                            // Send using SMTP
        $this->mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $this->mail->Username   = Config::ADDRESS_FROM;                     // SMTP username
        $this->mail->Password   = Config::ADDRESS_PASS;                               // SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $this->mail->Port       = 587;                                    // TCP port to connect to
        $this->mail->isHTML(true);

        //Recipients
        $this->mail->setFrom(Config::ADDRESS_FROM, 'GFL.TEST');
    }

    public function sendEmailAdmin($arrayData = array())
    {
        $this->sendTo(Config::ADDRESS_ADMIN)
            ->mailContent($arrayData);
        return $this->mail->send();
    }

    public function sendTo($address, $name = '')
    {
        $this->mail->addAddress($address, $name);     // Add a recipient
        return $this;
    }

    public function mailContent($arrayData)
    {
        if(!empty($arrayData))
        {
            $this->mail->Subject = $arrayData['subject'];
            $this->mail->Body = $arrayData['body'];
            $this->mail->AltBody = $arrayData['altBody'];

            return $this;
        }
        // Content DEFAULT
                                        // Set email format to HTML
        $this->mail->Subject = 'Тест';
        $this->mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        return $this;
    }
}