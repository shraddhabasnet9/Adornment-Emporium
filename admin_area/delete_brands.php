<?php
if (isset($_GET['remove_brand'])) {
    $delete_id=$_GET['remove_brand'];
    $get_data="select * from brands where brand_id={$delete_id}";
    $result=mysqli_query($conn, $get_data);
    $row=mysqli_fetch_assoc($result);
    $brand_id = $row['brand_id']; // Get the user_id from the form
    $delete_query = "DELETE FROM `brands` WHERE brand_id=$brand_id";
    $run_delete = mysqli_query($conn, $delete_query);
    if ($run_delete) {
        echo "<script>alert('Brand removed successfully!'); window.open('index.php','_self');</script>";
    } else {
        echo "<script>alert('Failed to remove brand.');</script>";
    }
}
?>