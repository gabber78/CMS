<?php include "db.php";

session_start();

if (isset($_POST['login'])){

     $username = $_POST['username'];
     $password = $_POST['password'];

     $username =  mysqli_real_escape_string($connection, $username);
     $password =  mysqli_real_escape_string($connection, $password);

     $query = "SELECT * FROM users WHERE username = '{$username}'";
     $select_user_query = mysqli_query($connection, $query);

     if(!$select_user_query){
         die("Query failed" . mysqli_error($connection));
     }

     while ($row = mysqli_fetch_array($select_user_query)) {
         $db_user_id = $row['user_id'];
         $db_username = $row['username'];
         $db_user_password = $row['user_password'];
         $db_user_firstname = $row['user_firstname'];
         $db_user_lastname = $row['user_lastname'];
         $db_user_role = $row['user_role'];

     }

// * old version not working*
//if($username !== $db_username && $password !== $db_user_password) {
//    header("Location: ../index.php");
//
//}else if ($username == $db_username && $password == $db_user_password){
//
////    var_dump($db_username);
////    var_dump($db_user_password);
////    exit;
//    header("Location ../admin");
//}else {
//    header("Location: ../index.php");
//}

    if($username == $db_username && $password == $db_user_password){   //username and password are correct
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;

        header("Location: ../admin");
    } else {
        header("Location: ../index.php");
    }

}

