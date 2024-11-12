

<?php
@include('../include/connect.php');
@include('../functions_folder/common_function.php');
@session_start();

if(isset($_GET['user_id'])){
    $user_id = $_GET['user_id'];
} else {
    // Handle the case where user_id is missing
    echo "<script>alert('User ID is missing!');</script>";
    echo "<script>window.open('../index.php','_self')</script>";
    //exit();
}

//getting total items and total price of all items 
$get_ip = getIPAddress();
$total_price = 0;
$cart_query_price = "SELECT * FROM `cart_details` WHERE ip_address='$get_ip'";
$result_cart_price = mysqli_query($conn, $cart_query_price);

$invoice_number = mt_rand();
$status = 'pending';
$count_products = mysqli_num_rows($result_cart_price);

while($row_price = mysqli_fetch_array($result_cart_price)){
    $product_id = $row_price['product_id'];
    $select_product = "SELECT * FROM `products` WHERE product_id='$product_id'";
    $run_price = mysqli_query($conn, $select_product);
    
    while($row_product_price = mysqli_fetch_array($run_price)){
        $product_price = $row_product_price['product_price'];
        $total_price += $product_price;
    }
}

//getting quantity from cart
$get_cart = "SELECT * FROM `cart_details` WHERE ip_address='$get_ip'";
$run_cart = mysqli_query($conn, $get_cart);
$get_item_quantity = mysqli_fetch_array($run_cart);
$quantity = $get_item_quantity['quantity'] ?? 1;
$subtotal = ($quantity == 0) ? $total_price : $total_price * $quantity;

// Insert orders
$insert_orders = "INSERT INTO `user_orders`(user_id, amount_due, invoice_number, total_products, order_date, order_status) 
                  VALUES ('$user_id', '$subtotal', '$invoice_number', '$count_products', NOW(), '$status')";
$result_query = mysqli_query($conn, $insert_orders);

if($result_query){
    echo "<script>alert('Order has been submitted successfully');</script>";
    echo "<script>window.open('profile.php', '_self');</script>";
    // session_destroy();
}

// Insert pending orders for each product in the cart
// while($row_price = mysqli_fetch_array($result_cart_price)){
//     $product_id = $row_price['product_id'];
    $insert_pending_orders = "INSERT INTO `orders_pending`(user_id, invoice_number, product_id, quantity, order_status) 
                              VALUES ('$user_id', '$invoice_number', '$product_id', '$quantity', '$status')";
    $result_query2 = mysqli_query($conn, $insert_pending_orders);
//}

// Delete items from cart
$empty_cart = "DELETE FROM `cart_details` WHERE ip_address='$get_ip'";
$result_delete = mysqli_query($conn, $empty_cart);
?>
