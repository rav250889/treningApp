<?php

    class EmailSender
    {
        public function send_email($email)
        {

            require __DIR__.'/PHPMailer/src/Exception.php';
            require __DIR__.'/PHPMailer/src/PHPMailer.php';
            require __DIR__.'/PHPMailer/src/SMTP.php';
            echo __DIR__.'/PHPMailer/src/PHPMailer.php';
            //$email = new PHPMailer();
        }
    }
?>

