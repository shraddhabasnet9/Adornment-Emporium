<?php
@include('../include/connect.php');
@include('../functions_folder/common_function.php');
@session_start();
if(isset($_SESSION['username'])){
    $username=$_SESSION['username'];
    $get_user="SELECT * FROM user_table WHERE user_name = '$username'";
    $get_user_query = mysqli_query($conn, $get_user);
    $row_fetch = mysqli_fetch_assoc($get_user_query);
    $user_id = $row_fetch['user_id'];
}else{
    echo "<script>window.open('../index.php','_self')</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>payment Page</title>
    <!--Bootstrap link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
            .payment_img{
                width:80%;
                margin: auto;
                display: block;
            }
    </style>
</head>
<body>
        <!--php code to access user id-->
        <?php
            $user_ip=getIPAddress();
            $get_user="Select * from `user_table` where user_ip='$user_ip'";
            $result_query=mysqli_query($conn,$get_user);
            if ($result_query && mysqli_num_rows($result_query) > 0) {
                $run_query=mysqli_fetch_array($result_query);
                $user_id=$run_query['user_id'];
            }else {
                $user_id = null;  // Default to null if no user is found
                echo "<script>window.open('../index.php','_self')</script>";
            }
            //echo $user_id;

        ?>
    <div class="container">
        <h2 class="text-center-text-info">Payment Options</h2>
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-6">
            <a href="https://www.paypal.com" target="_blank"><img src="../images/i.jpg" alt="" class="payment_img"></a>
            </div>
            <div class="col-md-6">
            <a href="order.php?user_id=<?php echo $user_id   ?>"><h2 class="text-center">Pay Offline</h2></a>
            </div>
        </div>
       
    </div>
</body>
</html>