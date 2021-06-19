<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportify";

try {
    session_start();
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully <br/>";

    $stmt = $connection->prepare("SELECT blogId, headline,img1,introduction,publishDate,author,postCat,catTag1,catTag2,content,conclusion FROM blog");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}



if (isset($_GET['postCat'])) {
    $post_cat = $_GET['postCat'];
    try {
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully <br/>";

        $stmt = $connection->prepare("SELECT blogId, headline,img1,introduction,publishDate,author,postCat,catTag1,catTag2,content,conclusion FROM blog WHERE postCat= '$post_cat'");
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Could not connect to the database $dbname :" . $e->getMessage());
    }
}

if (isset($_GET['catTag1'])) {
    $cat_tag1 = $_GET['catTag1'];
    try {
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully <br/>";

        $stmt = $connection->prepare("SELECT blogId, headline,img1,introduction,publishDate,author,postCat,catTag1,catTag2,content,conclusion FROM blog WHERE catTag1= '$cat_tag1'");
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Could not connect to the database $dbname :" . $e->getMessage());
    }
}
if (isset($_GET['catTag2'])) {
    $cat_tag2 = $_GET['catTag2'];
    try {
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully <br/>";

        $stmt = $connection->prepare("SELECT blogId, headline,img1,introduction,publishDate,author,postCat,catTag1,catTag2,content,conclusion FROM blog WHERE catTag2= '$cat_tag2'");
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Could not connect to the database $dbname :" . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Blog</title>
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
    <style>
        .all_main_content {
            width: 520px;
            margin-left: 330px;
            margin: auto;
        }

        .blog_main_content {
            margin: 30px;
        }

        .blogtitle {
            color: cornflowerblue;
            text-decoration: none;
            font-weight: bold;
            font-size: 20px;
        }

        .blogtitle:hover {
            text-decoration: underline blue 3px;
        }

        .remarks p {
            color: gray;
        }

        .remarks #category,
        .remarks #tag1,
        .remarks #tag2 {
            color: white;
            border: white solid 1px;
            background-color: lightskyblue;
            border-left: cornflowerblue 5px solid;
            box-shadow: 3px 3px 10px grey;
            padding-left: 3px;
            padding-right: 3px;


        }

        .preview p {
            color: gray;
        }

        .addBlogBtn img {
            border-radius: 50px;
            position: fixed;
            top: 420px;
            left: 20px;
            z-index: 1;
        }
    </style>

</head>
<header>
    <?php include 'header.php'; ?>
</header>
<link rel='stylesheet' type='text/css' href='style.css'>

<body>
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

            <div class="blog">
                <div class=top>
                    <h1>Blogs</h1>
                    <hr>
                </div>

                <div class="all_main_content">
                    <?php while ($row = $stmt->fetch()) {
                    ?>
                        <div class="blog_main_content">
                            <div class="blog1">
                                <a class="blogimg" value="<?php echo $row['blogId'] ?>" onclick="findBlog(this)"> <?php echo '<br/><img src = "data:image/png;base64,' . base64_encode($row['img1']) . '"width = 500px height = 300px/>' ?>
                                </a>
                                <br /><br />
                                <a class=" blogtitle" value="<?php echo $row['blogId'] ?>" onclick="findBlog(this)"><?php echo $row['headline'] ?></a>
                            </div>

                            <div class="remarks">
                                <p>
                                    by <?php echo $row['author'] ?> | Categories: <a id="category" value="<?php echo $row['postCat'] ?>" onclick="filterPostCat(this)"><?php echo $row['postCat'] ?></a>
                                    Tags: <a id="tag1" value="<?php echo $row['catTag1'] ?>" onclick="filterCatTag1(this)">#<?php echo $row['catTag1'] ?></a>
                                    <a id="tag2" value="<?php echo $row['catTag2'] ?>" onclick="filterCatTag2(this)">#<?php echo $row['catTag2'] ?></a>
                                </p>
                            </div>
                        </div>



                    <?php } ?>
                </div>
                <a href="createblog.php" class="addBlogBtn"><img src="img/plus.png" style="height:80px;width: 80px;" title="Post a blog"></a>
                <script>
                    function findBlog(object) {

                        //alert(object.getAttribute("value"));
                        location.href = 'blogcontent.php?blogId=' + object.getAttribute("value");


                    }

                    function filterPostCat(object) {

                        location.href = 'blog.php?postCat=' + object.getAttribute("value");

                    }

                    function filterCatTag1(object) {
                        location.href = 'blog.php?catTag1=' + object.getAttribute("value");

                    }

                    function filterCatTag2(object) {
                        location.href = 'blog.php?catTag2=' + object.getAttribute("value");

                    }
                </script>
                <footer>
                    <?php include 'footer.php'; ?>
                </footer>

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
        </div>
    </div>
</body>


</html>