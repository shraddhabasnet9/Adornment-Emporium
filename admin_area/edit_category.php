<?php
if(isset($_GET['edit_category'])){
    $edit_category=$_GET['edit_category'];
    // echo $edit_category;
    $get_categories="select * from `categories` where category_id={$edit_category}";
    $result=mysqli_query($conn,$get_categories);
    $row=mysqli_fetch_assoc($result);
    $category_title=$row['category_title'];
    // echo $category_title;
    

}
if(isset($_POST['edit_category'])){
    $cat_title=$_POST['category_title'];

    $update_query="update `categories` set category_title='$cat_title' where category_id=$edit_category";
    $result_cat=mysqli_query($conn, $update_query);
    if($result_cat){
        echo "<script>alert('category is been updated successfully')</script>";
        echo "<script>window.open('./index.php,'_self')</script>";

    }
}

?>



<div class="container mt-3">
    <h1 class="text-center">Edit Category</h1>
    <form action="" method="post" class="text-center">
        <div class="input-group w-90 mb-2">
            <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
            <input type="text" name="category_title" id="category_title" class="form-control" required="required"
            value='<?php echo $category_title; ?>'>
        </div>
        <input type="submit" value="Update Category" class="bg-info border-0 p-2 my-3"
        name="edit_category">
    </form>
</div>