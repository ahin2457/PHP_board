<?php include './inc/header.inc.php'; ?>
<div class="content-wrapper">
    <form name="form" method="post" action="post-test.php">
        <input type="text" name="input-name">
        <input type="submit"  value="확인">
    </form><br>

    <form name="form" method="post" action="post-test2.php">
        <input type="text" name="id"><br>
        <input type="password" name="pass"><br>
        <div>
            성별: 남성 <input type="radio" name="gender" value="남" cheked>
            성별: 여성 <input type="radio" name="gender" value="여">
        </div>
        <ul>
            <li>취미1 <input type="checkbox" name="hobby[]" value="취미1"></li>
            <li>취미2 <input type="checkbox" name="hobby[]" value="취미2" checked></li>
            <li>취미3 <input type="checkbox" name="hobby[]" value="취미3"></li>
        </ul>
        <select name="fruit">
            <option value="딸기">딸기</option>
            <option value="사과">사과</option>
            <option value="오렌지">오렌지</option>
        </select>

        <input type="submit" value="확인">
    </form>
    
    <br>
    <hr>
    <h1>이미지 업로드</h1>
    <br>
    <form name="form" method="post" enctype="multipart/form-data" action="post-test2.php">
        이미지 업로드 : <input type="file" name="upload">
        <br><br>
        <input type="submit" value="확인">
    </form>
</div>
<?php include './inc/footer.inc.php'; ?>