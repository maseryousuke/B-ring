<?php
session_start();
require_once(ROOT_PATH .'Models/User.php');

//ログアウトがPOSTで送られていなかったら不正なリクエストを出す
if(!$logout = filter_input(INPUT_POST, 'logout')) {
    exit('不正なリクエストです。');
}

//ログインしているかを判定し、セッションが切れていたらログインしてくださいとメッセージをだす
$result = User::loginCheck();
if(!$result) {
    exit('セッションが切れましたのでログインし直してください。');
}

//ログアウトする
User::logout();
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

<!-- 新規登録内容確認 -->
    <div id="login">
        <h3 class="text-center text-info pt-5">ログアウト完了</h3>
        <div class="container">
            <div  class="row justify-content-center align-items-center">
                <div  class="col-md-6">
                    <div  class="col-md-12">
                        <p class="text-center my-5">ログアウトが完了致しました。</p>

                        <a href="login.php" class="btn btn-info btn-md text-white d-block mx-auto my-5">ログインはこちら</a>       
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