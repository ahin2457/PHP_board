<?php
session_start();
include "db.php";
ini_set('display_errors', '0');


# 로그인이 안돼 있으면 member 출력
if (!$_SESSION['UID']) {
  echo "member";
  exit;
}

# memoid를 가져옴
$memoid = $_POST['memoid'];

# memo table에서 memoid와 같은 query를 가져옴
$result = $ahindb->query("select * from memo where memoid=" . $memoid) or die("querry error=>" . $db->error);
# 필드명 인덱스를 가진 객체를 반환
$rs = $result->fetch_object();

# 등록된 userid와 로그인한 사람이 같지 않으면 js의 my의 alert인 본인이 작성한 글만 삭제할 수 있습니다. 출력
if ($rs->userid != $_SESSION['UID']) {
  echo "my";
  exit;
}

# 일치하면 아래의 코드를 출력함.
echo "<form class=\"row g-3\">
  <div class=\"col-md-10\">
    <textarea class=\"form-control\" id=\"memo_text_" . $rs->memoid . "\" style=\"height: 60px\">" . $rs->memo . "</textarea>
  </div>
  <div class=\"col-md-2\">
    <button type=\"button\" class=\"btn btn-secondary\" onclick=\"memo_modify(" . $rs->memoid . ")\" >댓글수정</button>
  </div>
</form>";
