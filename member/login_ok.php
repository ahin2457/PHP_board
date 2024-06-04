<?php
#로그인 처리와 로그인 여부를 확인하기 위해 세션을 사용한다.
#세션값을 저자하거나 확인할 때느 항상 최상단에 session_start(); 함수를 호출해야함.
session_start();

include(__DIR__ . '/../db.php');

$userid = $_POST["userid"];
$passwd = $_POST["passwd"];
$passwd = hash('sha512', $passwd);

$query = "select * from members where userid='" . $userid . "'and passwd='" . $passwd . "'";
$result = $ahindb->query($query) or die("query error =>" . $ahindb->error);

# fetch_object 필드명 인덱스를 가진 객체를 반환
$rs = $result->fetch_object();

if ($rs) {
    # 세션에 아이디값을 입력
    $_SESSION['UID'] = $rs->userid;
    # 세션에 사용자 이름을 입력
    $_SESSION['UNAME'] = $rs->username;
    echo "<script>alert('어서오십시오.');location.href='../board.php';</script>";
    exit;
} else {
    echo "<script>alert('아이디나 암호가 틀렸습니다. 다시한번 확인해주십시오.');history.back()</script>";
    exit;
}
