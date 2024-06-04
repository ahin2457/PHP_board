<?php

include(__DIR__ . '/../db.php');
// include 'db.php';

$userid   = $_POST["userid"];
$username = $_POST["username"];
$email    = $_POST["email"];
$passwd   = $_POST["passwd"];

// hash() 해시 생성함수.
// 비밀번호 암호화
// 주어진 데이터를 특정 해시 알고리즘을 사용하여 해시값으로 변환함.
// 보안성을 높이기 위한 방법.
// 데이터의 무결성 검증, 비밀번호 저장 등의 보안 목적
// sha512 : SHA-2(Secure Hash Algorithm 2) 패밀리의 한 알고리즘으로, 512 비트 길이의 해시값을 생성함.
$passwd   = hash('sha512', $passwd);

$sql = "INSERT INTO members
            (userid, email, username, passwd)
          VALUES
            ('" . $userid . "', '" . $email . "', '" . $username . "', '" . $passwd . "')";

$result = $ahindb->query($sql) or die($ahindb->error);


if ($result) {
    echo "<script>alert('가입을 환영합니다.'); location.href='/project_test/board.php';</script>";
    exit;
} else {
    echo "<script>alert('회원가입에 실패했습니다.');history.back();</script>";
    exit;
}
