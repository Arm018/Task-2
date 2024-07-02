
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>
<body>

<div class="container">
    <div class="screen">
        <div class="screen__content">
            <form class="login" action="register.php" method="post">
                <div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input type="text" name="name" class="login__input" placeholder="Name">
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-lock"></i>
                    <input type="email" name="email" class="login__input" placeholder="Email">
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-lock"></i>
                    <input type="password" name="password" class="login__input" placeholder="Password">
                </div>
                <button class="button login__submit">
                    <span class="button__text">Register</span>
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

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (!empty($name) && !empty($email) && !empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $localhost = "localhost";
            $root = "root";
            $db_pass = '';
            $db_name = 'cms';

            try {
                $conn = new PDO("mysql:host=$localhost;dbname=$db_name", $root, $db_pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("INSERT INTO admin (name, password, email) VALUES (:name, :password, :email)");

                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':email', $email);

                if ($stmt->execute()) {

                    header("Location: login.php");

                } else {
                    echo "Error: Failed to execute SQL statement.";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            $stmt = null;
            $conn = null;
        } else {
            echo "Please fill in all fields.";
        }
    }
    ?>

