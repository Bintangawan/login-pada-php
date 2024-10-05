<?php
require 'config/database.php';

if(isset($_POST['submit'])) {
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$username_email) {
        $_SESSION['signin'] = "Username atau Email Dibutuhkan";
    } elseif (!$password) {
        $_SESSION['signin'] = "Password Dibutuhkan";
    } else {
        $fetch_user_query = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
        $fetch_user_result = mysqli_query($connection, $fetch_user_query);

        if(mysqli_num_rows($fetch_user_result) == 1) {
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['password'];

            if(password_verify($password, $db_password)) {
                $_SESSION['user-id'] = $user_record['id'];

                // Remove admin check if not needed
                // if($user_record['is_admin'] == 1) {
                //     $_SESSION['user_is_admin'] = true;
                // }

                // Redirect to index.php after successful login
                header('location: ' . ROOT_URL . 'index.php');
                exit;
            } else {
                $_SESSION['signin'] = "Username atau Password Salah";
            }
        } else {
            $_SESSION['signin'] = "User Tidak Ditemukan";
        }
    }

    // Redirect back to signin.php if there's an error
    if (isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signin.php');
        exit;
    }
} else {
    // Redirect to signin page if user tries to access signin-logic.php directly
    header('location: ' . ROOT_URL . 'signin.php');
    exit();
}
