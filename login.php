<?php
require_once 'conn.php';

if (isset($_POST['submit']))
{
    $name = $_POST['name'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM nutzer WHERE UserName = '$name'";
    $result = $conn->query($sql);

    if($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
            $user_id = $row['int_id'];
            $username = $row['name'];
            $userpassword = $row['password'];

            if(password_verify($password, $userpassword))
            {
                session_start();
                $_SESSION['user_id'] = $user_id;
                header("Location: success.php");
            }
            else{
                $_SESSION['fehler'] = "Falsches Passwort";
                header("Location: failed.php");
            }
        }
    }
    else{
        $_SESSION['fehler'] = "Falsches Passwort";
        header("Location: failed.php"); 
    }
}