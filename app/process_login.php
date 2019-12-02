<?php

// this script acts like a controller
// to process a login a JS request from form-submission.js is sent to this script
// view -> js -> process_login -> server
// view <- js <- process_login <- server
// other process scripts follow the same cycle

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
       if($result){
         $sql2 = "SELECT * FROM `client` WHERE email='$email' and isadmin = 1 ";
          $result2 = mysqli_query($con,$sql2);
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

/*
        $adminHandler = new AdminHandler();
        $admin = new Admin();
        // before running this method, make sure email exists
        $admin->setEmail($_POST["email"]);
        $adminId = ($adminHandler->getObjectUtil($admin->getEmail())->getAdminId());

        if ($adminId > 1 || intval($adminId) > 0) {
            $_SESSION["username"] = $_POST["email"];
            $_SESSION["accountEmail"] = $_POST["email"];
            $_SESSION['isAdmin'] = 1;
            echo $_SESSION['isAdmin'];
        } else {
            $handler = new CustomerHandler();
            $customer = new Customer();
            $customer->setEmail($_POST["email"]);

            $newCustomer = new Customer();
            if (!$handler->isPasswordMatchWithEmail($_POST['password'], $customer)) {
                echo Util::displayAlertV1("Incorrect password.", "warning");
            } else {
                $_SESSION["username"] = $handler->getUsername($_POST["email"]);
                $_SESSION["accountEmail"] = $customer->getEmail();
                $_SESSION["authenticated"] = 1;
                $_SESSION["password"] = $_POST["password"];

                // set the session phone number too
                if ($handler->getCustomerObj($_POST["email"])->getPhone()) {
                    $_SESSION["phoneNumber"] = $handler->getCustomerObj($_POST["email"])->getPhone();
                }
                echo $_SESSION["authenticated"];
            }
        }
        */
    }
}

/**
 * [x] validate the fields first
 * [x] if no errors check if email is registered
 *     if not registered, display not registered message
 *     otherwise, create a customer object
 * [x] check if password entered match with db password
 *     if not match display incorrect message
 *     otherwise, create a session variables
 */
