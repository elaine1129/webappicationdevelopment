<?php

session_start();
include("conndb.php");
include("functions.php");

$user_data = check_login($con);
generateStyle();
?>

<html>

<head>
    <title>About us</title>
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

        .contain {
            display: block;
        }
    </style>

    <header>
        <?php include 'header.php'; ?>
    </header>

</head>

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

            <div class="aboutus">
                <div class=top>
                    <h1>About us</h1>
                    <hr>
                </div>

                <div class="ourstory">
                    <h4>Our Story</h4>
                    <p>
                        Sportify established in the year 1993 by Chris Hemsworth.
                        <br><br>
                        Sportify’s strategy is to invest in our people and our key third party brand partners
                        in order to elevate our retail proposition to attain new levels of excellence across
                        our multi-brand, multi-channel offering to customers.
                        <br><br>
                        We aspire to be a leading sportshoes retailer internationally and to deliver
                        sustainable growth for our shareholders in the medium to long term by offering
                        our customers an unrivalled range of high quality leading brands.
                        <br><br>
                        By 2011, Sportify has dominated most of the Asia countries,
                        primarily in Japan, Korea, Singapore, China and Malaysia, with Indonesia and Thailand to follow
                        suit.
                        <br><br>
                        At this moment in time, Sportify was already regarded as the most innovative visual merchandiser
                        of sportshoes with the best and most exclusive stylish range.
                    </p>
                </div>

                <div class="mission">
                    <h4>Missions </h4>
                    <ul>
                        <li>To give people the opportunity to express themselves through sportshoes</li><br>
                        <li>To bring profound comfort, fun and innovation to the world's feet</li><br>
                        <li>To make all athletes better through passion, design and the relentless pursuit of innovation
                        </li>
                    </ul>
                </div>

                <div class="whyus">
                    <h4>Why SportsShoes?</h4>
                    <p>
                        <strong>Run, Gym, Hike... </strong>It doesn’t matter whether you’re an elite runner, weekend fell walker or gym
                        enthusiast, that commitment and passion to be active is what drives us both.<br><br>
                        With over 13,000 products, including running shoes, running clothing and outdoor gear, you’ll
                        struggle to find a better selection. We are very proud to bring you the very latest products and
                        technologies from the top sports and fitness brands, including <strong>Adidas, Nike, Puma </strong>and many
                        more.<br><br>
                        At Sportify, we are always trying to get better, pushing ourselves to keep you up to
                        speed. <strong>Why? Because it’s no fun standing still.</strong>
                    </p>
                </div>

                <div class="contact">
                    <p>Have any issue?
                        <a href=contact.php target=_self title="Contact our teams">Contact Us</a>
                        : )
                    </p>
                </div>

                <footer>
                    <?php include 'footer.php'; ?>
                </footer>

            </div>
        </div>
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