<?php
    @include('../include/connect.php');
    if(isset($_POST['insert_cart'])){
        $category_title = $_POST['cat_title'];
        //select data from db
        $select_query="Select * from `categories` where category_title='$category_title'";
        $_result_select = mysqli_query($conn, $select_query);
        $number=mysqli_num_rows($_result_select);
        if($category_title==''){
            echo "<script>alert('Input category to insert in database')</script>";
        }else{
            if($number>0){
                echo "<script>alert('Category is present in database')</script>";
            }else{
                // Correct the SQL query syntax by using backticks or removing quotes around table/column name
                $insert_query = "INSERT INTO `categories` (category_title) VALUES ('$category_title')";
                $_result = mysqli_query($conn, $insert_query);
                if($_result){
                    echo "<script>alert('Category has been successfully inserted')</script>";
                }else {
                    echo "<script>alert('Failed to insert category')</script>";
                }
                
            }
        }
    }
?>


<h2 class="text-center">Insert Categories</h2>
<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
        <input type="text" class="form-control" name="cat_title" placeholder="Insert Categories" >
    </div>
    <div class="input-group w-102 mb-2 m-auto">
        <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_cart" value="Insert Categories">
        <!-- <button class="bg-info p-3 border-0 my-3">Insert Categories</button> -->
    </div>
</form>