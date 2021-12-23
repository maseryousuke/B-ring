<?php
session_start();
require_once(ROOT_PATH .'Controllers/PostController.php');
$delete = new PostController();
$delete->delete();

echo $_SERVER['HTTP_REFERER'];

// リファラ情報の有無による分岐
$referer = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : null;

if (preg_match( "/post_edit/", $referer)) { // 正規表現による文字列判定
    header('Location: my_page.php');
    return;
} elseif(preg_match( "/index/", $referer)) {
    header('Location: index.php');
    return;
}



// var_dump($_SERVER['REQUEST_URI']);
// $url = $_SERVER['REQUEST_URI'];
// if(strstr($url,'index')) {
//     header('Location: index.php');
//     return;
// } elseif(strstr($url,'post_edit')) {
//     header('Location: my_page.php');
//     return;
// }



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
    <?php require_once("header1.php")?>

<!-- 新規登録内容確認 -->
    <?php if($login_user['role'] == 1): ?> 
    <div>
        <h3 class="text-center text-info pt-5">削除完了</h3>
        <div class="container">
            <div  class="row justify-content-center align-items-center">
                <div  class="col-md-6">
                    <div  class="col-md-12">
                        <p class="text-center my-5">削除が完了致しました。</p>

                        <a href="my_page.php" class="btn btn-info btn-md text-white d-block mx-auto my-5">マイページへ</a> 
                        <a href="index.php" class="btn btn-info btn-md text-white d-block mx-auto my-5">メインページへ</a>       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif ;?>

    <?php if($login_user['role'] == 0): ?> 
    <div>
        <h3 class="text-center text-info pt-5">削除完了</h3>
        <div class="container">
            <div  class="row justify-content-center align-items-center">
                <div  class="col-md-6">
                    <div  class="col-md-12">
                        <p class="text-center my-5">削除が完了致しました。</p>

                        <a href="my_page.php" class="btn btn-info btn-md text-white d-block mx-auto my-5">マイページへ</a>       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif ;?>

<!-- フッター -->
    <?php require_once("footer.php")?>
</div>  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>