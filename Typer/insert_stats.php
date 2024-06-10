<?php

require_once '../conn.php';
session_start();
if(isset($_POST['submit']))
{
    $wpm = $_POST['wpm'];
    $acc = $_POST['acc'];

    if(isset($_SESSION['user_id']))
    {
        $UserID = $_SESSION['user_id'];
    }

    echo $acc;
    $acc = str_replace('%', '', $acc);
    $wpm_float = (float) $wpm;
    echo $acc;


    $sql = "INSERT INTO result (wpm, acc, user_id) VALUES ($wpm_float, $acc, $UserID)";
    $conn->query($sql);

    

}
header("Location: index.html");

?>