<?php
require_once(ROOT_PATH .'/database.php');
require_once(ROOT_PATH .'/Models/Db.php');

class User extends Db {
    private $table = 'user';

    public function __construct($dbh = null) {
        parent::__construct($dbh);
    }

    /**
     * ユーザを登録する
     * @param array $_POST
     * @return bool $result
     */
    public function createUser($UserData) {
        $result = false;

        $sql = ' INSERT INTO users (name, email, password, birth, manufacturer, bike_name, role) VALUES (:name, :email, :password, :birth, :manufacturer, :bike_name, 0) ';
        $sth = $this->dbh->prepare($sql);

        $pass_hash = password_hash($UserData['password'], PASSWORD_DEFAULT);

        $sth->bindParam(':name', $UserData['name'],PDO::PARAM_STR);
        $sth->bindParam(':email', $UserData['email'],PDO::PARAM_STR);
        $sth->bindParam(':password', $pass_hash, PDO::PARAM_STR);
        $sth->bindParam(':birth', $UserData['birth'], PDO::PARAM_STR);
        $sth->bindParam(':manufacturer', $UserData['manufacturer'], PDO::PARAM_STR);
        $sth->bindParam(':bike_name', $UserData['bike_name'], PDO::PARAM_STR);
        
        try{
            $result = $sth->execute();
            return $result;
        } catch (PDOException $e) {
            return $result;
        }
    }

    /**
     * ユーザ情報を編集画面に表示する
     * @param int $id
     * @return Array $result
     */
    public function editUser($id = 0) {
        $result = false;

        $sql = ' SELECT * FROM users WHERE id = :id ' ;
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
        try{
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
        } catch (PDOException $e) {
            return $result;
        }
    }

    /**
     * ユーザ情報の更新
     * @param array $_POST
     * @return bool $result
     */
    public function updateUser() {

        $id = $_POST['id'];
        $name = $_POST['name'];
        $email  = $_POST['email'];
        $password  = $_POST['password'];
        $manufacturer  = $_POST['manufacturer'];
        $bike_name  = $_POST['bike_name'];

        $sql = ' UPDATE users SET name = :name, email = :email, password = :password, manufacturer = :manufacturer, bike_name = :bike_name ';
        $sql .= ' WHERE id = :id ';
        $sth = $this->dbh->prepare($sql);
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->bindParam(':name', $name,PDO::PARAM_STR);
        $sth->bindParam(':email', $email,PDO::PARAM_STR);
        $sth->bindParam(':password', $pass_hash,PDO::PARAM_STR);
        $sth->bindParam(':manufacturer', $manufacturer,PDO::PARAM_STR);
        $sth->bindParam(':bike_name', $bike_name,PDO::PARAM_STR);

        $result = $sth->execute();

        return $result;

    }
    
    /**
     * ログイン処理
     * @param string $email
     * @param string $password
     * @return bool $result
     */
    public static function login($email, $password) {
        // 結果
        $result = false;
        // ユーザをemailから検索して取得
        $user = self::getUserByEmail($email);

        if(!$user) {
            $_SESSION['msg'] = 'メールアドレスが一致しません。';
            return $result;
        }

        //パスワードの照会
        if(password_verify($password, $user['password'])) {
            //ログイン成功
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;
        }

        $_SESSION['msg'] = 'パスワードが一致しません。';
        return $result;
    }

    /**
     * emailからユーザを取得
     * @param string $email
     * @return array|bool $user|false
     */
    public static function getUserByEmail($email) {

        $dbh = new PDO(
            'mysql:dbname='.DB_NAME.
            ';host='.DB_HOST, DB_USER, DB_PASSWD
        );

        

        $sql = ' SELECT * FROM users WHERE email = :email ';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':email', $email,PDO::PARAM_STR);

        try{
            $sth->execute();
            $user = $sth->fetch();
            return $user;
        } catch(\Exception $e) {
            return false;
        }
    }

    /**
     * ログインチェック
     * @param void
     * @return bool $result
     */
    public static function loginCheck() {
        // 結果
        $result = false;

        //セッションにログインユーザが入っていなかったらfalse
        if(isset($_SESSION['login_user']) && isset($_SESSION['login_user']['id']) > 0) {
            return $result = true;
        }

        return $result;
    }

    /**
     * ログアウト
     */
    public static function logout() {
        $_SESSION = array();
        session_destroy();
    }

    /**
     * ユーザ情報の取得
     * @param int $id ユーザのID
     * @return Array $result 指定のユーザデータ
     */
    public function findByid($id = 0) {
        $sql = ' SELECT * FROM users ';
        $sql .= ' WHERE id = :id ';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * パスワードリセット準備（メールアドレスと誕生日の一致確認）
     * @param string $email
     * @param string $password
     * @return bool $result
     */
    public static function resetPass($email, $birth) {
        // 結果
        $result = false;
        // ユーザをemailから検索して取得
        $user = self::getUserByEmail($email);

        if(!$user) {
            $_SESSION['msg'] = 'メールアドレスが一致しません。';
            return $result;
        }

        //誕生日の照会
        if($birth === $user['birth']) {
            //照会成功
            $_SESSION['user'] = $user;
            $result = true;
            return $result;
        }

        $_SESSION['msg'] = '誕生日が一致しません。';
        return $result;
    }
    
    /**
     * パスワードリセット処理
     * @param array $_POST
     * @return bool $result
     */
    public function updatePass() {

        $id = $_POST['id'];
        $password  = $_POST['password'];

        $sql = ' UPDATE users SET password = :password ';
        $sql .= ' WHERE id = :id ';
        $sth = $this->dbh->prepare($sql);
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->bindParam(':password', $pass_hash,PDO::PARAM_STR);

        $sth->execute();
    }
}

?>