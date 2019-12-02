<?php

ob_start();
session_start();


require 'DB.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitBtn"])) {
    $errors_ = null;

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors_ .= Util::displayAlertV1("Please enter a valid email address", "warning");
    }
    if (empty($_POST["password"])) {
        $errors_ .= Util::displayAlertV1("Password is required.", "warning");
    }
    if (!empty($errors_)) {
        echo $errors_;
    } else {

      $email = $_POST["email"];
      $password = $_POST["password"];

      $sql = "SELECT * FROM `client` WHERE email = '$email' and password = '".md5($password)."' ";
       $result = mysqli_query($con,$sql);
        $rows1 = mysqli_num_rows($result);

       if($rows1 == 1){
         $sql2 = "SELECT * FROM `client` WHERE email='$email' and isadmin = 1 ";
          $result2 = mysqli_query($con,$sql2);
            $rows2 = mysqli_num_rows($result2);
            
          if($result2){
            $_SESSION["username"] = $_POST["email"];
            $_SESSION["accountEmail"] = $_POST["email"];
            $_SESSION['isAdmin'] = 1;
            echo $_SESSION['isAdmin'];
          }else{
            $_SESSION["username"] = $email;
            $_SESSION["accountEmail"] = $email;
            $_SESSION["authenticated"] = 1;
            $_SESSION["password"] = $_POST["password"];
            echo $_SESSION["authenticated"];
          }
       }else {
         echo Util::displayAlertV1("Incorrect password or email ", "warning");
       }
    }
}
