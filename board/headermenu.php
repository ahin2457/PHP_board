<body>
    <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
            <h5 class="text-white h4">Collapsed content</h5>
            <span class="text-muted">Toggleable via the navbar brand.</span>
        </div>
    </div>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <?php

            # 세션 값이 있는지 여부를 확인 해서 로그인 했는지를 체크함.
            if ($_SESSION['UID']) {

            ?>
                <a href="member/logout.php" style="color:white;">로그아웃</a>
            <?php
            } else {


            ?>
                <a href="member/login.php" style="color:white;">로그인</a>
                <a href="member/signup.php" style="color:white;">회원가입</a>
            <?php

            }
            ?>
        </div>
    </nav>