<?php
session_start();
include 'db.php';
require './board/Board.class.php';

if (!$_SESSION['UID']) {
    echo "<script>alert('회원 전용 게시판입니다.');history.back();</script>";
    exit;
}

# get으로 넘겼으니 get으로 받음. GET으로 받은 변수 처리
$bid = isset($_GET['bid']) ? intval($_GET['bid']) : 0;
$parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0;

$rs = new stdClass();
$rs->subject = '';
$rs->content = '';

$docTitle = $btnName = '등록';

# bid가 있다는건 수정이라는 의미
if ($bid > 0) {
    $btnName = '수정';

    $result = $ahindb->query("select * from board where bid=" . $bid) or die("query error=>" . $ahindb->error);
    $rs = $result->fetch_object();
    $docTitle = $btnName . ' > ' . $rs->subject;
    if ($rs->userid != $_SESSION['UID']) {
        echo "<script>alert('본인 글이 아니면 수정할 수 없습니다.');history.back();</script>";
        exit;
    }
}

if ($parent_id > 0) { //parent_id가 있다는건 답글이라는 의미다.
    $btnName = '답글 등록';
    $result = $ahindb->query("select * from board where bid=" . $parent_id) or die("query error => " . $ahindb->error);
    $rs = $result->fetch_object();
    $rs->subject = "[RE]" . $rs->subject;
    $docTitle = $btnName . ' > ' . $rs->subject;
}

?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <title><?= $docTitle ?></title>
    <script>
        // input box 가 비어져 있을때 alert
        function validateForm(event) {
            let subject = document.forms["boardForm"]["subject"].value;
            let content = document.forms["boardForm"]["content"].value;
            if (subject == "" || content == "") {
                alert("제목과 내용을 입력하세요.");
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <div class="col-md-8" style="margin:auto;padding:20px;">
        <form name="boardForm" method="post" action="write_ok.php" onsubmit="return validateForm(event);">
            <input type="hidden" name="bid" value="<?php echo $bid; ?>">
            <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">제목</label>
                <input type="text" name="subject" class="form-control" id="exampleFormControlInput1" placeholder="제목을 입력하세요." value="<?php echo $rs->subject; ?>">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">내용</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="content" rows="3" placeholder="내용을 입력하세요."><?php echo $rs->content; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><?= $btnName ?></button>
            <a class="btn btn-outline-primary" href="board.php">목록</a>
        </form>
    </div>
</body>

</html>