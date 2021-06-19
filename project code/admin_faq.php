<?php 
  
  session_start();   
  include("conndb.php");           
  include("functions.php");

  $user_data = check_login($con);
  generateStyle();
  $errors=array();
  $remove="";

    
    if (isset($_POST['action']) && $_POST['action']=="remove")
    { 
        $sql="select * from faq";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_all($result,MYSQLI_ASSOC);
        foreach($row as $value) 
        {
            $id=$value['id'];
            if($_POST["id"] == $value['id'])
            {   
                $sql="delete from faq where id='$id'";
                mysqli_query($con,$sql);

                $remove = "<div class='cartBox'>
                The Question is removed from your cart!</div>";
            }  
        }   
    }

    if(isset($_POST['insert']))
    {
        $category=$_POST['category'];
        $question=$_POST['question'];
        $answer=$_POST['answer'];
        $pattern = "/^[a-zA-Z\s0-9?.,!:;$%^&*()@#]+$/";
        if($_POST['category']==='none')
        { 
           array_push($errors, "Category is required"); 
        }

        if (empty($question)) 
        { 
           array_push($errors, "Question is required"); 
        }
        else
        {
            if(!preg_match($pattern,$question)) 
            {
                array_push($errors, "Question should contain only letters and numbers.");
            }
        } 
        if (empty($answer)) 
        { 
           array_push($errors, "Answer is required"); 
        }else
        {
            if(!preg_match($pattern,$answer)) 
            {
                array_push($errors, "Answer should contain only letters and numbers.");
            }
        }
        if(count($errors)==0)
        {
            $sql = "insert into faq( category, question, answer)
            values ( '$category ','$question','$answer')";
            mysqli_query($con,$sql);

            echo '<script>alert("Question is added to database.")</script>';
        }
    }

    if(isset($_POST['update']))
    {
        $id=$_POST['id'];
        $pattern = "/^[a-zA-Z\s0-9]+$/";
        if(!($_POST['category']==='none'))
        {
            $category=$_POST['category'];
            if(!preg_match($pattern,$category)) 
            {
                array_push($errors, "Category should contain only letters and numbers.");
            }
            if(count($errors)==0)
            {
                $sql = "update faq set category='$category' where id='$id'";
                mysqli_query($con,$sql);
            }

        }
        if(!empty($_POST['question']))
        {
            $question=$_POST['question'];
            if(!preg_match($pattern,$question)) 
            {
                array_push($errors, "Answer should contain only letters and numbers.");
            }
            if(count($errors)==0)
            {
                $sql = "update faq set question='$question' where id='$id'";
                mysqli_query($con,$sql);
            }

        }
        if(!empty($_POST['answer']))
        {
            $answer=$_POST['answer'];
            if(!preg_match($pattern,$answer)) 
            {
                array_push($errors, "Answer should contain only letters and numbers.");
            }

            if(count($errors)==0)
            {
                $sql = "update faq set answer='$answer' where id='$id'";
                mysqli_query($con,$sql);
            }
        }  
    }

?>

<html>
<head>
    <title>Admin Faq</title>
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

        input[type=text],
        textarea,
        input[type=int] {
            width: 100%;
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
            <a href="shop.php" alt="go to shop">Blog</a>
            <a href="faq.php" alt="go to faq">FAQ</a>
            <a href="aboutus.php" alt="go to about us">About Us</a>
            <a href="contact.php" alt="go to contact us">Contact Us</a>
        </div>

        <div id="main">

            <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>

            <div class="top">
                <h1> Faq </h1>
                <hr>
            </div>
    <div class="admin_faq">
    <div class="display">
    <table class=table>
    <thead>
    <tr>
    <th>Remove</th>
    <th>Id</th>
    <th>Category</th>
    <th>Question</th>
    <th>Answer</th>
    </tr>
    <thead>
    <tbody>
    <?php 

        $sql="select * from faq";
        $result = mysqli_query($con,$sql);

        if($result){
        $rows= mysqli_fetch_all($result,MYSQLI_ASSOC);

        foreach($rows as $row)
        {
            $id=$row['id'];
            $category=$row['category'];
            $question=$row['question'];
            $answer=$row['answer'];
            
    ?>
        <tr>
           <td><form method='post' action=''>
                <input type='hidden' name='id' value="<?php echo $id; ?>" />
                <input type='hidden' name='action' value="remove" />
                <button type='submit' class='remove'><img src="img/bin.png" width="30px" height="30px"></button>
                </form></td>
            <td><?php echo $id?> </td>
            <td><?php echo $category?> </td>
            <td><?php echo $question?> </td>
            <td><?php echo $answer?> </td>
        </tr>
        <?php } }//close foreach and if?>
        </tbody>
        </table>
    </div> <!--display-->
    <?php include('errors.php'); ?>
    <!--form to update faq-->
    <div class="update">
        <h1>Update faq by using id to select.</h1>
    <form method="post">
    <table>
        <tr>
            <td><label for="id"> Id: </label></td>
            <td><input type="text" placeholder="Enter id" name="id" required></td>
        </tr>
        <tr>
            <td><label for="category"> Category: </label></td>
            <td><select name='category' class='category'>
                    <option value="none">-</option>
                    <option value="Order And delivery">Order and Delivery</option>
                    <option value="Return And Refund">Return and Refund</option>
                    <option value="Product And Stock">Product and Stock</option>
                    <option value="Others">Others</option>
            </select></td>
        </tr>
        <tr>
            <td><label for="question"> Question: </label></td>
            <td><textarea rows="6" cols="30"  placeholder="Enter question" name="question"></textArea></td>
        </tr>
        <tr>
            <td><label for="answer"> Answer: </label></td>
            <td><textarea rows="6" cols="30"  placeholder="Enter answer" name="answer"></textArea></td>
        </tr>
    </table>
    <input type="submit" name="update" value="Update">
    </form>
    </div> <!--update-->
    
    <!--form to insert faq-->
    <div class="insert">
        <h1>Insert new frequent asked question.</h1>
    <form method="post">
    <table>
        <tr>
            <td><label for="category"> Category: </label></td>
            <td><select name='category' class='category'>
                    <option value="none">-</option>
                    <option value="Order And delivery">Order and Delivery</option>
                    <option value="Return And Refund">Return and Refund</option>
                    <option value="Product And Stock">Product and Stock</option>
                    <option value="Others">Others</option>
            </select></td>
        </tr>
        <tr>
            <td><label for="question"> Question: </label></td>
            <td><textarea rows="6" cols="30"  placeholder="Enter question" name="question" required></textArea></td>
        </tr>
        <tr>
            <td><label for="answer"> Answer: </label></td>
            <td><textarea rows="6" cols="30"  placeholder="Enter answer" name="answer" required></textArea></td>
        </tr>
    </table>
    <input type="submit" name="insert" value="Insert">
    </form>
    </div> <!--insert-->
    </div> <!--admin_faq-->

    </div><!--close main-->

</div><!--close contain-->

<footer>
    <?php include 'footer.php'; ?>
</footer>
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
</html>