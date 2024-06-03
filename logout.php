<?php
if(isset($_SESSION['user_id']))
{
    $_SESSION['user_id'] = null;
}
header("Location: index.php");
exit();
?>
