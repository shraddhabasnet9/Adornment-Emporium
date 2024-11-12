<?php
if (isset($_GET['edit_products'])) {
    $edit_id = $_GET['edit_products'];
    $get_data = "SELECT * FROM products WHERE product_id={$edit_id}";
    $result = mysqli_query($conn, $get_data);
    $row = mysqli_fetch_assoc($result);
    $product_title = $row['product_title'];
    $product_description = $row['product_description'];
    $product_keywords = $row['product_keywords'];
    $category_id = $row['category_id'];
    $brand_id = $row['brand_id'];
    $product_image1 = $row['product_image1'];
    $product_image2 = $row['product_image2'];
    $product_image3 = $row['product_image3'];
    $product_price = $row['product_price'];

    // Fetching category name
    $select_category = "SELECT * FROM categories WHERE category_id={$category_id}";
    $result_category = mysqli_query($conn, $select_category);
    $row_category = mysqli_fetch_assoc($result_category);
    $category_title = $row_category['category_title'];

    // Fetching brand name
    $select_brand = "SELECT * FROM brands WHERE brand_id={$brand_id}";
    $result_brand = mysqli_query($conn, $select_brand);
    $row_brand = mysqli_fetch_assoc($result_brand);
    $brand_title = $row_brand['brand_name'];
}

// Editing products with validation
if (isset($_POST['edit_product'])) {
    $product_title = trim($_POST['product_title']);
    $product_desc = trim($_POST['product_desc']);
    $product_keywords = trim($_POST['product_keywords']);
    $product_price = trim($_POST['product_price']);
    $product_categories = $_POST['product_category'];
    $product_brands = $_POST['product_brands'];

    // Accessing images
    $images = ['product_image1', 'product_image2', 'product_image3'];
    $image_errors = [];

    // Image validation function
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
    $titleError = $priceError = $descError = $keywordsError = $categoryError = $brandError = "";
    if (empty($product_title)) {
        $titleError = 'Title is required';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $product_title)) {
        $titleError = 'Title can only contain letters and spaces';
    }
    if (empty($product_desc)) {
        $descError = 'Description is required';
    }
    if (empty($product_keywords)) {
        $keywordsError = 'Keywords are required';
    }
    if (empty($product_categories)) {
        $categoryError = 'Category must be selected';
    }
    if (empty($product_brands)) {
        $brandError = 'Brand must be selected';
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

    // Check for errors before updating
    if (empty($titleError) && empty($priceError) && empty($descError) && empty($keywordsError) && empty($categoryError) && empty($brandError) && empty(array_filter($image_errors))) {
        // Convert title to lowercase for case-insensitive comparison
        $product_title_lower = strtolower($product_title);
        // Check for duplicate products for the same brand, excluding the current product
        $check_product_query = $conn->prepare("SELECT * FROM products WHERE product_title = ? AND brand_id = ? AND product_id != ?");
        $check_product_query->bind_param('sii', $product_title_lower, $product_brands, $edit_id);
        $check_product_query->execute();
        $check_result = $check_product_query->get_result();

        if ($check_result->num_rows > 0) {
            echo "<script>alert('This product already exists for the selected brand. Please choose a different product or brand.'); window.location.href='insert_product.php';</script>";
        } else {
            // Handle images: keep old images if new ones are not uploaded
            if (!empty($_FILES['product_image1']['name'])) {
                move_uploaded_file($_FILES['product_image1']['tmp_name'], "./product_images/" . $_FILES['product_image1']['name']);
                $product_image1_name = $_FILES['product_image1']['name'];
            } else {
                $product_image1_name = $product_image1;
            }

            if (!empty($_FILES['product_image2']['name'])) {
                move_uploaded_file($_FILES['product_image2']['tmp_name'], "./product_images/" . $_FILES['product_image2']['name']);
                $product_image2_name = $_FILES['product_image2']['name'];
            } else {
                $product_image2_name = $product_image2;
            }

            if (!empty($_FILES['product_image3']['name'])) {
                move_uploaded_file($_FILES['product_image3']['tmp_name'], "./product_images/" . $_FILES['product_image3']['name']);
                $product_image3_name = $_FILES['product_image3']['name'];
            } else {
                $product_image3_name = $product_image3;
            }
            // Update query
            $update_product = "UPDATE products SET 
                product_title='$product_title', 
                product_description='$product_desc', 
                product_keywords='$product_keywords', 
                category_id='{$_POST['product_category']}', 
                brand_id='{$_POST['product_brands']}', 
                product_image1='" . mysqli_real_escape_string($conn, $product_image1_name) . "', 
                product_image2='" . mysqli_real_escape_string($conn, $product_image2_name) . "', 
                product_image3='" . mysqli_real_escape_string($conn, $product_image3_name) . "', 
                product_price='$product_price', 
                date=NOW() 
                WHERE product_id=$edit_id";

            $result_update = mysqli_query($conn, $update_product);
           
            if ($result_update) {
                echo "<script>alert('Product updated successfully');</script>";
                echo "<script>window.open('./index.php', '_self');</script>";
            } else {
                echo "<script>alert('Error updating product: " . mysqli_error($conn) . "');</script>";
            }
        }
    }
}
?>

<!-- HTML FORM -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
    <h1 class="text-center">Edit Product</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-outline w-50 m-auto mb-2">
            <label for="product_title" class="form-label">Product Title</label>
            <input type="text" id="product_title" value="<?php echo htmlspecialchars($product_title); ?>" name="product_title" class="form-control">
            <span class="error text-danger" id="titleError"><?php if (isset($titleError)) echo $titleError; ?></span>
        </div>
        <div class="form-outline w-50 m-auto mb-2">
            <label for="product_desc" class="form-label">Product Description</label>
            <input type="text" id="product_desc" value="<?php echo htmlspecialchars($product_description); ?>" name="product_desc" class="form-control">
            <span class="error text-danger" id="descError"><?php if (isset($descError)) echo $descError; ?></span>
        </div>
        <div class="form-outline w-50 m-auto mb-2">
            <label for="product_keywords" class="form-label">Product Keywords</label>
            <input type="text" id="product_keywords" value="<?php echo htmlspecialchars($product_keywords); ?>" name="product_keywords" class="form-control">
            <span class="error text-danger" id="keywordsError"><?php if (isset($keywordsError)) echo $keywordsError; ?></span>
        </div>
        <div class="form-outline w-50 m-auto mb-2">
            <label for="product_category" class="form-label">Product Category</label>
            <select name="product_category" class="form-select">
                <option value="<?php echo $category_id; ?>"><?php echo htmlspecialchars($category_title); ?></option>
                <?php
                $select_category_all = "SELECT * FROM categories";
                $result_category_all = mysqli_query($conn, $select_category_all);
                while ($row_category_all = mysqli_fetch_assoc($result_category_all)) {
                    $category_title = $row_category_all['category_title'];
                    $category_id = $row_category_all['category_id'];
                    echo "<option value='$category_id'>$category_title</option>";
                }
                ?>
            </select>
            <span class="error text-danger" id="categoryError"><?php if (isset($categoryError)) echo $categoryError; ?></span>
        </div>
        <div class="form-outline w-50 m-auto mb-2">
            <label for="product_brands" class="form-label">Product Brand</label>
            <select name="product_brands" class="form-select">
                <option value="<?php echo $brand_id; ?>"><?php echo htmlspecialchars($brand_title); ?></option>
                <?php
                $select_brand_all = "SELECT * FROM brands";
                $result_brand_all = mysqli_query($conn, $select_brand_all);
                while ($row_brand_all = mysqli_fetch_assoc($result_brand_all)) {
                    $brand_title = $row_brand_all['brand_name'];
                    $brand_id = $row_brand_all['brand_id'];
                    echo "<option value='$brand_id'>$brand_title</option>";
                }
                ?>
            </select>
            <span class="error text-danger" id="brandError"><?php if (isset($brandError)) echo $brandError; ?></span>
        </div>
        <div class="form-outline w-50 m-auto mb-2">
            <label for="product_price" class="form-label">Product Price</label>
            <input type="text" id="product_price" value="<?php echo htmlspecialchars($product_price); ?>" name="product_price" class="form-control">
            <span class="error text-danger" id="priceError"><?php if (isset($priceError)) echo $priceError; ?></span>
        </div>

        <!-- IMAGE FIELDS -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image1" class="form-label">Product Image 1</label>
            <div class="d-flex">
                <input type="file" id="product_image1" name="product_image1" class="form-control w-90 m-auto">
                <img src="./product_images/<?php echo htmlspecialchars($product_image1); ?>" alt="Product Image 1" class="img-thumbnail" width="100">
            </div>
            <span class="error text-danger"><?php if (isset($image_errors[0])) echo $image_errors[0]; ?></span>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image2" class="form-label">Product Image 2</label>
            <div class="d-flex">
                <input type="file" id="product_image2" name="product_image2" class="form-control w-90 m-auto">
                <img src="./product_images/<?php echo htmlspecialchars($product_image2); ?>" alt="Product Image 2" class="img-thumbnail" width="100">
            </div>
            <span class="error text-danger"><?php if (isset($image_errors[1])) echo $image_errors[1]; ?></span>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image3" class="form-label">Product Image 3</label>
            <div class="d-flex">
                <input type="file" id="product_image3" name="product_image3" class="form-control w-90 m-auto">
                <img src="./product_images/<?php echo htmlspecialchars($product_image3); ?>" alt="Product Image 3" class="img-thumbnail" width="100">
            </div>
            <span class="error text-danger"><?php if (isset($image_errors[2])) echo $image_errors[2]; ?></span>
        </div>

        <!-- SUBMIT BUTTON -->
        <div class="form-outline w-50 m-auto mb-4">
            <input type="submit" name="edit_product" class="btn btn-primary px-3 mb-3" value="Update Product">
        </div>
    </form>
</div>
