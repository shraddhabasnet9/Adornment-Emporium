<?php
@include('../include/connect.php');
@include('../functions_folder/common_function.php');
@session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!--Bootstrap link-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <!-- Font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--Css file link-->
    <link rel="stylesheet" href="../index.css"/>
    <style>
        .poduct_img{
            width: 100px;
            object-fit: contain;
        }

    </style>
</head>
<body>
     <!--nav bar-->
   <div class="container-fluid p-0">
    <!--first Child-->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <img src="../images/logo.png" alt="" class="logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <?php
                            if(isset($_SESSION['admin_username'])){
                                echo "<li class='nav-item'>
                                    <a class='nav-link' href='#' name=''>Welcome ".$_SESSION['admin_username']."</a>
                                </li> ";
                                echo "<li class='nav-item'>
                                    <a class='nav-link' href='admin_logout.php' name=''>Logout</a>
                                </li> ";
                            }else{
                                echo "<script>window.open('admin_login.php','_self')</script>";
            
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!--Second Child-->
        <div class="bg-light">
            <h3 class="text-center p-2">Manage details</h3>
        </div>
        <!--Third Child-->
        <div class="row ">
            <div class="col-md-12 bg-secondary p-1 d-flex align-items-center">
                <div class="p-3">
                <div class="col-md-3">
                    <ul class="navbar-nav bg-secondary text-center text-light" >
                        <?php
                            if (isset($_SESSION['admin_username'])) {
                                // Get admin username from the session
                                $admin_username = $_SESSION['admin_username'];
                                
                                // Query to get admin details including the image
                                $query = "SELECT * FROM `admin_table` WHERE admin_username = '$admin_username'";
                                $result = mysqli_query($conn, $query);
                                
                                if ($result) {
                                    $row = mysqli_fetch_array($result);
                                    $admin_image = $row['admin_image']; // Path to the admin image

                                    // Display the profile image
                                    echo "
                                    <li class='nav-item'>
                                        <img src='./admin_images/$admin_image' class='profile p-0 ' alt='Admin Profile' style='width: 100px; height: 100px; object-fit: cover;' />
                                    </li>";
                                    
                                    // Display the admin username
                                    echo "<p class='text-light text-center'>" . htmlspecialchars($admin_username) . "</p>";
                                } 
                            } 
                        ?>
                    </ul>
                </div>
                </div>
                <div class="col-md-9">
                <div class="button text-center">
                    <button class="my-3"><a href="insert_product.php?insert_product" class="nav-link text-light bg-info my-1">Insert Products</a></button>
                    <button class="mb-4"><a href="index.php?view_products" class="nav-link text-light bg-info my-1">View Products</a></button>
                    <button class="my-3"><a href="index.php?insert_category" class="nav-link text-light bg-info my-1">Insert categories</a></button>
                    <button class="my-3"><a href="index.php?view_categories" class="nav-link text-light bg-info my-1">View Categories</a></button>
                    <button class="my-3"><a href="index.php?insert_brand" class="nav-link text-light bg-info my-1">Insert Brands</a></button>
                    <button class="my-3"><a href="index.php?view_brands" class="nav-link text-light bg-info my-1">View Brands</a></button>
                    <button><a href="index.php?list_orders" class="nav-link text-light bg-info my-1">All Orders</a></button>
                    <button><a href="index.php?list_payments" class="nav-link text-light bg-info my-1">All Payments</a></button>
                    <button class="mb-4"><a href="index.php?list_users" class="nav-link text-light bg-info my-1">List Users</a></button>
                </div>
                </div>
            </div>
        </div>
        <!--fourth child-->
        <div class="container my-2">
            <?php
                if(isset($_GET['insert_product'])){
                    include('insert_product.php');
                }
                if(isset($_GET['view_products'])){
                    include('view_products.php');
                }
                if(isset($_GET['edit_products'])){
                    include('edit_products.php');
                }
                if(isset($_GET['delete_product'])){
                    include('delete_products.php');
                }
                if(isset($_GET['insert_category'])){
                    include('insert_categories.php');
                }
                if(isset($_GET['view_categories'])){
                    include('view_categories.php');
                }
                if(isset($_GET['edit_category'])){
                    include('edit_category.php');
                }
                if(isset($_GET['remove_category'])){
                    include('delete_category.php');
                }

                if(isset($_GET['insert_brand'])){
                    include('insert_brands.php');
                }
                if(isset($_GET['view_brands'])){
                    include('view_brands.php');

                }
                if(isset($_GET['edit_brands'])){
                    include('edit_brands.php');
                }
                if(isset($_GET['remove_brand'])){
                    include('delete_brands.php');
                }
            
                if(isset($_GET['list_users'])){
                    include('list_users.php');
                }
                
                if(isset($_GET['list_orders'])){
                    include('list_orders.php');
                }
                if(isset($_GET['delete_order'])){
                    include('delete_orders.php');
                }
                if(isset($_GET['list_payments'])){
                    include('list_payments.php');
                }
                if(isset($_GET['delete_payment'])){
                    include('delete_payments.php');
                }
            ?>
        </div>
        <!--last child-->
        <?php include("../include/footer.php") ?>
        
    </div>
    <!--Bootstrap JS link-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>