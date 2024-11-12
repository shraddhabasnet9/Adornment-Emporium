<?php
@include('../include/connect.php');
@session_start();

// Check if the form to remove user is submitted
if (isset($_POST['remove_user'])) {
    $user_id = $_POST['user_id']; // Get the user_id from the form
    $delete_query = "DELETE FROM `user_table` WHERE user_id=$user_id";
    $run_delete = mysqli_query($conn, $delete_query);
    if ($run_delete) {
        echo "<script>alert('User removed successfully!'); window.open('list_users.php','_self');</script>";
    } else {
        echo "<script>alert('Failed to remove user.');</script>";
    }
}

// Fetching users from the database
$sql = "SELECT * FROM user_table";
$result = $conn->query($sql);
?>

<html>
<head>
    <title>User Records</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../index.css"/>
</head>
<body>
    <div class="bg-light">
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-info">
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
                        
                            }
                        ?>
                    </ul>
                </div>
            </div>
    </nav> -->
        <h3 class="text-center">User Records</h3>
    </div>
    <div class="container">
        <div class="row">
            <table class="table table-bordered text-center">
                <thead class="bg-info">
                    
                    <?php
                    if ($result->num_rows > 0) {
                        echo "
                            <tr> 
                                <th>Id</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Email</th> 
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        ";
                        while ($row = $result->fetch_assoc()) {
                            $user_id = $row['user_id'];
                            $user_image = $row['user_image']; // Ensure this field exists in your database
                            echo"
                            <tr> 
                                <td>{$row['user_id']}</td>
                                <td><img src='../user_area/user_images/$user_image' alt='User Image' class='cart_image' style='width: 50px; height: 50px;'></td>
                                <td>{$row['user_name']}</td> 
                                <td>{$row['user_address']}</td>
                                <td>{$row['user_email']}</td>
                                <td>{$row['user_mobile']}</td>
                                <td>
                                    <form method='POST' action=''>
                                        <input type='hidden' name='user_id' value='{$user_id}'>
                                        <input type='submit' value='Remove user' class='bg-info px-3 py-2 border-0 mx-3' name='remove_user'>
                                    </form>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<h2 class='text-danger text-center mt-5'>No users found.</h2>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
