<?php
include 'db.php';
// include './board/headermenu.php';
require './board/Board.class.php';

session_start();

// isset($_GET['bid']) : url에 'bid'라는 이름의 파라미터가 있는지 확인함.
$bid = isset($_GET['bid']) ? intval($_GET['bid']) : 0;

if ($bid > 0) {
    $AhinBoard = new Board($ahindb);
    $post = $AhinBoard->getPostById($bid);
} else {
    echo "Invalid post ID.";
    die();
}

$result = $ahindb->query("select * from board where bid=" . $bid) or die("query error=>" . $ahindb);
$rs = $result->fetch_object();

$query = "select * from memo where status=1 and bid=" . $rs->bid . " order by memoid desc";
$memo_result = $ahindb->query($query) or die("query error => " . $ahindb->error);
$memoArray = [];
while ($mrs = $memo_result->fetch_object()) {
    $memoArray[] = $mrs;
}

// 추천, 반대 초기값 설정
$recommend = [
    'like' => 0,
    'hate' => 0
];

$query2 = "select type,count(*) as cnt from recommend r where bid=" . $rs->bid . " group by type";
$rec_result = $ahindb->query($query2) or die("query error => " . $ahindb->error);
while ($recs = $rec_result->fetch_object()) {
    $recommend[$recs->type] = $recs->cnt;
}


?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
</head>

<body>
    <div class="col-md-8" style="margin:auto;padding:20px;">
        <h3 class="pb-4 mb-4 fst-italic border-bottom" style="text-align:center;">
            - 게시판 보기 -
        </h3>

        <article class="blog-post">
            <h2 class="blog-post-title"><?php echo $post->subject; ?></h2>
            <p class="blog-post-meta"><?php echo $post->regdate; ?> by <a href="#"><?php echo $post->userid; ?></a></p>

            <hr>
            <p>
                <?php echo $rs->content; ?>
            </p>

            <button type="button" class="btn btn-lg btn-primary" id="like_button">추천&nbsp;<span id="like"><?php echo number_format($recommend['like']); ?></span></button>
            <button type="button" class="btn btn-lg btn-warning" id="hate_button">반대&nbsp;<span id="hate"><?php echo number_format($recommend['hate']); ?></span></button>
            <hr>
        </article>

        <nav class=" blog-pagination" aria-label="Pagination">
            <a class="btn btn-outline-primary" href="board.php">목록</a>
            <a class="btn btn-outline-primary" href="write.php?parent_id=<?php echo $rs->bid; ?>">답글</a>
            <a class="btn btn-outline-primary" href="write.php?bid=<?php echo $rs->bid; ?>">수정</a>
            <a class="btn btn-outline-primary" onclick="return confirm('정말로 삭제하시겠습니까?');" href="delete.php?bid=<?php echo $rs->bid; ?>">삭제</a>
        </nav>

        <div style="margin-top:20px;">
            <form class="row g-3" id="memo_form">
                <div class="col-md-10">
                    <textarea class="form-control" placeholder="댓글을 입력해주세요." id="memo" style="height: 60px"></textarea>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-secondary" id="memo_button">댓글등록</button>
                </div>
            </form>
        </div>
        <div id="memo_place">
            <?php
            //댓글이 비어 있지 않을 경우 
            if (!empty($memoArray)) :
                foreach ($memoArray as $ma) :
            ?>
                    <div class="card mb-4" id="memo_<?php echo $ma->memoid ?>" style="max-width: 100%;margin-top:20px;">
                        <div class="row g-0">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <p class="card-text"><?php echo $ma->memo; ?></p>
                                    <p class="card-text"><small class="text-muted"><?php echo $ma->userid; ?> / <?php echo $ma->regdate; ?></small></p>
                                    <p class="card-text" style="text-align:right"><a href="javascript:;" onclick="memo_modi(<?php echo $ma->memoid ?>)">수정</a>
                                        / <a href="javascript:;" onclick="memo_del(<?php echo $ma->memoid ?>)">삭제</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach;
            else :
                ?>
                <!-- 댓글이 비어있을 경우 -->
                <p id="no_comments">댓글이 없습니다.</p>
            <?php
            endif;
            ?>
        </div>
    </div>

    <script>
        // 추천 버튼
        $("#like_button").click(function() {
            return false;

            var data = {
                type: 'like',
                bid: <?php echo $bid; ?>
            };

            $.ajax({
                async: false,
                type: 'post',
                url: 'like_hate.php',
                data: data,
                dataType: 'json',
                error: function(return_data) {
                    if (return_data.result == "member") {
                        alert('로그인 하십시오.');
                        return;
                    } else if (return_data.result == "check") {
                        alert('다시한번 시도해주십시오.');
                        return;
                    } else {
                        $("#like").text(return_data.cnt);
                    }
                }
            });

        });


        // 반대 버튼
        $("#hate_button").click(function() {
            if (!confirm('반대하시겠습니까?')) {
                return false;
            }

            var data = {
                type: 'hate',
                bid: <?php echo $bid; ?>,
            };

            $.ajax({
                async: false,
                type: 'post',
                url: 'like.hate.php',
                data: data,
                dataType: 'json',
                error: function() {},
                success: function(return_data) {
                    if (return_data.result == "member") {
                        alert('로그인 하십시오.');
                        return;
                    } else if (return_data.result == "check") {
                        alert('이미 추천이나 반대를 하셨습니다.');
                        return;
                    } else {
                        $("#hate").text(return_data.cnt);
                    }
                }

            });
        });

        // 댓글 삭제 함수
        function memo_del(memoid) {

            // confirm: js의 기본 함수 사용자에게 확인 대화상자를 표시 
            if (!confirm('삭제하시겠습니까?')) {
                return false;
            }

            let data = {
                memoid: memoid
            };

            $.ajax({
                async: false,
                type: 'POST',
                url: 'memo_delete.php',
                data: data,
                dataType: 'json',
                error: function() {},
                success: function(return_data) {
                    if (return_data.result == "member") {
                        alert('로그인 하십시오.');
                        return;
                    } else if (return_data.result == "my") {
                        alert('본인이 작성한 글만 삭제할 수 있습니다.');
                        return;
                    } else if (return_data.result == "no") {
                        alert('삭제하지 못했습니다. 관리자에게 문의하십시오.');
                        return;
                    } else if (return_data.result == "ok") {
                        $("#memo_" + memoid).hide();
                    }
                }
            });

        }


        // ajax에서 호출할 파일을 만듬
        $("#memo_button").click(function() {
            let memo = $('#memo').val().trim();

            if (memo === '') {
                alert('댓글을 입력해주세요');
                return false;
            }

            let data = {
                memo: $('#memo').val(),
                bid: <?php echo $bid; ?>
            };
            $.ajax({
                async: false,
                type: 'POST',
                url: 'memo_write.php',
                data: data,
                dataType: 'html',
                error: function() {},
                success: function(return_data) {
                    if (return_data == "member") {
                        alert('로그인 하십시오.');
                        return;
                    } else {
                        $("#memo_place").append(return_data);
                        $("#no_comments").hide(); // 댓글이 등록되면 "댓글이 없습니다." 메시지 숨김
                        $("#memo").val(''); // 댓글 입력창 초기화

                    }
                }
            });
        });


        function memo_modi(memoid) {

            let data = {
                memoid: memoid
            };

            $.ajax({
                async: false,
                type: 'post',
                url: 'memo_modify.php',
                data: data,
                dataType: 'html',
                error: function() {},
                success: function(return_data) {
                    if (return_data == "member") {
                        alert('로그인 하십시오.');
                        return;
                    } else if (return_data == 'my') {
                        alert('본인이 작성한 글만 수정할 수 있습니다.');
                        return;
                    } else if (retunr_data == "no") {
                        alert("수정하지 못했습니다. 관리자에게 문의하십시오.");
                        return;
                    } else {
                        $("#memo_" + memoid).html(return_data);
                    }

                }
            });
        }


        function memo_modify(memoid) {

            let data = {
                memoid: memoid,
                memo: $('#memo_text_' + memoid).val()
            };

            $.ajax({
                async: false,
                type: 'post',
                url: 'memo_modify_update.php',
                data: data,
                dataType: 'html',
                error: function() {},
                success: function(return_data) {
                    if (return_data == "member") {
                        alert('로그인 하십시오.');
                        return;
                    } else if (return_data == "my") {
                        alert('본인이 작성한 글만 수정할 수 있습니다.');
                        return;
                    } else if (return_data == "no") {
                        alert('수정하지 못했습니다. 관리자에게 문의하십시오.');
                        return
                    } else {
                        $("#memo_" + memoid).html(return_data);
                    }
                }
            });
        }

        // $(document).ready(function() {
        //     // Function to check input and toggle button state
        //     function checkInput() {
        //         if ($('#memo').val().trim() === '') {
        //             $('#memo_button').prop('disabled', true);
        //         } else {
        //             $('#memo_button').prop('disabled', false);
        //         }
        //     }

        //     // Initial check when the page loads
        //     checkInput();

        //     // Check input whenever the user types
        //     $('#memo').on('input', checkInput);
        // });
    </script>
</body>

</html>