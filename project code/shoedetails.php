<?php

session_start();
include("conndb.php");
include("functions.php");
generateStyle();

$con=mysqli_connect('localhost','root','','sportify');
?>
<?php
if(isset($_GET['shoeId'])){
    $shoeId=$_GET['shoeId'];
    $sql = "SELECT * FROM shoe WHERE shoeid = '$shoeId'";
    $rateSql = "SELECT * FROM rate WHERE shoeId = '$shoeId'";
}else{
    header("Location: shop.php");
}

if (isset($_POST["addreview"])) {
    $review = $_POST['review'];
    $shoeId=$_GET['shoeId'];
    $rate=$_POST['rate'];
    $reviewsql = "insert into rate(rateid,shoeId,rate,review_rate) VALUES (null,'$shoeId','$rate','$review')";
    if(mysqli_query($con, $reviewsql)){
        echo "Successfully register";
    }else{
        echo "failed";
    }
}


if (isset($_POST['addCart']) || isset($_POST['buy'])) {

    if(isset($_SESSION['memberId']))
    {
    $shoeId = $_GET['shoeId'];
    $quantity = $_POST['quantity'];
    $size = $_POST['size'];
    $id = $_SESSION['memberId'];

    $shoeDetailsSql = "select sdId from shoedetails where size='$size' and shoeId='$shoeId'";
    $result = mysqli_query($con, $shoeDetailsSql);
    $sdIdResult = mysqli_fetch_row($result);
    $sdId = $sdIdResult[0];

    $cartsql = "insert into cartdetails(cdId,memberId,shoeId,sdId,quantity) VALUES (null,'$id','$shoeId','$sdId','$quantity')";

    if (mysqli_query($con, $cartsql)) {
        if (isset($_POST['addCart'])) {
            echo "<script>window.alert('Successfully added')</script>";
        } else if (isset($_POST['buy'])) {
            echo "<script>location.href = 'shop.php'</script>";
        }
    } else {
        echo "<script>window.alert('Failed to add shoe. Please delete the shoe from your cart')</script>";
        //Failed to add shoe. Same shoes added to cart before.
    }
    
    }else{
        echo "<script>window.alert('Only members is allow to purchase. Please login in as member if you have an account or signup as member today : ) ')</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>
        Home
    </title>
    <style>

        #main{
            margin-bottom:10px;
        }

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

        * {
            margin: 0;
            padding: 0;
            background-size: auto;
            box-sizing: border-box;
        }

        input,
        button {
            cursor: pointer;
        }

        .container {
            max-width: 1440px;
            margin: 15px auto 100px;
            width: 90%;
        }

        .content{
            display:flex;
            justify-content: center;
        }

        .search h3 {
            font-size: 25px;
            margin-bottom: 5px;
            border: 1px solid red;
            text-decoration: underline;
        }

        .sidelist div {
            margin-bottom: 15px;
        }

        .rightcontent {
            display: block;
            width: 1000px;
            margin-bottom: 15px;
        }

        .sidelist h4 {
            font-size: 15px;
            margin-bottom: 10px;
            margin-left: 30px;
        }


        .categories_checkbox label,
        .brand_checkbox label,
        .shoesize_checkbox label,
        .shoecat_checkbox label {
            display: block;
            margin-right: 5px;
            margin-bottom: 5px;
            font-size: 15px;
        }

        .categories_checkbox label input,
        .brand_checkbox label input,
        .shoesize_checkbox label input,
        .shoecat_checkbox label input {
            margin-left: 30px;
            margin-right: 15px;
        }

        .rightcontent {
            margin: 0 auto;
            max-width: 700px;
        }

        .belowRightcontent {
            display: flex;
            max-width: 1000px;
            position: relative;
            margin: auto;
        }

        .shoeInfo {
            margin-top: 3%;
            min-width:500px;
        }

        .sizeBox {
            padding: 5px;
        }

        .sizeBox button {
            min-width: 48px;
            height: 48px;
            width: 0;
            font-size: 15px;
            cursor: pointer;
            margin: 5px;
            color: #2e2e2e;
            border: 1px solid #e5e5e5;
        }

        .sizeBox button:hover {
            background-color: #4d4dff;
            color: #FFFFFF;
        }

        .active {
            background-color: #4d4dff !important;
            color: #FFFFFF !important;
        }

        button {
            outline: none;
            border: none;
            width: 100px;
            height: 100px;
            margin-left: 15px;
        }

        #shoe {
            border: 1px solid grey;
            background: white;
            height: 110px;
            width: 110px;
        }

        /* Slider */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }

        .quantity .shoeQuantity input[type=number] {
            width: 70px;
            height: 30px;
        }

        .quantity .shoeQuantity input[type=button] {
            width: 35px;
            height: 30px;
            border-radius: 5px;
        }

        /* buy and add to cart button */
        .purchase {
            display: flex;
            justify-content: center;
        }

        .purchase .buy,
        .purchase .addtoCart {
            margin: 5%;
        }

        .purchase .buy input,
        .purchase .addtoCart input {
            max-width: 100px;
            width: 90px;
            height: 50px;
            border-radius: 5px;
            font-weight: bold;
        }

        /* picture left right button */
        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 200px;
            width: auto;
            margin-top: -22px;
            padding: 16px;
            color: grey;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }

        .next {
            right: 500px;
            border-radius: 3px 0 0 3px;
        }

        .prev:hover, .next:hover {
            background-color: #d9d9d9;
        }

        .fade {
            -webkit-animation-name: fade;
            -webkit-animation-duration: 1.5s;
            animation-name: fade;
            animation-duration: 1.5s;
        }

        @-webkit-keyframes fade {
            from {opacity: .4}
            to {opacity: 1}
        }

        @keyframes fade {
            from {opacity: .4}
            to {opacity: 1}
        }

        /* dot */
        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 20px 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .active, .dot:hover {
            background-color: #9999ff;
        }

        .review{
            margin:25px;
        }

    </style>

</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <div class="topnav">
        <?php include 'nav.php'; ?>
    </div>
    <div class="contain">

        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="index.php" alt="go to homepage">Home</a>
            <a href="shop.php" alt="go to shop">Shop</a>
            <a href="shop.php" alt="go to shop">Blog</a>
            <a href="faq.php" alt="go to faq">FAQ</a>
            <a href="aboutus.php" alt="go to about us">About Us</a>
            <a href="contact.php" alt="go to contact us">Contact Us</a>
        </div>
    </dv>
        <div id="main">
            <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>
    </div>
    <div class="container">
        <div class="content">
        <!..SHOE-->

        <?php $result = mysqli_query($con,$sql); ?>
        <?php $shoe = $result->fetch_array(); ?>
            <div class="rightcontent">
                <p style="font-weight: bold ;font-size: 30px; margin:5px"><?php echo $shoe['brand']?></p>
                <p style="font-size: 20px; margin:5px"><?php echo $shoe['name']?></p>
                <img style="height: 500px;width:550px; margin-left:70px" src="data:image/jpeg;base64, <?php echo base64_encode($shoe['picture'])?>" alt="">
                </div>

            <div class="cart">
                <p style="float:right; margin:10px;"><a href="shop.php" style="text-decoration:none; color:red; font-family:monospace"><img src="img/cart-icon.png"> Cart </a></p>
                <div class="belowRightcontent">
                    <div class="shoeInfo">
                        <div class="shoeDetails">
                            <div style="text-decoration: underline ;font-size:20px">Shoe Details</div>
                            <ul style="margin-left:20px ; margin-bottom: 15px ;font-size: 15px ; line-height: 25px">
                                <?php
                                    $details = explode("\n", $shoe['product_details']);
                                    foreach ($details as $detail) {
                                        echo "<li>{$detail}</li>";
                                    }
                                ?>
                            </ul>
                        </div>


                        <form method="POST" action="">
                        <div class="sizeType" style="font-size:20px; text-decoration: underline">Size (UK)</div>
                        <div class="sizeBox">
                            <button class="productSizeselectionButton" <input type="button" name="button" > 6</button>
                            <button class="productSizeselectionButton" <input type="button" name="button" > 7.5</button>
                            <button class="productSizeselectionButton" <input type="button" name="button" > 8</button>
                            <button class="productSizeselectionButton" <input type="button" name="button" > 8.5</button>
                        </div>
                        <input type="hidden" name="size" value="6">

                        <div class="quantity">
                            <div style="font-size:20px; text-decoration: underline">Quantity</div>
                            <div class="shoeQuantity"><br>
                                <input type="button" value="-" name="decrement" onclick="minusQuantity()">
                                <input style="text-align: center" id="quantity" name="quantity" type="number" min="1" max="99" value="1">
                                <input type="button" value="+" name="increment" onclick="addQuantity()">
                            </div>
                        </div>

                        <div class="price" style="font-weight:bold; font-size:30px; margin-top: 15px">
                            <p>RM <?php echo $shoe['price']?> </p>
                        </div>

                        <div class="purchase">
                            <div class="buy">
                                <input type="submit" name="buy" value="Buy">
                            </div>

                            <div class="addtoCart">
                                <input type="submit" name="addCart" value="Add to Cart">
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        
        

</div>
        <div class="review">
            <h2>Shoe Reviews</h2>
            <?php $result = mysqli_query($con,$rateSql); ?>
            <?php while($rate = $result->fetch_array()): ?>
            <p style="color:red; font-size: 10px; margin:5px">
                Rating:
                <?php if($rate['rate']==null){
                    echo "No rating";
                    }else{
                    echo $rate['rate'];
                }
                ?>
            </p>
            <ul style="margin-left:20px ; margin-bottom: 15px ;font-size: 15px ; line-height: 20px">
                <?php
                $rateDetails = explode("\n", $rate['review_rate']);
                if($rate['review_rate']==null){
                    echo "No review";
                }else {
                    foreach ($rateDetails as $rateDetail) {
                        echo "<li>{$rateDetail}</li>";
                    }
                }
                ?>
            </ul>
            <?php endwhile; ?>

            <form method="POST" action="">
                <div class="label">
                    <label for="rate"> Rate (?/5):
                        <input type="text" placeholder="Rate here" name="rate" required>
                    </label>
                </div>
                <div class="label">
                    <label for="review"> Do write your comment in the box given below: </label></div>
                <div class="input">
                    <textarea type="text" placeholder="Leave your comment here" name="review" style="width:700px; height:300px" required></textarea></div>
                <div class="review_button">
                    <input type="submit" name="addreview" value="submit">
                </div>
            </form>
        </div>
    </div>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</body>

<script>

    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
    }

    //minus quantity button
    function minusQuantity() {
        let quantity = document.querySelector('.quantity .shoeQuantity input[type=number]');
        if (quantity.value == '0') {
            return;
        }
        quantity.value--;
    }

    //add quantity button
    function addQuantity() {
        let quantity = document.querySelector('.quantity .shoeQuantity input[type=number]');
        quantity.value++;
    }

    //Size button
    let sizeButton = document.querySelectorAll('.productSizeselectionButton');
    sizeButton.forEach(btn => {
        btn.addEventListener('click', evt => {
            let current = document.querySelector('.active');
            if (current !== null) {
                current.classList.remove("active");
            }
            btn.classList.add('active');
            btn.parentElement.nextElementSibling.value = btn.innerHTML;
        });
    });
</script>
</html>