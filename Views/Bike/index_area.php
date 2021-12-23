<?php
session_start();
require_once(ROOT_PATH .'Controllers/PostController.php');
$post = new PostController();
$params = $post->index();

?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/base.css">
    <link href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" rel="stylesheet">
</head>

<body>
<div class="hako">
<!--  ヘッダー -->
  <?php require_once("header1.php")?>

<!-- カテゴリ別ページ -->
  <div class="containaer">
    <div class="row">
      <!-- エリア別カテゴリ -->
      <div class="col-md-3 ">
        <ul class="ms-5 my-5 border-end border-secondary border-4">
        <li class="p-2"><a href="index_area.php?a_id=1">北海道エリア</a></li>
          <li class="p-2"><a href="index_area.php?a_id=2">東北エリア</a></li>
          <li class="p-2"><a href="index_area.php?a_id=3">関東エリア</a></li>
          <li class="p-2"><a href="index_area.php?a_id=4">北信越エリア</a></li>
          <li class="p-2"><a href="index_area.php?a_id=5">東海エリア</a></li>
          <li class="p-2"><a href="index_area.php?a_id=6">近畿エリア</a></li>
          <li class="p-2"><a href="index_area.php?a_id=7">中国エリア</a></li>
          <li class="p-2"><a href="index_area.php?a_id=8">四国エリア</a></li>
          <li class="p-2"><a href="index_area.php?a_id=9">九州エリア</a></li>
        </ul>
      </div>
      <!-- 投稿一覧 -->
      <div class="col-md-9">
        <!-- 管理ユーザ用表示 -->
        <?php if($login_user['role'] == 1): ?> 
        <?php foreach($params['a_posts'] as $post): ?>
        <div class="mx-5 my-5 border-end border-secondary border-4">
        <tr>
            <td><a href='/Bike/detail.php?id=<?=$post['id'] ?>'><span class="h3 p-5"><?=$post['title'] ?></span></a></td>
            <td><span class="p-3">/<?=$post['name'] ?></span></td>
            <td><span class="p-3">/<?=$post['created_at'] ?></span></td>
            <td><a href='/Bike/post_delete.php?id=<?=$post['id'] ?>' onclick="return confirm('本当に削除しますか？')">削除</a></td>
        </tr>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <!-- 一般ユーザ用表示 -->
        <?php if($login_user['role'] == 0): ?> 
        <?php foreach($params['a_posts'] as $post): ?>
          <div class="mx-5 my-5 border-end border-secondary border-4">
        <tr>
            <td><a href='/Bike/detail.php?id=<?=$post['id'] ?>'><span class="h3 p-5"><?=$post['title'] ?></span></a></td>
            <td><span class="p-3">/<?=$post['name'] ?></span></td>
            <td><span class="p-3">/<?=$post['created_at'] ?></span></td>
        </tr>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        
      </div>
    </div>
  </div>

<!-- フッター -->
  <?php require_once("footer.php")?>

</div>  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>