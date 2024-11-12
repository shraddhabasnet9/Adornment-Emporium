<?php
@include('include/connect.php');
@include('functions_folder/common_function.php');
@session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adornment Emporium</title>
    <!--Bootstrap link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Font awesome link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--Css file link-->
    <link rel="stylesheet" href="index.css"/>
    <style>
        /* #hero{
            background-image: url("./images/66.jpg");
            height: 90vh;
            width:100%;
            background-size:cover;
            background-position:top 70% right 0 ;
            padding: 0 25px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
        } */
        #hero {
            position: relative;
            height: 90vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            padding: 0 25px;
            overflow: hidden;
        }

        #background-video {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            object-fit: cover;
            z-index: -1; /* Sends the video to the background */
        }

        .content {
            position: relative;
            z-index: 1; /* Ensures content appears above the video */
        }

       
        #hero p{
            font-size:16px;
            color: rgb(26, 85, 85);
            margin: 15px 0 20px 0;
        }
        #hero h2{
            font-size:45px;
            color: black;
        }
        #hero h4{
            font-size:30px;
            color: black;
        }
        #hero h1{
            font-size:50px;
            color:rgb(93, 97, 96)
        }
        #hero button {
            border:none;
        }
        #hero button a{
            background-color: rgb(99, 127, 123);
            border:none;
            box-shadow: 0 0 4px rgba(28, 27, 27, 0.03);
            padding: 10px 56px;
            margin:15px 0;
            cursor: pointer;
            font-weight:700;
            font-size: 18px;
            color:rgb(9, 9, 9);
            text-decoration: none;
        }
        #hero button a:hover{
            background-color: green;
            color: #ccc;
        }
        #feature{
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        #feature .fe-box{
            width:180px;
            text-align: center;
            padding: 25px 15px;
            box-shadow: 20px 20px 4px rgb(0, 0,0,0.03);
            border:1px solid rgb(233, 243, 243);
            border-radius: 4px;
            margin: 15px 0;
        }

        #feature .fe-box:hover{
            box-shadow: 10px 10px 54px rgb(76, 76, 76);;
        }
        #feature .fe-box img{
            width:100%;
            margin-bottom: 10px;
        }
        #feature .fe-box h6{
            display: inline-block;
            padding: 9px 8px 6px 8px;
            line-height: 1;
            border-radius: 4px;
            color: #106054;
            background-color: rgb(176, 225, 232);

        }
        #feature .fe-box:nth-child(2) h6{
            background-color: rgb(202, 217, 37);
        }
        #feature .fe-box:nth-child(3) h6{
            background-color: rgb(166, 159, 181);
        }
        #feature .fe-box:nth-child(4) h6{
            background-color: rgb(223, 121, 145);
        }
        #feature .fe-box:nth-child(5) h6{
            background-color: rgb(228, 176, 244);
        }
        #feature .fe-box:nth-child(6) h6{
            background-color: rgb(241, 41, 205);
        }

    </style>
    
</head>
<body>
    <!--nav bar-->
   <div class="container-fluid p-0">
        <!--first child-->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <img src="./images/logo.png" alt="" class="logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="product.php">Products</a>
                    </li>
                    <?php
                        if(isset($_SESSION['username'])){
                            echo " <li class='nav-item'>
                                <a class='nav-link' href='user_area/profile.php'>My Account</a>
                            </li>";
                        }else{
                            echo " <li class='nav-item'>
                                <a class='nav-link' href='user_area/user_registration.php'>Register</a>
                            </li>";

                        }
                    ?>
                    <li class="nav-item">
                    <a class="nav-link" href="contact_design.php">Contact</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart <i class="fa fa-shopping-cart"></i>
                        <sup>
                            <?php
                                cardItem();
                            ?>
                        </sup>
                    </a>
                    </li>
                    
                </ul>
                <form class="d-flex" action="search_product.php" method="get">
                    <input class="form-control me-2" type="search" placeholder="Search" name="search_data" aria-label="Search">
                    <!-- <button class="btn btn-outline-light" type="submit">Search</button> -->
                     <input type="submit" value="search" class="btn btn-outline-light" name="search_data_product">
                </form>
                </div>
            </div>
        </nav>
        <!--calling cart function-->
        <?php
            cart();
        ?>
        <!--Second Child-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <ul class="navbar-nav me-auto">
                <?php
                    if(!isset($_SESSION['username'])){
                        echo "<li class='nav-item'>
                            <a class='nav-link' href='#' name=''>Welcome Guest</a>
                        </li> ";
                    }else{
                        echo "<li class='nav-item'>
                            <a class='nav-link' href='#' name=''>Welcome ".$_SESSION['username']."</a>
                        </li> ";
                    }
                    if(!isset($_SESSION['username'])){
                        echo "<li class='nav-item'>
                            <a class='nav-link' href='./user_area/user_login.php' name=''>Login</a>
                        </li> ";
                    }else{
                        echo "<li class='nav-item'>
                             <a class='nav-link' href='./user_area/logout.php' name=''>Logout</a>
                        </li> ";
                    }
                    ?>
                  
            </ul> 
        </nav>
        <div id="hero">
            <video autoplay muted loop id="background-video">
                <source src="./images/2.mp4" type="video/mp4">
            </video>
            <h4>Welcome to Our Adornment Emporium</h4>
            <h2>Super value deals on </h2>
            <h1> all Products</h1>
            <p>Explore unique, locally crafted jewelry and artisanal designs.</p>
            <button type="submit"><a href="product.php">Shop Now</a></button>
        </div>
        <h2  class="text-center">Our Features</h2>
        <div id="feature" class="section-p1">
            
            <div class="fe-box">
                <img src="./images/shipping.jpg" alt="">
                <h6>Free shipping</h6>
            </div>
            <div class="fe-box">
                <img src="./images/shopping.png" alt="">
                <h6>online order</h6>
            </div>
            <div class="fe-box">
                <img src="./images/m.jpg" alt="">
                <h6>Happy sell</h6>
            </div>
            <div class="fe-box">
                <img src="./images/buying.png" alt="">
                <h6>save money</h6>
            </div>
            <div class="fe-box">
                <img src="./images/g.png" alt="">
                <h6>save time</h6>
            </div>
            <div class="fe-box">
        <img src="./images/i.jpg" alt="">
        <h6>feedback</h6>
      </div>
        </div>
        <!-- <div class="bg-light mt-3">
            <h3 class="text-center ">Related Products</h3>
        </div> -->
            
        <!--Fourth child-->
            <div class="row px-3">
                <div class="col"> 
                <!--Products-->
                    <div class="row">
                       <!--Products fetched from db -->
                        <?php 
                                                    
                            // Call to display recommended products
                            //getRecommendedProducts();


                            
                           // displayProducts();
                            // getUniqueCategories();
                            // getUniqueBrands();
                        ?>
                    </div>
                </div>
            </div>
                <!-- <div class="col-md-2 bg-secondary p-0"> -->
                    <!--Brands to be displayed-->
                    <!-- <ul class="navbar-nav me-auto text-center" >
                        <li class="nav-item bg-info">
                            <a href="#" class="nav-link text-light"><h4>Delivery Brands</h4></a>
                        </li> -->
                        <?php
                            // getBrands();
                            
                        ?>
                    <!-- </ul> -->
                    <!--Categories to be displayed-->
                    <!-- <ul class="navbar-nav me-auto text-center" >
                        <li class="nav-item bg-info">
                            <a href="#" class="nav-link text-light"><h4>Categories</h4></a>
                        </li> -->
                        <?php
                        //    getCategories();
                        ?>
                    <!-- </ul>
                </div>
           </div>       -->
            
        <!--last child-->
        <?php
        @include('./include/footer.php');
        ?>
   </div>
    <!--Bootstrap JS link-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>