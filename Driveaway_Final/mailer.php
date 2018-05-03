<?php
function sendmail($email,$titulo,$mensagem){

require 'PHPMailer/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    $mail->isSMTP();                            // defenir o mailer para SMTP
    $mail->Host = 'smtp.gmail.com';             // especificar o host
    $mail->SMTPAuth = true;                     // premitir autenticacao smtp
    $mail->Username = 'driveawaypsi@gmail.com'; // username do SMTP
    $mail->Password = 'driveawayPSI99';         // password do SMTP
    $mail->SMTPSecure = 'tls';                  // activar encryptacao TLS
    $mail->Port = 587;                          // defenir a porta de conexao

    $mail->setFrom('driveawaypsi@gmail.com', 'DriveAway');
    $mail->addReplyTo('driveawaypsi@gmail.com', 'DriveAway');
    foreach ($email as $m) {
        $mail->addAddress($m);
    }
    //$mail->addAddress($email);   // email da pessoa que recebe

    $mail->isHTML(true);  // permitir emails do tipo HTML

    
    // contiudo do email
    $bodyContent = $mensagem;
   


    $mail->Subject = $titulo; // o titulo do email
    $mail->Body    = $bodyContent;
    
    /*
    echo "<p>".$email."</p>";
    echo "<p>".$nome."</p>";
    echo "<p>".$titulo."</p>";
    echo "<p>".$mensagem."</p>";
    */

       
    if(!$mail->send()) {
        echo 'Mensagem não enviada';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        echo "<br> ".$email." - ";
    } else {
        echo 'Mensagem enviada';
    }
    

}
    //sendmail("dmos999@gmail.com","diogo","test","mensagem");
 //sendmail('dmos@ua.pt','danielmaricas',"Bem vindo ao Drive Away","coisas");
?>