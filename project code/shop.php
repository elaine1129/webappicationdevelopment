<?php
session_start();
include('conndb.php');
include('functions.php');
$total_price = 0;
$errors = array();
$status = "";
$memberId = "";
$user_data = check_login($con);
generateStyle();

if (isset($_SESSION['memberId'])) {
    $memberId = $_SESSION['memberId'];


    if (isset($_POST['action']) && $_POST['action'] == "remove") {

        $sql = "select * from cartdetails where memberId='$memberId'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($row as $product) {
            $shoeId = $product['shoeId'];
            //remove item
            if ($_POST["shoeId"] == $product['shoeId']) {
                $shodeId = $product['shoeId'];

                $sql = "delete from cartdetails where shoeId='$shoeId'";
                mysqli_query($con, $sql);

                $status = "<div class='cartBox'>
                    Product is removed from your cart!</div>";
            }
        }
    }
    if (isset($_POST['action']) && $_POST['action'] == "change") {
        $sql = "select * from cartdetails where memberId='$memberId'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

        foreach ($row as &$value) {
            if ($value['shoeId'] === $_POST["shoeId"]) {

                $shoeId = $value['shoeId'];
                $newQuantity = $_POST["quantity"];

                mysqli_data_seek($result, 0);
                $sql = "UPDATE `cartdetails` SET `quantity`=$newQuantity WHERE shoeId='$shoeId'";
                mysqli_query($con, $sql);
                break; // Stop the loop after we've found the product
            }
        }
    }
    if (isset($_POST['action']) && $_POST['action'] == "changeSize") {
        $sql = "select * from cartdetails where memberId='$memberId'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

        foreach ($row as &$value) {
            if ($value['shoeId'] === $_POST["shoeId"]) {
                $size = $_POST["size"];
                $shoeId = $_POST["shoeId"];

                mysqli_data_seek($result, 0);
                $sql = "select sdId from shoedetails where size='$size' and shoeId='$shoeId'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_row($result);
                $sdId_new = implode("", $row);

                mysqli_data_seek($result, 0);
                $sql = "UPDATE `cartdetails` SET `sdId`='$sdId_new' WHERE shoeId='$shoeId' ";
                mysqli_query($con, $sql);

                $sdId = $sdId_new;

                break; // Stop the loop after we've found the product
            }
        }
    }
}
/* confirm order*/

if (isset($_POST['confirm'])) {
    $sql0 = "select * from cartdetails where memberId='$memberId'";
    $result0 = mysqli_query($con, $sql0);
    $row0 = mysqli_fetch_all($result0, MYSQLI_ASSOC);

    foreach ($row0 as &$value) {
        $shoeId = $value['shoeId'];
        $query = "select name from shoe where shoeId = '$shoeId'";
        $result = mysqli_query($con, $query);
        $row1 = mysqli_fetch_row($result);
        $name = $row1[0];

        $sdId = $value['sdId'];
        $sql = "select quantity from shoedetails where sdId = '$sdId'";
        $result2 = mysqli_query($con, $sql);
        $row2 = mysqli_fetch_row($result2);
        $invQuantity = implode("", $row2);

        $sql2 = "select size from shoedetails where sdId = '$sdId'";
        $result3 = mysqli_query($con, $sql2);
        $row3 = mysqli_fetch_row($result3);
        $size = implode("", $row3);

        $quantitySel = (int) $value['quantity'];

        if ($invQuantity <= 0 || $quantitySel > $invQuantity) {
            array_push($errors, "Size (" . $size . ") of " . $name . " only left " . $invQuantity . " pairs. Please reselect.");
        }
    }

    //display total payment checkout 
}
/*checkout*/
if (isset($_POST['checkout'])) {
    $orderId = 'or' . random_num(7);
    $rname = $_POST['rname'];
    $rphone = $_POST['rphone'];
    $raddress = $_POST['raddress'];

    if (empty($rname)) {
        array_push($errors, "Recipient name is required");
    } else {
        $pattern =  "/^[a-zA-Z]+$/";

        if (!preg_match($pattern, $rname)) {
            array_push($errors, "Name should contain letters only.");
        }
    }
    if (empty($rphone)) {
        array_push($errors, "Phone number is required");
    } else {
        $pattern = "/^(\+?6?01)[0-9]{7,9}$/";       //+ and 6 is optional

        if (!preg_match($pattern, $rphone)) {
            array_push($errors, "Please enter valid phone number. Example: 0123456789");
        }
    }

    if (count($errors) == 0) {
        $query = "INSERT INTO member_order(orderId, memberId, rname, rphone,raddress) VALUES ('$orderId','$memberId','$rname','$rphone','$raddress')";
        mysqli_query($con, $query);

        $sql0 = "select * from cartdetails where memberId='$memberId'";
        $result0 = mysqli_query($con, $sql0);
        $row0 = mysqli_fetch_all($result0, MYSQLI_ASSOC);

        foreach ($row0 as &$value) {
            $shoeId = $value['shoeId'];
            $sdId = $value['sdId'];
            $quantity = $value['quantity'];;


            mysqli_data_seek($result0, 0);
            $query = "INSERT INTO `orderdetails`(`orderId`, `shoeId`, `sdId`, `quantity`) VALUES ('$orderId','$shoeId','$sdId','$quantity')";
            $result = mysqli_query($con, $query);


            $sql = "delete from cartdetails where sdId = '$sdId'";
            mysqli_query($con, $sql);


            //change shoe details quantity
            $sql2 = "select quantity from shoedetails where sdId = '$sdId'";
            $result2 = mysqli_query($con, $sql2);
            $row2 = mysqli_fetch_row($result2);
            $str = implode('', $row2);
            $temp = (int) $str;

            if ($temp <= 0) {
                $newQuantity = 0;
                $sql3 = "update shoedetails set quantity='$newQuantity' where sdId = '$sdId'";
                mysqli_query($con, $sql3);
            } else {

                $newQuantity = $temp - $quantity;
                $sql3 = "update shoedetails set quantity='$newQuantity' where sdId = '$sdId'";
                mysqli_query($con, $sql3);
            }
        }
        echo '<script>confirm("Order created. Proceeding to payment......")</script>';
    }
}



?>


<html>

<head>
    <title>Shopping Cart</title>
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
                <h1>Shopping cart</h1>
                <hr>
            </div>
            <?php

            if (isset($_SESSION['adminId']) || isset($_SESSION['user_id'])) {
                echo "<div class='top'>";
                echo "<h1 style=color:red;>Shopping cart only for members.</h1>";
                echo "</div>";
            } else { ?>

                <div class="sc">
                    <?php

                    $sql = "select * from cartdetails where memberId = '$memberId'";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_num_rows($result);

                    if ($row > 0) {
                        $total_price = 0;

                    ?>

                        <table>
                            <thead>
                                <tr>
                                    <th style="text-align:left;">Items</th>
                                    <th>Quantity</th>
                                    <th>Size</th>
                                    <th>Unit Price(RM)</th>
                                    <th>Item total</th>
                                    <th>Remove</th>
                                </tr>
                                <?php


                                $sql = "select * from cartdetails where memberId='$memberId'";
                                $result = mysqli_query($con, $sql);
                                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);


                                foreach ($rows as $product) {

                                    $shoeId = $product['shoeId'];
                                    $quantity = (int)$product['quantity'];
                                    $sdId = $product['sdId'];


                                    $sql = "select name,price,discount,age_type,gender,picture,brand from shoe where shoeId='$shoeId' limit 1";
                                    $result = mysqli_query($con, $sql);
                                    $row = mysqli_fetch_row($result);
                                    $name = $row[0];
                                    $price = $row[1];
                                    $discount = $row[2];
                                    $age_type = $row[3];
                                    $gender = $row[4];
                                    $picture = $row[5];
                                    $brand = $row[6];


                                    mysqli_data_seek($result, 0);
                                    $sql2 = "select size from shoedetails where sdId='$sdId' limit 1";
                                    $result = mysqli_query($con, $sql2);
                                    $row = mysqli_fetch_row($result);
                                    $size = $row[0];
                                ?>
                            <tbody>
                                <tr>

                                    <td>
                                        <?php echo "<p class='name'>" . $name . "</p>" ?>
                                        <?php echo "<p style='font-weight:bold;'>" . $brand  . "</p>" ?>
                                        <?php echo $gender . "( " . $age_type . " )"; ?>
                                        <form method='post' action=''>
                                            <img style="height: 150px;width:150px" src="data:image/jpeg;base64, <?php echo base64_encode($picture) ?>" alt="">
                                            <input type='hidden' name='shoeId' value="<?php echo $shoeId; ?>" />
                                        </form>
                                    </td>
                                    <td>
                                        <form method='post' action=''>
                                            <input type='hidden' name='shoeId' value="<?php echo $shoeId ?>" />
                                            <input type='hidden' name='action' value="change" />
                                            <select name='quantity' class='quantity' onchange="this.form.submit()">
                                                <option <?php if ($quantity == 1) echo "selected"; ?> value="1">1</option>
                                                <option <?php if ($quantity == 2) echo "selected"; ?> value="2">2</option>
                                                <option <?php if ($quantity == 3) echo "selected"; ?> value="3">3</option>
                                                <option <?php if ($quantity == 4) echo "selected"; ?> value="4">4</option>
                                                <option <?php if ($quantity == 5) echo "selected"; ?> value="5">5</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <form method='post' action=''>
                                            <input type='hidden' name='shoeId' value="<?php echo $shoeId ?>" />
                                            <input type='hidden' name='sdId' value="<?php echo $sdId; ?>" />
                                            <input type='hidden' name='action' value="changeSize" />
                                            <select name='size' class='size' onchange="this.form.submit()">
                                                <option <?php if ($size == 6.0) echo "selected"; ?> value="6.0">6.0</option>
                                                <option <?php if ($size == 7.5) echo "selected"; ?> value="7.5">7.5</option>
                                                <option <?php if ($size == 8.0) echo "selected"; ?> value="8.0">8.0</option>
                                                <option <?php if ($size == 8.5) echo "selected"; ?> value="8.5">8.5</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <?php echo "RM" . number_format($price, 2); ?>
                                    </td>
                                    <td>
                                        <?php

                                        $item_total = $price - ($price * $discount) * $quantity;
                                        echo "RM" . number_format($item_total, 2);

                                        ?>
                                    </td>
                                    <td>
                                        <form method='post' action=''>
                                            <input type='hidden' name='shoeId' value="<?php echo $shoeId; ?>" />
                                            <input type='hidden' name='action' value="remove" />
                                            <button type='submit' class='remove'><img src="img/bin.png" width="30px" height="30px"></button>
                                        </form>
                                </tr>
                            <?php
                                    $total_price += ($price * $quantity);
                                }/*close foreach */

                            ?>
                            <tr>
                                <td style="border-top:1px solid grey;" colspan="4"></td>
                                <td style="border-top:1px solid grey;">
                                    <strong>TOTAL:
                                        <?php echo "RM" . number_format($total_price, 2); ?>
                                    </strong>
                                </td>
                                <td style="border-top:1px solid grey;">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="index.php">Continue Shopping</a>
                                </td>
                                <td colspan="3"></td>
                                <td>
                                    <form method="post">
                                        <input type="submit" name="confirm" value="Confirm"></input>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5"><?php include('errors.php'); ?></td>
                            </tr>
                            </tbody>
                        </table>
                </div>
                <!--end of sc-->



                <?php if (isset($_POST['confirm'])) {
                            if (count($errors) == 0) {
                ?>
                        <div class="confirmOrder">

                            <h1>Total Payment: <?php echo "RM " . number_format($total_price, 2); ?></h1>

                            <form class="order" method="post">

                                <table>
                                    <tr>
                                        <td><label for="rname"> Recipient name: </label></td>
                                        <td><input type="text" placeholder="Recipient name" name="rname" required></td>
                                    </tr>
                                    <tr>
                                        <td><label for="rname"> Recipient phone number: </label></td>
                                        <td><input type="text" placeholder="Recipient phone number" name="rphone" required></td>
                                    </tr>
                                    <tr>
                                        <td><label for="raddress"> Recipient address: </label></td>
                                        <td><textarea rows="5" cols="20" placeholder="Recipient address" name="raddress" required></textArea></td>
                                    </tr>
                                </table>

                                <input type="submit" name="checkout" value="Checkout">

                            </form>
                        </div>

                <?php }
                        } ?>
            <?php
                    } else if ($row <= 0) {
                        echo "<div class='top'>";
                        echo "<h1>Your shopping cart is empty</h1>";
                        echo "</div>";
                    }
            ?>

            <div class="message_box" style="margin:10px 0px;">
                <?php echo $status; ?>
            </div>
        <?php } ?>
        </div>
        <!--main -->
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
<footer>
    <?php include('footer.php'); ?>
</footer>


</html>