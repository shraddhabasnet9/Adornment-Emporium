<?php
if(isset($_GET['edit_brands'])){
    $edit_brands=$_GET['edit_brands'];
    // echo $edit_brands;
    $get_brands="select * from `brands` where brand_id=$edit_brands";
    $result=mysqli_query($conn,$get_brands);
    $row=mysqli_fetch_assoc($result);
    $brand_title=$row['brand_name'];
    // echo $brands_title;

}
if(isset($_POST['edit_brands'])){
    $brand_title=$_POST['brand_title'];

    $update_query="update `brands` set brand_name='$brand_title' where brand_id=$edit_brands";
    $result_brand=mysqli_query($conn, $update_query);
    if($result_brand){
        echo "<script>alert('brand  updated successfully')</script>";
        echo "<script>window.open('./index.php'_self')</script>";

    }
}

?>

<div class="container mt-3">
    <h1 class="text-center">Edit Brands</h1>
    <form action="" method="post" class="mb-2">
        <div class="input-group w-90 mb-2">
            <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
            <input type="text" name="brand_title" id="brand_title" class="form-control" placeholder="Insert Brands" required="required"
            value="<?php echo $brand_title; ?>">
        </div>
        <input type="submit" value="Update Brand" class="bg-info border-0 p-2 my-3" name="edit_brands">
    </form>
</div>