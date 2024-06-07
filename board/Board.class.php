<?php
class Board
{
    public $DB = null;

    // & : 참조
    // __construct : 인스턴스가 생성될 때 자동으로 호출되는 함수. 또는 생성자
    public function __construct(Ahindb &$ahindb)
    {
        $this->DB =  $ahindb;
    }

    /**
     * 게시물 리스트를 가져온다
     * @param int $page 현재 페이지 번호
     * @param int $limit 페이지당 게시물 수
     * @param string|null $search 검색어
     * @return array
     */
    public function getListData($page, $limit, $search = null)
    {

        $offset = ($page - 1) * $limit;
        $searchQuery = "";

        if ($search) {
            //문자열에 대한 DB에 불필요한 문자열에 / 븉임처리 ' => \'
            $search = $this->DB->real_escape_string($search);
            $searchQuery = "WHERE subject LIKE '%$search%' OR content LIKE '%$search%' OR userid LIKE '%$search%'";
        }

        // ifnull : 해당 Column의 값이 NULL을 반환할때, 다른 값으로 출력할 수 있도록 하는 함수.
        // SELECT INFNULL(Column명, "Null일 경우 대체 값") FROM 테이블명;
        // parent_id가 NULL일 경우 bid를 출력
        $query = $this->DB->query("SELECT * FROM board $searchQuery ORDER BY ifnull(parent_id, bid)  desc LIMIT $offset, $limit ");
        if ($this->DB->errno) {
            echo "query error => " . $this->DB->error;
            die();
        }

        $return = [];
        // fetch_object : 필드명 인덱스를 가진 객체를 반환
        while ($rs = $query->fetch_object()) {
            $return[] = $rs;
        }
        return $return;
    }

    /**
     * 등록후 자동증가 키 값을 리턴  실패한다면 false 리턴
     * @param $userid 회원아이디
     * @param $title 제목
     * @param $content 내용
     * @return int |Bool
     */
    public function write($userid, $title, $content)
    {
        $insert = "insert into board (userid,SUBJECT,content,regdate)values('" . $userid . "','" . $title . "','" . $content . "',now())";
        $rs = $this->DB->query($insert);
        return ($rs) ? $this->DB->insert_id : false;
    }

    /**
     * 해당글의 번호(bid)를 갖고 옴 
     * 
     * $this : PHP 클래스 내부에서 현재 인스턴스를 참조하는 특수한 키워드
     *         객체지향프로그래미에서 클래스의 메소드나 프로퍼티에 접근할 때 사용 됨.
     * 
     * $this : 현재 객체의 인스턴스를 참조함. 즉, $this는 메소드가 호출된 그 객체를 가르킴ㅁ
     * 
     * $this->DB : 현재 객체의 'DB' 프로퍼티에 접근함
     * 
     * - 클래스 내에서 다른 메소드를 호출할 때도 '$this'를 사용함 ex) $this->anotherMethod()
     */
    public function getPostById($bid)
    {
        $query = $this->DB->query("SELECT * FROM board WHERE bid = " . $bid);
        if ($this->DB->errno) {
            echo "query error => " . $this->DB->error;
            die();
        }

        return $query->fetch_object();
    }


    /**
     * 총 개시물의 수를 가져온다.
     * 
     * 
     * @param String|null $search 검색어
     * @return int
     * 
     * 
     */
    public function getTotalCount($search = null)
    {
        $searchQuery = "";

        if ($search) {
            $search = $this->DB->real_escape_string($search);
            $searchQuery = "WHERE subject LIKE '%$search%' OR content LIKE '%$search%' ";
        }

        $query = $this->DB->query("SELECT COUNT(*) AS total FROM board");
        if ($this->DB->errno) {
            echo "query error => " . $this->DB->error;
            die();
        }

        // $return = [];
        // while($rs = $query->fetch_object()){
        //     $return[] = $rs;
        // }
        // return $return;
        // fetch_obejct : 필드명 인덱스를 가진 객체를 반환.
        $result = $query->fetch_object();
        return $result->total;
    }

    /**
     * 
     * 게시물 삭제 
     * @param int $post_id 삭제할 게시물의 ID
     * @return bool 삭제 성공 여부
     */
    public function deletePost($post_bid)
    {
        // 삭제할 게시물의 존재 여부 확인
        $post = $this->getPostById($post_bid);
        if (!$post) {
            //echo "게시물을 찾을 수 없습니다.";
            return false;
        }

        // 게시물 삭제 쿼리 실행
        $query = $this->DB->query("DELETE FROM board WHERE bid = $post_bid");
        if (!$query) {
            //echo "게시물 삭제에 실패했습니다.";
            return false;
        }
        //echo "게시물이 성공적으로 삭제되었습니다.";
        return true;
    }

    /**
     * 
     */
}
