<?php
@include('include/connect.php');
    // Escape user inputs to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);


    // Fetch UID from the users table based on the provided email
    $sql_fetch_userid = "SELECT user_id FROM user_table WHERE user_email = '$email' AND user_name='$name'";
    $result = $conn->query($sql_fetch_userid);

    if ($result->num_rows > 0) {
        // Assuming that there is only one user with the provided email (unique email constraint)
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];

        // Insert feedback into the feedback table along with the fetched UID
        $sql_insert_message = "INSERT INTO users_message (user_id, user_name, user_email, subject, message) VALUES ('$user_id', '$name', '$email', '$subject', '$message')";

        if ($conn->query($sql_insert_message) === TRUE) {
            echo "<script>alert('message sent successfully')</script>";
            echo "<script>window.open('index.php','_self')</script>";
        } else {
            echo "<script>alert('Error posting values:')</script> " . $conn->error;
            echo "<script>window.open('contact_design.php','_self')</script>";
        }
    } else {
        echo "<script>alert('user and email address provided doesnot match.')</script>";
        echo "<script>window.open('contact_design.php','_self')</script>";
        
    }


?>

