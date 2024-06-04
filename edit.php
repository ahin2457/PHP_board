<?php
include 'db.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("UPDATE posts SET title = :title, content = :content WHERE id = :id");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header('Location: view.php?id=' . $id);
} else {
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $post = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>글 수정</title>
</head>
<body>
    <h1>글 수정</h1>
    <form action="edit.php?id=<?= $id ?>" method="post">
        <label for="title">제목:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
        <br>
        <label for="content">내용:</label>
        <textarea id="content" name="content" required><?= htmlspecialchars($post['content']) ?></textarea>
        <br>
        <button type="submit">수정</button>
    </form>
    <a href="view.php?id=<?= $id ?>">취소</a>
</body>
</html>
