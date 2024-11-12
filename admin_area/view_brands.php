
<h1 class="text-center text-success">All brands</h1>
<table class="table table-bordered mt-5">
    <thead class="bg-info">
        <tr class="text-center">
                <th>SN</th>
                <th>Brand title</th>
                <th>Edit</th>
                <th>Delete</th>
            
        </tr>
    </thead>
    <tbody class="bg-secondary text-light">
    <?php
        $select_brand="select * from `brands`";
        $result=mysqli_query($conn,$select_brand);
        $number=0;
        while($row=mysqli_fetch_assoc($result)){
            $brand_id=$row['brand_id'];
            $brand_title=$row['brand_name'];
            $number++;
       

?>
        <tr class="text-center">
            <td><?php echo $number; ?></td>
            <td><?php echo $brand_title; ?></td>
            <!-- <td><?php echo$status;?></td> -->
            <td><a href='index.php?edit_brands=<?php echo $brand_id ?>'class='text-dark'><i class='fa-solid fa-pen-to-square'></i></a></td>
            <td><a href='index.php?remove_brand=<?php echo $brand_id ?>'class='text-dark'><i class='fa-solid fa-trash'></i></a></td>
        </tr>
        <?php
         }
         ?>
    </tbody>
</table>