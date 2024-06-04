<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <?php
      $file_dir = "C:/xampp/htdocs/project_test/";
      $file = $_FILES["upload"];
      $file_name = $file["name"];
      $file_path = $file_dir.$file_name;
      $tmp_name = $file["tmp_name"];
      echo "tmp_name: $tmp_name<br>";
      if(move_uploaded_file($tmp_name, $file_path)) {
    ?>
        <img src="<?=$file_name?>">
    <?php
        }else{
            echo "파일 업로드 에러 발생!";
        }
    ?>
</body>
</html>