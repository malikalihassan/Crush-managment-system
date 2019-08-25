<?php

require 'Connection.php';
session_start();
if (isset($_POST['signup'])) {
    if (!empty($_POST)) {        // keep track validation errors
        $fnameError = null;
        $lnameError = null;
        $emailError = null;
        $mobileError = null;
        $passwordError = null;
        $passwordconfirmError = null;
        $notmachpassword = NULL;
        // keep track post values
        $fname = $_POST['fnamesignup'];
        $lname = $_POST['lnamesignup'];
        $email = $_POST['emailsignup'];
        $mobile = $_POST['phonesignup'];
        $passwordsign = $_POST['passwordsignup'];
        $passwordconfirm = $_POST['passwordsignup_confirm'];
        // validate input
        $valid = true;
        if (empty($fname)) {
            $fnameError = 'Please enter first Name';
            $valid = false;
        }
        if (empty($lname)) {
            $lnameError = 'Please enter first Name';
            $valid = false;
        }
        if (empty($email)) {
            $emailError = 'Please enter Email Address';
            $valid = false;
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = 'Please enter a valid Email Address';
            $valid = false;
        }

        if (empty($mobile)) {
            $mobileError = 'Please enter Mobile Number';
            $valid = false;
        }
        if (empty($passwordsign)) {
            $passwordError = 'Please enter password';
            $valid = false;
        }
        if (empty($passwordconfirm)) {
            $passwordconfirmErro = 'Please enter confirm password';
            $valid = false;
        }
        if ($passwordsign != $passwordconfirm) {
            echo 'Password does not mach';
            $valid = false;
            header("Location: signup.html");
        }
        // insert data
        if ($valid) {
            
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $search = "SELECT employee_id from employee where jobtitle='Manager'";
            $id = $pdo->prepare($search);
            $employeeId = $id->execute();
         
            $sql = "INSERT INTO customer (firstname,lastname,phonenumber,email,password,employee_id) values(?,?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($fname, $lname, $mobile, $email, $passwordsign, $employeeId));
            Database::disconnect();
            header("Location: index.html");
        }
    }
}
?>
