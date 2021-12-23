<?php
session_start();
$_POST = $_SESSION['form'];

//var_dump($_POST);

//送信ボタンを押したら完了画面に移動
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $_SESSION['form'] = $_POST;
    header('Location: signup_comp.php');
    exit();
}
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
        <h3 class="text-center text-info pt-5">登録確認</h3>
        <div class="container">
            <div  class="row justify-content-center align-items-center">
                <div  class="col-md-6">
                    <div  class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">

                            <p class="text-center">下記の内容をご確認の上送信ボタンを押してください。</p>
                            <p class="text-center">内容を訂正する場合は戻るを押してください。</p>

                            <div class="form-group my-5">
                                <label for="name" class="text-info lead">ユーザネーム:</label><br>
                                <p><?php echo htmlspecialchars($_POST['name']); ?></p>
                            </div>
                            <div class="form-group my-5">
                                <label for="email" class="text-info lead">メールアドレス:</label><br>
                                <p><?php echo htmlspecialchars($_POST['email']); ?></p>
                            </div>
                            <div class="form-group my-5">
                                <label for="password" class="text-info lead">パスワード:</label><br>
                                <p><?php echo htmlspecialchars($_POST['password']); ?></p>
                            </div>
                            <div class="form-group my-5">
                                <label for="birth" class="text-info lead">誕生日:</label><br>
                                <p><?php echo htmlspecialchars($_POST['birth']); ?></p>
                            </div>
                            <div class="form-group my-5">
                                <label for="manufacturer" class="text-info lead">よく乗るバイク（メーカー）:</label><br>
                                <p><?php echo htmlspecialchars($_POST['manufacturer']); ?></p>
                            </div>
                            <div class="form-group my-5">
                                <label for="bike_name" class="text-info lead">よく乗るバイク（車種）:</label><br>
                                <p><?php echo htmlspecialchars($_POST['bike_name']); ?></p>
                            </div>
                            <div class="row justify-content-center">
                                <div class="form-group btn-group my-5">
                                    <input type="submit" name="submit" class="btn btn-info btn-md text-white mx-2" value="登録">
                                    <a class="btn btn-dark btn-md mx-2" role="button" onclick="history.back(-1)">戻る</a>
                                </div>
                            </div>
                            
                        </form>
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