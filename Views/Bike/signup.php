<?php
session_start();

// 変数を初期化
$name = '';
$email = '';
$password = '';
$birth = '';
$manufacturer = '';
$bike_name = '';

// エラー内容
$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 送信時にエラーをチェックする
  if (isset($_POST)) {

    // 氏名(空チェック)
    if ($_POST['name'] === '') {
        $error['name'] = 'blank';
    }

    // メールアドレス(空チェック、正規表現チェック)
    if ($_POST['email'] === '') {
        $error['email'] = 'blank';
    } else if ( !preg_match( '/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $_POST['email']) ) {
        $error['email'] = 'email';
    }

    // パスワード(空チェック、正規表現チェック)
    if ($_POST['password'] === '') {
        $error['password'] = 'blank';
    } else if ( !preg_match("/\A[a-z\d]{8,100}+\z/i", $_POST['password']) ) {
        $error['password'] = 'password';
    }

    //確認用パスワード(空チェック、パスワードとあっているか)
    if ($_POST['password_conf'] === '') {
        $error['password_conf'] = 'blank';
    } else if ($_POST["password"] !== $_POST['password_conf'] ) {
        $error['password_conf'] = 'password_conf';
    }

    //誕生日(空チェック)
    if ($_POST['birth'] === '') {
        $error['birth'] = 'blank';
    }

    // バイクメーカー(空チェック)　
    if ($_POST['manufacturer'] === '') {
        $error['manufacturer'] = 'blank';
    }

    // バイクメーカー(空チェック)　
    if ($_POST['bike_name'] === '') {
        $error['bike_name'] = 'blank';
    }
  }

    if (count($error) === 0) {
        // エラーがないので確認画面に移動
        $_SESSION['form'] = $_POST;
        header('Location: signup_confirm.php');
        exit();
    }
} 

?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/base.css"></head>
<body>
<div class="hako">
<!--  ヘッダー -->
    <?php require_once("header.php")?>
<!-- 新規登録フォーム -->
    <div id="login">
        <h3 class="text-center text-info pt-5">ユーザ新規登録ページ</h3>
        <p class="text-center pt-5"><span class="text-danger">*</span>は必須入力です。</p>
        <div class="container">
            <div  class="row justify-content-center align-items-center">
                <div  class="col-md-6">
                    <div  class="col-md-12">

                        <form class="form" action="" method="post" novalidate>

                            <div class="form-group my-5">
                                <label for="name" class="text-info lead"><span class="text-danger">*</span>ユーザネーム:</label><br>
                                <?php if (isset($error['name']) && $error['name'] === 'blank'): ?>
                                    <p class="text-danger">ユーザネームは必須入力です。</p>
                                <?php endif; ?>
                                <input type="text" name="name" id="name" class="form-control" value="<?php if(isset($_POST['name'])){echo htmlspecialchars($_POST['name'], ENT_QUOTES);} ?>">
                            </div>

                            <div class="form-group my-5">
                                <label for="email" class="text-info lead"><span class="text-danger">*</span>メールアドレス:</label><br>
                                <?php if (isset($error['email']) && $error['email'] === 'blank'): ?>
                                    <p class="text-danger">メールアドレスは必須入力です。</p>
                                <?php endif; ?>
                                <?php if (isset($error['email']) && $error['email'] === 'email'): ?>
                                    <p class="text-danger">メールアドレスは正しくご入力ください。</p>
                                <?php endif; ?>
                                <input type="email" name="email" id="email" class="form-control" value="<?php if(isset($_POST['email'])){echo htmlspecialchars($_POST['email'], ENT_QUOTES);} ?>">
                            </div>

                            <div class="form-group my-5">
                                <label for="password" class="text-info lead"><span class="text-danger">*</span>パスワード:</label><br>
                                <?php if (isset($error['password']) && $error['password'] === 'blank'): ?>
                                    <p class="text-danger">パスワードは必須入力です。</p>
                                <?php endif; ?>
                                <?php if (isset($error['password']) && $error['password'] === 'password'): ?>
                                    <p class="text-danger">パスワードは英数字８文字以上１００文字以下にしてください。</p>
                                <?php endif; ?>
                                <input type="password" name="password" id="password" class="form-control" value="<?php if(isset($_POST['password'])){echo htmlspecialchars($_POST['password'], ENT_QUOTES);} ?>">
                            </div>

                            <div class="form-group my-5">
                                <label for="password_conf" class="text-info lead"><span class="text-danger">*</span>パスワード確認:</label><br>
                                <?php if (isset($error['password_conf']) && $error['password_conf'] === 'blank'): ?>
                                    <p class="text-danger">パスワード確認は必須入力です。</p>
                                <?php endif; ?>
                                <?php if (isset($error['password_conf']) && $error['password_conf'] === 'password_conf'): ?>
                                    <p class="text-danger">確認用パスワードは異なっています。</p>
                                <?php endif; ?>
                                <input type="password" name="password_conf" id="password_conf" class="form-control" value="<?php if(isset($_POST['password_conf'])){echo htmlspecialchars($_POST['password_conf'], ENT_QUOTES);} ?>">
                            </div>

                            <div class="form-group my-5">
                                <label for="birth" class="text-info lead"><span class="text-danger">*</span>誕生日:</label><br>
                                <?php if (isset($error['birth']) && $error['birth'] === 'blank'): ?>
                                    <p class="text-danger">誕生日は必須入力です。</p>
                                <?php endif; ?>
                                <input type="date" name="birth" id="birth" class="form-control" value="<?php if(isset($_POST['birth'])){echo htmlspecialchars($_POST['birth'], ENT_QUOTES);} ?>">
                            </div>

                            <div class="form-group my-5">
                                <label for="manufacturer" class="text-info lead"><span class="text-danger">*</span>よく乗るバイク（メーカー）:</label><br>
                                <?php if (isset($error['manufacturer']) && $error['manufacturer'] === 'blank'): ?>
                                    <p class="text-danger">メーカー名は必須入力です。</p>
                                <?php endif; ?>
                                <input type="text" name="manufacturer" id="manufacturer" class="form-control" value="<?php if(isset($_POST['manufacturer'])){echo htmlspecialchars($_POST['manufacturer'], ENT_QUOTES);} ?>">
                            </div>

                            <div class="form-group my-5">
                                <label for="bike_name" class="text-info lead"><span class="text-danger">*</span>よく乗るバイク（車種）:</label><br>
                                <?php if (isset($error['bike_name']) && $error['bike_name'] === 'blank'): ?>
                                    <p class="text-danger">車種名は必須入力です。</p>
                                <?php endif; ?>
                                <input type="text" name="bike_name" id="bike_name" class="form-control" value="<?php if(isset($_POST['bike_name'])){echo htmlspecialchars($_POST['bike_name'], ENT_QUOTES);} ?>">
                            </div>

                            <div class="form-group my-5">
                                <input type="submit" name="submit" class="btn btn-info btn-md text-white d-block mx-auto" value="確認画面へ">
                            </div>

                        </form>

                    </div>
                    <div class="my-5">
                        <a href="login.php"><p class="text-dark text-center">ログインページへ</p></a>
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