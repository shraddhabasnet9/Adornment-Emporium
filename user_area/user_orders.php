
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Orders</title>
    <style>
    </style>
</head>
<body>
    <?php
    if(isset($_SESSION['username'])){
        $username=$_SESSION['username'];
        $get_user="SELECT * FROM user_table WHERE user_name = '$username'";
        $get_user_query = mysqli_query($conn, $get_user);
        $row_fetch = mysqli_fetch_array($get_user_query);
        $user_id = $row_fetch['user_id'];
    }else{
        echo "<script>window.open('../index.php','_self')</script>";
    }

    ?>
    <h3 class="text-success text-center">My Orders</h3>
    <table class="table table-bordered mt-5">
        <thead class="bg-info">
            <tr>
                <th>SN</th>
                <th>Amount Due</th>
                <th>Total Products</th>
                <th>Invoice Number</th>
                <th>Date</th>
                <th>Complete/Incomplete</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody class="bg-secondary text-light">
            <?php
                $get_order_details="Select * from user_orders where user_id='$user_id'";
                $get_order_query = mysqli_query($conn,$get_order_details);
                $number=1;
                while($row_data=mysqli_fetch_assoc($get_order_query)){
                    $order_id=$row_data['order_id'];
                    $amount_due=$row_data['amount_due'];
                    $invoice_number=$row_data['invoice_number'];
                    $total_products=$row_data['total_products'];
                    $order_date=$row_data['order_date'];
                    $order_status=$row_data['order_status'];
                    if($order_status=='pending'){
                        $order_status='Incomplete';

                    }else{
                        $order_status='Complete';
                    }
                    
                    echo "<tr>
                        <td>$number</td>
                        <td>$amount_due</td>
                        <td>$total_products</td>
                        <td>$invoice_number</td>
                        <td>$order_date</td>
                        <td>$order_status</td>";
            ?>
                        <?php
                        if($order_status=='Complete'){
                            echo "<td>Paid</td>";
                        }else{
                            echo "<td><a href='confirm_payment.php?order_id=$order_id' class='text-dark'>Confirm</a></td>
                            </tr>";
                        }
                    $number++;
                }
            ?>
            
        </tbody>
    </table>
</body>
</html>