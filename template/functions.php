<?php


require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function createfile(string $filepath, string $filename, string $phpcode){

    if (!is_dir($filepath)) {

        if (mkdir($filepath, 0755, true)) {
        }
    }

    $filename = $filepath.'/'.$filename;

    if (file_put_contents($filename, $phpcode)) 
    {

    } 
    else {


    }

}






/**
 *  @param string $email Die E-Mail Adresse des Empängers
*   @param string $name Der Name des Empfängers
*   @param string $mail_text Der Inhalt der Email
*   @param bool $important Wichtig? Dann geht die E-Mail auch an alle Teammitglieder
*   @param string $title_sender Name der Herkunft des E-Mails
*   @param string $subject Betreff der Mail
*/
function sendmailtouser(string $email, string $name, string $mail_text, bool $important, string $title_sender, string $subject)
    {

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        $mail->isSMTP();
        $mail->SMTPAuth = true;
        
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        $mail->Username = "typusahwii@gmail.com";
        $mail->Password = 'cnzm qlhv zzoa chno';     
        $mail->CharSet = "UTF-8";
        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        if(isset($title_sender))
        {
            $mail->setFrom('typusahwii@gmail.com', $title_sender);
        }
        else{
            $mail->setFrom('typusahwii@gmail.comm', "Typus");
        }
        $mail->addAddress($email, $name);     
        $mail->addReplyTo('typusahwii@gmail.com', 'Typus');
        
        if(isset($important))
        {
            if($important == 1)
            {        
                $mail->addBCC('SOU22464@spengergasse.at');
            }
        }

        //Content
        $mail->isHTML(true);//Set email format to HTML
        
        if(isset($subject))
        {
            $mail->Subject = $subject;
        }
        else{
            $mail->Subject = "Neue Informationen von Railwayfans";
        }


        $mail->Body    = '
        <style>
            p, h1, h2 , h3, h4, h5{
                font-family: monospace;
            }
            p{
                margin-top: 7px;
            }
        @media screen and (max-width: 520px) {
            #logo_header {
                max-width: 60%; 
            }
        }

        @media screen and (min-width: 420px) {
            #activate_button{
                width: 400px;
                font-size: large;

            }
        }
        @media screen and (max-width: 420px) {
            #activate_button{
                width: 250px;
                font-size: medium;
            }
        }


        </style>
        <div style="background-color: rgb(58, 203, 203); height: 170px;" >
            <img src="https://railwayfans.b-cdn.net/typus/logo.jpg" style="float: right; margin-right: 10%; height: 170px"  alt="Railwayfans Logo">
        </div>
        <div id="content" style=" max-width: 1000px; width: 100vw; background-color: rgb(250, 250, 250); min-height: 300px; margin: auto;">
            <div id="content_text" style="padding: 20px; max-width: 1000px; ">
                <h1 style="font-size: 41px;">Servus '.$name.'!</h1>

                <p style="font-size: 18px;">'.$mail_text.'
                    <p style="font-size: 18px;">F&uuml;r Fragen stehen wir jederzeit zur Verf&uuml;gung! </br>Antworte uns hier einfach auf diese Mail :)</p> 
                    <p style="font-size: 18px;">
                    Liebe Gr&uuml;&szlig;e w&uuml;nscht dir:</br>
                    Dein Typus Team
                    </p>
                    <p style="margin-top: 50px; font-size: 18px;">Eine Antwort auf diese Mail gelangt an: typusahwii@gmail.com
                        <br>Every answer of this mail will be send to: typusahwii@gmail.com
                    </p>


                    

                </p>


            </div>
            <div style="background-color: #333741; height: 50px; margin-top: 50px; color: white;">
                <div id="content_text_small" style="font-size: smaller; padding: 10px;">
                    <p style="float: left;">
                    &copy; Typus by Typus Group / HTL Spengergasse
                    </p>


                    <p style="float: right; ">
                        <a href="" style="color: white;">Impressum</a>
                    </p>
                    <p style="float: right; margin-right: 10px;">
                        <a href="" style="color: white;">Datenschutzerklärung</a>
                    </p>
                    <p style="float: right; margin-right: 10px;">
                        <a href="" style="color: white;">Nutzungsbedingungen</a>
                    </p>
                </div>
                

            </div>

            
        </div>


        ';
        $mail->AltBody = 'Please press follwing link to activate your account: ';

        $mail->send();
        echo 'Message has been sent';
        } 
    catch (Exception $e) {
        $_SESSION['fehler'] = 'Ein unbekannter Fehler beim Senden der Willkommensnachricht ist aufgetreten. Bitte überprüfe deine angegebene Email erneut
        oder kontaktiere uns mittels dem <a href="../imprint">Kontaktformular.</a>';
        header("Location: failed.php");
        exit();
    }
}


?>