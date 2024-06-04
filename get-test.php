<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
    $table = $_GET["table"];
    $type = $_GET["type"];

    setcookie("cookie1", "abc");
    setcookie("cookie2","123",time()+10);

    if(isset($_COOKIE["cookie1"])) {
        $cookie1 = $_COOKIE["cookie1"];
        echo "cookie1 = $cookie1<br>";
    }
    if(isset($_COOKIE["cookie2"])) {
        $cookie2 = $_COOKIE["cookie2"];
        echo "cookie2 = $cookie2";
    } else {
        echo "cookie2 time out!";
    }
?>


>> <?=$table?> | <?=$type?>

    <h3>자유게시판</h3>
    <br>
    <a href="get-test.php?table=자유게시판&type=목록보기">목록보기</a><br>
    <a href="get-test.php?table=자유게시판&type=글쓰기">글쓰기</a><br>
    
    <h3>질문 게시판</h3>
    <br>
    <a href="get-test.php?table=질문게시판&type=목록보기">목록보기</a><br>
    <a href="get-test.php?table=질문게시판&type=글쓰기">글쓰기</a><br>
</body>
</html>