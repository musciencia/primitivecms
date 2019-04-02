<?php
class MenuItem {
    private $id = null;
    private $title = '';
    private $link = '';
    private $order = 0;

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }
    public function getLink() {
        return $this->link;
    }
    public function getOrder() {
        return $this->order;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function setOrder($order) {
        $this->order = $order;
    }

    public function set($title, $link, $order) {
        $this->title = $title;
        $this->link = $link;
        $this->order = $order;
    }

    public static function delete($pdo, $id) {
        $sql = 'DELETE FROM `MenuItem` WHERE `id` = ? ORDER BY `id`';
        $prepare = $pdo->prepare($sql);
        $prepare->execute([$id]);
    }
    
    public function save($pdo)
    { 
        if ( $this->id == null ) {
            return $this->insert($pdo);
        } else {
            if ( self::exists($pdo, $this->id) ) {
                return $this->update($pdo);
            } else {
                return $this->insert($pdo);
            }
        }
    }

    public function insert($pdo)
    {
        $result = 'success';
        $sql = 'INSERT INTO `MenuItem` (`title`, `link`, `order`) VALUES (?,?,?)';
        $prepare = $pdo->prepare($sql);
        try {
            $res = $prepare->execute([$this->title, $this->link, $this->order]);
            $result = $res ? 'succes': 'error';
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $result = 'duplicate';
            } else {
                $result =  'error';
            }
        }
        return $result;
    }

    public function update($pdo)
    { 
        $result = 'success';
        $sql = 'UPDATE `MenuItem` SET `title`=?, `link`=?, `order`=? WHERE `id` = ?';
        $prepare = $pdo->prepare($sql);
        try {
            $res = $prepare->execute([$this->title, $this->link, $this->order, $this->id]);
            $result = $res ? 'succes': 'error';
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $result = 'duplicate';
            } else {
                $result =  'error';
            }
        }
        return $result;
    }

    public static function exists($pdo, $id)
    {
        $sql = 'SELECT `id` FROM `MenuItem` WHERE `id` = ?';
        $prepare = $pdo->prepare($sql);
        $prepare->execute([$id]);
        return $prepare->rowCount() > 0;
    }

    public static function load($pdo, $id) {
        $sql = 'SELECT * FROM `MenuItem` WHERE `id` = ?';
        $prepare = $pdo->prepare($sql);
        $prepare->setFetchMode( PDO::FETCH_CLASS, 'MenuItem');
        $prepare->execute([$id]);
        $menuItem = $prepare->fetch();
        return $menuItem;
    }

    public static function loadAll($pdo) {
        $menuItems = array();
        $sql = 'SELECT * FROM `MenuItem` ORDER BY `order`';
        $prepare = $pdo->prepare($sql);
        $prepare->setFetchMode( PDO::FETCH_CLASS, 'MenuItem');
        $prepare->execute();
        while (  $menuItem = $prepare->fetch() ){
            $menuItems[] = $menuItem;
        }
        return $menuItems;
    }



    public static function create($title, $link, $order) {
        $menuItem = new MenuItem;
        $menuItem->title = $title;
        $menuItem->link = $link;
        $menuItem->order = $order;
        return $menuItem;
    }

    public static function createTable($pdo) {
        $sql = 
            "CREATE TABLE IF NOT EXISTS `menuitem` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(255) DEFAULT NULL,
                `link` varchar(255) DEFAULT NULL,
                `order` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`)
            );";
        $pdo->query($sql);
    }
}