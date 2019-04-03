<?php

class Page
{
    private $id = null;
    private $code;
    private $title;
    private $content;
    private $template ='default';

    public static function create($code, $title, $content, $template)
    {
        $page = new Page();
        $page->code = $code;
        $page->title = $title;
        $page->content = $content;
        return $page;
    }

    public function setTitle($title) {
        $this->title = $title;
    } 

    public function setCode($code) {
        $this->code = $code;
    } 

    public function setContent($content) {
        $this->content = $content;
    } 

    public function setTemplate($template) {
        $this->template = $template;
    } 

    public function getId() {
        return $this->id;
    }

    public function getCode() {
        return $this->code;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getTemplate() {
        return $this->template;
    }

    public static function exists($pdo, $id)
    {
        $sql = 'SELECT `id` FROM Page WHERE `id` = ?';
        $prepare = $pdo->prepare($sql);
        $prepare->execute([$id]);
        return $prepare->rowCount() > 0;
    }

    public static function deleteById($pdo, $id) {
        $sql = 'DELETE FROM Page WHERE `id` = ? ORDER BY `id`';
        $prepare = $pdo->prepare($sql);
        $prepare->execute([$id]);
    }

    public static function loadByCode($pdo, $code) {
        $sql = 'SELECT * FROM Page WHERE `code` = ? ORDER BY `id`';
        $prepare = $pdo->prepare($sql);
        $prepare->setFetchMode( PDO::FETCH_CLASS, 'Page');
        $prepare->execute([$code]);
        $page = $prepare->fetch();
        return $page;
    }

    public static function loadById($pdo, $id) {
        $sql = 'SELECT * FROM Page WHERE `id` = ?';
        $prepare = $pdo->prepare($sql);
        $prepare->setFetchMode( PDO::FETCH_CLASS, 'page');
        $prepare->execute([$id]);
        $page = $prepare->fetch();
        return $page;
    }

    public static function loadAll($pdo) {
        $pages = array();
        $sql = 'SELECT * FROM Page ORDER BY `id`';
        $prepare = $pdo->prepare($sql);
        $prepare->setFetchMode( PDO::FETCH_CLASS, 'Page');
        $prepare->execute();
        while (  $page = $prepare->fetch() ){
            $pages[] = $page;
        }
        return $pages;
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
        $sql = 'INSERT INTO Page (`code`, `title`, `content`, `template`) VALUES (?,?,?,?)';
        $prepare = $pdo->prepare($sql);
        try {
            $res = $prepare->execute([$this->code, $this->title, $this->content, $this->template]);
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
        $sql = 'UPDATE `Page` SET `code`=?, `title`=?, `content`=?, `template`=? WHERE id = ?';
        $prepare = $pdo->prepare($sql);
        try {
            $res = $prepare->execute([$this->code, $this->title, $this->content, $this->template, $this->id]);
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

    public static function createTable($pdo)
    {
        $sql = "CREATE TABLE IF NOT EXISTS `Page` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `code` varchar(150) NOT NULL,
            `title` varchar(255) DEFAULT NULL,
            `content` text,
            `template` varchar(255) DEFAULT 'default',
            PRIMARY KEY (`id`),
            UNIQUE KEY `code` (`code`)
          );";
        $pdo->query($sql);
    }
}
