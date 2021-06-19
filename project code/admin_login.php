<?php

session_start();   
include("conndb.php");
include("functions.php");
$errors=array();

if(isset($_POST['a-login']))
{

    $adminId = $_POST['L-adminId'];
    $password = $_POST['L-password'];

    if(empty($adminId)){array_push($errors,"AdminId is required");}
    if(empty($password)){array_push($errors,"Password is required");}

    if(count($errors)==0)
    {  
        $query = "select * from admin where adminId = '$adminId' limit 1";        
        $result = mysqli_query($con, $query);

        if($result && mysqli_num_rows($result)>0)
        {
            $user_data = mysqli_fetch_assoc($result);       
                
            if($user_data)
            {
                if($user_data['password']===$password && $user_data['adminId']===$adminId)     
                {
                   
                    $_SESSION['adminId']=$user_data['adminId'];
                    $_SESSION['gender']=null;
                        
                    header("Location:index.php");
                    die;
                }else {
                        array_push($errors, "Wrong username/password combination");
                }  
            }
        }else
        {
            array_push($errors, "Admin Id not found");
        }               
    } 
}

?>


<html>

<head>
    <title>Admin Login</title>
    <link href="signup_login.css" rel="stylesheet" type="text/css">
</head>

<header>
    <?php include 'header.php'; ?>
</header>
<body>
   
    <div class="admin">
        <div class="admin_login">
            <h2>Login as Admin</h2>
            <form method="post">
            <?php include('errors.php'); ?>
                <div class="label">
                    <label for="L-adminId"> Admin Id: </label>
                </div>
                <div class="input">
                    <input type="text" placeholder="Enter admin id" name="L-adminId" required>
                </div>
                <div class="label">
                    <label for="L-password"> Password: </label>
                </div>
                <div class="input">
                    <input type="password" placeholder="Enter password" name="L-password" required>
                </div>

                <div class="a-login">
                    <input type="submit" name="a-login" value="Login">
                </div>
            </form>
        </div>
        

        <div class="back">
            <p>Back to <a href="login.php">member's login</a> page </span>
        </div>

       
</div>
</body>

<footer>
    <?php include 'footer.php'; ?>
</footer>

</html>