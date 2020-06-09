<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php

    if (isset($_POST['submit'])){

        $firstName  =   $_POST['firstname'];
        $lastName   =   $_POST['lastname'];
        $username   =   $_POST['username'];
        $email      =   $_POST['email'];
        $password   =   $_POST['password'];

        if (!empty($firstName) && !empty($lastName)  && !empty($username) && !empty($email) && !empty($password)){

            $firstName  =   mysqli_real_escape_string($connection, $firstName);
            $lastName   =   mysqli_real_escape_string($connection, $lastName);
            $username   =   mysqli_real_escape_string($connection, $username);
            $email      =   mysqli_real_escape_string($connection, $email);
            $password   =   mysqli_real_escape_string($connection, $password);

            $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));



//            $query = "SELECT randSalt FROM users";
//            $select_randSalt_query = mysqli_query($connection, $query);
//
//            if (!$select_randSalt_query) {
//                die("query failed" . mysqli_error($connection));
//            }

//            $row = mysqli_fetch_array($select_randSalt_query);
//            $salt = $row['randSalt'];
//
//            $password = crypt($password, $salt);


            $query = "INSERT INTO users(user_firstname, user_lastname, username, user_email, user_password, user_role)
                  VALUES ('{$firstName}', '{$lastName}', '{$username}', '{$email}', '{$password}', 'subscriber')";
            $register_user_query = mysqli_query($connection, $query);

            if (!$register_user_query){
                die("Query failed" . mysqli_error($connection));
            }

            $message = "Your registration submitted";

        } else {

            $message = "Fields can not be empty";
        }
    } else {
        $message = "";
    }


?>



    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">

                       <h6 class="text-center"><?= $message; ?></h6>

                        <div class="form-group">
                            <label for="firstname" class="sr-only">firstname</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter First Name">
                        </div>

                        <div class="form-group">
                            <label for="lastname" class="sr-only">lastname</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter Last Name">
                        </div>

                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>

                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>

                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
