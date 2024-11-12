<?php
    @include('../include/connect.php');
    if(isset($_POST['insert_brand'])){
        $brand_name = $_POST['brand_title'];
        //select data from db
        $select_query="Select * from `brands` where brand_name='$brand_name'";
        $_result_select = mysqli_query($conn, $select_query);
        $number=mysqli_num_rows($_result_select);
        
        if($brand_name==''){
            echo "<script>alert('Input brand to insert in database')</script>";
        }else{
            if($number>0){
                echo "<script>alert('Brand is present in database')</script>";
            }else{
                // Correct the SQL query syntax by using backticks or removing quotes around table/column name
                $insert_query = "INSERT INTO `brands` (brand_name) VALUES ('$brand_name')";
                $_result = mysqli_query($conn, $insert_query);
                if($_result){
                    echo "<script>alert('Brand has been successfully inserted')</script>";
                }else {
                    echo "<script>alert('Failed to insert brand')</script>";
                }
            }
        }
    }
?>
<h2 class="text-center">Insert Brands</h2>
<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
        <input type="text" class="form-control" name="brand_title" placeholder="Insert Brands" >
    </div>
    <div class="input-group w-102 mb-2 m-auto">
    <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_brand" value="Insert Brands">
        <!-- <button class="bg-info p-3 border-0 my-3">Insert Brands</button> -->
    </div>
</form>