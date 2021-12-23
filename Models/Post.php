<?php 
require_once(ROOT_PATH .'/Models/Db.php');

class Post extends Db {
    public function __construct($dbh = null) {
        parent::__construct($dbh);
    }

    /**
     * 全投稿データを参照する
     * @param void
     * @return Array $result 全参照データ
     */
    public function findAll($page) {
        $sql = " SELECT p.id, p.title, p.area_id, p.location, p.file_name, p.file_path, p.contents, u.name, p.created_at, p.updated_at FROM post p INNER JOIN users u ON p.user_id = u.id WHERE del_flg = 0 ";
        $sql .= ' LIMIT 8 OFFSET '.(8 * $page);
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        // 結果の取得
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /** 
     * postテーブルから全データ数を取得
     * 
     * @return Int $count 全投稿の件数
    */
    public function countAll() {
        $sql = 'SELECT count(*) as count FROM post';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();
        return $count;
    }

    /** 
     * postテーブルから指定IDの全データ数を取得
     * @param int $id
     * @return Int $count 全投稿の件数
    */
    public function countAllByUser() {
        $login_user = $_SESSION['login_user'];
        $id = $login_user['id'];

        $sql = ' SELECT COUNT(*) FROM post p INNER JOIN users u ON p.user_id = u.id WHERE u.id = :id ';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $count = $sth->fetchColumn();
        return $count;
    }
    

    /**
     * エリア別投稿データを参照する
     * @param void
     * @return Array $result 全参照データ
     */
    public function findByArea($a_id = 0) {
        $sql = " SELECT p.id, p.title, p.area_id, p.location, p.file_name, p.file_path, p.contents, u.name, p.created_at, p.updated_at FROM post p INNER JOIN users u ON p.user_id = u.id WHERE p.area_id = :a_id AND del_flg = 0 ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':a_id', $a_id, PDO::PARAM_INT);
        $stmt->execute();
        // 結果の取得
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * ユーザ別投稿データを参照する
     * @param void
     * @return Array $result 全参照データ
     */
    public function findByUser($page) {
        $login_user = $_SESSION['login_user'];
        $id = $login_user['id'];

        $sql = " SELECT p.id, p.title, p.area_id, p.location, p.file_name, p.file_path, p.contents, u.name, p.created_at, p.updated_at FROM post p INNER JOIN users u ON p.user_id = u.id WHERE p.user_id = :id AND del_flg = 0 ";
        $sql .= ' LIMIT 5 OFFSET '.(5 * $page);
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        // 結果の取得
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * 投稿詳細を取得する（指定IDのデータ）
     * @param int $id 投稿のID
     * @return Array $result 指定IDの投稿データ
     */
    public function findById($id = 0) {
        $sql = ' SELECT * FROM post WHERE id = :id ' ;
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * 投稿編集ページに投稿データを取得する（指定IDのデータ）
     * @param int $id 投稿のID
     * @return Array $result 指定IDの投稿データ
     */
    public function editPost($id = 0) {
        $sql = ' SELECT p.id, p.title, p.area_id, a.name, p.location, p.file_path, p.contents, p.user_id FROM post p INNER JOIN area a ON p.area_id = a.id WHERE p.id = :id ' ;
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // /**
    //  * 指定IDのエリア名を取得する
    //  * @param void
    //  * @return Array $result 全参照データ
    //  */
    
    // public function areaById($a_id = 0) {

    //     $sql = ' SELECT * FROM area WHERE id = :a_id';
    //     $stmt = $this->dbh->prepare($sql);
    //     $stmt->bindParam(':a_id', $a_id, PDO::PARAM_INT);
    //     $stmt->execute();
    //     // 結果の取得
    //     $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $result;
    // }

    /**
     * 新規投稿の保存
     * @param int $user_id ユーザID
     * @param string $title　タイトル
     * @param int $area_id　エリアID
     * @param string $location　目的地
     * @param string $contents　感想
     * @param string $save_filename　ファイル名
     * @param string $save_path　保存先のパス
     * @return bool $result
     */
    public function savePost() {
        $result = false;

        // //ファイル関連の取得
        $file = $_FILES['img'];
        $filename = basename($file['name']);
        $tmp_path = $file['tmp_name'];
        $file_err = $file['error'];
        $filesize = $file['size'];
        $upload_dir = 'img/';

        $save_filename = date('YmdHis') . $filename;
        $save_path = $upload_dir . $save_filename;


        $title  = $_POST['title'];
        $area_id  = $_POST['area_id'];
        $location  = $_POST['location'];
        $contents  = $_POST['contents'];
        $user_id  = $_POST['user_id'];
        


        $sql = " INSERT INTO post (`title`,`area_id`,`location`,`file_name`,`file_path`,`contents`,`user_id`, del_flg ) VALUES (:title, :area_id, :location, :file_name, :file_path, :contents, :user_id, 0 ) ";
        try{
            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':title',$title,PDO::PARAM_STR);
            $sth->bindValue(':area_id',$area_id,PDO::PARAM_INT);
            $sth->bindValue(':location',$location,PDO::PARAM_STR);
            $sth->bindValue(':file_name',$save_filename,PDO::PARAM_STR);
            $sth->bindValue(':file_path',$save_path,PDO::PARAM_STR);
            $sth->bindValue(':contents',$contents,PDO::PARAM_STR);
            $sth->bindValue(':user_id',$user_id,PDO::PARAM_INT);
            // // executeで実行
            $result = $sth->execute();
            return $result;
        } catch(\Exception $e) {
            echo $e->getMessage();
            return $result;
        }    
    }

    /**
     * 新規投稿の更新
     * @param int $user_id ユーザID
     * @param string $title　タイトル
     * @param int $area_id　エリアID
     * @param string $location　目的地
     * @param string $contents　感想
     * @param string $save_filename　ファイル名
     * @param string $save_path　保存先のパス
     * @return bool $result
     */
    public function updatePost() {

        // //ファイル関連の取得
        $file = $_FILES['img'];
        $filename = basename($file['name']);
        $tmp_path = $file['tmp_name'];
        $file_err = $file['error'];
        $filesize = $file['size'];
        $upload_dir = 'img/';
        $save_filename = date('YmdHis') . $filename;

        $save_path = $upload_dir . $save_filename;

        $id = $_POST['id'];
        $title  = $_POST['title'];
        $area_id  = $_POST['area_id'];
        $location  = $_POST['location'];
        $contents  = $_POST['contents'];
        $user_id  = $_POST['user_id'];

        $sql = ' UPDATE post SET id = :id, title = :title, area_id = :area_id, file_name = :file_name, file_path = :file_path, location = :location, contents = :contents, user_id = :user_id ';
        $sql .= ' WHERE id = :id ';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->bindParam(':title', $_POST['title'],PDO::PARAM_STR);
        $sth->bindParam(':area_id', $_POST['area_id'],PDO::PARAM_INT);
        $sth->bindParam(':location', $_POST['location'],PDO::PARAM_STR);
        $sth->bindParam(':file_name', $save_filename,PDO::PARAM_STR);
        $sth->bindParam(':file_path', $save_path,PDO::PARAM_STR);
        $sth->bindParam(':contents', $_POST['contents'],PDO::PARAM_STR);
        $sth->bindParam(':user_id', $_POST['user_id'],PDO::PARAM_INT);
        $sth->execute();

    }

    /**
     * 削除
     * del_flgカラムが０で表示、１で非表示にするためにUPDATEで更新する。
     */
    public function deletepost($id = 0) {
        $sql = ' UPDATE post SET del_flg = 1 ';
        $sql .= ' WHERE id = :id ';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();

    }

    // /**
    //  * データを編集する
    //  * @param int $id
    //  * @return Array $result 指定idの参照データ
    //  */
    // public function editContact($id = 0):Array {
    //     $sql = " SELECT * FROM contacts WHERE id = :id ";
    //     $stmt = $this->dbh->prepare($sql);
    //     $stmt -> bindValue(':id', $id, PDO::PARAM_INT);
    //     $stmt -> execute();
    //     $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    //     return $result;
    // }

    // /**
    //  * お問い合わせ内容の削除
    //  * @param int $id
    //  */
    // public function deleteContact() {
    //     $sql = " DELETE FROM contacts WHERE id = :id ";
    //     $stmt = $this->dbh->prepare($sql);
    //     $stmt -> bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    //     $stmt->execute();
    // }

    // /**
    //  * お問い合わせ内容の更新
    //  * @param int $id
    //  * @return bool $result
    //  */
    // public function updataContact() {
    //     $sql = 'UPDATE contacts SET name = :name, kana = :kana, tel = :tel, email = :email, body = :body  WHERE id = :id';
    //     $stmt = $this->dbh -> prepare($sql);
    //     $stmt -> bindValue(':id',$_POST['id'],PDO::PARAM_INT);
    //     $stmt -> bindValue(':name',$_POST['name'],PDO::PARAM_STR);
    //     $stmt -> bindValue(':kana',$_POST['kana'],PDO::PARAM_STR);
    //     $stmt -> bindValue(':tel',$_POST['tel'],PDO::PARAM_STR);
    //     $stmt -> bindValue(':email',$_POST['email'],PDO::PARAM_STR);
    //     $stmt -> bindValue(':body',$_POST['contact'],PDO::PARAM_STR);
    //     $result = $stmt -> execute();
    // }

}
?>