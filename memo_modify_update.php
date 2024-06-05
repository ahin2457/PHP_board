<?php
session_start();
include "db.php";
ini_set('display_errors', '0');


if (!$_SESSION['UID']) {
  echo "member";
  exit;
}

$memoid = $_POST['memoid'];
$memo = $_POST['memo'];

$result = $ahindb->query("select * from memo where memoid=" . $memoid) or die("query error=>" . $ahindb->error);
$rs = $result->fetch_object();

if ($rs->userid != $_SESSION['UID']) {
  echo "my";
  exit;
}

//$sql = "update memo set memo=" . $memo . "where memoid=" . $memoid;
$memo = $ahindb->escape_string($memo);
$memoid = (int) $memoid;

if ($memoid > 0) {
  $sql = 'update memo set memo= \'' . $memo . '\' where memoid= ' . $memoid;

  $result = $ahindb->query($sql) or die($ahindb->error);

  echo "<div class=\"row g-0\">
      <div class=\"col-md-12\">
      <div class=\"card-body\">
        <p class=\"card-text\">" . $memo . "</p>
        <p class=\"card-text\"><small class=\"text-muted\">" . $_SESSION['UID'] . " / now</small></p>
        <p class=\"card-text\" style=\"text-align:right\"><a href=\"javascript:;\" onclick=\"memo_modi(" . $memoid . ")\">수정</a> / <a href=\"javascript:;\" onclick=\"memo_del(" . $memoid . ")\">삭제</a></p>
      </div>
    </div>
  </div>";
} else {
  // 잘못된 호출이다
}
