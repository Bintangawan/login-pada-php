<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$username) {
        $_SESSION['signup'] = "Please Masukkan Username";
    } elseif (!$email) {
        $_SESSION['signup'] = "Please Masukkan Email yang Valid";
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['signup'] = "Password harus lebih dari 8 Karakter";
    } else {
        if($createpassword !== $confirmpassword) {
            $_SESSION['signup'] = "Password Tidak Sama";
        } else {
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            $user_check_query = "SELECT *FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result) > 0) {
                $_SESSION ['signup'] = "Username or Email sudah ada";
            } else {
                $insert_user_query = "INSERT INTO users (username, email, password) 
                VALUES('$username','$email','$hashed_password')";
                $insert_user_result = mysqli_query($connection, $insert_user_query);
                if (!mysqli_errno($connection)) {
                    $_SESSION['signup-success'] = "Berhasil Registrasi";
                    header('location: ' . ROOT_URL . 'signin.php');
                    die();
                }
            }
        }
    }

    if (isset($_SESSION['signup'])) {
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    }

} else {
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}
