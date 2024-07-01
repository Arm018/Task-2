<?php


    session_start();


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

            $stmt = $conn->prepare("SELECT id, title, content FROM articles ORDER BY id DESC");
            $stmt->execute();

            $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['articles'] = $articles;

            header("Location: index.php");
            exit();
        } catch (Exception $e) {
            $e->getMessage();
        }
        $conn = null;
    } else {
        echo "The fields are required";
}

