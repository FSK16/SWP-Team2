<?php
require_once 'conn.php';
include 'template/functions.php';
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

    $stmt = $conn->prepare("INSERT INTO nutzer (UserName, EMail, verified, password, country_id) VALUES (?, ?, 0, ?, 1)");
    $stmt->bind_param("sss", $username, $email, $password_hashed);
    $stmt->execute();
    $UserID = $stmt->insert_id;
    $stmt->close();

    $mail = 'Willkommen bei Typus! Es freut uns, dass du dich gerade bei uns registriert hast. Bitte verifiziere dich nun mit einem Klick auf diesem Knopf:
        </p>
        <div style="margin: auto; width: 200px;"> 
            <a href="http://localhost/typrus/user/verification.php?user_id='.$UserID.'"><button style="margin: auto; cursor: pointer; width: 200px; margin-bottom: 5px; height: 50px; background-color: rgb(58, 203, 203); border: none;"><p style="font-size: 18px; margin-bottom: 8px; font-weight: bold;" >Verifizieren</p></button></a>
        </div>';

    sendmailtouser($email, $username, $mail, 0, 'Typus Verifizierung', 'Dein Verifizierungsmail');

    $phpCode =
    '<?php
    $UserID = '.$UserID.';
    require_once \'../../template/user_page.php\';
    ?>
    ';

    $filepath = 'user/'.$UserID.'/'.$username;
    $filename = 'index.php';

    createfile($filepath, $filename, $phpCode);


    echo '<script type="text/javascript">
    window.location.href = "register/success";
    </script>';
    exit(); 
}
else{
    echo 'geht nicht';
}

?>