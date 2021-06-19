<?php
session_start();
include("conndb.php");
include('functions.php');

$user_data = check_login($con);
generateStyle();



$sql = "SELECT * FROM shoe";

//search filter function
function parseFilter($filterList): string
{
    $filters = $filterList;
    $tempSql = "(";
    foreach ($filters as $filter) {
        $tempSql .= "'" . $filter . "',";
    }


    $tempSql = substr($tempSql, 0, -1);
    $tempSql .= ")";
    return $tempSql;
}

if (isset($_POST['filterBtn'])) {

    $genderSql = "";
    $brandSql = "";
    $category_typeSql = "";
    $sizeSql = "";

    if (isset($_POST['gender'])) {
        $gender = $_POST['gender'];

        $genderSql = "`gender` IN";
        $genderSql .= parseFilter($_POST['gender']);
    }

    if (isset($_POST['brand'])) {
        $brand = $_POST['brand'];

        $brandSql = "`brand` IN";
        $brandSql .= parseFilter($_POST['brand']);
    }

    if (isset($_POST['category_type'])) {
        $category_type = $_POST['category_type'];

        $category_typeSql = "`category_type` IN";
        $category_typeSql .= parseFilter($_POST['category_type']);
    }


    if (isset($_POST['shoesize'])) {
        $size = $_POST['shoesize'];

        $sizeSql = " shoeid IN ( SELECT s.shoeid FROM shoe s JOIN shoedetails sd ON s.shoeid = sd.shoeid WHERE ";

        foreach ($size as $aSize) {
            $singleSize = " sd.size = {$aSize} AND ";
            $sizeSql .= $singleSize;
        }

        $sizeSql = substr($sizeSql, 0, -4);
        $sizeSql .= " )";
    }


    if ($genderSql != "" || $brandSql != "" || $category_typeSql != "" || $sizeSql != "") {
        $filterSqlArr = array($genderSql, $brandSql, $category_typeSql, $sizeSql);
        $parseFilterSql = ' WHERE';
        foreach ($filterSqlArr as $singleFilter) {
            if ($singleFilter != "") {
                $parseFilterSql .= $singleFilter . " AND ";
            }
        }

        $parseFilterSql = substr($parseFilterSql, 0, -5);
        $sql .= " $parseFilterSql";
    }
}

if (isset($_SESSION['adminId'])) {
    include("adminwidget.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>
        Home
    </title>

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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        input,
        button {
            cursor: pointer;
        }

        .container {
            display: flex;
            justify-content: center;
            max-width: 1440px;
            margin: 15px auto 100px;
            width: 90%;
        }

        hr {
            width: 230px;
            margin: auto;
            height: 5px;
            background-color: #e5e5e5;
        }

        .sidelist div {
            margin-bottom: 15px;
        }

        .search h3 {
            font-size: 25px;
            margin-bottom: 5px;
            text-decoration: underline;
        }

        .rightcontent {
            display: block;
            width: 945px;
            margin-bottom: 15px;
            background-color: #f5f5f5;
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
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .information {
            margin: 10px;
        }

        .shoeInfo {
            display: flex;
            margin: 15px;
            padding: 5px;
            flex-direction: column;
            border: 1px solid rgb(215, 230, 230);
            max-width: 270px;
            cursor: pointer;
            transition: transform .2s;
        }

        .shoeInfo:hover {
            box-shadow: 1px 1px 10px #888888;
            transform: scale(1.1);
        }

        .shoeInfo img {
            height: 200px;
        }

        .shoeInfo h2 {
            margin-top: 15px;
        }


        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidelist {
            display: block;
            width: 20%;
            margin-right: 15px;
            margin-bottom: 15px;
        }

        .search h3 {
            font-size: 25px;
            margin-bottom: 5px;
            text-decoration: underline;
        }

        .sidelist div {
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

        .slidecontainer {
            width: 90%;
        }

        .slider {
            -webkit-appearance: none;
            width: 80%;
            height: 15px;
            background: #d3d3d3;
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
            margin: 0px 0px 10px 30px;
        }

        .slider:hover {
            opacity: 1;
        }

        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 15px;
            height: 15px;
            background: #4CAF50;
            cursor: pointer;
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

        button {
            outline: none;
            border: none;
            border: none;
            width: 100px;
            height: 100px;
            margin-left: 15px;
        }

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

        .purchase .buy input,
        .purchase .addtoCart input {
            max-width: 100px;
            width: 90px;
            height: 50px;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>

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
            <a href="blog.php" alt="go to blog">Blog</a>
            <a href="faq.php" alt="go to faq">FAQ</a>
            <a href="aboutus.php" alt="go to about us">About Us</a>
            <a href="contact.php" alt="go to contact us">Contact Us</a>
        </div>

        <div id="main">
            <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>


            <div class="container">
                <div class="sidelist">
                    <div class="search" style="text-align: center">
                        <h3>Search Filter</h3>
                    </div>

                    <form action="index.php" method="POST">
                        <div class="categories">
                            <h4>By Category</h4>
                            <div class="categories_checkbox">
                                <label for="Man"> <input type="checkbox" value="Man" name="gender[]" <?php if (isset($gender) && in_array("Man", $gender)) echo "checked"; ?>>Man </label>
                                <label for="Woman"> <input type="checkbox" value="Woman" name="gender[]" <?php if (isset($gender) && in_array("Woman", $gender)) echo "checked"; ?>>Woman</label>
                                <label for="Boy"> <input type="checkbox" value="Boy" name="gender[]" <?php if (isset($gender) && in_array("Boy", $gender)) echo "checked"; ?>>Kid(Boy) </label>
                                <label for="Girl"> <input type="checkbox" value="Girl" name="gender[]" <?php if (isset($gender) && in_array("Girl", $gender)) echo "checked"; ?>>Kid(Girl)</label>
                            </div>
                            <hr>
                        </div>

                        <div class="brand">
                            <h4>Brand</h4>
                            <div class="brand_checkbox">
                                <label for="Adidas"> <input type="checkbox" value="Adidas" name="brand[]" <?php if (isset($brand) && in_array("Adidas", $brand)) echo "checked"; ?>>Adidas</label>
                                <label for="New Balance"> <input type="checkbox" value="New Balance" name="brand[]" <?php if (isset($brand) && in_array("New Balance", $brand)) echo "checked"; ?>>New Balance</label>
                                <label for="Nike"> <input type="checkbox" value="Nike" name="brand[]" <?php if (isset($brand) && in_array("Nike", $brand)) echo "checked"; ?>>Nike</label>
                                <label for="Puma"> <input type="checkbox" value="Puma" name="brand[]" <?php if (isset($brand) && in_array("Puma", $brand)) echo "checked"; ?>>Puma</label>
                                <label for="Skechers"> <input type="checkbox" value="Skechers" name="brand[]" <?php if (isset($brand) && in_array("Skechers", $brand)) echo "checked"; ?>>Skechers</label>
                            </div>
                            <hr>
                        </div>

                        <div class="shoesize">
                            <h4>Size (UK)</h4>
                            <div class="shoesize_checkbox">
                                <label for="4.5"> <input type="checkbox" value="4.5" name="shoesize[]" <?php if (isset($size) && in_array("4.5", $size)) echo "checked"; ?>>4.5</label>
                                <label for="5"> <input type="checkbox" value="5" name="shoesize[]" <?php if (isset($size) && in_array("5", $size)) echo "checked"; ?>>5</label>
                                <label for="5.5"> <input type="checkbox" value="5.5" name="shoesize[]" <?php if (isset($size) && in_array("5.5", $size)) echo "checked"; ?>>5.5</label>
                                <label for="6"> <input type="checkbox" value="6" name="shoesize[]" <?php if (isset($size) && in_array("6", $size)) echo "checked"; ?>>6</label>
                                <label for="6.5"> <input type="checkbox" value="6.5" name="shoesize[]" <?php if (isset($size) && in_array("6.5", $size)) echo "checked"; ?>>6.5</label>
                                <label for="7"> <input type="checkbox" value="7" name="shoesize[]" <?php if (isset($size) && in_array("7", $size)) echo "checked"; ?>>7</label>
                                <label for="7.5"> <input type="checkbox" value="7.5" name="shoesize[]" <?php if (isset($size) && in_array("7.5", $size)) echo "checked"; ?>>7.5</label>
                                <label for="8"> <input type="checkbox" value="8" name="shoesize[]" <?php if (isset($size) && in_array("8", $size)) echo "checked"; ?>>8</label>
                                <label for="8.5"> <input type="checkbox" value="8.5" name="shoesize[]" <?php if (isset($size) && in_array("8.5", $size)) echo "checked"; ?>>8.5</label>
                                <label for="9"> <input type="checkbox" value="9" name="shoesize[]" <?php if (isset($size) && in_array("9", $size)) echo "checked"; ?>>9</label>
                            </div>
                            <hr>
                        </div>

                        <div class="shoe_cat">
                            <h4>Shoe Categories</h4>
                            <div class="shoecat_checkbox">
                                <label for="Sandals"> <input type="checkbox" value="Sandals" name="category_type[]" <?php if (isset($category_type) && in_array("Sandals", $category_type)) echo "checked"; ?>>Sandals</label>
                                <label for="Lifestyle"> <input type="checkbox" value="Lifestyle" name="category_type[]" <?php if (isset($category_type) && in_array("Training", $category_type)) echo "checked"; ?>>Lifestyle</label>
                                <label for="Running"> <input type="checkbox" value="Running" name="category_type[]" <?php if (isset($category_type) && in_array("Running", $category_type)) echo "checked"; ?>>Running</label>
                                <label for="Training"> <input type="checkbox" value="Training" name="category_type[]" <?php if (isset($category_type) && in_array("Training", $category_type)) echo "checked"; ?>>Training</label>
                            </div>
                            <hr>
                        </div>
                        <!--
                        <div class="slidecontainer">
                            <h4>Price range</h4>
                            <input type="range" min="14" max="3000" class="slider" id="range">
                            <p style="font-size: 15px; margin-left: 30px">Price: RM <span id="price"></span></p>
                            <script>
                                var slider = document.getElementById("range");
                                var output = document.getElementById("price");
                                output.innerHTML = slider.value;

                                slider.oninput = function() {
                                    output.innerHTML = this.value;
                                }
                            </script>
                        </div>-->
                        <button type="submit" value="filterBtn" name="filterBtn" style="width:70px; height: 50px; float:right">Search</button>
                    </form>
                </div>

                <div class="cart">
                    <p style="float:right; margin:15px"><a href="shop.php" style="text-decoration:none; color:red; font-family:monospace"><img src="img/cart-icon.png"> Cart </a></p>

                    <div class="rightcontent">
                        <?php
                        $result = mysqli_query($con, $sql) ?>
                        <?php while ($shoe = $result->fetch_assoc()) { ?>
                            <div class="information">
                                <div class="shoeInfo" onclick="location.href = 'shoedetails.php?shoeId=<?php echo $shoe['shoeId'] ?>'">
                                    <p style="font-weight: bold ;font-size: 20px"><?php echo $shoe['brand'] ?></p>
                                    <img style="height: 250px;width:250px" src="data:image/jpeg;base64, <?php echo base64_encode($shoe['picture']) ?>" alt="">
                                    <p style="font-size: 15px"><?php echo $shoe['name'] ?></p>
                                    <h2>RM <?php echo $shoe['price'] ?></h2>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <?php include 'footer.php'; ?>
        </footer>
</body>

</html>