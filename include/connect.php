<?php
$conn=mysqli_connect("localhost","root","","ejwellery");
if(mysqli_connect_error()){
    echo "connection error" . $conn->connect_error;

}
?>