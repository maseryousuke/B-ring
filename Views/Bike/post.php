<?php
session_start();
require_once(ROOT_PATH .'Controllers/Controller.php');
$area = new Controller();
$params = $area -> area();

if(isset($_SESSION['err'])) {
    $err = $_SESSION['err'];
}
if(isset($_SESSION['post'])) {
    $post = $_SESSION['post'];
}

$_SESSION['err'] = '';
$_SESSION['post'] = '';

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
        <h3 class="text-center text-info pt-5">新規投稿ページ</h3>
        <p class="text-center pt-2"><span class="text-danger">*</span>は必須入力です。</p>
        <div class="container">
            <div  class="row justify-content-center align-items-center">
                <div  class="col-md-6">
                    <div  class="col-md-12">
                        <form id="post" class="form" enctype="multipart/form-data" action="post_comp.php" method="post">
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo htmlspecialchars($login_user['id'], ENT_QUOTES) ?>">
                            <div class="form-group my-5">
                                <label for="title" class="text-info lead"><span class="text-danger">*</span>タイトル</label><br>
                                <?php if (isset($err['title'])): ?>
                                    <p class="text-danger"><?php echo $err['title']; ?></p>
                                <?php endif; ?>
                                <input type="text" name="title" id="title" class="form-control" value='<?php if(isset($post['title'])){echo htmlspecialchars($post['title'], ENT_QUOTES);}?>'>
                            </div>
                            <div class="form-group my-5">
                                <label for="area" class="text-info lead"><span class="text-danger">*</span>エリア</label><br>
                                <?php if (isset($err['area'])): ?>
                                    <p class="text-danger"><?php echo $err['area']; ?></p>
                                <?php endif; ?>
                                <select name="area_id" id="area_id" class="form-control">
                                        <option disabled selected>選択してください</option>
                                        <?php foreach($params['areas'] as $area): ?>
                                        <option value='<?=$area['id']?>'><?=$area['name']?></option>
                                        <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group my-5">
                                <label for="location" class="text-info lead"><span class="text-danger">*</span>目的地</label><br>
                                <?php if (isset($err['location'])): ?>
                                    <p class="text-danger"><?php echo $err['location']; ?></p>
                                <?php endif; ?>
                                <input type="text" name="location" id="location" class="form-control" value='<?php if(isset($post['location'])){echo htmlspecialchars($post['location'], ENT_QUOTES);}?>'>
                            </div>
                            <div class="form-group my-5">
                                <label for="img" class="text-info lead"><span class="text-danger">*</span>写真</label><br>
                                <?php if (isset($err['img'])): ?>
                                    <p class="text-danger"><?php echo $err['img']; ?></p>
                                <?php endif; ?>
                                <input name="img" type="file" accept="image/*" class="form-control"/>
                    
                            </div>
                            <div class="form-group my-5">
                                <label for="contents" class="text-info lead"><span class="text-danger">*</span>感想</label><br>
                                <?php if (isset($err['contents'])): ?>
                                    <p class="text-danger"><?php echo $err['contents']; ?></p>
                                <?php endif; ?>
                                <textarea type="text" name="contents" id="contents" class="form-control"><?php if(isset($post['contents'])){echo htmlspecialchars($post['contents'], ENT_QUOTES);}?></textarea>
                            </div>
                            
                            <div class="form-group my-5">
                                <input type="submit" name="submit" class="btn btn-info btn-md text-white d-block mx-auto" value="投稿">
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