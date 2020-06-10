<?php include "includes/admin_header.php"; ?>
<?php
    if (isset($_SESSION['username'])){

        $username = $_SESSION['username'];

        $query = "SELECT * FROM users WHERE username = '{$username}'";
        $select_user_profile_query = mysqli_query($connection, $query);

        while($row = mysqli_fetch_array($select_user_profile_query)){
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
        }
    }
?>

<?php

if (isset($_POST['edit_user'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $query = "UPDATE users SET 
                 user_firstname         = '{$user_firstname}', 
                 user_lastname          = '{$user_lastname}', 
                 username               = '{$username}', 
                 user_email             = '{$user_email}', 
                 user_password          = '{$user_password}' 
           WHERE username                = '{$username}' ";

    $edit_user_query = mysqli_query($connection, $query);
    confirmQuery($edit_user_query);
    }

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
                        <small><?= $_SESSION['username']; ?></small>
                    </h1>

                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="title">First Name</label>
                            <input type="text" value="<?= $user_firstname ?>" class="form-control" name="user_firstname">
                        </div>

                        <div class="form-group">
                            <label for="post_status">Last Name</label>
                            <input type="text" value="<?= $user_lastname ?>" class="form-control" name="user_lastname">
                        </div>

                        <div class="form-group">
                            <label for="post_tags">Username</label>
                            <input type="text" value="<?= $username ?>" class="form-control" name="username">
                        </div>

                        <div class="form-group">
                            <label for="post_content">Email</label>
                            <input type="email" value="<?= $user_email ?>" class="form-control" name="user_email">
                        </div>

                        <div class="form-group">
                            <label for="post_content">Password</label>
                            <input type="password" autocomplete="off" class="form-control" name="user_password">
                        </div>

                        <div>
                            <input class="btn btn-primary" type="Submit" name="edit_user" value="Update Profile">
                        </div>


                    </form>

                </div>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->



    </div>
    <!-- /#page-wrapper -->


<?php include "includes/admin_footer.php"; ?>