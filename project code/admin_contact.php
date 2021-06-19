<?php

    session_start();   
    include("conndb.php");           
    include("functions.php");

    $user_data = check_login($con);
    generateStyle();
    $errors=array();
    $remove="";

    /*admin change enquiry status */
    if (isset($_POST['action']) && $_POST['action']=="change"){
        $sql="select * from enquiry";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_all($result,MYSQLI_ASSOC);

        foreach($row as &$value)
        {
          if($value['id'] === $_POST["id"]){
                $id=$value['id'];
                $status= $_POST['status'];
              
              mysqli_data_seek($result, 0);
              $sql= "UPDATE `enquiry` SET `status`='$status' WHERE id='$id'";
              mysqli_query($con,$sql);
              break; // Stop the loop after we've found the product
          }
        }
        
    }

    if (isset($_POST['action']) && $_POST['action']=="remove"){
       
        $sql="select * from enquiry";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_all($result,MYSQLI_ASSOC);
        foreach($row as &$value) 
        {
            $id=$value['id'];
            //remove item
            if($_POST["id"] == $value['id'])
            {
                $id=$value['id'];
                $sql="delete from enquiry where id='$id'";
                mysqli_query($con,$sql);

                $remove = "<div class='cartBox'>
                Enquiry is removed from your database!</div>";
            }
    }
}

?>

<html>

<head>
    <title>Contact Us</title>
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

            <form class="form" method="post">

            <div class="top">
                <h1> Contact us </h1>
                <hr>
            </div>
            <div class="admin_contact">
                <div class="enquiry_ur">
                <h1>Users' enquiry(unread)</h1>
                
                <table>
                <thead>
                    <tr>
                        <th>Remove</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Subject</th>
                        <th>Status</th>
                    </tr>
                    <thead>
                    <?php 
           
             
                    $sql="select * from enquiry where status='unread'";
                    $result = mysqli_query($con,$sql);
                    $rows= mysqli_fetch_all($result,MYSQLI_ASSOC);

                    echo "<tbody>";
                    foreach($rows as $row)
                    {
                        $id=$row['id'];
                        $name=$row['name'];
                        $email=$row['email'];
                        $address=$row['address'];
                        $phone=$row['phone'];
                        $type=$row['type'];
                        $subject=$row['subject'];
                        $status=$row['status'];
            ?>
            
                <tr>
                    <td><form method='post' action=''>
                            <input type='hidden' name='id' value="<?php echo $id; ?>" />
                            <input type='hidden' name='action' value="remove" />
                            <button type='submit' class='remove'><img src="img/bin.png" width="30px" height="30px"></button>
                    </form></td>
                    <td><?php echo $name?> </td>
                    <td><?php echo "<a href=\"mailto:" . $email ."\">".$email?></td>
                    <td><?php echo $address?> </td>
                    <td><?php echo $phone?> </td>
                    <td><?php echo $type?> </td>
                    <td><?php echo $subject?> </td>
                    <td>
                        <form method='post' action=''>
                        <input type='hidden' name='id' value="<?php echo $id ?>" />
                        <input type='hidden' name='action' value="change" />
                        <select name='status' class='status' onchange="this.form.submit()">
                                <option <?php if($status=='unread') echo "selected" ;?> value="unread">Unread</option>
                                <option <?php if($status=='read') echo "selected" ;?> value="read">Read</option>
                                <option <?php if($status=='replied') echo "selected" ;?> value="replied">Replied</option>
                        </select>
                        
                        </form>
                    </td>
                </tr>
                
                    <?php } //close foreach?>
                    </tbody>
            </table>
            </div>
            <div class="message_box" style="margin:10px 0px;">
                <?php echo $remove; ?>
            </div>
            <div class="enquiry_rr">
            <h1>Users' enquiry(read&replied)</h1>
            <table>
                <thead>
                    <tr>
                        <th>Remove</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Subject</th>
                        <th>Status</th>
                    </tr>
                    <thead>
                    <?php 
           
             
                    $sql="select * from enquiry where status='read' or status='replied'";
                    $result = mysqli_query($con,$sql);
                    $rows= mysqli_fetch_all($result,MYSQLI_ASSOC);

                    echo "<tbody>";
                    foreach($rows as $row)
                    {
                        $id=$row['id'];
                        $name=$row['name'];
                        $email=$row['email'];
                        $address=$row['address'];
                        $phone=$row['phone'];
                        $type=$row['type'];
                        $subject=$row['subject'];
                        $status=$row['status'];
            ?>
            
                <tr>
                    <td><form method='post' action=''>
                            <input type='hidden' name='id' value="<?php echo $id; ?>" />
                            <input type='hidden' name='action' value="remove" />
                            <button type='submit' class='remove'><img src="img/bin.png" width="30px" height="30px"></button>
                    </form></td>
                    <td><?php echo $name?> </td>
                    <td><?php echo "<a href=\"mailto:" . $email ."\">".$email?></td>
                    <td><?php echo $address?> </td>
                    <td><?php echo $phone?> </td>
                    <td><?php echo $type?> </td>
                    <td><?php echo $subject?> </td>
                    <td>
                        <form method='post' action=''>
                        <input type='hidden' name='id' value="<?php echo $id ?>" />
                        <input type='hidden' name='action' value="change" />
                        <select name='status' class='status' onchange="this.form.submit()">
                                <option <?php if($status=='read') echo "selected" ;?> value="read">Read</option>
                                <option <?php if($status=='replied') echo "selected" ;?> value="replied">Replied</option>
                        </select>
                        
                        </form>
                    </td>
                </tr>
                
                    <?php } //close foreach?>
                    </tbody>
                </table>
            </div><!--close enquiry_rr-->
            </div><!--close admin_contact-->
            
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