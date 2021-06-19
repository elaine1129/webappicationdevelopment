<?php

session_start();


if(isset($_SESSION['memberId']) && isset($_SESSION['gender'])|| isset($_SESSION['user_id'])|| isset($_SESSION['adminId']))
{
    unset($_SESSION['memberId']);
    unset($_SESSION['user_id']); 
    unset($_SESSION['gender']); 
    unset($_SESSION['adminId']);
    session_destroy();
    header("Location:login.php");
}else
{
    echo "something wrong";
}
