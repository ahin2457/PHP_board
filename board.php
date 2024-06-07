<?php
include './board/header.board.php';
include './board/headermenu.php';

#아래 controller 파트

# 오류 표시 설정
ini_set('display_errors', '1');

include 'db.php';
require './board/Board.class.php';
$AhinBoard = new Board($ahindb);

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10; #한 페이지당 보여줄 게시물 수
$search = isset($_GET['search']) ? $_GET['search'] : '';


#전체 게시글 수를 가져옴
$list = $AhinBoard->getListData($page, $limit, $search);

# $AhinBoard 객체에 있는 getTotalCount 메소드를 호출한다
$totalCount = $AhinBoard->getTotalCount($search);

# ceil : 주어진 숫자를 올림하여 가장 가까운 정수를 반환하는 내장함수.
# 즉, 소수점 이하의 숫자를 올림하여 가장 가까운 정수로 올림함.
$totalPages = ceil($totalCount / $limit);


#게시글이 삭제되었을 때의 처리
#if (isset($_GET['post_bid'])) {
#    $post_bid = $_GET['post_bid'];

#게시글을 삭제하는 메소드 호출
#    $deleted = $AhinBoard->deletePost($post_bid);
#    if ($deleted) {

#삭제 성공시 메시지 표시
#        echo "<script>alert('게시글이 삭제되었습니다.');</script>";

#삭제 후 현재 페이지를 다시 로드
#        echo "<script>window.location.href='?page=$page';</script>";
#        exit;
#    } else {

# 삭제 실패시 메시지 표시
#        echo "<script>alert('게시글 삭제에 실패했습니다.');</script>";
#    }
#}

#저장시 아래와 같은 형태가 된다
#$subject = $_POST['subject'];
#$content= $_POST['content'];
#$boardno = $AhinBoard->write('자동등록자',$subject , $content);
#if($boardno)
#{
# 정상등록됨 이후 처리
#}else{
# 등록 실패
# 어떻게 처리할지 
#}

# 이래부터 view part 

?>
<style>
    /* .content {width: 70%; margin:0 auto; border:1px solid blue} */
    .content {
        width: 70%;
        margin: 0 auto;
        margin-top: 70px;
    }

    .text-align-right {
        text-align: right;
        width: 80%;
        margin: 0 auto;
    }
</style>


<!-- <div class="content-wrapper" style="border:1px solid red">     -->
<div class="content-wrapper">

    <div class="content">

        <div class="search-content" style="text-align:center;margin-bottom:6px;">
            <div class="btn-group">
                <form method="GET" action="" style="display:inline-block;" class="search-box">
                    <input type="text" class="btn btn-outline-secondary " name="search" placeholder="검색어를 입력하세요" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">
                        <input type="checkbox" id="checkbox-all">
                    </th>
                    <th scope="col">번호</th>
                    <th scope="col">글쓴이</th>
                    <th scope="col">제목</th>
                    <th scope="col">등록일</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($totalCount > 0) {
                    //$i = ($page - 1) * $limit + 1;
                    $i = (($page - 1) * $limit);
                    foreach ($list as $r) {
                ?>

                        <tr>
                            <td><input type="checkbox" name="checkList" value="<?php echo $r->bid; ?>"></td>
                            <th scope="row"><?php echo $totalCount - ($i++) ?></th>
                            <td><?php echo $r->userid  ?></td>
                            <td><a href="view.php?bid=<?php echo $r->bid; ?>"><?php echo $r->subject ?></a></td>
                            <td><?php echo $r->regdate ?></td>
                            <!-- <td><a href="?page=<?php echo $page; ?>&post_bid=<?php echo $r->bid; ?>" onclick="return confirm('정말로 삭제하시겠습니까?');" class="btn btn-outline-dark">삭제</a></td> -->
                        </tr>

                    <?php
                    } // end foreach
                } else { ?>
                    <tr>
                        <td colspan="5" style="height: 6rem; text-align: center; padding:2rem 0px; ">
                            게시물이 없습니다
                        </td>
                        <!-- <td><a href="?page=<?php echo $page; ?>&post_bid=<?php echo $r->bid; ?>" onclick="return confirm('정말로 삭제하시겠습니까?');" class="btn btn-outline-dark">삭제</a></td> -->
                    </tr>
                <?php } /*endif */ ?>
            </tbody>
        </table>

        <!-- 
    &laquo : html 엔티티 왼쪽 이중 각 인용 부호를 나타냄 
    &raquo : 오른쪽 페이지로 이동하는 버튼
    &laquo Previous : 이전 페이지로 이동하는 버튼
    Next &raquo; : 다음 페이지로 이동하는 버튼

-->
        <nav aira-label="Page navigation" style="margin-top:10px;">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"> <?php echo $i; ?> </a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

        <div class="text-align-right">
            <?php
            # $_SESSION['UID'] 접근하기 전에 isset()으로 확인하여 경고를 방지함.
            if (isset($_SESSION['UID']) && $_SESSION['UID']) {

            ?>
                <div>
                    <a href="write.php" class="btn btn-secondary">등록</a>
                    <input type="submit" id="delete-selected" class="btn btn-secondary" value="삭제">
                </div>
            <?php
            }
            ?>

        </div>
    </div>


</div>

<!-- jQuery를 사용하여 체크박스 이벤트 처리 -->
<script>
    $(document).ready(function() {

        // '전체선택' 체크박스 클릭 이벤트
        $("#checkbox-all").click(function() {
            $("input[name='checkList']").prop("checked", this.checked);
        });

        // 개별 체크박스 클릭 이벤트
        $("input[name='checkList']").click(function() {

            // 전체 체크박스 길이
            let total = $("input[name='checkList']").length;
            //체크된 체크박스의 길이
            let checked = $("input[name='checkList']:checked").length;
            // total === checked이면 전체 체크박스는 checked됨.
            $("#checkbox-all").prop("checked", total === checked);
        });

        // '삭제' 버튼을 클릭했을 때 실행되는 함수
        $("#delete-selected").click(function() {
            // 체크된 'checkList' 체크박스의 값을 배열로 가져옴
            let checkedValues = $("input[name='checkList']:checked")
                .map(function() {
                    return this.value;
                }).get();

            // 하나 이상의 체크박스가 선택되었는지 확인
            if (checkedValues.length > 0) {
                // 삭제 확인 메시지를 띄움
                if (confirm("정말로 삭제하시겠습니까?")) {
                    // AJAX 요청을 통해 선택된 게시글을 삭제
                    $.ajax({
                        type: "POST", // 요청 타입을 POST로 설정
                        url: "deleteList.php", // 요청을 보낼 URL
                        data: {
                            ids: checkedValues
                        }, // 보내고자 하는 data 변수 설정
                        success: function(response) {
                            // 서버로부터 성공 응답을 받으면 메시지를 알림
                            alert(response.message);
                            if (response.success) {
                                // 삭제 성공 시 페이지를 새로고침
                                location.reload();
                            }
                        },

                        error: function(xhr, status, error) {

                            // 요청이 실패했을 때 에러 메시지를 알림
                            alert("삭제하는 중에 문제가 발생했습니다.");
                            console.error("Error: ", error); // 오류 메시지를 콘솔에 출력
                            console.error("Status: ", status);
                            console.dir(xhr);
                        }
                    });
                }
            } else {
                // 선택된 체크박스가 없을 때 경고 메시지를 알림
                alert("삭제할 항목을 선택하세요.");
            }
        });
    });
</script>
<?php include './board/footer.board.php'; ?>