<?php
require 'config/constants.php';

$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;

unset($_SESSION['signup-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGSITRASI ADMIN</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <!--ICONS-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!--FONTS-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Sign Up</h2>
        <?php if(isset($_SESSION['signup'])): ?> 
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['signup'];
                    unset($_SESSION['signup']);
                    ?>
                </p>
            </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>signup_logic.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="username" value="<?= $username?>" placeholder="Username">
            <input type="email" name="email" value="<?= $email?>" placeholder="Email">
            <input type="password" name="createpassword" value="<?= $createpassword?>" placeholder="Create password">
            <input type="password" name="confirmpassword" value="<?= $confirmpassword?>" placeholder="Confirm password">
            <button type="submit" name="submit" class="btn">Sign Up</button>
        </form>
    </div>
</section>

</body>
</html>