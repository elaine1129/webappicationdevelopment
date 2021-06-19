<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportify";



if (isset($_GET['blogId'])) {
    $blog_val = $_GET['blogId'];

    try {
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully <br/>";

        $stmt = $connection->prepare("SELECT headline,img1,introduction,publishDate,author,postCat,catTag1,catTag2,content,conclusion FROM blog WHERE blogId = '$blog_val'");
        $stmt->execute();
        //var_dump($stmt);
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Could not connect to the database $dbname :" . $e->getMessage());
    }
}



?>

<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap');

        .remarks>p {
            color: gray;
        }

        .remarks p a {
            padding-right: 5px;
        }


        .blog_content p {
            text-align: justify;
            line-height: 30px;
        }

        .fa {
            padding: 10px;
            font-size: 15px;
            width: 15px;
            text-align: center;
            text-decoration: none;
            border-radius: 50%;
        }

        .fa:hover {
            opacity: 0.7;
        }

        .fa-facebook {
            background: #3B5998;
            color: white;
        }

        .fa-twitter {
            background: #55ACEE;
            color: white;
        }

        .fa-rss {
            background: #ff6600;
            color: white;
        }

        .b_content {
            text-align: center;
            margin: 0px 300px;
        }

        .b_content .title {
            text-align: center;
            font-family: Georgia;
            margin: 30px auto;
            height: 50px;
            line-height: 50px;
            font-size: 30px;

        }

        .b_content h2 {
            margin: 80px auto 30px;
            font-family: 'Dela Gothic One';
        }

        .blog_content h4 {
            color: purple;
            text-align: justify;
            line-height: 37.5px;
            font-size: 20px;
            text-decoration: underline;
        }

        .blog_content p {
            text-align: justify;
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
    </style>
    <title>Blog Content</title>
</head>
<link rel='stylesheet' type='text/css' href='style.css'>
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
            <a href="shop.php" alt="go to shop">Blog</a>
            <a href="faq.php" alt="go to faq">FAQ</a>
            <a href="aboutus.php" alt="go to about us">About Us</a>
            <a href="contact.php" alt="go to contact us">Contact Us</a>
        </div>

        <div id="main">
            <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>


            <div class="b_content">
                <!--because cnt make sure only select one data -->

                <?php while ($row = $stmt->fetch()) : ?>
                    <?php

                    echo '<title>' . $row['headline'] . '</title>' ?>

                    <h1 class="title"><?php echo $row['headline'] ?></h1>

                    <?php echo '<br/><img src = "data:image/png;base64,' . base64_encode($row['img1']) . '"width = 550px height = 300px/>' ?>
                   
                    <div class="remarks">
                        <p> <?php echo $row['publishDate'] ?> &emsp;| by <?php echo $row['author'] ?> &emsp; | Categories: <a id="category" value="<?php echo $row['postCat'] ?>" onclick="filterPostCat(this)"><?php echo $row['postCat'] ?></a>Tags:<a id="tag1" value="<?php echo $row['catTag1'] ?>" onclick="filterCatTag1(this)">#<?php echo $row['catTag1'] ?></a>
                            <a id="tag2" value="<?php echo $row['catTag2'] ?>" onclick="filterCatTag2(this)">#<?php echo $row['catTag2'] ?></a>
                        </p>

                    </div>
                    <div class="blog_content">
                        <h2>Introduction
                            <hr>
                        </h2>

                        <p><?php echo $row['introduction'] ?></p>

                        <h2>Main Content
                            <hr>
                        </h2>

                        <p><?php echo $row['content'] ?></p>

                        <h2>Conclusion
                            <hr>
                        </h2>

                        <p><?php echo $row['conclusion'] ?></p>

                        <br /> <br /> <br />

                        <div class="socialshare" style="text-align:center">
                            <a href="https://www.facebook.com" class="fa fa-facebook"></a>
                            <a href="https://www.twitter.com" class="fa fa-twitter"></a>
                            <a href="https://www.rss.com" class="fa fa-rss"></a>
                        </div>

                    </div>

                <?php endwhile; ?>

                <script>
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


            </div>
        </div>
    </div>

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
</body>

</html>