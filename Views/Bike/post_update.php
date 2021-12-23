<?php
session_start();


//var_dump($_POST);
//var_dump($_FILES);

//ファイル関連の取得
$file = $_FILES['img'];
$filename = basename($file['name']);
$tmp_path = $file['tmp_name'];
$file_err = $file['error'];
$filesize = $file['size'];
$upload_dir = 'img/';
$save_filename = date('YmdHis') . $filename;

$save_path = $upload_dir . $save_filename;



//エラーメッセージ
$err = [];

//バリデーション

// タイトル(空チェック)
if (!$title = filter_input(INPUT_POST, 'title')) {
    $err['title'] = 'タイトルを入力してください。';
}

//エリア(空チェック)
if (!$area_id = filter_input(INPUT_POST, 'area_id')) {
    $err['area'] = 'エリアを選択してください。';
}

// 目的地(空チェック)
if (!$location = filter_input(INPUT_POST, 'location')) {
    $err['location'] = '目的地を入力してください。';
}

// 感想(空チェック)　
if (!$contents = filter_input(INPUT_POST, 'contents')) {
    $err['contents'] = '感想を入力してください。';
}

//写真(拡張は画像形式か、ファイルはあるか)
//画像形式チェック
$allow_ext = array('jpg', 'jpeg', 'png');
$file_ext = pathinfo($filename, PATHINFO_EXTENSION);

if(!in_array(strtolower($file_ext), $allow_ext)) {
    $err['img'] = '画像ファイルを添付してください。';
}

//var_dump($err);

if(count($err) === 0) { //エラーがない場合
    //ファイルがあるか
    if(is_uploaded_file($tmp_path)) {
        if(move_uploaded_file($tmp_path, $upload_dir. $save_filename)) {
            // echo $filename . 'を'. $upload_dir. 'アップしました。';
            // echo $save_filename;
            //DBに保存
            require_once(ROOT_PATH .'Controllers/PostController.php');
            $update = new PostController();
            $params = $update->update();

            header('Location: my_page.php');
            return;

            // if($params) {
            //     echo '更新しました。';
            // }else {
            //     echo 'データベースへの保存が失敗しました。';
            // }
        }else {
            echo 'ファイルを保存できませんでした。';
        }
    }else {
        echo 'ファイルが選択されていません。';
        echo '</br>';
    }
} else{ //エラーがあった場合は戻す
    $_SESSION['err'] = $err;
    $id = $_POST['id'];
    $url = "post_edit.php?id=" . $id;
    header('Location:' .$url);
    return;
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
    <?php require_once("header1.php")?>

<!-- 新規登録内容確認 -->
    <div id="login">
        <h3 class="text-center text-info pt-5">更新完了</h3>
        <div class="container">
            <div  class="row justify-content-center align-items-center">
                <div  class="col-md-6">
                    <div  class="col-md-12">
                        <p class="text-center my-5">更新が完了致しました。</p>

                        <a href="my_page.php" class="btn btn-info btn-md text-white d-block mx-auto my-5">マイページへ</a>       
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