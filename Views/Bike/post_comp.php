<?php
session_start();



//ファイル関連の取得
$file = $_FILES['img'];
$filename = basename($file['name']);
$tmp_path = $file['tmp_name'];
$file_err = $file['error'];
$filesize = $file['size'];
$upload_dir = 'img/';
$save_filename = date('YmdHis') . $filename;

$save_path = $upload_dir . $save_filename;

// $user_id = $_POST['user_id'];

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

if(count($err) === 0) { //エラーがない場合
    //ファイルがあるか
    if(is_uploaded_file($tmp_path)) {
        if(move_uploaded_file($tmp_path, $upload_dir. $save_filename)) {
            // echo $filename . 'を'. $upload_dir. 'アップしました。';
            // echo $save_filename;
            //DBに保存
            require_once(ROOT_PATH .'Controllers/PostController.php');
            $post = new PostController();
            $params = $post->create();

            header('Location: my_page.php');
            return;

            if($params) {
                echo 'データベースに保存しました。';
            }else {
                echo 'データベースへの保存が失敗しました。';
            }
        }else {
            echo 'ファイルを保存できませんでした。';
        }
    }else {
        echo 'ファイルが選択されていません。';
        echo '</br>';
    }
} else{ //エラーがあった場合は戻す
    $_SESSION['err'] = $err;
    $_SESSION['post'] = $_POST;
    header('Location: post.php');
    return;
}
    
?>