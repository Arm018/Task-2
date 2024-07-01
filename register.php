<?php
    session_start();

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';


    if (isset($name, $email, $password)) {

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
                header("Location: login.html");

            } else {
                echo "Error: Failed to execute SQL statement.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $stmt = null;
        $conn = null;
    }
    ?>
