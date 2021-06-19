<?php
session_start();
require_once("conndb.php");
include("functions.php");
include("adminwidget.php");

$user_data = check_login($con);
generateStyle();


$sql = "SELECT shoeid, name FROM shoe";
$result = mysqli_query($con, $sql);

if (isset($_GET['deleteid'])) {
    $deleteid = $_GET['deleteid'];
    $deletesql = "DELETE FROM shoe WHERE shoeid = '$deleteid '";
    mysqli_query($con, $deletesql);
    echo "<script>alert('Delete success')</script>";
    header("location: admin_deleteshoe.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Delete Shoe</title>


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
    <?php include 'header.php'; ?>
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

        <div id="main">
            <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>

            <div class=top>
                <h1>Sportify Delete Shoe Form</h1>
                <hr>
            </div>
            <div class="delete_shoe">

                <?php
                echo "<table><thead><tr><th>Shoe ID</th><th>Shoe Name</th><th>Action</th></tr></thead><tbody>";
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $row['shoeid'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        printf("<td><a  onclick=\"deleteConfirm('%s')\">Delete</a></td>", $row['shoeid']);
                        echo "</tr>";
                    }
                }
                echo "</tbody></table>";
                ?>
                <br><br><br><br><br><br><br><br><br><br>
            </div>

            <footer>
                <?php include 'footer.php'; ?>
            </footer>
        </div>
    </div>
    <script>
        function deleteConfirm(shoeid) {
            if (confirm("Are you sure to delete this shoe " + shoeid + " ?")) {
                location.href = 'admin_deleteshoe.php?deleteid=' + shoeid;
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