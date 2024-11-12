<?php
if (isset($_GET['delete_payment'])) {
    $delete_id = $_GET['delete_payment'];
    
    // SQL to get the order based on the order ID
    $get_data = "SELECT * FROM user_payments WHERE payment_id = {$delete_id}";
    $result = mysqli_query($conn, $get_data);

    // Check if the query executed successfully
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the data
        $row = mysqli_fetch_assoc($result);
        $payment_id = $row['payment_id']; // Get the order ID from the database
        
        // SQL to delete the order
        $delete_query = "DELETE FROM `user_payments` WHERE payment_id = $payment_id";
        $run_delete = mysqli_query($conn, $delete_query);

        // Check if the deletion was successful
        if ($run_delete) {
            echo "<script>alert('user_payments removed successfully!'); window.open('index.php','_self');</script>";
        } else {
            echo "<script>alert('Failed to remove user_payments');</script>";
        }
    } else {
        // If query failed or order not found
        echo "<script>alert('user_payments not found or query failed.');</script>";
    }
}
?>
