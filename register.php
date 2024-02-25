<?php
require_once 'conn.php';
session_start();

if (isset($_POST['submit']))
{
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $password_hashed = hash('sha256',$password); //Passwort mit mit der SHA-256 Methode verschlüsselt.

    $sql = "SELECT * FROM nutzer WHERE Email = '$email'";
    $result = $conn->query($sql);
    if($result->num_rows > 0)
    {
        $fehler = "E-Mail Adresse existiert bereits in unserer Datenbank. Bitte verwende eine andere E-Mail Adresse";
        $_SESSION['fehler'] = $fehler;

        header("Location: register/failed"); //Weiterleitung zur Startseite

        exit();
    }

    $sql = "SELECT * FROM nutzer WHERE UserName = '$username'"; //Überprüfen, ob es schon Nutzer 
    $result = $conn->query($sql);
    if($result->num_rows > 0)
    {
        $fehler = "Nutzname existiert bereits in unserer Datenbank. Bitte verwende einen anderen.";
        $_SESSION['fehler'] = $fehler;
        header("Location: register/failed"); //Weiterleitung zur Startseite
        exit();
    } 

    $sql = "INSERT INTO nutzer (UserName, EMail, verified, password, country_id) VALUES ('$username','$email',0,'$password_hashed',1)"; //Einfügen des neuen Nutzers in die DB
    $result = $conn->query($sql);
    $UserID = $conn->$inserted_id;

    /*if($result)
    {
        
        $mail = new PHPMailer(true);
        $name = str_replace(' ', '_', $name); 


        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;

            $mail->isSMTP();
            $mail->SMTPAuth = true;
            
            $mail->Host = "smtp.easyname.com";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            
            $mail->Username = "232847mail2";
            $mail->Password = 'confirm';                                  
            //Recipients
            $mail->setFrom('confirmation@typrus.at', 'Confirmation');
            $mail->addAddress($email, $name);     
            $mail->addReplyTo('info@typrus.at', 'Information');
            $mail->addBCC('felix0404@typrus.at');

            //Content
            $mail->isHTML(true);                                
            $mail->Subject = 'Confirmation Email for '.$name;
            $mail->Body    = ';
            $mail->AltBody = 'Please press follwing link to activate your account: ';

            $mail->send();
            echo 'Message has been sent';

        }
    }*/   

    $phpCode =
    '$UserID = ';

    header("Location: register/success"); //Weiterleitung zur Startseite
    exit(); 
}

?>