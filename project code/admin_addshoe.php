<?php
session_start();
require_once("conndb.php");
include('functions.php');
include("adminwidget.php");
$user_data = check_login($con);
generateStyle();

$sql = "SELECT shoeid FROM shoe";
$result = mysqli_query($con, $sql);
$shoesData = mysqli_fetch_all($result);

if (isset($_POST['submit'])) {

    $shoeBrand = $_POST['shoe_brand'];
    $shoeID = $_POST['shoe_id'];
    $shoeName = $_POST['shoe_name'];
    $price = $_POST['price'];
    $color = $_POST['color'];
    $year = $_POST['year'];

    $productDetails = $_POST['product_details'];
    $discount = $_POST['discount'];

    if (!empty($_POST['age_type']) || !empty($_POST['gender']) || !empty($_POST['category']) || !empty($_POST['category_type'])) {
        $ageType = $_POST['age_type'];
        $gender = $_POST['gender'];
        $category = $_POST['category'];
        $categoryType = $_POST['category_type'];
    }
    $imgtemp = $_FILES['image']['tmp_name'];
    $img1 = addslashes(file_get_contents($imgtemp));

    if (!empty($shoeBrand) && !empty($shoeID) && !empty($shoeName) && !empty($price) && !empty($color) && !empty($ageType) && !empty($gender) && !empty($category) && !empty($categoryType) && !empty($year) && !empty($productDetails) && !empty($discount) && !empty($img1)) {
        $query = "INSERT INTO shoe (shoeId, brand, name, price, color, age_type, gender, category, picture, category_type, year_of_product, product_details, discount) VALUES ('$shoeID','$shoeBrand','$shoeName','$price','$color','$ageType','$gender','$category','$img1','$categoryType','$year','$productDetails','$discount') ";
        mysqli_query($con, $query);
        $query2 = "INSERT INTO shoedetails(sdId, shoeId, size, quantity)VALUES ('{$shoeID}a','$shoeID',6.0,0)";
        $query3 = "INSERT INTO shoedetails(sdId, shoeId, size, quantity)VALUES ('{$shoeID}b','$shoeID',7.5,0)";
        $query4 = "INSERT INTO shoedetails(sdId, shoeId, size, quantity)VALUES ('{$shoeID}c','$shoeID',8.0,0)";

        $query5 = "INSERT INTO shoedetails(sdId, shoeId, size, quantity)VALUES ('{$shoeID}d','$shoeID',8.5,0)";
        mysqli_query($con, $query2);
        mysqli_query($con, $query3);
        mysqli_query($con, $query4);
        mysqli_query($con, $query5);



        $message = "Successful added data";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Shoe</title>
    <?php include 'header.php'; ?>
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

            <div class=top>
                <h1>Sportify Add Shoe Form</h1>
                <hr>
            </div>
            <div class="add_shoe">
                <form class="addform" method="post" action="admin_addshoe.php" enctype="multipart/form-data">
                   
                    <table>
                        <tr>
                            <td>Shoe Brand:</td>
                            <td>
                                <select name="shoe_brand" id="" required>
                                    <option value="Adidas">Adidas</option>
                                    <option value="Nike">Nike</option>
                                    <option value="Puma">Puma</option>
                                    <option value="Skechers">Skechers</option>
                                </select>
                            </td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td>Shoe ID:</td>
                            <td><input pattern="^[aspn][0-9]{1,2}$" id="idtext" id="shoesid" class="text" type="text" name="shoe_id" onblur="checkShoesId(this) " required></td>
                            <td><span class="text error" style="color: red; display: none;"></span></td>
                        </tr>
                        <tr>
                            <td>Shoe Name:</td>
                            <td><input id="nametext" type="text" class="text" name="shoe_name" required></td>
                        </tr>
                        <tr>
                            <td>Price(RM): </td>
                            <td><input id="pricenumber" class="number" type="number" name="price" required></td>
                        </tr>
                        <tr>
                            <td>Color:</td>
                            <td><input id="colortext" type="text" class="text" name="color" required></td>
                        </tr>
                        <tr>
                            <td>Age Type:</td>
                            <td>
                                <input id="adult" type="radio" name="age_type" value="Adult" onchange=checkAgeType() required>
                                <label for="adult">Adult</label>
                                <input id="kids" type="radio" name="age_type" value="Kids" onchange=checkAgeType() required>
                                <label for="kids">Kids</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Gender:</td>
                            <td>
                                <input type="radio" name="gender" value="man" disabled id="man" required>
                                <label for="man">Man</label>
                                <input type="radio" name="gender" value="woman" disabled id="woman" required>
                                <label for="woman">Woman</label>
                                <input type="radio" name="gender" value="boy" disabled id="boy" required>
                                <label for="boy">Boy</label>
                                <input type="radio" name="gender" value="girl" disabled id="girl" required>
                                <label for="girl">Girl</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Shoe Category:</td>
                            <td>
                                <input id="sport" type="radio" name="category" value="Sport" onchange=checkShoeType() required>
                                <label for="sport">Sport</label>
                                <input id="casual" type="radio" name="category" value="Casual" onchange=checkShoeType() required>
                                <label for="casual">Casual</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Category Type:</td>
                            <td>
                                <input type="radio" name="category_type" value="running" disabled id="running" required>
                                <label for="running">Running</label>
                                <input type="radio" name="category_type" value="training" disabled id="training" required>
                                <label for="training">Training</label>
                                <input type="radio" name="category_type" value="lifestyle" disabled id="lifestyle" required>
                                <label for="lifestyle">Lifestyle</label>
                                <input type="radio" name="category_type" value="sandals" disabled id="sandals" required>
                                <label for="sandals">Sandals</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Picture:</td>
                            <td>
                                <input type="file" name="image" required accept="image/x-png,image/gif,image/jpeg" required />
                            </td>
                        </tr>
                        <tr>
                            <td>Product Year:</td>
                            <td><input id="pynumber" type="number" class="number" name="year" required></td>
                        </tr>
                        <tr>
                            <td>Product Details:</td>
                            <td><textarea name="product_details" id="pdtextarea" cols="40" rows="10" placeholder="Enter product details: " required></textarea></td>
                        </tr>
                        <tr>
                            <td>Discount:</td>
                            <td><input id="number" type="number" class="number" name="discount" value="0.0" required></td>
                        </tr>
                    </table>
                    <input id="button" type="submit" name="submit" value="Add Shoe">
                </form>

            </div>
        </div>

        <footer>
            <?php include 'footer.php'; ?>
        </footer>
    </div>

    <script>
        let shoesData = <?php echo json_encode($shoesData) ?>;

        function checkShoesId(input) {
            let selectedBrand = document.forms[0].elements[0].value;
            let tempId = "";

            switch (selectedBrand) {
                case "Adidas":
                    tempId = "a";
                    break;
                case "Nike":
                    tempId = "n";
                    break;
                case "Puma":
                    tempId = "p";
                    break;
                case "Skechers":
                    tempId = "s";
                    break;
                case "New Balance":
                    tempId = "nb";
                    break;
            }

            tempId = tempId + input.value;

            let isRepeated = false;
            for (let shoes of shoesData) {
                if (shoes[0] === tempId) {
                    isRepeated = true;
                }
            }

            let errorMsg = document.querySelector(".error");
            if (isRepeated) {
                errorMsg.style.display = "inline";
                errorMsg.innerHTML = "Id is repeated. Please try another one."
                document.querySelector("input[type=submit]").disabled = true;
            } else {
                input.value = tempId;
                errorMsg.style.display = "none";
                document.querySelector("input[type=submit]").disabled = false;
            }
        }

        function checkAgeType() {
            let Adult = document.getElementById("adult").checked;
            let Kids = document.getElementById("kids").checked;

            if (Adult == true) {
                document.getElementById("man").disabled = false;
                document.getElementById("woman").disabled = false;
                document.getElementById("boy").disabled = true;
                document.getElementById("girl").disabled = true;
            } else if (Kids == true) {
                document.getElementById("man").disabled = true;
                document.getElementById("woman").disabled = true;
                document.getElementById("boy").disabled = false;
                document.getElementById("girl").disabled = false;
            }
        }

        function checkShoeType() {
            let Sport = document.getElementById("sport").checked;
            let Casual = document.getElementById("casual").checked;

            if (Sport == true) {
                document.getElementById("running").disabled = false;
                document.getElementById("training").disabled = false;
                document.getElementById("lifestyle").disabled = true;
                document.getElementById("sandals").disabled = true;
            } else if (Casual == true) {
                document.getElementById("running").disabled = true;
                document.getElementById("training").disabled = true;
                document.getElementById("lifestyle").disabled = false;
                document.getElementById("sandals").disabled = false;
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

</html>