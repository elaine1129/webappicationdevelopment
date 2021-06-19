<html>

<head>
  <title> Footer</title>
</head>
<style>
    body {
        position: relative;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .footer {
        background-color: rgb(0, 32, 96);
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 100px;
        margin-top: auto;

    }
    

    .footer p {
        color: White;
        font-size: 12px;
        padding: 3px;
        margin: 0px;
        text-align: center;
        font-family: courier;
    }

    .footer>p a{
        display:block;
        background-color: rgb(0, 32, 96);
        width: 100%;
        height: 30px;
        text-decoration: none; 
        color: cyan;
        font-size:20px;
        font-family: courier;
        font-weight: bold;
    }

    .footer div {
        display: flex;
        justify-content: space-between;
    }

    .footer div p {
        padding: 5px;
        display: block;
        text-align: unset;
        margin-top: -20px;
    }
</style>

<body>
    <div class="footer" style="min-width:800px">

    <?php
        
        if(isset($_SESSION['memberId'])||isset($_SESSION['user_id'])||isset($_SESSION['adminId']))
        {
            echo "<p><a href=\"logout.php\">" . "Log out" . "</a>" . "</p>"; 
        }
    

    ?>
        <p>Copyright &copy; 2021 Sportify </p>
        <p>All rights reserved</p>
        <br>
        <div>
            <p>Working hours: 0930-1830(GMT+8) </p>
            <p>Email: admin@sportify.com</p>
        </div>
    </div>

</body>

</html>