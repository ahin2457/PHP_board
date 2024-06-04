<?php
session_start();

include "db.php";
ini_set('display_errors', '1'); // 오류를 출력 켜서 디버깅에 도움

// 로그인 확인
if (!$_SESSION['UID']) {
    $return_data = array(
        "result" => "member"
    );

    // json_encode() : php array 또는 string 따위를 JSON 으로 변환하는 PHP 함수
    // json_decode() : JSON형식 문자열을 배열 또는 객체로 변환하는 php 함수
    echo json_encode($return_data);
    // array("result" => "member") => {"result" : "member"}
    exit;
}

$memoid = isset($_POST['memoid']) ? intval($_POST['memoid']) : 0;

if ($memoid <= 0) {
    $return_data = array("result => no");
    echo json_encode($return_data);
    exit;
}

$result = $ahindb->query("select * from memo where memoid=" . $memoid) or die("query error=>" . $ahindb->error);

//fetch_object 필드명 인덱스를 가진 객체를 반환
$rs = $result->fetch_object();

if (!$rs) {
    $return_data = array(
        "result" => "no",
        'debug' => $rs,
    );
    echo  json_encode($return_data);
    exit;
}


if ($rs->userid != $_SESSION['UID']) {
    // 배열 생성 key => value
    $return_data = array(
        "result" => "my"
    );
    echo json_encode($return_data);
    exit;
}


$sql = "update memo set status = 0 where memoid=" . $memoid; //status 값을 바꿔줌
$result = $ahindb->query($sql) or die($ahindb->error);

if ($result) {
    $return_data = array("result" => "ok", 'debug' => $rs,);
    echo json_encode($return_data);
} else {
    $return_data = array("result" => "no");
    echo json_encode($return_data);
}
