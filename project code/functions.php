<?php

function check_login($con) 
{
   if(isset($_SESSION['memberId'])&& isset($_SESSION['gender']))  
    {
        $id = $_SESSION['memberId'];     
        $query = "select * from members where memberId = '$id' limit 1";      

        $result = mysqli_query($con,$query);
        if($result && mysqli_num_rows($result)>0)             
        {
            $user_data = mysqli_fetch_assoc($result);      
            return $user_data;
        }
    }else if (isset($_SESSION['user_id']) && isset($_SESSION['gender']))
    {
        $id=$_SESSION['user_id'];
        $gender=$_SESSION['gender'];
        $guest_data=array("user_id"=>$id, "gender"=>$gender);
        return $guest_data;
        
    }
    else if (isset($_SESSION['adminId']))
    {
        $id=$_SESSION['adminId'];
        $admin_data=array("adminId"=>$id);
        return $admin_data;
    }

    header("Location:login.php");
    die;
    
}

function generateStyle()
{ 
    if(isset($_SESSION['adminId']))
    {
        echo "<html> <link rel='stylesheet' type='text/css' href='style.css'> <html>";
    }
    if($_SESSION['gender']==="women")
    {
         echo "<html> <link rel='stylesheet' type='text/css' href='wstyle.css'> </html>";
       
    }
    if($_SESSION['gender']==="men")
    {
         echo "<html> <link rel='stylesheet' type='text/css' href='mstyle.css'> <html>";
    }
}


function random_num($length)
{
    $text = "";
    if($length < 5)
    {
        $length = 5;
    }

    $len = rand(4,$length);

    for ($i=0; $i < $len; $i++) { 
       $text .= rand(0,9);
    }

    return $text;

}


?>