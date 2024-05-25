<?php
session_start();
require_once '../conn.php';
if($_GET['user_id'])
{
    $UserID = $_GET['user_id'];
    try {
        $sql = "UPDATE nutzer SET verified = 1 WHERE int_id = $UserID";
        $result = $conn->query($sql);
        if($result)
        {
            header("Location: verification/success");
        }
        else{
            $_SESSION['fehler'] = "Die Verifizierung hat leider nicht geklappt!";
            header("Location: verification/failed");
        }    
    } catch (\Throwable $th) {
        $_SESSION['fehler'] = $th;
        header("Location: verification/failed");

    }
}
else{
    $_SESSION['fehler'] = "Die Verifizierung hat leider nicht geklappt!";
    header("Location: verification/failed");
}

