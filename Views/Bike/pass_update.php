<?php
session_start();
require_once(ROOT_PATH .'Models/User.php');

if(!isset($_SESSION['password']) && !isset($_SESSION['password_conf'])) {
    //エラーメッセージ
    $err = [];
    //バリデーション
    //メールアドレス(空チェック)
    if(!$email = filter_input(INPUT_POST, 'email')) {
        $err['email'] = 'メールアドレスを記入してください。';
    }
    //パスワード(空チェック)
    if(!$birth = filter_input(INPUT_POST, 'birth')) {
        $err['birth'] = '誕生日を記入してください。';
    }

    if(count($err) > 0) {
        //エラーがあった場合は戻す
        $_SESSION = $err;
        header('Location: pass_reset.php');
        return;
    }

    // メールアドレスと誕生日照会成功時の処理
    $result = User::resetPass($email, $birth);
    //照会失敗時の処理
    if(!$result){
    header('Location: pass_reset.php');
    return;
}
}
$err = $_SESSION;

$user = $_SESSION['user'];

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
        <h3 class="text-center text-info pt-5">パスワード入力ページ</h3>
        <div class="container">
            <div  class="row justify-content-center align-items-center">
                <div  class="col-md-6">
                    <div  class="col-md-12">

                        <?php if(isset($err['msg'])) : ?>
                            <p class="text-danger"><?php echo $err['msg']; ?></p>
                        <?php endif; ?>
                        <form id="login-form" class="form" action="pass_comp.php" method="post">
                        <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($user['id'], ENT_QUOTES) ?>">
                           <div class="form-group my-5">
                                <label for="password" class="text-info lead">新しいパスワード:</label><br>
                                <?php if(isset($err['password'])) : ?>
                                    <p class="text-danger"><?php echo $err['password']; ?></p>
                                <?php endif; ?>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                            <div class="form-group my-5">
                                <label for="password_conf" class="text-info lead">新しいパスワード確認用:</label><br>
                                <?php if(isset($err['password_conf'])) : ?>
                                    <p class="text-danger"><?php echo $err['password_conf']; ?></p>
                                <?php endif; ?>
                                <input type="password" name="password_conf" id="password_conf" class="form-control">
                            </div>

                            <div class="form-group my-5">
                                <input type="submit" name="submit" class="btn btn-info btn-md text-white d-block mx-auto" value="パスワードをリセット">
                            </div>

                        </form>

                        <div class="my-5">
                            <a href="pass_reset.php"><p class="text-dark text-center">戻る</p></a>
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