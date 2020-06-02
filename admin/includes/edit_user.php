<?php

if (isset($_GET['edit_user'])) {
    $the_user_id = $_GET['edit_user'];

    $query = "SELECT * FROM users WHERE  user_id = $the_user_id";
    $select_users_query = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_users_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }
}

if (isset($_POST['edit_user'])) {

    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];


    $query = "SELECT randSalt FROM users";
    $select_randSalt_query = mysqli_query($connection, $query);
    if (!$select_randSalt_query){
        die("Query failed" . mysqli_error($connection));
    }

    $row = mysqli_fetch_array($select_randSalt_query);
    $salt = $row['randSalt'];
    $hashed_password = crypt($user_password, $salt);

    $query = "UPDATE users SET 
                 user_firstname         = '{$user_firstname}', 
                 user_lastname          = '{$user_lastname}', 
                 user_role              = '{$user_role}', 
                 username               = '{$username}', 
                 user_email             = '{$user_email}', 
                 user_password          = '{$hashed_password}' 
           WHERE user_id                = {$the_user_id} ";

    $edit_user_query = mysqli_query($connection, $query);

    confirmQuery($edit_user_query);

    }
?>


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
        <select name="user_role" id="">

            <option value="<?= $user_role ?>"><?= $user_role ?></option>
            <?php
                if ($user_role == 'admin'){
                    echo "<option value='subscriber'>subscriber</option>";
                } else {
                    echo "<option value='admin'>admin</option>";
                }
            ?>

<!--            <option value="admin">Admin</option>-->
<!--            <option value="subscriber">Subscriber</option>-->

        </select>
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
        <input type="password" value="<?= $user_password ?>" class="form-control" name="user_password">
    </div>

    <div>
        <input class="btn btn-primary" type="Submit" name="edit_user" value="Edit User">
    </div>


</form>

