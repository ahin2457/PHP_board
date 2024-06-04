<?php
session_start();
include "db.php";

if (!$_SESSION['UID']) {
    echo "<script>alert('회원 전용 게시판입니다.');location.href='board.php';</script>";
    exit;
}

// echo "<pre>";
// print_r($_POST);

$subject   = $_POST["subject"];
$content   = $_POST["content"];
$bid       = $_POST["bid"];       # bid 값이 있으면 수정 아니면 등록
$parent_id = $_POST["parent_id"]; # parent_id가 있으면 답글이다.
$userid    = $_SESSION['UID'];    # userid를 SESSION 값으로 넣어주기
$status    = 1;                   # 1이면 true, 0이면 false

#bid 값이 있으면 수정 아니면 등록
if ($bid) {
    $result = $ahindb->query("select * from board where bid=" . $bid) or die("query error=> " . $ahindb->error);
    $rs = $result->fetch_object();

    if ($rs->userid != $_SESSION['UID']) {
        echo "<script>alert('본인 글이 아니면 수정할 수 없습니다.');location.href='board.php';</script>";
        exit;
    }
    $sql = "update board set subject='" . $subject . "',content='" . $content . "' where bid=" . $bid; # 수정하기
} else {
    # 답글인 경우 쿼리를 수정해서 parent_id를 넣어줌
    if ($parent_id) {
        $sql = "insert into board(userid,subject,content,parent_id) values('" . $userid . "','" . $subject . "','" . $content . "','" . $parent_id . "')";
    } else
        $sql = "insert into board(userid,subject,content) values('" . $userid . "','" . $subject . "','" . $content . "')"; # 등록하기
}


# list에 등록 버튼 작동
$result = $ahindb->query($sql) or die($ahindb->error);

if ($result) {
    echo "<script>alert('등록되었습니다.'); window.location.href = 'board.php';</script>";
    // echo "<script>location.href='board.php';</script>";
    exit;
} else {
    echo "<script>alert('글 등록에 실패했습니다.');history.back();</script>";
    exit;
}
