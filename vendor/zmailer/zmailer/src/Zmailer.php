<?php 

namespace Zmailer;
use PHPMailer\PHPMailer\PHPMailer;
use Framework\LogEngine;
use PHPMailer\PHPMailer\Exception;

class Zmailer extends LogEngine{

    protected $_mailer;

    public function __construct() 
    {

        parent::__construct();

        try {
            $this->_mailer = new PHPMailer(true); // Enable exceptions

        
            $this->_mailer->SMTPDebug = 0;
            $this->_mailer->isSMTP();
            $this->_mailer->Host = 'smtp.gmail.com';
            $this->_mailer->SMTPAuth = true;
            $this->_mailer->Username = '';
            $this->_mailer->Password = "";
            $this->_mailer->SMTPSecure = 'tls';
            $this->_mailer->Port = 587;

        } catch (Exception $e) {

            $this->logMessage('MAIL ERROR: ' . $e->getMessage());

        }


    }


    public function sendMail($from, $to, $subject, $message, $attachment = null) {

        $this->_mailer->setFrom($from, 'Mailer');
        
        foreach ($to as $recipient) {

            $this->_mailer->addAddress($recipient);
            
        }

        if ($attachment !== null) $this->_mailer->addAttachment((string)$attachment);

        $this->_mailer->isHTML = true;
        $this->_mailer->Subject = $subject;
        $this->_mailer->Body = $message;


        try {

            $this->_mailer->send();
            foreach ($to as $dest) $this->logMessage('Email sent to ' . $dest);

        } catch (Exception $e) {

            $this->logMessage('Email sending error: ' . $this->_mailer->ErrorInfo);

        }

        
    }

}