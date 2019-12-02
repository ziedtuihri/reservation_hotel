<?php
require 'DB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitBtn"])) {
    $errors_ = null;

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors_ .= Util::displayAlertV1("Please enter a valid email address.", "warning");
    }
    if (strlen($_POST["password"]) < 4 || strlen($_POST["password2"]) < 4) {
        $errors_ .= Util::displayAlertV1("A password of at least 4 characters is required", "warning");
    }
    if (!empty($_POST["password"]) && !empty($_POST["password2"])) {
        if ($_POST["password"] != $_POST["password2"]) {
            $errors_ .= Util::displayAlertV1("Password not match.", "warning");
        }
    }

    if (!empty($errors_)) {
        echo $errors_;
    } else {

      $fullName = $_POST["fullName"];
      $email = $_POST["email"];
      $phoneNumber = $_POST["phoneNumber"];
      $password = $_POST["password"];

  $sql = "INSERT INTO `client` (`fullname`, `email`, `password`, `phone`)
  VALUES ('$fullName', '$email','".md5($password)."', '$phoneNumber')";

  $result = mysqli_query($con,$sql);
         if($result){
             echo "<div class='form'>
               <h3 style=\"color: green;\">You are registered successfully.</h3> ";
             }else{
               echo "<div class='form'>
                 <h3 style=\"color: red;\">You are not registered error.</h3> ";
             }

    }
}
