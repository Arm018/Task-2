<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

include 'functions.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['title']) && !empty($_POST['content'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];

        $db_host = "localhost";
        $db_user = "root";
        $db_pass = '';
        $db_name = 'cms';

        try {
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("INSERT INTO articles (title, content) VALUES (:title, :content)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->execute();

            header("Location: index.php");
            exit();
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }

        $conn = null;
    } else {
        $error = "The fields are required";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adminka</title>
    <style>
        div {
            display: flex;
            flex-direction: column;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        label {
            font-weight: bold;
            margin-bottom: 8px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            font-size: 20px;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        a {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            font-size: 20px;
        }
        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div>
    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="admin.php">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title">
        <label for="content">Content:</label>
        <textarea name="content" style="max-width: 400px" id="content"></textarea>
        <button type="submit">Create</button>
        <a href="index.php">Go to the Articles Page</a>
    </form>
</div>
</body>
</html>
