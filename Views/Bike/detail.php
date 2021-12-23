<?php
session_start();
require_once(ROOT_PATH .'Controllers/PostController.php');
$post = new PostController();
$params = $post->view();

$file_path = '/' . $params['post']['file_path'];


//ユーザーIDと投稿IDを元にいいね値の重複チェックを行う
require_once(ROOT_PATH .'/database.php');
require_once(ROOT_PATH .'/Models/Db.php');

$user_id = $_SESSION['login_user']['id'];
$post_id = $_GET['id'];

//var_dump($user_id);
//var_dump($post_id);

function check_like_duplicate($user_id, $post_id){
    $dbh = new PDO(
        'mysql:dbname='.DB_NAME.
        ';host='.DB_HOST, DB_USER, DB_PASSWD
    );

    $sql = " SELECT * FROM likes WHERE user_id = :user_id AND post_id = :post_id ";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    $like = $stmt->fetch();
    return $like;
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">

    <script>
        var user_id = <?php echo $user_id; ?>;
        var post_id = <?php echo $post_id; ?>;

        $(document).on('click','.like_btn',function(e){
            e.preventDefault();
            var $this = $(this);
                
            $.ajax({
                type: 'POST',
                url: 'ajax_post_like_process.php',
                dataType: 'text',
                data: { user_id: user_id,
                        post_id: post_id}
            }).done(function(data){
                console.log(data);
                $this.children('i').toggleClass('far'); //空洞ハート
                // いいね押した時のスタイル
                $this.children('i').toggleClass('fas'); //塗りつぶしハート
                $this.children('i').toggleClass('active');
                $this.toggleClass('active');
                //window.alert(user_id);
            }).fail(function() {
                console.log('だめです');
            });
        });

    </script>
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
                        <div class='col-md-8 mx-auto'>
                        <form class="favorite_count" action="" method="post">
                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                <input type="hidden" name="post_id" value="<?= $post_id ?>">
                                <!-- <button type="button" name="favorite" class="like_btn">
                                <?php if (!check_like_duplicate($user_id,$post_id)): ?>
                                    <i class="fas fa-heart"></i>
                                <?php else: ?>
                                いいね解除
                                <?php endif; ?>
                                </button> -->
                                <section class="post" data-postid="<?php echo $post_id; ?>">
                                    <div class="like_btn <?php if (!check_like_duplicate($user_id,$post_id)) echo 'active';?>">
                                        <!-- 自分がいいねした投稿にはハートのスタイルを常に保持する -->
                                        <i class="fa-heart fa-lg px-16
                                        <?php
                                            if((check_like_duplicate($user_id,$post_id))){ //いいね押したらハートが塗りつぶされる
                                                echo ' active fas';
                                            }else{ //いいねを取り消したらハートのスタイルが取り消される
                                                echo ' far';
                                            }; ?>"><span>いいね！</span></i>
                                    </div>
                                </section>
                        </form>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            <a class="btn btn-info text-white" onclick="history.back(-1)">メインページへ戻る</a>
                        </div>
                    </div>     
                </div>  
            </div>
        </div>
    </div>

<!-- フッター -->
  <?php require_once("footer.php")?>
</div>

  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>