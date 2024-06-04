<?php
session_start();
include 'db.php';

if (!$_SESSION['UID']) {
    echo "<script>alert('회원 전용 게시판입니다.');location.href='/index.php';</script>";
    exit;
}

# post가 아니면 get으로 받음
$bid = $_POST["bid"] ?? $_GET["bid"];

# bid(글)이 있으면 삭제 가능 
# userid가 작성자와 일치하는 경우 삭제 가능 아니면 alert창 
if ($bid) {
    $result = $ahindb->query("select * from board where bid=" . $bid) or die("query error => " . $mysqli->error);
    $rs = $result->fetch_object();

    if ($rs->userid != $_SESSION['UID']) {
        echo "<script>alert('본인 글이 아니면 삭제할 수 없습니다.');location.href='board.php';</script>";
        exit;
    }

    # status 값을 바꿔준다.
    $sql = "update board set status=0 where bid=" . $bid;
    $result = $ahindb->query($sql) or die($ahindb->error);
} else {
    echo "<script>alert('삭제할 수 없습니다.');history.back();</script>";
    exit;
}

if ($result) {
    echo "<script>alert('삭제했습니다.');location.href='board.php';</script>";
    exit;
} else {
    echo "<script>alert('글 삭제에 실패했습니다.');history.back();</script>";
    exit;
}
