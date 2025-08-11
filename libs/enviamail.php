<?php
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class Enviamail {
        
        private $asunt; 
        private $cuerp;
        
        public function send($asunt, $cuerp) {

            $this->asunt = $asunt;
            $this->cuerp = $cuerp;
            $ruta = ROOT . 'libs' . DS;
            
            require_once $ruta . "Exception.php";
            require_once $ruta . "PHPMailer.php";
            require_once $ruta . "SMTP.php";

            $mail = new PHPMailer(true);
            
            $mail->SMTPSecure = 'tls';
            $mail->Username = "robgutgom@hotmail.com";
            $mail->Password = PSSEML;
            $mail->AddAddress("robgutgom@hotmail.com");
            $mail->FromName = "Robert Gutierrez";
            
            $mail->Host = "smtp.office365.com";
            $mail->Port = 587;
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->From = $mail->Username;

            $mail->isSMTP();
            
            $mail->Subject = mb_convert_encoding($this->asunt, 'UTF-8');
            $mail->Body = $this->cuerp;
            $copito = 'robguter114@gmail.com';
            $copito1 = 'lilimarzmedina@gmail.com';
            //$mail->AltBody = 'Su servidor de correo no soporta html';
            $mail->addAddress("claudehendrickx@gmail.com", "Claude");
            $mail->addAddress('jalberto071966@gmail.com', "Alberto");
            $mail->addAddress('robertgutierrez6@yahoo.com', "Robert");
            $mail->addCC($copito);
            $mail->addCC($copito1);
            $mail->isHTML(true);
            $mail->CharSet = "UTF-8";
            $resp = $mail->send();
            //echo "ENVIADO CORRECTAMENTE";
            return $resp;
        }
    }
?>