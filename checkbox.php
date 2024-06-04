<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="../board/heamenu.css">
</head>
<script>
    $(document).ready(function() {
        $("#checkbox-all").click(function() {
            if ($("#checkbox-all").is(":checked")) $("input[name=checkList]").prop("checked", true);
            else $("input[name=checkList]").prop("checked", false);
        });

        $("input[name=checkList]").click(function() {
            var total = $("input[name=checkList]").length;
            var checked = $("input[name=checkList]:checked").length;

            if (total != checked) $("#checkbox-all").prop("checked", false);
            else $("#checkbox-all").prop("checked", true);
        });
    });

    function clickEvent() {
        alert("모바일에서 지원하는 기능입니다. \n" +

            "1688-1026번으로 연락주시면 자세한 상담 도와드리겠습니다.  ");
    }
</script>

<body>
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


            <tr>
                <td><input type="checkbox" name="checkList"></td>
                <td><a onclick=clickEvent();>test</a></td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
            </tr>
            <tr>
                <td><input type="checkbox" name="checkList"></td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
            </tr>
            <tr>
                <td><input type="checkbox" name="checkList"></td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
            </tr>

        </tbody>
    </table>
</body>

</html>