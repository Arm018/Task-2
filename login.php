<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>

<div class="container">
    <div class="screen">
        <div class="screen__content">
            <form class="login" action="login.php" method="post">
                <div class="login__field">
                    <i class="login__icon fas fa-lock"></i>
                    <input type="email" name="email" class="login__input" placeholder="Email">
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-lock"></i>
                    <input type="password" name="password" class="login__input" placeholder="Password">
                </div>
                <button class="button login__submit">
                    <span class="button__text">Log in</span>
                    <i class="button__icon fas fa-chevron-right"></i>
                </button>
            </form>

        </div>
        <div class="screen__background">
            <span class="screen__background__shape screen__background__shape4"></span>
            <span class="screen__background__shape screen__background__shape3"></span>
            <span class="screen__background__shape screen__background__shape2"></span>
            <span class="screen__background__shape screen__background__shape1"></span>
        </div>
    </div>
</div>

</body>
</html>



<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db_host = "localhost";
    $db_user = "root";
    $db_pass = '';
    $db_name = 'cms';

    try {
        $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT id, name, password FROM admin WHERE email = :email");


        $stmt->bindParam(':email', $email);

        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];


                header("Location: admin.php");
                exit();
            } else {
                echo "Invalid email or password.";
            }
        } else {
            echo "Invalid email or password.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

