<?php
session_start();
if($page == 'login')
{
    if(isset($_SESSION['username']))
    {
        header('Location: dashboard.php');
    }
   
}
else
{
    if(!isset($_SESSION['username']))
    {
        header('Location: index.php');
    }
    else
    {
        $logged_in_user_name = $_SESSION['username'];
        $logged_in_user_role = $_SESSION['role'];
        $logged_in_user_group = $_SESSION['group'];
        $logged_in_user_image = $_SESSION['userimg'];
    }
}

?>