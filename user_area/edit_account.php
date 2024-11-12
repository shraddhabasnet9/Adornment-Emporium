<?php
@include('../include/connect.php');
@session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $get_user = "SELECT * FROM user_table WHERE user_name = '$username'";
    $get_user_query = mysqli_query($conn, $get_user);
    $row_fetch = mysqli_fetch_assoc($get_user_query);
    $user_id = $row_fetch['user_id'];
}else{
    echo "<script>window.open('../index.php','_self')</script>";
}

if (isset($_GET['edit_account'])) {
    $user_session_name = $_SESSION['username'];
    $select_query = "SELECT * FROM user_table WHERE user_name = '$user_session_name'";
    $result_query = mysqli_query($conn, $select_query);

    if ($row_fetch = mysqli_fetch_assoc($result_query)) {
        $user_id = $row_fetch['user_id'];
        $user_name = $row_fetch['user_name'];
        $user_email = $row_fetch['user_email'];
        $user_address = $row_fetch['user_address'];
        $user_mobile = $row_fetch['user_mobile'];
        $user_image = $row_fetch['user_image'];
    }

    if (isset($_POST['user_update'])) {
        $update_id = $user_id;
        $user_name = $_POST['user_name'];
        $user_email = $_POST['user_email'];
        $user_address = $_POST['user_address'];
        $user_mobile = $_POST['user_mobile'];

        function validate($str) {
            return trim(htmlspecialchars($str));
        }

        // Initialize error variables
        $nameError = $emailError = $addressError = $imageError = $phoneError = "";

        // Validating name
        if (empty($user_name)) {
            $nameError = 'Name should be filled';
        } else {
            $user_name = validate($user_name);
            if (!preg_match('/^[a-zA-Z\s]+$/', $user_name)) {
                $nameError = 'Name can only contain letters and white spaces';
            }
        }

        // Validating address
        if (empty($user_address)) {
            $addressError = 'Address should be filled';
        } else {
            $user_address = validate($user_address);
            if (!preg_match('/^[a-zA-Z\s]+$/', $user_address)) {
                $addressError = 'Address can only contain letters and white spaces';
            }
        }

        // Validating email
        if (empty($user_email)) {
            $emailError = 'Please enter your email';
        } else {
            $user_email = validate($user_email);
            if (!preg_match('/^[a-zA-Z][a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $user_email)) {
                $emailError = 'Invalid Email';
            }
        }

        // Validate image upload
        if (empty($_FILES['user_image']['name'])) {
            $imageError = "User image is required.";
        } else {
            $user_image = $_FILES['user_image']['name'];
            $user_image_tmp = $_FILES['user_image']['tmp_name'];
            $allowed_extensions = ['jpg', 'jpeg', 'png'];
            $file_extension = strtolower(pathinfo($user_image, PATHINFO_EXTENSION));
            $max_file_size = 5 * 1024 * 1024; // 5MB
            $file_size = $_FILES['user_image']['size'];
            if (!in_array($file_extension, $allowed_extensions)) {
                $imageError = "Only JPG, JPEG, PNG files are allowed.";
            } elseif ($file_size > $max_file_size) {
                $imageError = "The image size should not exceed 5MB.";
            }
        }

        // Validating phone number
        if (empty($user_mobile)) {
            $phoneError = 'Phone number must be filled';
        } else {
            $user_mobile = validate($user_mobile);
            if (!preg_match('/^(?:\+977|0)?[1-9]\d{9}$/', $user_mobile)) {
                $phoneError = "Invalid Phone Number";
            }
        }

        // If no errors, proceed with update
        if (empty($nameError) && empty($emailError) && empty($addressError) && empty($imageError) && empty($phoneError)) {
            move_uploaded_file($user_image_tmp, "./user_images/$user_image");

            // Update query
            $update_data = "UPDATE user_table 
                            SET user_name = '$user_name', user_email = '$user_email', 
                                user_image = '$user_image', user_address = '$user_address', 
                                user_mobile = '$user_mobile' 
                            WHERE user_id = '$update_id'";
            $result_query_update = mysqli_query($conn, $update_data);

            if ($result_query_update) {
                echo "<script>alert('Data updated successfully');</script>";
                echo "<script>window.open('logout.php', '_self');</script>";
            } else {
                echo "<script>alert('Data update failed');</script>";
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
    <title>Edit Account</title>
    <style>
        .edit_img {
            height: 30%;
            width: 20%;
        }
    </style>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-outline mb-4">
        <input type="text" class="form-control w-50 m-auto" value="<?php echo $user_name ?>" name="user_name">
        <span class="error text-danger w-50 m-auto d-flex" id="nameError"><?php echo $nameError ?? '' ?></span>
    </div>
    <div class="form-outline mb-4">
        <input type="email" class="form-control w-50 m-auto" value="<?php echo $user_email ?>" name="user_email">
        <span class="error text-danger w-50 m-auto d-flex" id="emailError"><?php echo $emailError ?? '' ?></span>
    </div>
    <div class="form-outline d-flex w-50 m-auto">
        <input type="file" class="form-control" name="user_image">
        <img src="./user_images/<?php echo $user_image ?>" alt="Profile Image" class="edit_img">
    </div>
    <div  class=" mb-4 d-flex ">
        <span class="error text-danger w-50 m-auto d-flex" id="imageError"><?php echo $imageError ?? '' ?></span>
    </div>
    <div class="form-outline mb-4">
        <input type="text" class="form-control w-50 m-auto" name="user_address" value="<?php echo $user_address ?>">
        <span class="error text-danger w-50 m-auto d-flex" id="addressError"><?php echo $addressError ?? '' ?></span>
    </div>
    <div class="form-outline mb-4">
        <input type="text" class="form-control w-50 m-auto" name="user_mobile" value="<?php echo $user_mobile ?>">
        <span class="error text-danger w-50 m-auto d-flex" id="phoneError"><?php echo $phoneError ?? '' ?></span>
    </div>
    <div class="form-outline mb-4 d-flex justify-content-center">
        <input type="submit" value="Update" class="bg-info py-2 px-3 border-0 " name="user_update">
    </div>
</form>



</body>
</html>
