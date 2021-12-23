<?php
session_start();
require_once(ROOT_PATH .'Models/User.php');

$result = User::loginCheck();
if($result) {
    header('Location: index.php?id='.$_SESSION['login_user']['id']);
    return;
}

$err = $_SESSION;

//セッションを消す
$_SESSION = array();
session_destroy();

?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/base.css">
</head>

<body>
<div class="hako">
<!--  ヘッダー -->
<?php require_once("header.php")?>

<!-- ログインフォーム -->
    <div id="login">
        <h3 class="text-center text-info pt-5">ログインページ</h3>
        <div class="container">
            <div  class="row justify-content-center align-items-center">
                <div  class="col-md-6">
                    <div  class="col-md-12">

                        <?php if(isset($err['msg'])) : ?>
                            <p class="text-danger"><?php echo $err['msg']; ?></p>
                        <?php endif; ?>
                        <form id="login-form" class="form" action="login_comp.php" method="post">

                           <div class="form-group my-5">
                                <label for="username" class="text-info lead">メールアドレス:</label><br>
                                <?php if(isset($err['email'])) : ?>
                                    <p class="text-danger"><?php echo $err['email']; ?></p>
                                <?php endif; ?>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>

                            <div class="form-group my-5">
                                <label for="password" class="text-info lead">パスワード:</label><br>
                                <?php if(isset($err['password'])) : ?>
                                    <p class="text-danger"><?php echo $err['password']; ?></p>
                                <?php endif; ?>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                            <div class="form-group my-5">
                                <input type="submit" name="submit" class="btn btn-info btn-md text-white d-block mx-auto" value="ログイン">
                            </div>

                        </form>

                        <div class="my-5">
                            <a href="pass_reset.php"><p class="text-dark text-center">パスワードを忘れた方はこちら</p></a>
                        </div>
                        <div class="my-5">
                            <a href="signup.php"><p class="text-dark text-center">新規登録はこちら</p></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- フッター -->
    <?php require_once("footer.php")?>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>