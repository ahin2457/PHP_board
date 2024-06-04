<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</head>

<body>
    <div class="col-md-8" style="margin:auto;padding:20px;">
        <form class="row g-3-needs-validation" method="post" action="signup_ok.php">
            <div class="col-12">
                <label for="validationCustom02" class="form-label">아이디</label>
                <input type="text" class="form-control" id="userid" name="userid" placeholder="" required>
            </div>
            <div class="col-12">
                <label for="validationCustom01" class="form-label">이름</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="" required>
            </div>
            <div class="col-12">
                <label for="validationCustom02" class="form-label">비밀번호</label>
                <input type="password" class="form-control" id="passwd" name="passwd" placeholder="" required>
            </div>
            <div class="col-12">
                <label for="validationCustomUsername" class="form-label">이메일</label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="" required>
                </div>
            </div>

            <div class="col-12" style="margin-top:10px;">
                <button class="btn btn-primary" type="submit">가입하기</button>
            </div>
        </form>
    </div>

</body>
<script>
</script>

</html>