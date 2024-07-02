<?php

function getArticles() {
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = '';
    $db_name = 'cms';
    $articles = [];

    try {
        $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT id, title, content FROM articles ORDER BY id DESC");
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
    return $articles;
}
?>
