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
# 즉, 소수점 이하의 숫자를 올림하여 가장 가까운 정수로 반올림함.
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

<script>
    // 체크박스
    $(document).ready(function() {

        $("#checkbox-all").click(function() {
            if ($("#checkbox-all").is(":checked"))
                $("input[name=checkList]").prop("checked", true);
            else
                $("input[name=checkList]").prop("checked", false);
        });

        $("input[name=checkList]").click(function() {

            let total = $("input[name=checkList]").length;
            let checked = $("input[name=checkList]:checked").length;

            if (total != checked)
                $("#checkbox-all").prop("checked", false);
            else
                $("#checkbox-all").prop("checked", true);
        });
    });
</script>

<!-- <div class="content-wrapper" style="border:1px solid red">     -->
<div class="content-wrapper">

    <div class="content">

        <div class="text-align-right">
            <div class="btn-group">
                <form method="GET" action="" style="display:inline-block;" class="search-box">
                    <input type="text" class="btn btn-outline-secondary " name="search" placeholder="검색어를 입력하세요" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>
            <?php
            # $_SESSION['UID'] 접근하기 전에 isset()으로 확인하여 경고를 방지함.
            if (isset($_SESSION['UID']) && $_SESSION['UID']) {

            ?>
                <div class="btn-group">
                    <a href="write.php" class="btn btn-secondary">등록</a>
                    <form action="deleteList.php" method="post">
                        <input type="hidden" name="id" value="<?= $GET['id'] ?>">
                        <input type="submit" class="btn btn-secondary" value="삭제">
                        <!-- <a href="" class="btn btn-secondary" name="deletedSelected">삭제</a> -->
                    </form>
                </div>
            <?php
            }
            ?>
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
                }
                ?>
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
    </div>


</div>

<?php include './board/footer.board.php'; ?>