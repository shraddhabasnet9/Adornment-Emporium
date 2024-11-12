<?php
@include('../include/connect.php');
@session_start();

if (isset($_POST['insert_product'])) {
    $product_title = trim($_POST['product_title']);
    $product_description = trim($_POST['product_description']);
    $product_keywords = trim($_POST['product_keywords']);
    $product_categories = $_POST['product_categories'];
    $product_brands = $_POST['product_brands'];
    $product_price = $_POST['product_price'];
    $product_status = 'true';

    // Accessing images
    $images = ['product_image1', 'product_image2', 'product_image3'];
    $image_errors = [];

    // Validation helper function
    function validate_image($image, $max_size = 5 * 1024 * 1024) {
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        if (empty($image['name'])) {
            return "Image is required.";
        } elseif (!in_array($file_extension, $allowed_extensions)) {
            return "Only JPG, JPEG, PNG files are allowed.";
        } elseif ($image['size'] > $max_size) {
            return "Image size should not exceed 5MB.";
        }
        return "";
    }

    // Validate fields
    $titleError = $priceError =$descError=$keywordsError=$categoryError=$brandError= "";

    if (empty($product_title)) {
        $titleError = 'Title is required';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $product_title)) {
        $titleError = 'Title can only contain letters and spaces';
    }
    if (empty($product_description)) {
        $descError = 'Description is required';
    }
    if (empty($product_keywords)) {
        $keywordsError = 'keyword is required';
    }
    if(empty($product_categories)){
        $categoryError='Category must be selected';
    }
    if(empty($product_brands)){
        $brandError='Brand must be selected';
    }
    if (empty($product_price)) {
        $priceError = 'Price is required';
    } elseif (!is_numeric($product_price) || $product_price <= 0) {
        $priceError = 'Price must be a valid number greater than zero';
    }

    // Validate images
    foreach ($images as $key => $image) {
        $image_errors[$key] = validate_image($_FILES[$image]);
    }

    // Check for errors before inserting
    if (empty($titleError) && empty($priceError) && empty($descError) && empty($keywordsError) && empty($categoryError) && empty($brandError) && empty(array_filter($image_errors))) {
        // Check for duplicate products for the same brand
        $check_product_query = $conn->prepare("SELECT * FROM products WHERE product_title = ? AND brand_id = ?");
        $check_product_query->bind_param('si', $product_title, $product_brands);
        $check_product_query->execute();
        $check_result = $check_product_query->get_result();

        if ($check_result->num_rows > 0) {
            echo "<script>alert('This product already exists for the selected brand. Please choose a different product or brand.'); window.location.href='insert_product.php';</script>";
        } else {
            // Insert query with prepared statements
            $insert_products = $conn->prepare("INSERT INTO products (product_title, product_description, product_keywords, category_id, brand_id, product_image1, product_image2, product_image3, product_price, date, status) 
                                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
            $insert_products->bind_param('sssiisssis', $product_title, $product_description, $product_keywords, $product_categories, $product_brands, 
                                        $_FILES['product_image1']['name'], $_FILES['product_image2']['name'], $_FILES['product_image3']['name'], $product_price, $product_status);

            if ($insert_products->execute()) {
                // Move uploaded images
                move_uploaded_file($_FILES['product_image1']['tmp_name'], "./product_images/" . $_FILES['product_image1']['name']);
                move_uploaded_file($_FILES['product_image2']['tmp_name'], "./product_images/" . $_FILES['product_image2']['name']);
                move_uploaded_file($_FILES['product_image3']['tmp_name'], "./product_images/" . $_FILES['product_image3']['name']);
                
                echo "<script>alert('Product successfully inserted'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Error inserting the product'); window.location.href='insert_product.php';</script>";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Products_Admin Dashboard</title>
     <!-- Bootstrap link -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Css file link -->
    <link rel="stylesheet" href="../index.css"/>
</head>
<body class="bg-light">
    <div class="container-fluid p-0 ">
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
                                echo "<li class='nav-item'>
                                <a class='nav-link' href='#' name=''>Welcome Guest</a>
                                </li> ";
                                echo "<li class='nav-item'>
                                <a class='nav-link' href='admin_login.php' name=''>Login</a>
                            </li> ";
                            
                           }
                        ?>
                    </ul>
                </div>
            </div>
        </nav> 
 <h1 class="text-center">Insert Products</h1>
        <!--Form design-->
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_title" class="form-label">Product Title</label>
                <input type="text" name="product_title" id="product_title" class="form-control" placeholder="Enter product title" autocomplete="off" 
                value="<?php if (isset($product_title)) echo $product_title; ?>"/>
                <span class="error text-danger" id="titleError"><?php if (isset($titleError)) echo $titleError; ?></span>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_description" class="form-label">Product Description</label>
                <input type="text" name="product_description" id="product_description" class="form-control" placeholder="Enter product description" autocomplete="off" value="<?php if (isset($product_description)) echo $product_description; ?>"/>
                <span class="error text-danger" id="descError"><?php if (isset($descError)) echo $descError; ?></span>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_keywords" class="form-label">Product Keywords</label>
                <input type="text" name="product_keywords" id="product_keywords" class="form-control" placeholder="Enter product keywords" autocomplete="off" value="<?php if (isset($product_keywords)) echo $product_keywords; ?>"/>
                <span class="error text-danger" id="titleError"><?php if (isset($keywordsError)) echo $keywordsError; ?></span>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <select name="product_categories" id="product_categories" class="form-select" >
                    <option value="">Select a Category</option>
                    <?php
                        $select_query="Select * from categories";
                        $result_query=mysqli_query($conn,$select_query);
                        while($row=mysqli_fetch_assoc($result_query)){
                            $category_title=$row['category_title'];
                            $category_id=$row['category_id'];
                            echo "<option value='$category_id'>$category_title</option>";
                        }
                    ?>
                </select>
                <span class="error text-danger" id="categoryError"><?php if (isset($categoryError)) echo $categoryError; ?></span>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <select name="product_brands" id="product_brands" class="form-select" >
                    <option value="">Select a Brand</option>
                    <?php
                        $select_query2="Select * from brands";
                        $result_query2=mysqli_query($conn,$select_query2);
                        while($row=mysqli_fetch_assoc($result_query2)){
                            $brand_name=$row['brand_name'];
                            $brand_id=$row['brand_id'];
                            echo "<option value='$brand_id'>$brand_name</option>";
                        }

                    ?>
                </select>
                <span class="error text-danger" id="brandError"><?php if (isset($brandError)) echo $brandError; ?></span>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image1" class="form-label">Product Image 1</label>
                <input type="file" name="product_image1" id="product_image1" class="form-control" />
                <span class="error text-danger" id="imageError1"><?php if (isset($image_errors[0])) echo $image_errors[0]; ?></span>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image2" class="form-label">Product Image 2</label>
                <input type="file" name="product_image2" id="product_image2" class="form-control" />
                <span class="error text-danger" id="imageError2"><?php if (isset($image_errors[1])) echo $image_errors[1]; ?></span>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image3" class="form-label">Product Image 3</label>
                <input type="file" name="product_image3" id="product_image3" class="form-control" />
                <span class="error text-danger" id="imageError3"><?php if (isset($image_errors[2])) echo $image_errors[2]; ?></span>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="text" name="product_price" id="product_price" class="form-control" placeholder="Enter product price" autocomplete="off" value="<?php if (isset($product_price)) echo $product_price; ?>"/>
                <span class="error text-danger" id="priceError"><?php if (isset($priceError)) echo $priceError; ?></span>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="insert_product" class="btn btn-info mb-3 px-3 " value="Insert Product"/>
            </div>
        </form>
    </div>
    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>