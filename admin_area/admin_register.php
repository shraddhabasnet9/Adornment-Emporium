<?php
include('../include/connect.php');
//include('../functions_folder/common_function.php');
session_start();

if (isset($_POST['admin_register'])) {
    $admin_username=$_POST['admin_username'];
    $admin_email=$_POST['admin_email'];
    $admin_password=$_POST['admin_password'];
    $hash_password=password_hash($admin_password, PASSWORD_DEFAULT);
    $confirm_admin_password=$_POST['confirm_admin_password'];
    $admin_contact=$_POST['admin_contact'];
    $admin_image=$_FILES['admin_image']['name'];
    $admin_image_tmp=$_FILES['admin_image']['tmp_name'];
    // primary validate function
    function validate($str) {
        return trim(htmlspecialchars($str));
    }
    
    
    // Validating name
    if (empty($_POST['admin_username'])) {
        $nameError = 'Name should be filled';
    } else {
        $admin_username = validate($_POST['admin_username']);
        if (!preg_match('/^[a-zA-Z\s]+$/', $admin_username)) {
            $nameError = 'Name can only contain letters and white spaces';
        }
        $select_query="Select * from `admin_table` where admin_username='$admin_username'";
        $result=mysqli_query($conn,$select_query);
        $rows_count=mysqli_num_rows($result);
        if($rows_count>0){
            $nameError = 'admin exist with same username';
        }
        
    }

    // Validating email
    if (empty($_POST['admin_email'])) {
        $emailError = 'Please enter your email';
    } else {
        $admin_email = validate($_POST['admin_email']);
        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $admin_email)) {
            $emailError = 'Invalid Email';
        }
        $select_query="Select * from `admin_table` where admin_email='$admin_email'";
        $result=mysqli_query($conn,$select_query);
        $rows_count=mysqli_num_rows($result);
        if($rows_count>0){
            $emailError = 'admin exist with same email';
        }
    }

    // Validate image upload (required, valid image type)
    if (empty($_FILES['admin_image']['name'])) {
        $imageError = "admin image is required.";
    } else {
        $admin_image = $_FILES['admin_image']['name'];
        $admin_image_tmp = $_FILES['admin_image']['tmp_name'];
        $allowed_extensions = ['jpg', 'png'];
        $file_extension = strtolower(pathinfo($admin_image, PATHINFO_EXTENSION));
        $max_file_size = 5* 1024 * 1024; // 5MB in bytes
        $file_size = $_FILES['admin_image']['size'];
        if (!in_array($file_extension, $allowed_extensions)) {
            $imageError = "Only JPG, PNG files are allowed.";
        }elseif ($file_size > $max_file_size) {
            $imageError = "The image size should not exceed 5MB.";
        }
    }
    // Validating password
    if (empty($_POST['admin_password'])) {
        $passwordError = 'Password cannot be empty';
    } else {
        $admin_password = validate($_POST['admin_password']);
        if (strlen($admin_password) < 6) {
            $passwordError = 'Password should be longer than 6 characters';
        }else if(strlen($user_password)>10){
            $passwordError = 'Password should be less than 10 characters';
        }
    }

    // Validating password retype
    if (empty($_POST['confirm_admin_password'])) {
        $confirmError = 'Please retype your password';
    } else {
        $confirm_admin_password = validate($_POST['confirm_admin_password']);
        if ($admin_password !== $confirm_admin_password) {
            $confirmError = 'Passwords do not match';
        }
    }

    // Validating phone number
    if (empty($_POST['admin_contact'])) {
        $phoneError = 'Phone number must be filled';
    } else {
        $admin_contact = validate($_POST['admin_contact']);
        if (!preg_match('/^(?:\+977|0)?[1-9]\d{9}$/', $admin_contact)) {
            $phoneError = "Invalid Phone Number";
        }
    }

    // If there are no errors, proceed with database insertion
    if (empty($nameError) && empty($emailError) && empty($passwordError) && empty($confirmError) && empty($phoneError) && empty($imageError)) {
        // Hash the password
       // $hash_password = password_hash($user_password, PASSWORD_DEFAULT);

        $insert_query="INSERT INTO `admin_table` (admin_username, admin_email, admin_password, admin_contact, admin_image ) VALUES('$admin_username','$admin_email','$hash_password','$admin_contact','$admin_image')";
        $sql_execute=mysqli_query($conn,$insert_query);
        move_uploaded_file($admin_image_tmp,"./admin_images/$admin_image");
        echo "<script>alert('You are registered')</script>";
        echo "<script>window.open('admin_login.php','_self')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <!-- Bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid my-3">
        <h2 class="text-center">New Admin Registration</h2>
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-12 col-xl-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-outline ">
                        <label for="admin_username" class="form-label">Username</label>
                        <input type="text" id="admin_username" class="form-control" placeholder="Enter your username" autocomplete="off" name="admin_username" value="<?php if (isset($admin_username)) echo $admin_username; ?>"/>
                        <span class="error text-danger" id="nameError"><?php if (isset($nameError)) echo $nameError; ?></span><br>
                    </div>
                    <div class="form-outline">
                        <label for="admin_email" class="form-label">Email</label>
                        <input type="email" id="admin_email" class="form-control" placeholder="Enter your Email" autocomplete="off" name="admin_email" value="<?php if (isset($admin_email)) echo $admin_email; ?>"/>
                        <span class="error text-danger" id="emailError"><?php if (isset($emailError)) echo $emailError; ?></span><br>
                    </div>
                    <div class="form-outline">
                        <label for="admin_image" class="form-label">User Image</label>
                        <input type="file" id="admin_image" class="form-control" autocomplete="off" name="admin_image" value="<?php if (isset($admin_image)) echo $admin_image; ?>"/>
                        <span class="error text-danger" id="imageError"><?php if (isset($imageError)) echo $imageError; ?></span><br>
                    </div>
                    <div class="form-outline">
                        <label for="admin_password" class="form-label">Password</label>
                        <input type="password" id="admin_password" class="form-control" placeholder="Enter your password" autocomplete="off" name="admin_password" value="<?php if (isset($admin_password)) echo $admin_password; ?>"/>
                        <span class="error text-danger" id="passwordError"><?php if (isset($passwordError)) echo $passwordError; ?></span><br>
                    </div>
                    <div class="form-outline">
                        <label for="confirm_admin_password" class="form-label">Confirm Password</label>
                        <input type="password" id="confirm_admin_password" class="form-control" placeholder="Enter your password again" autocomplete="off" name="confirm_admin_password" value="<?php if (isset($confirm_admin_password)) echo $confirm_admin_password; ?>"/>
                        <span class="error text-danger" id="confirmError"><?php if (isset($confirmError)) echo $confirmError; ?></span><br>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="admin_contact" class="form-label">Contact Number</label>
                        <input type="text" id="admin_contact" class="form-control" placeholder="Enter your contact number" autocomplete="off" name="admin_contact" value="<?php if (isset($admin_contact)) echo $admin_contact; ?>"/>
                        <span class="error text-danger" id="phoneError"><?php if (isset($phoneError)) echo $phoneError; ?></span>

                    </div>
                    <div class="mt-2 pt-2">
                        <input type="submit" value="Register" class="bg-info py-2 px-4 border-0" name="admin_register">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="admin_login.php" class="text-danger">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
