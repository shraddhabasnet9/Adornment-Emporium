<?php
@include('../include/connect.php');
@session_start();

// Check if the form to remove user is submitted
if (isset($_POST['remove_brand'])) {
    $brand_id = $_POST['brand_id']; 
    $delete_query = "DELETE FROM `brands` WHERE brand_id=$brand_id";
    $run_delete = mysqli_query($conn, $delete_query);
    if ($run_delete) {
        echo "<script>alert('brand removed successfully!'); window.open('view_brands.php','_self');</script>";
    } else {
        echo "<script>alert('Failed to remove brand.');</script>";
    }
}
// Fetching brands from the database
$sql = "SELECT * FROM brands";
$result = $conn->query($sql);
?>

<html>
<head>
    <title>Brand Records</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../index.css"/>
</head>
<body>
    <div class="bg-light">
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
                        
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <h3 class="text-center">Brand Records</h3>
    </div>
    <div class="container">
        <div class="row">
            <table class="table table-bordered text-center">
                <thead>
                    <tr> 
                        <th>Id</th>
                        <th>Brand title</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $brand_id= $row['brand_id'];
                            echo "
                            <tr> 
                                <td>{$row['brand_id']}</td>
                                <td>{$row['brand_name']}</td> 
                                <td>
                                    <form method='POST' action=''>
                                        <input type='hidden' name='brand_id' value='{$brand_id}'>
                                        <input type='submit' value='Remove brand' class='bg-info px-3 py-2 border-0 mx-3' name='remove_brand'>
                                    
                                       
                                    </form>
                                    
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No brands found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>