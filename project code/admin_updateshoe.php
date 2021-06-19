<?php

session_start();
require_once("conndb.php");
include("functions.php");
include("adminwidget.php");

$user_data = check_login($con);
generateStyle();
$errors = array();
$found = 0;

if (isset($_POST['a-search'])) {
    
    $sdId = $_POST['sdId'];

    if (empty($sdId)) {
        array_push($errors, "Shoe details Id is required");
    }

    if (count($errors) == 0) {
        $query = "select * from shoedetails where sdid = '$sdId' limit 1";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $shoedetail_data = mysqli_fetch_assoc($result);
            $found = 1;
            $shoeId = $shoedetail_data['shoeId'];
            $query2 = "select * from shoe where shoeId = '$shoeId' limit 1";
            $result2 = mysqli_query($con, $query2);
            $shoe_data = mysqli_fetch_assoc($result2);
        } else {
            $found = 0;
            array_push($errors, "Shoe details Id not found");
        }
    }
}



if (isset($_POST['a-update'])) {
    
    $sdId = $_POST['sdIdu'];
    $shoeId = $_POST['shoeIdu'];
    $size = $_POST['size'];
    $quantity = $_POST['quantity'];
    $discount = $_POST['discount'];


    if ($size != 6.0 && $size != 7.5 && $size != 8.0  && $size != 8.5) {
        array_push($errors, "Shoe size only allow 6.0,7.5,8.0 and 8.5");
    }

    if (count($errors) == 0) {
        $query = "UPDATE shoedetails SET size='$size', quantity='$quantity' WHERE sdId='$sdId'";
        mysqli_query($con, $query);
        $query2 = "UPDATE shoe SET discount='$discount' WHERE shoeId='$shoeId'";
        mysqli_query($con, $query2);
        echo '<script>alert("Shoe updated.")</script>';
    }
}

?>

<html>
<style>
    /*side navigator*/
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

<head>
    <title>Admin Update</title>
</head>

<header>
    <?php include 'header.php'; ?>
</header>

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
                <h1>Sportify Update Shoe</h1>
                <hr>
            </div>

            <div class="update_shoe">
                <form method="post">
                    <h3>Search Shoe details</h3>

                    <label for="sdId">Shoe Details ID:</label>
                    <input type="text" id="sdId" name="sdId" required><br><br>
                    <input type="submit" name=a-search value="Search"><br><br>
                    <?php include('errors.php'); ?>
                </form>

                <div class="display_search_result">
                    <?php
                    if ($found == 1) {
                        echo "Shoe detail Id:" . $shoedetail_data['sdId'] . "<br/>";
                        echo "Shoe Id:" . $shoedetail_data['shoeId'] . "<br/>";
                        echo "Shoe size:" . $shoedetail_data['size'] . "<br/>";
                        echo "Shoe quantity:" . $shoedetail_data['quantity'] . "<br/>";
                        echo "Shoe discount:" . $shoe_data['discount'] . "<br/>";
                    } ?>
                </div>



                <div id="update_form">
                    <form method="post" action="admin_updateshoe.php">
                        <h3>Update Shoe details</h3>
                        <label for="sdIdu">Shoe Details ID:</label>
                        <input type="text" id="sdIdu" name="sdIdu" value="<?php echo $shoedetail_data['sdId'] ?>" readonly="readonly" ><br><br>
                        <label for="shoeIdu">Shoe ID:</label>
                        <input type="text" id="shoeIdu" name="shoeIdu" value="<?php echo $shoedetail_data['shoeId'] ?>" readonly="readonly"><br><br>
                        <label for="size">Size:</label>
                        <input type="number" id="size" name="size" value="<?php echo $shoedetail_data['size'] ?>" required step=".01" min="0.0"><br><br>
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" value="<?php echo $shoedetail_data['quantity'] ?>" required min="0" step="1"><br><br>
                        <label for="discount">Discount:</label>
                        <input type="number" id="discount" name="discount" value="<?php echo $shoe_data['discount'] ?>" required min="0.00" step="0.01"><br><br>
                        <input type="submit" name=a-update value="Update">
                    </form>
                </div>

                <script>
                    if (<?php echo $found ?> == 1) {
                        document.getElementById("update_form").style.display = "block";
                    } else if (<?php echo $found ?> == 0) {
                        document.getElementById("update_form").style.display = "none";
                    }
                </script>

            </div>
            <script>
                function deleteConfirm(shoeid) {
                    if (confirm("Are you sure to delete this shoes " + shoeid + " ?")) {
                        window.location.href = "/deleteshoe.php?deleteid=" + shoeid;
                    }
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
<footer>
    <?php include 'footer.php'; ?>
</footer>

</html>