<?php
include('../include/connect.php');
include('../functions_folder/common_function.php');
session_start();
if (isset($_POST['user_register'])) {
    $user_username=$_POST['user_username'];
    $user_email=$_POST['user_email'];
    $user_password=$_POST['user_password'];
    $hash_password=password_hash($user_password, PASSWORD_DEFAULT);
    $confirm_user_password=$_POST['confirm_user_password'];
    $user_address=$_POST['user_address'];
    $user_username=$_POST['user_username'];
    $user_contact=$_POST['user_contact'];
    $user_image=$_FILES['user_image']['name'];
    $user_image_tmp=$_FILES['user_image']['tmp_name'];
    $user_ip=getIPAddress();

    // primary validate function
    function validate($str) {
        return trim(htmlspecialchars($str));
    }
    
    // Validating name
    if (empty($_POST['user_username'])) {
        $nameError = 'Name should be filled';
    } else {
        $user_username = validate($_POST['user_username']);
        if (!preg_match('/^[a-zA-Z\s]+$/', $user_username)) {
            $nameError = 'Name can only contain letters and white spaces';
        }
        $select_query="Select * from `user_table` where user_name='$user_username'";
        $result=mysqli_query($conn,$select_query);
        $rows_count=mysqli_num_rows($result);
        if($rows_count>0){
            $nameError = 'user exist with same username';
        }
        
    }

    // Validating email
    if (empty($_POST['user_email'])) {
        $emailError = 'Please enter your email';
    } else {
        $user_email = validate($_POST['user_email']);
        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $user_email)) {
            $emailError = 'Invalid Email';
        }
        $select_query="Select * from `user_table` where user_email='$user_email'";
        $result=mysqli_query($conn,$select_query);
        $rows_count=mysqli_num_rows($result);
        if($rows_count>0){
            $emailError = 'user exist with same email';
        }
    }

    // Validate image upload (required, valid image type)
    if (empty($_FILES['user_image']['name'])) {
        $imageError = "User image is required.";
    } else {
        $user_image = $_FILES['user_image']['name'];
        $user_image_tmp = $_FILES['user_image']['tmp_name'];
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_extension = strtolower(pathinfo($user_image, PATHINFO_EXTENSION));
        // File size validation (5MB max)
        $max_file_size = 5 * 1024 * 1024; // 5MB in bytes
        $file_size = $_FILES['user_image']['size'];
        if (!in_array($file_extension, $allowed_extensions)) {
            $imageError = "Only JPG, JPEG, PNG files are allowed.";
        }elseif ($file_size > $max_file_size) {
            $imageError = "The image size should not exceed 5MB.";
        }
    }
    // Validating password
    if (empty($_POST['user_password'])) {
        $passwordError = 'Password cannot be empty';
    } else {
        $user_password = validate($_POST['user_password']);
        if (strlen($user_password) < 6) {
            $passwordError = 'Password should be longer than 6 characters';
        }else if(strlen($user_password)>10){
            $passwordError = 'Password should be less than 10 characters';
        }
    }

    // Validating password retype
    if (empty($_POST['confirm_user_password'])) {
        $confirmError = 'Please retype your password';
    } else {
        $confirm_user_password = validate($_POST['confirm_user_password']);
        if ($user_password !== $confirm_user_password) {
            $confirmError = 'Passwords do not match';
        }
    }

    // Validating address
    if (empty($_POST['user_address'])) {
        $addressError = 'Address should be filled';
    } else {
        $user_address = validate($_POST['user_address']);
        if (!preg_match('/^[a-zA-Z\s]+$/', $user_address)) {
            $addressError = 'Address can only contain letters and white spaces';
        }
    }

    // Validating phone number
    if (empty($_POST['user_contact'])) {
        $phoneError = 'Phone number must be filled';
    } else {
        $user_contact = validate($_POST['user_contact']);
        if (!preg_match('/^(?:\+977|0)?[1-9]\d{9}$/', $user_contact)) {
            $phoneError = "Invalid Phone Number";
        }
    }

    // If there are no errors, proceed with database insertion
    if (empty($nameError) && empty($emailError) && empty($passwordError) && empty($confirmError) && empty($addressError) && empty($phoneError) && empty($imageError)) {
        // Hash the password
        $hash_password = password_hash($user_password, PASSWORD_DEFAULT);
        $insert_query="INSERT INTO `user_table` (user_name, user_email, user_password, user_image, user_ip, user_address, user_mobile) VALUES('$user_username','$user_email','$hash_password','$user_image','$user_ip','$user_address','$user_contact')";
        $sql_execute=mysqli_query($conn,$insert_query);
        move_uploaded_file($user_image_tmp,"./user_images/$user_image");
        echo "<script>alert('You are registered')</script>";
       // echo "<script>window.open('user_login.php','_self')</script>";

        // Select cart items
        $user_ip = getIPAddress(); // Assuming there's a function to get IP

        $select_cart_item = "SELECT * FROM cart_details WHERE ip_address='$user_ip' ";
        $result_cart = mysqli_query($conn, $select_cart_item);
        $rows_cart = mysqli_num_rows($result_cart);

        
        if ($rows_cart) {
            $_SESSION['username'] = $user_username;
            $_SESSION['user_id'] = $user_id; 
            echo "<script>alert('You have items in your cart')</script>";
            echo "<script>window.open('../cart.php', '_self')</script>";
        } else {
            echo "<script>window.open('../index.php', '_self')</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <!-- Bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid my-3">
        <h2 class="text-center">New User Registration</h2>
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-12 col-xl-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-outline ">
                        <label for="user_username" class="form-label">Username</label>
                        <input type="text" id="user_username" class="form-control" placeholder="Enter your username" autocomplete="off" name="user_username" 
                        value="<?php if (isset($user_username)) echo $user_username; ?>"/>
                        <span class="error text-danger" id="nameError"><?php if (isset($nameError)) echo $nameError; ?></span><br>
                    </div>
                    <div class="form-outline">
                        <label for="user_email" class="form-label">Email</label>
                        <input type="email" id="user_email" class="form-control" placeholder="Enter your Email" autocomplete="off" name="user_email" value="<?php if (isset($user_email)) echo $user_email; ?>"/>
                        <span class="error text-danger" id="emailError"><?php if (isset($emailError)) echo $emailError; ?></span><br>
                    </div>
                    <div class="form-outline">
                        <label for="user_image" class="form-label">User Image</label>
                        <input type="file" id="user_image" class="form-control" autocomplete="off" name="user_image" value="<?php if (isset($user_image)) echo $user_image; ?>"/>
                        <span class="error text-danger" id="imageError"><?php if (isset($imageError)) echo $imageError; ?></span><br>
                    </div>
                    <div class="form-outline">
                        <label for="user_password" class="form-label">Password</label>
                        <input type="password" id="user_password" class="form-control" placeholder="Enter your password" autocomplete="off" name="user_password" value="<?php if (isset($user_password)) echo $user_password; ?>"/>
                        <span class="error text-danger" id="passwordError"><?php if (isset($passwordError)) echo $passwordError; ?></span><br>
                    </div>
                    <div class="form-outline">
                        <label for="confirm_user_password" class="form-label">Confirm Password</label>
                        <input type="password" id="confirm_user_password" class="form-control" placeholder="Enter your password again" autocomplete="off" name="confirm_user_password" value="<?php if (isset($confirm_user_password)) echo $confirm_user_password; ?>"/>
                        <span class="error text-danger" id="confirmError"><?php if (isset($confirmError)) echo $confirmError; ?></span><br>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="user_address" class="form-label">User Address</label>
                        <input type="text" id="user_address" class="form-control" placeholder="Enter your address" autocomplete="off" name="user_address" value="<?php if (isset($user_address)) echo $user_address; ?>"/>
                        <span class="error text-danger" id="addressError"><?php if (isset($addressError)) echo $addressError; ?></span><br>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="user_contact" class="form-label">Contact Number</label>
                        <input type="text" id="user_contact" class="form-control" placeholder="Enter your contact number" autocomplete="off" name="user_contact" value="<?php if (isset($user_contact)) echo $user_contact; ?>"/>
                        <span class="error text-danger" id="phoneError"><?php if (isset($phoneError)) echo $phoneError; ?></span>

                    </div>
                    <div class="mt-2 pt-2">
                        <input type="submit" value="Register" class="bg-info py-2 px-2 border-0" name="user_register">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="user_login.php" class="text-danger">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
