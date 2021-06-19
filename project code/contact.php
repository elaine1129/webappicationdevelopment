<?php

session_start();
include("conndb.php");
include("functions.php");

$user_data = check_login($con);
generateStyle();
$errors = array();
$remove = "";
if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    if (!empty($_POST['address'])) {
        $address = $_POST['address'];
    } else {
        $address = "-Not provided-";
    }
    $phone = $_POST['phone'];
    $type = $_POST['enquiry'];
    $subject = $_POST['subject'];
    $status = "unread";

    if (empty($name)) {
        array_push($errors, "Name is required");
    } else {
        $pattern = "/^[a-zA-Z\s]+$/";
        if (!preg_match($pattern, $name)) {
            array_push($errors, "Name should contain only letters.");
        }
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    } else {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email entered is not a valid email address");
        }
    }
    if (empty($phone)) {
        array_push($errors, "Phone number is required");
    } else {
        $pattern = "/^(\+?6?01)[0-9]{7,9}$/";

        if (!preg_match($pattern, $phone)) {
            array_push($errors, "Please enter valid phone number. Example: 0123456789");
        }
    }

    if (count($errors) == 0) {
        $sql = "insert into enquiry( name, email, address,phone, type, subject, status)
                values ( '$name ','$email','$address','$phone','$type','$subject','$status')";
        mysqli_query($con, $sql);

        echo '<script>alert("Enquiry sent to admin.")</script>';
    }
}

?>

<html>

<head>
    <title>Contact Us</title>
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

        input[type=text],
        textarea,
        input[type=int] {
            width: 100%;
        }
    </style>
</head>
<style>

</style>
<header>
    <?php include 'header.php'; ?>
</header>
<style>
    #main .edit {
        position: fixed;
        left: 10px;
        bottom: 130px;
    }

    #main .edit img:hover {
        background: lightgreen;
        border-radius: 50px;
    }
</style>

<body>

    <div class="topnav">
        <?php include 'nav.php'; ?>

    </div>

    <div class="contain">

        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="index.php" alt="go to homepage">Home</a>
            <a href="shop.php" alt="go to shop">Shop</a>
            <a href="blog.php" alt="go to blog">Blog</a>
            <a href="faq.php" alt="go to faq">FAQ</a>
            <a href="aboutus.php" alt="go to about us">About Us</a>
            <a href="contact.php" alt="go to contact us">Contact Us</a>
        </div>

        <div id="main">

            <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>

            <div class="contact_form">
                <div class="top">
                    <h1> Contact us </h1>
                    <hr>
                </div>
                <div class="contactdetail">
                    <h3>Office number:</h3>
                    <p> 03-1089-3243</p><br><br>

                    <h3>Email:</h3>
                    <p>admin@sportify.com</p><br><br>

                    <h3>Our Address:</h3>
                    <p>1, Jalan Sungai Long, Bandar Sungai Long, 43000 Kajang, Selangor</p><br>

                </div>

                <h3 style="margin:50px auto 10px;font-size:30px;color:#4472C4;font-family: 'Segoe UI';"> Contact
                    administrator</h3>

                <div class="form1">
                    <form method="post">
                        <?php include('errors.php'); ?>
                        <div class="col-25">
                            <label for="name"><b>Name :</b></label>
                        </div>
                        <div class="col-75">
                            <input type="text" name="name" placeholder="Your name..." required>

                        </div>

                        <div class="col-25">
                            <label for="email"><b>Email :</b></label>
                        </div>

                        <div class="col-75">
                            <input type="text" name="email" placeholder="Email address..." requried>

                        </div>

                        <div class="col-25">

                            <label for="address"><b>Address :</b></label>
                        </div>
                        <div class="col-75">

                            <textarea rows="3" cols="40" name="address" placeholder="Address..."></textarea>
                        </div>

                        <div class="col-25">

                            <label for="phone"><b>Phone Number:</b></label>
                        </div>
                        <div class="col-75">

                            <input type="int" name="phone" placeholder="ex: 012-3456789" required>
                        </div>

                        <div class="col-25">

                            <label for="Enquirytype"><b>Type of Enquiry:</b></label>
                        </div>
                        <div class="col-75">
                            <label><input type="radio" name="enquiry" value="General Enquiry" required>General Enquiry</label>
                            <label><input type="radio" name="enquiry" value="Complaints" required>Complaints</label>
                            <label><input type="radio" name="enquiry" value="Suggestions" required>Suggestions</label>
                        </div>

                        <div class="col-25">
                            <label for="subject"><b>Subject :</b></label>
                        </div>
                        <div class="col-75">
                            <textarea rows="3" cols="40" name="subject" placeholder="Subject" required></textarea>
                        </div>


                        <button type="submit" name="submit">Submit</button>

                </div>
                <?php if (isset($_SESSION['adminId'])) { ?>
                    <a href="admin_contact.php" class="edit"><img src="img/mail.png" width="100px" height="100px"></a>
                <?php } ?>
            </div>
        </div>
    </div>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>
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
</body>


</html>