<?php
# unlink 함수 : 지정된 파일을 삭제하는 PHP 함수
# POST 요청으로 전달된 id값을 이용하여 파일 경로를 생성함.
# $_POST['id']가 example.txt라면 이 함수는 data/example.txt 파일을 삭제함.
#unlink('data/' . $_POST['UID']);

# hedaer 함수 : HTTP 헤더를 설정하는 함수
# 웹 브라우저를 '/board.php'로 리다이렉션
# 즉, 파일 삭제 후 사용자가 '/board.php'로 이동하게 됨.
#header('location: /board.php');

ini_set('display_errors', 1);
ini_set('display_startip_errors', 1);
error_reporting(E_ALL);

# 데이터베이스 연결 파일과 Board 클래스 파일을 포함
include 'db.php';
require './board/Board.class.php';

// 응답을 JSON 형식으로 설정
header('Content-Type: application/json');

// 기본 응답 배열을 정의
$response = ['success' => false, 'message' => ''];

# 클라이언트가 서버에 보낸 요청이 POST요청인지 확인
# $_SERVER['REQUEST_METHOD'] : 현재 요청의 메소드(HTTP 메소드)를 반환함
# 요청 메소드가 POST인지 확인
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ids = isset($_POST['ids']) ? $_POST['ids'] : [];

    # ids 배열이 비어 있지 않은지 확인
    if (!empty($ids)) {

        # Board 클래스의 인스턴스를 생성
        $AhinBoard = new Board($ahindb);
        $deletedCount = 0;
        $failedCount  = 0;

        # 각 ids에 대해 삭제 작업을 수행
        foreach ($ids as $id) {

            # 삭제가 성공하면 삭제된 게시글 수를 증가
            if ($AhinBoard->deletePost($id)) {
                $deletedCount++;
            } else {
                $failedCount++;
            }
        }

        # 하나 이상의 게시글이 삭제되었는지 확인
        if ($deletedCount > 0) {
            $response['success'] = true;
            $response['message'] = $deletedCount . "개의 게시글이 삭제되었습니다.";
        }

        if ($failedCount > 0) {
            $response['message'] .= " " . $failedCount . "개의 게시글 삭제에 실패했습니다.";
        }
        # 삭제된 게시글의 수
        if ($deletedCount == 0 && $failedCount > 0) {
            $response['success'] = false;
            $response['message'] = '게시글 삭제에 실패했습니다. 실패한 게시글의 수: ' . $failedCount;
        }
    } else {
        $response['message'] = "삭제할 항목을 선택하지 않았습니다.";
    }
} else {
    $response['message'] = "잘못된 요청입니다.";
}

// JSON 형식으로 응답
echo json_encode($response);

// echo "<script>window.location.href='board.php';</script>";
