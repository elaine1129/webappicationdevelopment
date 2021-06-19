<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportify";

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully <br/>";
    $stmt1 = $connection->prepare("SELECT COUNT(*) FROM blog");
    $stmt1->execute();
    $count = $stmt1->fetchAll();
    var_dump($count);
    echo ($count[0][0]);
    $count1 = $count[0][0] + 1;
    date_default_timezone_set("ETC/GMT-8");
    $date = date("y-m-d H:i:s");
    $headline = $_POST['headline'];
    $imgtemp = $_FILES['image']['tmp_name']; // need add enctype="multipart/form-data" to the form
    $img1 = addslashes(file_get_contents($imgtemp));
    $introduction = $_POST['introduction'];
    $author = $_POST['author'];
    $postCat = $_POST['postCat'];
    $catTag1 = $_POST['catTag1'];
    $catTag2 = $_POST['catTag2'];
    $content = $_POST['content'];
    $conclusion = $_POST['conclusion'];

        $stmt2 = $connection->prepare("INSERT INTO blog( blogId, headline,img1,introduction,publishDate,author,postCat,catTag1,catTag2,content,conclusion)
        VALUES('b{$count1}', '$headline', '$img1' , '$introduction','$date' ,'$author','$postCat','$catTag1' ,'$catTag2' ,'$content','$conclusion')");
        $stmt2->execute();

        echo "<script>alert('The blog have been inserted successfully');</script>";
        header("location:blog.php");
    
    //header("location: blogtry . php");
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
