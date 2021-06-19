<?php 

session_start();   
include("conndb.php");
include("functions.php");
$errors = array(); 


/*errors put into array */
//check if login button is click
if(isset($_POST['login']))
{
    //add values into variables
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username)){array_push($errors,"Username is required");}
    if(empty($password)){array_push($errors,"Password is required");}



    if(count($errors)==0)
    {
        $password = md5($password);
       
        $query = "select * from members where username = '$username' limit 1";        
        $result = mysqli_query($con, $query);
 
        if(mysqli_num_rows($result)>0)
        {
            $user_data = mysqli_fetch_assoc($result);       
  
            if($user_data['password']===$password && $user_data['username']===$username)     
            {
                //add session
                $_SESSION['memberId']=$user_data['memberId'];
                $_SESSION['gender']=$user_data['gender'];
                        
                header("Location:index.php");
                die;
            } else
            {
                array_push($errors, "Wrong username/password combination");
            }                       
        }else
        {
            array_push($errors, "Username not found");
        }             
    }   
  }
  else if(isset($_POST['guest']))
  {
      $gender =$_POST['guest_gender'];
      $user_id = random_num(6);

      $guest_data=array("user_id"=>$user_id,"gender"=>$gender);
      if(!empty($guest_data))
       {

        $_SESSION['user_id']= $guest_data['user_id'];
        $_SESSION['gender']=$guest_data['gender'];
        
        header("Location:index.php");
        die;
        }
  }


?>
<html>

<head>
    <title>Login page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="signup_login.css" rel="stylesheet" type="text/css">


</head>
<header>
    <?php include 'header.php'; ?>
</header>

<body>
    <div class="login-background">
        <div class="container">

            <div class="col">
                <img src="img/login-pic.jpg" alt="login-pic" style="width:375px;height:400px;" />
            </div>
            <div class="col">
                <h1 style="text-align:center; margin:10px auto;">Login Account</h1>
                
                <form method="post">
                <?php include('errors.php'); ?>
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="submit"name="login" value="Login">
                </form>
                <div class="bottom-container">
                   <!-- <label> <input type="checkbox" name="remember">Remember me</label>-->
                    <br>
                    <span class="rgt">No account?<a href="signup.php"> Register now!!</a></span>
                    <br>
                    <div class="guest_box">
                    <form method="post">
                        <input type="submit" id="guest" name="guest" value="Continue as guest">
                        <div class="guest_gender">
                            <label for="guest_gender"><input type="radio" name="guest_gender" value="men" required>Men </label>
                             <label for="guest_gender"><input type="radio" name="guest_gender" value="women" required>Women </label>
                         </div>
                     </form>
                    </div>
                    <div class="admin_box">
                    <form method="post" action="admin_login.php">
                        <input type="submit" id="admin" name="admin" value="Continue as admin">
                    </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
</body>
<footer>
        <?php include 'footer.php'; ?>
</footer>
</html>