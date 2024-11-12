<?php
@include('../include/connect.php');
@include('../functions_folder/common_function.php');
@session_start();
if(isset($_SESSION['username'])){
    $username=$_SESSION['username'];
    $get_user="SELECT * FROM user_table WHERE user_name = '$username'";
    $get_user_query = mysqli_query($conn, $get_user);
    $row_fetch = mysqli_fetch_assoc($get_user_query);
    $user_id = $row_fetch['user_id'];
}else{
    echo "<script>window.open('../index.php','_self')</script>";
}

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
    <link rel="stylesheet" href="../index.css"/>
    <style>
        
        </style>
</head>
<body>
    <!--nav bar-->
   <div class="container-fluid p-0">
        <!--first child-->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <img src="../images/logo.png" alt="" class="logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="../product.php">Products</a>
                    </li>
                    <?php
                        if(isset($_SESSION['username'])){
                            echo " <li class='nav-item'>
                                <a class='nav-link' href='profile.php'>My Account</a>
                            </li>";
                        }else{
                            echo " <li class='nav-item'>
                                <a class='nav-link' href='user_registration.php'>Register</a>
                            </li>";

                        }
                    ?>
                    <li class="nav-item">
                    <a class="nav-link" href="../contact_design.php">Contact</a>
                    </li> 
                    <li class="nav-item">
                    <a class="nav-link" href="../cart.php">Cart <i class="fa fa-shopping-cart"></i>
                        <sup>
                            <?php
                                cardItem();
                            ?>
                        </sup>
                    </a>
                    </li>
                   
                </ul>
                <form class="d-flex" action="../search_product.php" method="get">
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
                            <a class='nav-link' href='user_login.php' name=''>Login</a>
                        </li> ";
                    }else{
                        echo "<li class='nav-item'>
                             <a class='nav-link' href='logout.php' name=''>Logout</a>
                        </li> ";
                    }
                    ?>
                  
            </ul> 
        </nav>
        <!--third child-->
        <!-- <div class="bg-light">
            <h3 class="text-center ">My Profile</h3>
        </div> -->
            
        <!--Fourth child-->
           <div class="row pt-5">
                <div class="col-md-2 ">
                    <ul class="navbar-nav bg-secondary text-center text-light" >
                        <li class="nav-item bg-info">
                            <a class="nav-link text-light" href="#"><h4 class="text-light">Your Profile</h4></a>
                        </li>
                        <?php
                            $username=$_SESSION['username'];
                            $user_image="Select * from `user_table` where user_name='$username'";
                            $user_image=mysqli_query($conn,$user_image);
                            $row_image=mysqli_fetch_array($user_image);
                            $user_image=$row_image['user_image'];
                            echo "
                            <li class='nav-item '>
                            <img src='./user_images/$user_image' class='profile my-4' alt=''/>
                            </li> ";
                        ?>
                        
                        <li class="nav-item ">
                            <a class="nav-link text-light" href="profile.php"><h5 class="text-light">Pending Orders</h5></a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-light" href="profile.php?edit_account"><h5 class="text-light">Edit Account</h5></a>
                           
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-light" href="profile.php?my_orders"><h5 class="text-light">My Orders</h5></a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-light" href="profile.php?delete_account"><h5 class="text-light">Delete Account</h5></a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-light" href="logout.php"><h5 class="text-light">Logout</h5></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-10">
                    <?php
                         get_user_order_details();
                         if(isset($_GET['edit_account'])){
                            include('edit_account.php');
                         }
                         if(isset($_GET['my_orders'])){
                            include('user_orders.php');
                         }
                         if(isset($_GET['delete_account'])){
                            include('delete_account.php');
                         }
                         ?>
                </div>
           </div>     
           
        <!--last child-->
        <?php
        @include('../include/footer.php');
        ?>
   </div>
    <!--Bootstrap JS link-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>