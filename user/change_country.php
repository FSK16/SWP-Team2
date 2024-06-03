<?php
session_start();
require_once '../conn.php';
if(isset($_POST['submit']))
{
    if(isset($_SESSION['user_id']))
    {
        $UserID = $_SESSION['user_id'];
        $country = $_POST['country'];
        $sql = "UPDATE nutzer SET country_id = $country WHERE int_id = $UserID";
        $result = $conn->query($sql);
        if($result)
        {
            $sql2 ="SELECT UserName FROM nutzer WHERE int_id = $UserID";
            $result2 = $conn->query($sql2);
            if($result2->num_rows > 0)
            {
                while($row2 = $result2->fetch_assoc())
                {
                    $UserName = $row2['UserName'];
                }
            }
            header("Location: $UserID/$UserName");
            exit();
        }
    }
    
}

?>