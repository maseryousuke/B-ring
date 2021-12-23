<?php

require_once(ROOT_PATH .'/database.php');
require_once(ROOT_PATH .'/Models/Db.php');

$user_id = $_POST['user_id'];
$post_id = $_POST['post_id'];

function check_like_duplicate($user_id, $post_id){
    $result = false;
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
    if(!empty($like)) {
        $result = true;
    }
    return $result;
}

//var_dump($result);

if(isset($_POST)){

  $user_id = $_POST['user_id'];
  $post_id = $_POST['post_id'];

  //既に登録されているか確認
  if(check_like_duplicate($user_id, $post_id)){
    $action = '解除';
    $sql = " DELETE FROM likes WHERE :user_id = user_id AND :post_id = post_id ";
  }else{
    $action = '登録';
    $sql = " INSERT INTO likes ( post_id, user_id ) VALUE ( :post_id, :user_id ) ";
  }

  try{
    $dbh = new PDO(
        'mysql:dbname='.DB_NAME.
        ';host='.DB_HOST, DB_USER, DB_PASSWD
    );
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

  } catch (\Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
    //set_flash('error',ERR_MSG1);
    echo ("error".$e);
  }
}
