<?php
session_start();
require_once(ROOT_PATH .'Controllers/PostController.php');
require_once(ROOT_PATH .'Controllers/Controller.php');
$edit = new PostController();
$params = $edit->edit();
$areas = new Controller();
$areas = $areas->area();

//var_dump($params);


if(isset($_SESSION['err'])) {
    $err = $_SESSION['err'];
}
//var_dump($err);

$_SESSION['err'] = '';

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
<!-- 新規投稿フォーム -->
    <div id="login">
        <h3 class="text-center text-info pt-5">編集ページ</h3>
        <div class="container">
            <div  class="row justify-content-center align-items-center">
                <div  class="col-md-6">
                    <div  class="col-md-12">
                        <form id="post" class="form" enctype="multipart/form-data" action="post_update.php" method="post">
                        <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($params['post']['id'], ENT_QUOTES) ?>">
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo htmlspecialchars($params['post']['user_id'], ENT_QUOTES) ?>">
                            <div class="form-group my-5">
                                <label for="title" class="text-info lead"><span class="text-danger">*</span>タイトル</label><br>
                                
                                <?php if (isset($err['title'])): ?>
                                    <p class="text-danger"><?php echo $err['title']; ?></p>
                                <?php endif; ?>
                                <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($params['post']['title'], ENT_QUOTES)?>">
                            </div>
                            <div class="form-group my-5">
                                <label for="area" class="text-info lead"><span class="text-danger">*</span>エリア</label><br>
                                
                                <?php if (isset($err['area'])): ?>
                                    <p class="text-danger"><?php echo $err['area']; ?></p>
                                <?php endif; ?>
                                <select name="area_id" id="area_id" class="form-control">
                                    <option value="<?=$params['post']['area_id']?>" ><?php echo htmlspecialchars($params['post']['name'], ENT_QUOTES)?></option>
                                    <?php foreach($areas['areas'] as $area): ?>
                                    <option value='<?=$area['id']?>'><?=$area['name']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group my-5">
                                <label for="location" class="text-info lead"><span class="text-danger">*</span>目的地</label><br>
                                
                                <?php if (isset($err['location'])): ?>
                                    <p class="text-danger"><?php echo $err['location']; ?></p>
                                <?php endif; ?>
                                <input type="text" name="location" id="location" class="form-control" value="<?php echo htmlspecialchars($params['post']['location'], ENT_QUOTES)?>">
                            </div>
                            <div class="form-group my-5">
                                <label for="img" class="text-info lead"><span class="text-danger">*</span>写真</label><br>
                                
                                <?php if (isset($err['img'])): ?>
                                    <p class="text-danger"><?php echo $err['img']; ?></p>
                                <?php endif; ?>
                                <input name="img" type="file" accept="image/*" class="form-control" >
                    
                            </div>
                            <div class="form-group my-5">
                                <label for="contents" class="text-info lead"><span class="text-danger">*</span>感想</label><br>
                                
                                <?php if (isset($err['contents'])): ?>
                                    <p class="text-danger"><?php echo $err['contents']; ?></p>
                                <?php endif; ?>
                                <textarea type="text" name="contents" id="contents" class="form-control"><?php echo htmlspecialchars($params['post']['contents'], ENT_QUOTES)?></textarea>
                            </div>
                            
                            
                            <div class="form-group my-5 d-flex justify-content-center">
                                <input type="submit" name="submit" class="btn btn-info btn-md text-white mx-2" value="更新">
                                <a class="btn btn-dark btn-md mx-2" role="button" onclick="history.back(-1)">戻る</a>
                                <a href="post_delete.php?id=<?= $params['post']['id'] ?> " class="btn btn-dark btn-md mx-2" onclick="return confirm('本当に投稿を削除しますか？')">削除</a>
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