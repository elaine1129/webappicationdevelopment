<?php

session_start();
include("conndb.php");
include("functions.php");

$user_data = check_login($con);
generateStyle();
?>

<html>

<head>
    <title>FAQ Page</title>
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

            <div class=top>
                <h1>Frequent Asked Question</h1>
                <hr>
                <h2>How can we help?</h2>
            </div>

            <div class=category>
                <ul style>
                    <li><a href=#OrdernDelivery><strong>Order and Delivery</strong></a></li>
                    <li><a href=#ReturnnRefund><strong>Return and Refund</strong></a></li>
                    <li><a href=#ProductnStock><strong>Product and Stock</strong></a></li>
                    <li><a href=#Others><strong>Others</strong></a></li>
                </ul>
            </div>

            <div class="box">
                <a name=OrdernDelivery>
                    <div class="category2">
                        <h4>Order And Delivery</h4>
                    </div>
                    <?php

                    $sql = "select * from faq where category='Order And Delivery'";
                    $result = mysqli_query($con, $sql);
                    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    foreach ($rows as $row) {
                        $question = $row['question'];
                        $answer = $row['answer']; ?>

                        <button type="button" class=collapsible><?php echo "$question" ?></button>
                        <div class="content">
                            <?php echo "<p>$answer</p>" ?>
                        </div>
                    <?php } ?>
                </a>
            </div>

            <div class="box">
                <a name=ReturnnRefund>
                    <div class="category2">
                        <h4>Return And Refund</h4>
                    </div>

                    <?php

                    $sql = "select * from faq where category='Return And Refund'";
                    $result = mysqli_query($con, $sql);
                    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    foreach ($rows as $row) {
                        $question = $row['question'];
                        $answer = $row['answer']; ?>

                        <button type="button" class=collapsible><?php echo "$question" ?></button>
                        <div class="content">
                            <?php echo "<p>$answer</p>" ?>
                        </div>
                    <?php } ?>
                </a>
            </div>

            <div class="box">
                <a name=ProductnStock>
                    <div class="category2">
                        <h4>Product And Stock</h4>
                    </div>

                    <?php

                    $sql = "select * from faq where category='Product And Stock'";
                    $result = mysqli_query($con, $sql);
                    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    foreach ($rows as $row) {
                        $question = $row['question'];
                        $answer = $row['answer']; ?>

                        <button type="button" class=collapsible><?php echo "$question" ?></button>
                        <div class="content">
                            <?php echo "<p>$answer</p>" ?>
                        </div>
                    <?php } ?>
                </a>
            </div>
            <div class="box">
                <a name=Others>
                    <div class="category2">
                        <h4>Others</h4>
                    </div>

                    <?php

                    $sql = "select * from faq where category='Others'";
                    $result = mysqli_query($con, $sql);
                    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    foreach ($rows as $row) {
                        $question = $row['question'];
                        $answer = $row['answer']; ?>

                        <button type="button" class=collapsible><?php echo "$question" ?></button>
                        <div class="content">
                            <?php echo "<p>$answer</p>" ?>
                        </div>
                    <?php } ?>
                </a>
            </div>

            <?php if (isset($_SESSION['adminId'])) { ?>
                <a href="admin_faq.php" class="edit"><img src="img/edit.png" width="100px" height="100px"></a>
            <?php } ?>
        </div>

        <footer>
            <?php include 'footer.php'; ?>
        </footer>

    </div>

    <script>
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
            });
        }

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