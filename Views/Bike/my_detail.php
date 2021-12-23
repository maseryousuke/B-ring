<?php
session_start();
require_once(ROOT_PATH .'Controllers/PostController.php');
$post = new PostController();
$params = $post->view();
//var_dump($params);

$file_path = '/' . $params['post']['file_path'];

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

<!-- 投稿詳細 -->
    <div class="containaer">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8">
                <!-- 投稿一覧 -->
                <div class="col-md-12">
                    <div class="mx-5 my-5">
                        <h3 class="text-center pb-3"><?php echo $params['post']['title'] ?></h3>
                        <div class="col-md-8 mx-auto">
                            <img src="<?php echo $file_path ?>" alt="" width="100%">
                            <p class="lead py-3">★<?php echo $params['post']['location'] ?></p>
                        </div>
                        <div class="col-md-8 border border-secondary mx-auto mb-5">
                            <p class=""><?php echo nl2br($params['post']['contents']) ?></p>
                            
                        </div>
                        <div class="d-flex justify-content-center">
                            <a class="btn btn-info text-white mx-2" onclick="history.back(-1)">マイページへ戻る</a>
                            <a href="post_edit.php?id=<?= $params['post']['id']?>" class="btn btn-dark btn-md mx-2">編集</a>
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