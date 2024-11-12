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
    <title>User Registration</title>
     <!--Bootstrap link-->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body{
            overflow-x: hidden;
        }
    </style>
</head>
<body>
    <div class="container-fluid my-3">
        <h2 class="text-center">User Login panel</h2>
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-12 col-xl-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-outline mb-4">
                        <label for="user_username" class="form-label">Username</label>
                        <input type="text" id="user_username" class="form-control" placeholder="Enter your username" autocomplete="off" name="user_username" required/>
                    </div>
                    <div class="form-outline">
                        <label for="user_password" class="form-label">Password</label>
                        <input type="password" id="user_password" class="form-control" placeholder="Enter your password" autocomplete="off" name="user_password" required/>
                    </div>
                    <div class="mt-4 pt-2">
                        <input type="submit" value="Login" class="bg-info py-2 px-3 border-0" name="user_login">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="user_registration.php" class="text-danger">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    if(isset($_POST['user_login'])){
        $user_username=$_POST['user_username'];
        $user_password=$_POST['user_password'];
        $user_ip=getIPAddress();
        $select_query="Select * from `user_table` where user_name='$user_username'";
        $result=mysqli_query($conn,$select_query);
        $rows_count=mysqli_num_rows($result);
        $row_data=mysqli_fetch_assoc($result);

        //cart item
        
        $select_query2="Select * from `cart_details` where ip_address='$user_ip'";
        $select_cart=mysqli_query($conn,$select_query2);
        $rows_count_cart=mysqli_num_rows($select_cart);
        if($rows_count>0){
            $_SESSION['username']=$user_username;
           // $_SESSION['user_id'] = $user_id; 
            if(password_verify($user_password, $row_data['user_password'])){
                //echo "<script>alert('Login Successful')</script>";
                if($rows_count==1 and $rows_count_cart==0){
                    echo "<script>alert('Login Successful')</script>";
                    echo "<script>alert('This is your profile page')</script>";
                    echo "<script>window.open('profile.php','_self')</script>";
                }else{
                    echo "<script>alert('Login Successful')</script>";
                    echo "<script>alert('You have items in your cart')</script>";
                    echo "<script>window.open('../cart.php','_self')</script>";
                }
            }else{
                echo "<script>alert('Invalid Credentials')</script>";
            }
        }
        else{
            echo "<script>alert('Invalid Credentials')</script>";
        }
    }
?>