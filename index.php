<?php
session_start();

$articles = isset($_SESSION['articles']) ? $_SESSION['articles'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>

</head>
<body>
<h2>Articles Page</h2>
<table>
    <thead>
    <tr>
        <th>Title</th>
        <th>Content</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($articles as $article): ?>
        <tr>
            <td><?= $article['title']; ?></td>
            <td><?= $article['content']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        border: 1px solid #ccc;
        text-align: left;
    }
</style>