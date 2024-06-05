<div class="content-wrapper">
    <?php

    $str = $_GET['s'];
    echo (int) $str;
    echo '<hr>';
    echo intval($str);
    echo '<hr>';
    //$str = '이거슨 문자열';
    $admin = 'admin';

    echo " $str 쌍따옴표 변수출력 <br><br><br> ";

    echo  '$str 홑따옴표 변수출력 <br><br><br>';

    ?>
</div>