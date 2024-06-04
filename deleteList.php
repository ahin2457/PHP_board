<?php
# unlink 함수 : 지정된 파일을 삭제하는 PHP 함수
# POST 요청으로 전달된 id값을 이용하여 파일 경로를 생성함.
# $_POST['id']가 example.txt라면 이 함수는 data/example.txt 파일을 삭제함.
#unlink('data/' . $_POST['UID']);

# hedaer 함수 : HTTP 헤더를 설정하는 함수
# 웹 브라우저를 '/board.php'로 리다이렉션
# 즉, 파일 삭제 후 사용자가 '/board.php'로 이동하게 됨.
#header('location: /board.php');
include 'db.php';
require './board/Board.class.php';

$AhinBoard = new Board($ahindb);
