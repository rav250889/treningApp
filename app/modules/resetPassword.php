<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/functions/errors.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/functions/success.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Db.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/classes/PHPMailer/src/PHPMailer.php';
?>
<div>
    <form action="index.php?page=resetPassword" method="post">
        <h1>Wprowadź adres email na który ma wyślemy nowe hasło</h1>
        <div>
            <input type="email" name="email-to-send">
        </div>
        <div>
            <input name="send-email" type="submit" value="Wyślij nowe hasło">
        </div>
    </form>
    <?php
    
        if(isset($_POST['email-to-send']))
        {
            $email = filter_var($_POST['email-to-send'], FILTER_SANITIZE_STRING);
            
            if(!empty($email))
            {
                $check_email = new Db();
                $result = mysqli_query($check_email->connectDb(), "SELECT email FROM users WHERE login='".$_SESSION['login']."'");
                $row = mysqli_fetch_assoc($result);
                
                if($email == $row['email'])
                {
                    $tmp_pass = rand();
                    
                    if($_POST['send-email'])
                    {
                        $mail = new PHPMailer\PHPMailer\PHPMailer();
                        
                        $mail->PluginDir = $_SERVER."/app/classes/PHPMailer/src/";
                        $mail->Host = "ssl://hosting2287854.online.pro";
                        $mail->Port = 465;	

                        $mail->SMTPKeepAlive = true;  					
                        $mail->SMTPAuth = true;
                        $mail->Username = "admin@rafalwalach.pl";
                        $mail->Password = "Admin123!@";	

                        $mail->SetLanguage("pl", $_SERVER."/app/classes/PHPMailer/language/");				
                        $mail->CharSet = "UTF-8";	
                        $mail->ContentType = "text/html";					

                        $mail->From = "admin@rafalwalach.pl";	
                        $mail->FromName = "Admin";
                        $mail->Subject = "Nowe hasło";
                        $mail->Body = '<h1>Poniżej znajduje się Twoje nowe hasło. Po zalogowaniu zmień je natychmiast!</h1>'
                                      . '<p>'.$tmp_pass.'</p>';

                        $mail->AddAddress($email);

                        if($mail->Send())
                        {
                            mysqli_query($check_email->connectDb(), "UPDATE users SET password='".password_hash($tmp_pass, PASSWORD_ARGON2I)."' WHERE login='".$_SESSION['login']."'");
                        
                            success("Email został wysłany");
                            
                            header("Refresh: 2, url=index.php?page=settings");
                        }
                        $mail->SmtpClose();
                    }
                }
                else error ("Podany email nie istnieje w naszej bazie");
            }
            else error ("Wprowaź email");
        }
    ?>
</div>

