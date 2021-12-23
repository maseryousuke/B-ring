<?php
session_start();
require_once(ROOT_PATH .'Models/User.php');

//エラーメッセージ
$err = [];

//バリデーション
//メールアドレス(空チェック)
if(!$email = filter_input(INPUT_POST, 'email')) {
    $err['email'] = 'メールアドレスを記入してください。';
}
//パスワード(正規表現チェック)
if(!$password = filter_input(INPUT_POST, 'password')) {
    $err['password'] = 'パスワードを記入してください。';
}

if(count($err) > 0) {
    //エラーがあった場合は戻す
    $_SESSION = $err;
    header('Location: login.php');
    return;
}

// ログイン成功時の処理
$result = User::login($email, $password);
//ログイン失敗時の処理
if(!$result){
    header('Location: login.php');
    return;
}

$login_user = $_SESSION['login_user'];

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

<!-- ログイン完了 -->
    <div id="login">
        <h3 class="text-center text-info pt-5">ログイン完了</h3>
        <div class="container">
            <div  class="row justify-content-center align-items-center">
                <div  class="col-md-6">
                    <div  class="col-md-12">
                        <p class="text-center my-5">ログインが完了致しました。</p>

                        <a href="index.php?id=<?=$login_user['id'] ?>" class="btn btn-info btn-md text-white d-block mx-auto my-5">メインページへ</a>       
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