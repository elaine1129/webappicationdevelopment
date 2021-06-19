<?php 


    session_start();   
    include("conndb.php");
    include("functions.php");
    $errors =array();
    $pattern="";
    
    
    if($_SERVER['REQUEST_METHOD']=="POST")
    {
       //add value into variable
       $member_id = "mb" . random_num(7);
       $username = $_POST['username'];
       $password = $_POST['password'];   
       $first_name =$_POST['first_name'];
       $last_name =$_POST['last_name'];
       $email =$_POST['email'];
       $phone_number =$_POST['phone_number'];
       $address =$_POST['address'];
       $gender =$_POST['gender'];

        if (empty($username)) 
        { 
           array_push($errors, "Username is required"); 
        }
        else
        {
            $pattern ="/^[a-zA-Z0-9_-]+$/";
            if (!preg_match($pattern,$username)) 
            {
                array_push($errors, "Username only allow letters, numbers, underscore(_) and hyphen (-)");  
            }
        }
        
       
        if (empty($password)) 
        { 
            array_push($errors, "Password is required"); 
        }
       else{
            $pattern = "/^[\w!@#$%^&*();:.,]+$/";
            if(!preg_match($pattern,$password) || strlen($password) < 6) 
            {
                array_push($errors, "Password should be at least 6 characters. And only contains letters, numbers or !@#$%^&*();:., ");
            }
        }
        if (empty($first_name)) 
        { 
           array_push($errors, "First name is required"); 
        }
        else{
            $pattern = "/^[a-zA-Z\s]+$/";
            if(!preg_match($pattern,$first_name)) 
            {
                array_push($errors, "First name should contain only letters.");
            }
        }

        if (empty($last_name)) 
        { 
           array_push($errors, "Last name is required"); 
        }
        else{
            $pattern = "/^[a-zA-Z\s]+$/";
            if(!preg_match($pattern,$last_name)) 
            {
                array_push($errors, "Last name should contain only letters.");
            }
        }
        if (empty($email)) 
        { 
            array_push($errors, "Email is required"); 
        }
        else{
           
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {
                array_push($errors, "Email entered is not a valid email address");
            }
        }
        if (empty($phone_number)) 
        { 
            array_push($errors, "Phone number is required"); 
        }
        else{
            $pattern = "/^(\+?6?01)[0-9]{7,9}$/";       //+ and 6 is optional
            
            if(!preg_match($pattern,$phone_number)) 
            {
                array_push($errors, "Please enter valid phone number. Example: 0123456789");
            }
        }
        
        if (empty($address)) { array_push($errors, "Address is required"); }
        if (empty($gender)) { array_push($errors, "Gender is required"); }
        
   
            $sql = "SELECT * FROM members where username='$username' or memberId='$member_id'";
            $result = mysqli_query($con,$sql);
            $user_data = mysqli_fetch_assoc($result);

            if($user_data)
            {
                if($user_data['username']=== $username)
                {
                    array_push($errors,"Username already exists");
                }
                if($user_data['memberId']=== $member_id)
                {
                    $member_id = "mb" . random_num(7);
                }
            }

            if(count($errors)==0)
            {
                $password = md5($password);   //encrypt the password before saving in db

                $query = "insert into members( memberId,username, password, first_name, last_name, email, phone_number, address, gender)
                values ( '$member_id ','$username','$password','$first_name','$last_name','$email','$phone_number','$address','$gender')";

                mysqli_query($con,$query);
                header('location:login.php');
            }

    }


?>



<!DOCTYPE html>
<html>
<head>
    <title>
        Sign Up
    </title>
    <style>
        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;

            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 10px;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }
    </style>
</head>

<link href="signup_login.css" rel="stylesheet" type="text/css">

<header>
   <?php include 'header.php'; ?>
</header>

<body>
<div class="contain">
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="index.php" alt="go to homepage">Home</a>
        <a href="shop.php" alt="go to shop">Shop</a>
        <a href="faq.php" alt="go to faq">FAQ</a>
        <a href="aboutus.php" alt="go to about us">About Us</a>
        <a href="contact.php" alt="go to contact us">Contact Us</a>
    </div>
    <div id="main">
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>
    </div>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }
    </script>

</div>

   <h2 style="color:black; text-align:center;margin-top:50px;">Sign up to get a account!</h2>
    <div class="signupform">
        <form method="POST" action="">
        <?php include('errors.php'); ?>
            <div class="label">
                <label for="username"> Username*: </label>
            </div>
            <div class="input">
                <input type="text" placeholder="Enter username" name="username" required>
            </div>
            
            <div class="label">
                <label for="password">Password*:</label>
            </div>
            <div class="input">
                <input type="password" placeholder="Minimum 6 characters" name="password" required>
            </div>

            <div class="label">
                <label for="FullName"> Full Name: </label>
            </div>
            <div class="input">
                <input type="text" placeholder="First name" name="first_name" required>
            </div>

            <div class="label"><label></label></div>
            <div class="input">
                <input type="text" placeholder="Last name" name="last_name" required>
            </div>

            <div class="label">
                <label for="email"> Email: </label>
            </div>
            <div class="input">
                <input type="email" placeholder="Enter your email" name="email" required>
            </div>

            <div class="label">
                <label for="phone_number"> Phone Number: </label>
            </div>
            <div class="input">
                <input type="text" placeholder="Ex: 0123456677" name="phone_number" required>
            </div>

            <div class="label">
                <label for="address">Address: </label>
            </div>
                <textarea id="address" name="address" placeholder="Enter address" 
                    style="height:50px;width:200px;"></textarea>

            <div class="label">
                <label for="gender"> Gender: </label>
            </div>
            <div class="labelgender">
                <label for="gender"><input type="radio" name="gender" required value="men">Men  </label>
                <label for="gender"><input type="radio" name="gender" required value="women">Women </label>
            </div>

            <div class="signup">
                <input type="submit"name="register" value="Register">
            </div>

            <p style="font-size:15px;">By signing up, you agree to our <b>Policy</b>.</p><br>
            <p>Have an account?<a href="login.php"> Log in</a></p>
        </form>
    </div>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>



</body>

</html>