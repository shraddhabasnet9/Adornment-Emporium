<?php
if (isset($_GET['delete_order'])) {
    $delete_id = $_GET['delete_order'];
    
    // SQL to get the order based on the order ID
    $get_data = "SELECT * FROM user_orders WHERE order_id = {$delete_id}";
    $result = mysqli_query($conn, $get_data);

    // Check if the query executed successfully
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the data
        $row = mysqli_fetch_assoc($result);
        $order_id = $row['order_id']; // Get the order ID from the database
        
        // SQL to delete the order
        $delete_query = "DELETE FROM `user_orders` WHERE order_id = $order_id";
        $run_delete = mysqli_query($conn, $delete_query);

        // Check if the deletion was successful
        if ($run_delete) {
            echo "<script>alert('Order removed successfully!'); window.open('index.php','_self');</script>";
        } else {
            echo "<script>alert('Failed to remove order.');</script>";
        }
    } else {
        // If query failed or order not found
        echo "<script>alert('Order not found or query failed.');</script>";
    }
}
?>
