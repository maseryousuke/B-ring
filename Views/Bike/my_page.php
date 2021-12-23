<?php
session_start();
require_once(ROOT_PATH .'Controllers/Controller.php');
require_once(ROOT_PATH .'Controllers/PostController.php');
require_once(ROOT_PATH .'Models/User.php');
$u_post = new PostController();
$params = $u_post->myindex();


$result = User::loginCheck();

$login_user = $_SESSION['login_user'];

//var_dump($login_user);

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

<!-- マイページ -->
<div class="containaer">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-9">
            <div class="col-md-12">
                <div class="text-center">
                    <h3 class="m-5">マイページ</h3>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="mx-5 my-3">
                        <p>ユーザ名：<?php echo htmlspecialchars($login_user['name'])?></p>
                        <p>バイクの車種：<?php echo htmlspecialchars($login_user['bike_name'])?></p>
                    </div>
                    <div class="mx-5 my-3">
                        <a href="user_edit.php?id=<?= $login_user['id'] ?>"><p>アカウントを編集する</p></a>
                    </div>
                </div>

                <div class="mx-5 my-3">
                    <a href="post.php?id=<?=$login_user['id']?>" class="btn btn-secondary btn-md text-white">新規投稿</a>
                </div>

                <?php if(empty($params['u_posts'])) :?>
                    <p>投稿はありません。</p>
                <?php else :?>
                    <?php foreach($params['u_posts'] as $u_post): ?>
                    <div class="mx-5 my-5 border-end border-secondary border-4">
                    <tr>
                        <td><a href='/Bike/my_detail.php?id=<?=$u_post['id'] ?>'><span class="h3 p-5"><?=$u_post['title'] ?></span></a></td>
                        <td><span class="p-3">/<?=$u_post['name'] ?></span></td>
                        <td><span class="p-3">/<?=$u_post['created_at'] ?></span></td>
                    </tr>
                    </div>
                    <?php endforeach; ?>
                
                
                    <div class='paging'>
                        <?php
                        for($i=0; $i<$params['pages']; $i++) {
                            if(isset($_GET['page']) && $_GET['page'] == $i) {
                                echo $i+1;
                            } else {
                                echo "<a href='?page=".$i."'>".($i+1)."</a>";
                            }
                        }
                        ?>
                    </div>  
                <?php endif ;?>
          

                
                
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