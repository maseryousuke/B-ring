<?php
require_once(ROOT_PATH .'/Models/Post.php');
require_once(ROOT_PATH .'/Models/User.php');
require_once(ROOT_PATH .'/Models/Area.php');

class Controller {
    private $request;   //リクエストパラメータ(GET,POST)
    private $User;      //Userモデル
    private $Area;      //Areaモデル  
    private $Post;      //Postモデル    
    
    public function __construct() {  
        //　リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;
        $this->request['files'] = $_FILES;
        
        //　モデルオブジェクトの生成 (User.php)
        $this->User = new User();
        //　別モデルと連携（Area.php）
        $dbh = $this->User->get_db_handler();
        $this->Area = new Area($dbh);
        //　別モデルと連携（Post.php）
        $dbh = $this->User->get_db_handler();
        $this->Post = new Post($dbh);
        
    }

    // public function index() {
    //     $page = 0;
    //     if(isset($this->request['get']['page'])) {
    //         $page = $this->request['get']['page'];
    //     }

    //     $c_id = 0;
    //     if(isset($this->request['get']['c_id'])) {
    //         $c_id = $this->request['get']['c_id'];
    //     }

    //     $players = $this->Player->findAll($page);
    //     $players_count = $this->Player->countAll();
    //     $c_name = $this->Player->findCountry($c_id);

    //     $c_players = $this->Player->findByCountry($c_id);
    //     $params = [
    //         'players' => $players,
    //         'pages' => $players_count / 20,
    //         'c_name' => $c_name,
    //         'c_players' => $c_players
    //     ];
    //     return $params;
    // }

    // public function view() {
    //     // if(empty($this->request['get']['id'])) {
    //     //     echo '指定のパラメータが不正です。　このページを表示できません。';
    //     //     exit;
    //     // }

    //     $login_user = $this->User->findById($this->request['get']['id']);
    //     $params = [
    //         'login_user' => $login_user,
    //     ];
    //     return $params;
    // }

    // public function delete() {
    //     if(empty($this->request['get']['id'])) {
    //         echo '指定のパラメータが不正です。　このページを表示できません。';
    //         exit;
    //     }

    //     $delete = $this->Player->deleteFlg($this->request['get']['id']);
    //     $tmp = $this->Player->tmp();

    // }

    // public function edit() {
    //     if(empty($this->request['get']['id'])) {
    //         echo '指定のパラメータが不正です。　このページを表示できません。';
    //         exit;
    //     }

    //     $edit = $this->Player->editPlayer($this->request['get']['id']);
    //     $countries = $this->Player->getAllCountry();
    //     $country = $this->Player->getCountry($this->request['get']['id']);
    //     $params = [
    //         'player' => $edit,
    //         'countries' => $countries,
    //         'country' => $country
    //     ];
    //     return $params;
    // }

    // public function update() {
    //     if(empty($this->request['post']['id'])) {
    //         echo '指定のパラメータが不正です。　このページを表示できません。';
    //         exit;
    //     }
        
    //     $update = $this->Player->updatePlayer($this->request['post']['id']);
    //     $tmp = $this->Player->tmp();

    // }
    
    // public function signUp() {
        
    //     $countries = $this->Player->getAllCountry();
    //     $params = [
    //         'countries' => $countries
    //     ];
    //     return $params;
    // }
    
    public function create() {
        $create = $this->User->createUser($this->request['post']);   
    }

    public function edit() {
        $edit = $this->User->editUser($this->request['get']['id']); 
        $params = [
            'user' => $edit
        ];
        return $params;
    }

    

    public function update() {
        $update = $this->User->updateUser(); 
        $user = $this->User->findByid($this->request['post']['id']);
        $params = [
            'user' => $user
        ];
        return $params;
        //$result = $this->User->updateUser(); 
        //$_SESSION['login_user'] = $update;
    }

    public function reset() {
        $reset= $this->User->updatePass(); 
        // $name = $this->User->updateUser(); 
        // $_SESSION['login_user']['name'] = $name;
    }

    public function area() {
        $areas = $this->Area->areaAll();
        $params = [
            'areas' => $areas
        ];
        return $params;
    }

    

}



?>