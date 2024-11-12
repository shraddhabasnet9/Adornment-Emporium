<?php
if (isset($_GET['delete_product'])) {
    $delete_id=$_GET['delete_product'];
    $get_data="select * from products where product_id={$delete_id}";
    $result=mysqli_query($conn, $get_data);
    $row=mysqli_fetch_assoc($result);
    $product_id = $row['product_id']; // Get the user_id from the form
    $delete_query = "DELETE FROM `products` WHERE product_id=$product_id";
    $run_delete = mysqli_query($conn, $delete_query);
    if ($run_delete) {
        echo "<script>alert('Product removed successfully!'); window.open('index.php','_self');</script>";
    } else {
        echo "<script>alert('Failed to remove product.');</script>";
    }
}
?>