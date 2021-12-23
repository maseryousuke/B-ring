<?php
require_once(ROOT_PATH .'/Models/Post.php');

class PostController {
    private $request;   //リクエストパラメータ(GET,POST)
    private $User;      //Userモデル
    private $Area;      //Areaモデル  
    private $Post;      //Postモデル    
    
    public function __construct() {  
        //　リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;
        $this->request['files'] = $_FILES;
        
        //　モデルオブジェクトの生成 (Post.php)
        $this->Post = new Post();
        //　別モデルと連携（Area.php）
        // $dbh = $this->User->get_db_handler();
        // $this->Area = new Area($dbh);
        //　別モデルと連携（Post.php）
        // $dbh = $this->User->get_db_handler();
        // $this->Post = new Post($dbh);
        
    }

    public function index() {
        $page = 0;
        if(isset($this->request['get']['page'])) {
            $page = $this->request['get']['page'];
        }

        $a_id = 0;
        if(isset($this->request['get']['a_id'])) {
            $a_id = $this->request['get']['a_id'];
        }

        $posts = $this->Post->findAll($page);
        $posts_count = $this->Post->countAll();
        $a_posts = $this->Post->findByArea($a_id);
        $params = [
            'posts' => $posts,
            'pages' => $posts_count / 8,
            'a_posts' => $a_posts,
        ];
        return $params;
    }

    public function myindex() {
        $page = 0;
        if(isset($this->request['get']['page'])) {
            $page = $this->request['get']['page'];
        }

        $u_posts = $this->Post->findByUser($page);
        $posts_count = $this->Post->countAllByUser();
        $params = [
            'u_posts' => $u_posts,
            'pages' => $posts_count / 5
        ];
        return $params;

    }

    public function view() {
        $post = $this->Post->findById($this->request['get']['id']);
        $params = [
            'post' => $post,
        ];
        return $params;
    }

    public function create() {
        $posts = $this->Post->savePost();
        $params = [
            'posts' => $posts
        ];
        return $params;
    }

    public function edit() {
        $edit = $this->Post->editPost($this->request['get']['id']);
        // $area = $this->Post->areaById($this->request['get']);
        $params = [
            'post' => $edit
            // 'area' => $area
        ];
        return $params;
    }

    public function update() {
        $update = $this->Post->updatePost();
    }

    public function delete() {
        $delete = $this->Post->deletePost($this->request['get']['id']);
    }





}

?>
