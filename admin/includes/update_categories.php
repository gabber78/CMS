
<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Category</label>
        <?php

        if (isset($_GET['edit'])) {
            $cat_id = $_GET['edit'];

            $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
            $select_categories_id = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                ?>

                <input value="<?php if (isset($cat_title)){echo $cat_title;}?>" name="cat_title" type="text" class="form-control">

            <?php } } ?>

        <?php
        //UPDATE Query
        if (isset($_POST['update_category'])) {
            $the_cat_title = $_POST['cat_title'];

            $query = "UPDATE  categories SET cat_title = '{$the_cat_title}' WHERE cat_id = {$cat_id} ";
            $update_query = mysqli_query($connection, $query);
            //header("Location: categories.php"); //refresh the page
            if (!$update_query){
                die('query failed'. mysqli_error($connection));
            }
        }

        ?>

    </div>
    <div class="form-group">
        <input class="btn btn-primary" name="update_category" type="submit" value="Edit Category">
    </div>
</form>