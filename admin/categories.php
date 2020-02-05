<?php
    include "includes/admin_header.php";

?>


    <div id="wrapper">

    <!-- Navigation -->

    <?php include "includes/admin_navigation.php";?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin
                        <small>Author</small>
                    </h1>

                    <div class="col-xs-6">
                        <?php

                            if (isset($_POST['submit'])){
                                $cat_title =  $_POST['cat_title'];

                                if ($cat_title == "" || empty($cat_title)){
                                    echo "This field should not be empty";
                                }else{
                                    $query = "INSERT INTO categories(cat_title) VALUE ('{$cat_title}')";
                                    $create_category_query = mysqli_query($connection, $query);
                                    header("Location: categories.php"); //refresh the page

                                    //make sure if the query failed we send an error message
                                    if (!$create_category_query) {
                                        die('Query failed' . mysqli_error($connection));
                                    }

                                }

                            }
                        
                        ?>
                        
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat-title">Add Category</label>
                                <input name="cat_title" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" name="submit" type="submit" value="Add Category">
                            </div>

                        </form>

                        <?php
                            if (isset($_GET['edit'])){
                                $cat_id = $_GET['edit'];
                                include "includes/update_categories.php";
                            }
                        ?>

                </div> <!-- Add + Edit category form-->


                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Category Title</th>
                            </tr>
                            </thead>
                            <tbody>

                                <?php
                                    // find all categories query
                                    $query = "SELECT * FROM categories";
                                    $select_categories = mysqli_query($connection, $query);

                                    while($row = mysqli_fetch_assoc($select_categories)) {
                                        $cat_id = $row['cat_id'];
                                        $cat_title = $row['cat_title'];
                                        echo "<tr>";
                                            echo "<td>{$cat_id}</td>";
                                            echo "<td>{$cat_title}</td>";
                                            echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
                                            echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
                                        echo "</tr>";
                                    }

                                    //DELETE query
                                    if (isset($_GET['delete'])){
                                        $the_cat_id =  $_GET['delete'];
                                        
                                        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";
                                        $delete_query = mysqli_query($connection, $query);
                                        header("Location: categories.php"); //refresh the page

                                    }

                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->



    </div>
    <!-- /#page-wrapper -->


<?php include "includes/admin_footer.php"; ?>