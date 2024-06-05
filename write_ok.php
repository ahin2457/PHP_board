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
$parent_id = (int)$_POST["parent_id"]; # parent_id가 있으면 답글이다.
$userid    = $_SESSION['UID'];    # userid를 SESSION 값으로 넣어주기
$status    = 1;                   # 1이면 true, 0이면 false


#bid 값이 있으면 수정 아니면 등록
$bid       = isset($_POST["bid"]) ? (int)$_POST["bid"] : 0;
$subject       = isset($_POST["subject"]) ? $ahindb->escape_string($subject) : '';
$content       = isset($_POST["content"]) ? $ahindb->escape_string($content) : '';

if ((int)$bid > 0) {
    $result = $ahindb->query("select * from board where bid=" . $bid) or die("query error=> " . $ahindb->error);
    $rs = $result->fetch_object();

    if ($rs->userid != $_SESSION['UID']) {
        echo "<script>alert('본인 글이 아니면 수정할 수 없습니다.');location.href='board.php';</script>";
        exit;
    }
    $sql = "update board set subject='" . $subject . "',content='" . $content . "' where bid=" . $bid; # 수정하기
} else {
    # 답글인 경우 쿼리를 수정해서 parent_id를 넣어줌
    $sql = ($parent_id)
        ? "insert into board(userid,subject,content,parent_id) values('" . $userid . "','" . $subject . "','" . $content . "','" . $parent_id . "')"
        : "insert into board(userid,subject,content) values('" . $userid . "','" . $subject . "','" . $content . "')"; # 등록하기
}

# list에 등록 버튼 작동
try {
    $result = $ahindb->query($sql); // or die();
    $newid = $ahindb->insert_id; // 자동 증가
} catch (Exception $ex) {
    $result = false;
    $newid = 0;
}

if ($result && $newid > 0) {
    echo "<script>alert('등록되었습니다.'); window.location.href = 'board.php';</script>";
    // echo "<script>location.href='board.php';</script>";
    exit;
} else {
    $message = '글 등록에 실패했습니다.\n Error : ' . $ahindb->escape_string($ahindb->error);
    echo '<script>alert("' . $message . '");history.back();</script>';
    exit;
}
