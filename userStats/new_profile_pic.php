<?php
require_once '../conn.php';
if(isset($_SESSION['user_id']))
{
    $UserID = $_SESSION['user_id'];
}
else{
    $UserID = 20;
}
print_r($_POST);

if(isset($_POST['submit']))
{
    
    $img_name = $_FILES['my_image']['name'];

    $img_size = $_FILES['my_image']['size'];
    if($img_size == 0)
    {
        $sql = "UPDATE nutzer SET profile_pic = NULL WHERE int_id = $UserID";
        $result = $conn->query($sql);
        if($result)
        {
            header("Location: index.php");
            exit();
        }
    }

    $tmp_name = $_FILES['my_image']['tmp_name'];


    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_ex_lc = strtolower($img_ex);

    $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;

    $img_upload_path = '../user/profile_pictures/'.$new_img_name;
    move_uploaded_file($tmp_name,$img_upload_path);



    $sql = "UPDATE nutzer SET profile_pic = '$new_img_name' WHERE int_id = $UserID";
    $result = $conn->query($sql);
    if($result)
    {
        header("Location: index.php");
        exit();
    }
    
    
}
else if (isset($_POST['delete'])){
    $sql = "UPDATE nutzer SET profile_pic = NULL WHERE int_id = $UserID";
    $result = $conn->query($sql);
    if($result)
    {
        header("Location: index.php");
        exit();
    }
}
else{
    echo ' geht nicht';

}
