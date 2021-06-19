<html>

<head>
    <title>Post A Blog</title>
    
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

    <style>
        #main .add_blog {
        width: 700px;
        box-shadow: 0 0 3px 0 rgb(255, 189, 189);
         background: #fff;
        padding: 20px;
        border-radius: 20px;
        margin: 100px auto 200px;
        text-align: center;
    }
    #main .add_blog table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 50px;
    font-family: 'Segoe UI';
    }

    #main .add_blog td
    {
        min-width:120px;
        line-height:27.5px;
    }
    #main .add_blog td input,  #main .add_blog td select,  #main .add_blog td textarea
    {
        margin:5px;
    }


    #main .add_blog td:first-child {
    text-align: right;
    padding: 5px 0px;
    font-weight:bold;
}


    #main .add_blog input[type="submit"]
    {
        background: black;
        color: white;
        padding: 3px;
        font-size: 15px;
        letter-spacing: 3px;
        font-family: 'Segoe UI';
        font-weight: bold;
        border-radius: 3px;
    }

    #main .add_blog form input[type="submit"]:hover
    {
        background: lightgreen;
        cursor:pointer;
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
            <a href="blog.php" alt="go to blog">Blog</a>
            <a href="faq.php" alt="go to faq">FAQ</a>
            <a href="aboutus.php" alt="go to about us">About Us</a>
            <a href="contact.php" alt="go to contact us">Contact Us</a>
        </div>

        <div id="main" class="main">
            <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>
            <div class=top>
                <h1 style="text-align:center">Post A Blog</h1>
                <hr>
            </div>
          <div class="add_blog">
          
            <form action="submitblog.php" method="post" enctype="multipart/form-data">
            <table>
            <tbody>
            <tr>
                <td><label for="a">Author name: </label></td>
                <td><input type="text" name="author" required></td>
            </tr>
            <tr>
                <td><label for="pc">Post Categoty: </label></td>
                <td><select name="postCat" required>
                    <option value="Tips in footwear">Tips in footwear</option>
                    <option value="Tips in footcare">Tips in footcare</option>
                </select></td>
            </tr>
            <tr>
                <td><label for="ct1">Category Tag1: </label></td>
                <td> <select name="catTag1" required>
                    <option value="Reviews">Reviews</option>
                    <option value="Informative">Informative</option>
                    <option value="StyleTricks">StyleTricks</option>
                </select></td>
            </tr>
            <tr>
                <td><label for="ct2">Category Tag2: </label></td>
                <td> <select name="catTag2" required>
                    <option value="Running">Running</option>
                    <option value="Training">Training</option>
                    <option value="Basketball">Basketball</option>
                    <option value="Football">Football</option>
                    <option value="Others">Others</option>
                </select></td>
            </tr>
            <tr>
                <td><label for="hl">HeadLine: </label></td>
                <td><textarea rows="2" cols="60" name="headline" required></textarea></td>
            </tr>
            <tr>
                <td><label for="img">Featured Image [jpg/jpeg/gif only]: </label></td>
                <td><input type="file" name="image" required accept="image/x-png,image/gif,image/jpeg" /></td>
            </tr>
            <tr>
                <td><label for="intro">Introduction: </label></td>
                <td><textarea rows="10" cols="80" name="introduction" required></textarea></td>
            </tr>
            <tr>
                <td><label for="content" name="ct">Content: </label></td>
                <td><textarea rows="50" cols="80" name="content" required></textarea></td>
            </tr>
            <tr>
                <td><label for="text" name="cl">Conclusion: </label></td>
                <td><textarea rows="10" cols="80" name="conclusion" required></textarea></textarea></td>
            </tr>
        </tbody>
        </table>
            <input type="submit" name="submit" value="Submit">
        </form>
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
    <footer>
            <?php include 'footer.php'; ?>
        </footer>
</body>

</html>