<?php 
require_once(ROOT_PATH .'/Models/Db.php');

class Area extends Db {
    public function __construct($dbh = null) {
        parent::__construct($dbh);
    }

    /**
     * 全エリア名を取得する
     * @param void
     * @return Array $result 全参照データ
     */
    
    public function areaAll() {
        $sql = ' SELECT * FROM area ';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array());
        // 結果の取得
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * 指定IDのエリア名を取得する
     * @param void
     * @return Array $result 全参照データ
     */
    
    public function areaById($a_id = 0) {

        $sql = ' SELECT * FROM area WHERE id = :a_id';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':a_id', $a_id, PDO::PARAM_INT);
        $stmt->execute();
        // 結果の取得
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>