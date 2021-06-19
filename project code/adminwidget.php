<?php if (isset($_SESSION['adminId'])) : ?>

    <style>
        .widget {
            /*make widget div same size as the widget image*/
            position: fixed;
            /*scroll liao still fix the position*/
            bottom: 50px;
            left: 10px;
            display: block;
            width: 100px;
            height: 100px;
            z-index: 99;

            /*100, 70*/
        }


        .main-widget {
            /* set widget image size*/
            position: absolute;
            bottom: 0px;
            z-index: 99;
        }

        .widget img:hover {
            border-radius: 50px;
            box-shadow: -1px 5px 29px 9px rgba(171, 235, 194, 0.78);
            -webkit-box-shadow: -1px 5px 29px 9px rgba(171, 235, 194, 0.78);
            -moz-box-shadow: -1px 5px 29px 9px rgba(171, 235, 194, 0.78);
        }

        .content img {
            width: 50px;
            height: 50px;
            border-radius: 80px;
            border: 1px solid black;
            transition: 1s;
            transition-timing-function: cubic-bezier(0.01, 1, 0.8, 1);
            z-index: 0;
        }

        .p1,
        .p2,
        .p3 {
            position: absolute;
            top: 10px;
            left: 30px;
        }

        .widget:hover .p1 {
            top: -55px;
            left: 10px;
        }

        .widget:hover .p2 {
            top: -43px;
            left: 70px;
        }

        .widget:hover .p3 {
            left: 100px;
        }
    </style>
    </head>

    <body>

        <div class="widget">
            <a href="#"><img src="img/edit2.png" class="main-widget" width="100px" height="100px"></a>

            <div class="content">
                <a href="admin_addshoe.php"><img src="img/widgetadd.jpg" title="Add Shoe" class="p1"></a>
                <a href="admin_deleteshoe.php"><img src="img/widgetdelete.jpg" title="Delete Shoe" class="p2"></a>
                <a href="admin_updateshoe.php"><img src="img/widgetupdate.jpg" title="Update Shoe" class="p3"></a>
            </div>
        </div>

    </body>

<?php endif;
