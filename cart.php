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
        .cart_image{
            width: 50px;
            height:50px ;
            object-fit: contain;
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
        <!--Third Child-->
        <div class="bg-light">
            <h3 class="text-center ">My Cart Products</h3>
        </div>
        <!--Fourth Child-->
        <div class="container">
            <div class="row">
                <form action="" method="post">
                   <table class="table table-bordered text-center">
                       <tbody class="text-center">
                            <!--php code to display dynamic cart items-->
                            <?php
                                global $conn;
                                $ip = getIPAddress();
                                $total_price=0;
                                $cart_query="Select * from `cart_details` where ip_address='$ip'";
                                $result_query=mysqli_query($conn,$cart_query);
                                $result_count=mysqli_num_rows($result_query);
                                if($result_count>0){
                                    echo "
                                        <thead>
                                            <tr>
                                                <th>Product Title</th>
                                                <th>Product Image</th>
                                                <th>Quantity</th>
                                                <th>Total Price</th>
                                                <th>Remove</th>
                                                <th colspan='2'>Operations</th>
                                            </tr>
                                        </thead>";
                                        while ($row = mysqli_fetch_array($result_query)) {
                                            $product_id = $row['product_id'];
                                            $cart_quantity = $row['quantity'];
                                            // Fetch product details based on product ID
                                            $select_product = "SELECT * FROM `products` WHERE product_id='$product_id'";
                                            $product_result = mysqli_query($conn, $select_product);
                                            $product_row = mysqli_fetch_array($product_result);
                                            $product_title = $product_row['product_title'];
                                            $product_image1 = $product_row['product_image1'];
                                            $product_price = $product_row['product_price'];
                                            // Calculate total price for this product
                                            $product_total_price = $product_price * $cart_quantity;
                                            $total_price += $product_total_price;
                            ?>
                                            <tr> 
                                                <td><?php echo $product_title ?></td>
                                                <td><img src="./admin_area/product_images/<?php echo $product_image1?>" alt="" class="cart_image"></td>
                                                <td><input type="number" name="qty[<?php echo $product_id; ?>]" class="form-input w-50" 
                                                value="<?php 
                                                echo isset($_POST['qty'][$product_id]) ? $_POST['qty'][$product_id] : $cart_quantity;  
                                                ?>"></td>
                                                <?php  
                                                    if (isset($_POST['update_cart'])) {
                                                        $ip = getIPAddress();
                                                        $quntity_updated=false;
                                                        if (isset($_POST['qty']) && is_array($_POST['qty'])) {
                                                            foreach ($_POST['qty'] as $product_id => $quantities) {
                                                                // Check if quantities is provided and is greater than 0
                                                                $quantities = (!empty($quantities) && $quantities > 0) ? $quantities : null; 
                                                                // Only update if a valid quantity is provided
                                                                //  if ($quantities !== null) {
                                                                if($quantities>0){
                                                                    $update_cart = "UPDATE `cart_details` SET quantity=$quantities WHERE ip_address='$ip' AND product_id='$product_id'";
                                                                    mysqli_query($conn, $update_cart);
                                                                    $quntity_updated=true;
                                                                    // $_POST['qty']=$quantities;
                                                                    // echo "<script>alert('Quantity updated successfully');</script>";
                                                                    // echo "<script>window.open('cart.php','_self');</script>";
                                                                    //exit();
                                                                }
                                                                else{
                                                                    echo "<script>alert('Quantity for product_id $product_id  couldnot be updated');</script>";
                                                                    echo "<script>window.open('cart.php','_self');</script>";
                                                                    exit();
                                                                }
                                                            }
                                                        }
                                                        if($quntity_updated){
                                                            echo "<script>alert('Quantity updated successfully');</script>";
                                                            echo "<script>window.open('cart.php','_self');</script>";
                                                        }
                                                    }
                                                ?>
                                                <td><?php echo  $product_total_price;?></td>
                                                <td><input type="checkbox" name="removeitem[]" value="<?php echo $product_id ?>"></td>
                                                <td>
                                                    <input type="submit" value="Update cart" class="bg-info px-3 py-2 border-0 mx-3" name="update_cart">
                                                    <input type="submit" value="Remove cart" class="bg-info px-3 py-2 border-0 mx-3" name="remove_cart">
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else{
                                        echo "<h2 class='text-center text-danger'>cart is empty</h2>";
                                    }
                                            ?>
                        </tbody>
                   </table> 
                    <!--subTotal-->
                    <div class="d-flex mb-5">
                        <?php
                           // global $conn;
                            $ip = getIPAddress();
                            $cart_query="Select * from `cart_details` where ip_address='$ip'";
                            $result_query=mysqli_query($conn,$cart_query);
                            $result_count=mysqli_num_rows($result_query);
                            if($result_count>0){
                                echo "
                                    <h4 class='px-3'>SubTotal:<strong class='text-info'> $total_price /-</strong></h4>
                                    <input type='submit' name='continue_shopping' value='Continue Shopping' class='bg-info px-3 py-2 border-0 mx-3'>
                                    <input type='submit' name='checkout_now' value='Checkout Now' class='bg-secondary p-3 py-2 border-0 mx-3 text-light'>
                                ";
                            }
                            else{
                                echo "<input type='submit' name='continue_shopping' value='Continue Shopping' class='bg-info px-3 py-2 border-0 mx-3'>";
                            }
                            if(isset($_POST['continue_shopping'])){
                                echo "<script>window.open('index.php','_self')</script>";
                            }
                            if(isset($_POST['checkout_now'])){
                                echo "<script>window.open('./user_area/checkout.php','_self')</script>";
                            }
                        ?>
                        
                    </div>
                </form>
                <!--remove item-->
                <?php
                    function remove_cart_item(){
                        global $conn;
                        if(isset($_POST['remove_cart']) && isset($_POST['removeitem']) && is_array($_POST['removeitem'])){
                            foreach($_POST['removeitem'] as $remove_id){
                                $delete_query="DELETE FROM `cart_details` WHERE product_id=$remove_id";
                                $run_delete=mysqli_query($conn, $delete_query);
                                if($run_delete){
                                    echo "<script>window.open('cart.php','_self')</script>";
                                }
                            }
                        }
                    }    
                    echo $remove_item=remove_cart_item();
                ?>
           </div>
       </div>
        <!--last child-->
        <?php
        @include('./include/footer.php');
        ?>
   </div>
    <!--Bootstrap JS link-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>