<?php
@include("./include/connect.php");
//getting products
function getProducts(){
    global $conn;
    if(!isset($_GET['category'])){
        if(!isset($_GET['brand'])){
            $select_query="Select * from `products` order by rand() LIMIT 0,9";
            $result_query=mysqli_query($conn,$select_query);
            while($row=mysqli_fetch_assoc($result_query)){
                $product_id=$row['product_id'];
                $product_title=$row['product_title'];
                $product_descriptions=$row['product_description'];
                $product_image1=$row['product_image1'];
                $product_price=$row['product_price'];
                $category_id=$row['category_id'];
                $brand_id=$row['brand_id'];
                echo "
                <div class='col-md-4 mb-2'>
                    <div class='card'>
                        <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_descriptions</p>
                            <p class='card-text'>Rs: $product_price /-</p>
                            <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to cart</a>
                            <a href='products_details.php?product_id=$product_id' class='btn btn-secondary'>View More</a>
                        </div>
                    </div>
                </div>
                ";
            }
        }
    }
}

// function getRecommendedProducts() {
//     global $conn;

//     // Check if user is logged in
//     if (isset($_SESSION['user_id'])) {
//         $user_id = $_SESSION['user_id'];

//         // Fetch user's previous orders
//         $user_orders_query = "SELECT DISTINCT product_id FROM orders_pending WHERE user_id = '$user_id'";
//         $user_orders_result = mysqli_query($conn, $user_orders_query);

//         if ($user_orders_result === false) {
//             echo "<p>Error fetching user orders: " . mysqli_error($conn) . "</p>";
//             return;
//         }

//         if (mysqli_num_rows($user_orders_result) > 0) {
//             // Get the products the user ordered
//             $user_ordered_products = array_column(mysqli_fetch_all($user_orders_result, MYSQLI_ASSOC), 'product_id');
//             // Recommend products based on user's order history and matching keywords
//             recommendBasedOnOrders($user_ordered_products);
//         } else {
//             // No orders, recommend popular products
//             recommendPopularProducts();
//         }
//     } else {
//         // New visitor, recommend popular products
//         recommendPopularProducts();
//     }
// }

// Recommend products based on user's order history and matching keywords
// function recommendBasedOnOrders($ordered_products) {
//     global $conn;
//     echo "<h3 class='text-center'>Recommended Products (Based on Your Orders and Keywords)</h3>";

//     // Fetch keywords of products the user ordered
//     $keywords_query = "SELECT DISTINCT product_keywords 
//                        FROM products 
//                        WHERE product_id IN (" . implode(',', $ordered_products) . ")";
//     $keywords_result = mysqli_query($conn, $keywords_query);

//     if ($keywords_result === false) {
//         echo "<p>Error fetching product keywords: " . mysqli_error($conn) . "</p>";
//         return;
//     }

//     // Get all unique keywords as a string
//     $keywords = [];
//     while ($row = mysqli_fetch_assoc($keywords_result)) {
//         $product_keywords = explode(',', $row['product_keywords']);
//         $keywords = array_merge($keywords, $product_keywords);
//     }

//     // Remove duplicates and trim whitespace
//     $keywords = array_unique(array_map('trim', $keywords));

//     if (!empty($keywords)) {
//         // Prepare the keyword string for REGEXP matching
//         $keyword_string = implode('|', $keywords); // Join keywords for REGEXP
//         echo "<pre>Keyword String for REGEXP: " . htmlentities($keyword_string) . "</pre>";

//         // Query to fetch products that match the keywords (excluding already ordered products)
//         $recommended_products_query = "
//             SELECT * 
//             FROM products 
//             WHERE product_keywords REGEXP '$keyword_string'
//             AND product_id NOT IN (" . implode(',', $ordered_products) . ") 
//             LIMIT 9";
        
//         // Debug: Output the recommended products query for verification
//         echo "<pre>Recommended Products Query: " . htmlentities($recommended_products_query) . "</pre>";

//         $recommended_products_result = mysqli_query($conn, $recommended_products_query);

//         if ($recommended_products_result === false) {
//             echo "<p>Error fetching recommended products: " . mysqli_error($conn) . "</p>";
//             return;
//         }

//         // Display the recommended products
//         displayProducts($recommended_products_result);
//     } else {
//         echo "<p>No matching keywords found for your past orders.</p>";
//     }
// }

// Recommend popular products
// function recommendPopularProducts() {
//     global $conn;
//     echo "<h3 class='text-center'>Popular Products</h3>";

//     // Query to fetch popular products based on number of orders
//     $popular_products_query = "
//         SELECT p.*, COUNT(o.product_id) AS order_count 
//         FROM orders_pending o 
//         JOIN products p ON o.product_id = p.product_id 
//         GROUP BY o.product_id 
//         ORDER BY order_count DESC 
//         LIMIT 9";
    
//     $popular_products_result = mysqli_query($conn, $popular_products_query);

//     if ($popular_products_result === false) {
//         echo "<p>Error fetching popular products: " . mysqli_error($conn) . "</p>";
//         return;
//     }

//     // Display the popular products
//     displayProducts($popular_products_result);
// }

// Helper function to display products
// function displayProducts($result_query) {
//     if ($result_query === false) {
//         echo "<p>Error: Invalid result provided.</p>";
//         return;
//     }

//     if (mysqli_num_rows($result_query) > 0) {
//         while ($row = mysqli_fetch_assoc($result_query)) {
//             echo "
//             <div class='col-md-4 mb-2'>
//                 <div class='card'>
//                     <img src='./admin_area/product_images/{$row['product_image1']}' class='card-img-top' alt='{$row['product_title']}'>
//                     <div class='card-body'>
//                         <h5 class='card-title'>{$row['product_title']}</h5>
//                         <p class='card-text'>Rs: {$row['product_price']} /-</p>
//                         <a href='index.php?add_to_cart={$row['product_id']}' class='btn btn-info'>Add to cart</a>
//                         <a href='products_details.php?product_id={$row['product_id']}' class='btn btn-secondary'>View More</a>
//                     </div>
//                 </div>
//             </div>";
//         }
//     } 
// }





//getting unique categories
function getUniqueCategories(){
    global $conn;
    if(isset($_GET['category'])){
        $category_id=$_GET['category'];
            $select_query="Select * from `products` where category_id=$category_id";
            $result_query=mysqli_query($conn,$select_query);
            $num_of_rows=mysqli_num_rows($result_query);
            if($num_of_rows==0){
                echo "<h2 class='text-center text-danger'>No stock for this Category</h2>";
            }
            while($row=mysqli_fetch_assoc($result_query)){
                $product_id=$row['product_id'];
                $product_title=$row['product_title'];
                $product_descriptions=$row['product_description'];
                $product_image1=$row['product_image1'];
                $product_price=$row['product_price'];
                $category_id=$row['category_id'];
                $brand_id=$row['brand_id'];
                echo "
                <div class='col-md-4 mb-2'>
                    <div class='card'>
                        <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_descriptions</p>
                            <p class='card-text'>Price= Rs: $product_price /-</p>
                             <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to cart</a>
                            <a href='products_details.php?product_id=$product_id' class='btn btn-secondary'>View More</a>
                        </div>
                    </div>
                </div>
                ";
            }
        }
    

}
//getting unique brands
function getUniqueBrands(){
    global $conn;
    if(isset($_GET['brand'])){
        $brand_id=$_GET['brand'];
            $select_query2="Select * from `products` where brand_id=$brand_id";
            $result_query2=mysqli_query($conn,$select_query2);
            $num_of_rows=mysqli_num_rows($result_query2);
            if($num_of_rows==0){
                echo "<h2 class='text-center text-danger'>No stock for this brand</h2>";
            }
            while($row=mysqli_fetch_assoc($result_query2)){
                $product_id=$row['product_id'];
                $product_title=$row['product_title'];
                $product_descriptions=$row['product_description'];
                $product_image1=$row['product_image1'];
                $product_price=$row['product_price'];
                $category_id=$row['category_id'];
                $brand_id=$row['brand_id'];
                echo "
                <div class='col-md-4 mb-2'>
                    <div class='card'>
                        <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_descriptions</p>
                            <p class='card-text'>Price= Rs: $product_price /-</p>
                             <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to cart</a>
                            <a href='products_details.php?product_id=$product_id' class='btn btn-secondary'>View More</a>
                        </div>
                    </div>
                </div>
                ";
            }
        }
    

}
//displaying brands
function getBrands(){
    global $conn;
    $select_brands="Select * from `brands`";
    $result_brands=mysqli_query($conn,$select_brands);
    while( $row_data=mysqli_fetch_assoc($result_brands)){
        $brand_name=$row_data['brand_name'];
        $brand_id=$row_data['brand_id'];
        echo "<li class='nav-item'>
        <a href='product.php?brand=$brand_id' class='nav-link text-light'>$brand_name</a>
        </li>";
    }
}

//displaying categories
function getCategories(){
    global $conn;
    $select_cats="Select * from `categories`";
    $result_cats=mysqli_query($conn,$select_cats);
    while( $row_data=mysqli_fetch_assoc($result_cats)){
        $category_title=$row_data['category_title'];
        $category_id=$row_data['category_id'];
        echo "<li class='nav-item'>
            <a href='product.php?category=$category_id' class='nav-link text-light'>$category_title</a>
                </li>";
    }
}
//get searched products
function searchProducts(){
    global $conn;
    if(isset($_GET['search_data_product'])){

        $search_data_value=$_GET['search_data'];
            $search_query="Select * from `products` where product_keywords like '%$search_data_value%'";
            $result_query=mysqli_query($conn,$search_query);
            $num_of_rows=mysqli_num_rows($result_query);
            if($num_of_rows==0){
                echo "<h2 class='text-center text-danger'>No results match. No products fond for this category!</h2>";
                //echo "<script>window.location.href='index.php';</script>";
            }
            while($row=mysqli_fetch_assoc($result_query)){
                $product_id=$row['product_id'];
                $product_title=$row['product_title'];
                $product_descriptions=$row['product_description'];
                $product_image1=$row['product_image1'];
                $product_price=$row['product_price'];
                $category_id=$row['category_id'];
                $brand_id=$row['brand_id'];
                echo "
                <div class='col-md-4 mb-2'>
                    <div class='card'>
                        <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_descriptions</p>
                            <p class='card-text'>Rs: $product_price /-</p>
                             <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to cart</a>
                            <a href='products_details.php?product_id=$product_id' class='btn btn-secondary'>View More</a>
                        </div>
                    </div>
                </div>
                ";
            }
        }
}
//view details 
function viewDetails(){
    global $conn;
    if(isset($_GET['product_id'])){
        if(!isset($_GET['category'])){
            if(!isset($_GET['brand'])){
                $product_id=$_GET['product_id'];
                $select_query="Select * from `products` where product_id=$product_id";
                $result_query=mysqli_query($conn,$select_query);
                while($row=mysqli_fetch_assoc($result_query)){
                    $product_id=$row['product_id'];
                    $product_title=$row['product_title'];
                    $product_descriptions=$row['product_description'];
                    $product_image1=$row['product_image1'];
                    $product_image2=$row['product_image2'];
                    $product_image3=$row['product_image3'];
                    $product_price=$row['product_price'];
                    $category_id=$row['category_id'];
                    $brand_id=$row['brand_id'];
                    echo "
                    <div class='col-md-4 mb-2'>
                        <div class='card'>
                            <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                            <div class='card-body'>
                                <h5 class='card-title'>$product_title</h5>
                                <p class='card-text'>$product_descriptions</p>
                                <p class='card-text'>Rs: $product_price /-</p>
                                 <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to cart</a>
                                <a href='products_details.php?product_id=$product_id' class='btn btn-secondary'>View More</a>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-8'>
                            <!--Related images-->
                            <div class='row'>
                                <div class='col-md-12'>
                                    <h4 class='text-center text-info mb-5'>Related Products</h4>
                                </div>
                                <div class='col-md-6'>
                                <img src='./admin_area/product_images/$product_image2' class='card-img-top' alt='$product_title'>
                                </div>
                                <div class'col-md-6'>
                                <img src='./admin_area/product_images/$product_image3' class='card-img-top' alt='$product_title'>
                                </div>
                            </div>
                        </div>
                    ";
                }
            }
        }
    }
}
//get ip address
function getIPAddress() {  
    //whether ip is from the share internet  
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
    //whether ip is from the remote address  
    else{  
             $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
}  

//cart function
function cart(){
    if(isset($_GET['add_to_cart'])){
        global $conn;

        $ip = getIPAddress();
        $get_product_id=$_GET['add_to_cart'];
        $select_query="Select * from `cart_details` where ip_address='$ip'and product_id=$get_product_id";
        $result_query=mysqli_query($conn,$select_query);
        $num_of_rows=mysqli_num_rows($result_query);
            if($num_of_rows>0){
                echo "<script>
                        alert('Item is already present inside cart')
                      </script>";
               echo "<script>window.open('product.php','_self')</script>";
            }else{
                $insert_query="INSERT INTO `cart_details` (product_id, ip_address, quantity) VALUES ($get_product_id, '$ip', 1)";
                $result_query=mysqli_query($conn,$insert_query);
                echo "<script>
                            alert('Item is added to cart')
                        </script>";
                echo "<script>window.open('product.php','_self')</script>";
            }
        }
        
}


//get cart items numbers
function cardItem(){
    if(isset($_GET['add_to_cart'])){
        global $conn;

        $ip = getIPAddress();
        $get_product_id=$_GET['add_to_cart'];
        $select_query="Select * from `cart_details` where ip_address='$ip'";
        $result_query=mysqli_query($conn,$select_query);
        $count_cart_items=mysqli_num_rows($result_query);
    }else{
        global $conn;
        $ip = getIPAddress();
        $select_query="Select * from `cart_details` where ip_address='$ip' ";
        $result_query=mysqli_query($conn,$select_query);
        $count_cart_items=mysqli_num_rows($result_query);
    }
    echo $count_cart_items;
}
//total price
function getTotalPrice(){
    global $conn;
    $ip = getIPAddress();
    $total_price=0;
    $cart_query="Select * from `cart_details` where ip_address='$ip' ";
    $result_query=mysqli_query($conn,$cart_query);
    while($row=mysqli_fetch_array($result_query)){
        $product_id=$row['product_id'];
        $select_products="Select * from `products` where product_id='$product_id' ";
        $result_products=mysqli_query($conn,$select_products);
        while($row_product_price=mysqli_fetch_array($result_products)){
            $product_price=array($row_product_price['product_price']);
            $product_values=array_sum($product_price);
            $total_price+=$product_values;
        }
    }
    echo $total_price;
}
//get user order details
function get_user_order_details(){
    global $conn;
    $username=$_SESSION['username'];
    $get_details="Select * from `user_table` where user_name='$username'";
    $result_query=mysqli_query($conn,$get_details);
    while($row_query=mysqli_fetch_array($result_query)){
        $user_id=$row_query['user_id'];
        if(!isset($_GET['edit_account'])){
            if(!isset($_GET['my_orders'])){
                if(!isset($_GET['delete_account'])){
                    $get_orders="Select * from `user_orders` where user_id=$user_id and order_status='pending'";
                    $result_orders_query=mysqli_query($conn,$get_orders);
                    $row_count=mysqli_num_rows($result_orders_query);
                    if($row_count>0){
                        echo "<h3 class='text-center text-success mt-5 mb-2'>You have <span class='text-danger'>$row_count</span> pending orders</h3>
                        <p class='text-center'><a href='profile.php?my_orders' class='text-dark'>Order Details</a></p>";
                    }else{
                        echo "<h3 class='text-center text-success mt-5 mb-2'>You have zero pending orders</h3>
                        <p class='text-center'><a href='../index.php' class='text-dark'>Explore Products</a></p>";
                    }
                }
            }
        }
    }
}

?>