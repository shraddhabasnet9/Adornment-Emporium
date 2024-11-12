<?php
if (isset($_GET['remove_category'])) {
    $delete_id=$_GET['remove_category'];
    $get_data="select * from categories where category_id={$delete_id}";
    $result=mysqli_query($conn, $get_data);
    $row=mysqli_fetch_assoc($result);
    $category_id = $row['category_id']; // Get the user_id from the form
    $delete_query = "DELETE FROM `categories` WHERE category_id=$category_id";
    $run_delete = mysqli_query($conn, $delete_query);
    if ($run_delete) {
        echo "<script>alert('category removed successfully!'); window.open('index.php','_self');</script>";
    } else {
        echo "<script>alert('Failed to remove category.');</script>";
    }
}
?>