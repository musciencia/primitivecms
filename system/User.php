<?php

class User {
    private $userName = 'visitor';
    private $role = 'visitor';
    private $passwordHash = null;
    private $cookieHash = null;


    public static function create( $userName, $role, $password ) {
        $user = new User();
        $user->userName = $userName;
        $user->role = $role;
        $user->passwordHash = password_hash($password, PASSWORD_BCRYPT);
        return $user;
    }

    public static function load($pdo, $userName) {
        $sql = 'SELECT * FROM User WHERE `userName` = ?';
        $query = $pdo->prepare($sql);
        $query->setFetchMode(PDO::FETCH_CLASS, 'User');
        $query->execute([$userName]);
        $user = $query->fetch();
        return $user;
    }
    
    public function isPasswordValid($password) {
        return password_verify($password, $this->passwordHash);
    }

    public function isCookieCodeValid($cookieCode) {
        return password_verify($cookieCode, $this->cookieHash);
    }

    public function setPassword($password) {
        $this->passwordHash = password_hash($password, PASSWORD_BCRYPT);
    }

    public function setCookieCode( $cookieCode ) {
        $this->cookieHash = password_hash($cookieCode, PASSWORD_BCRYPT);
    }

    public function setRandomCookieCode() {
        $cookieCode = rand(0, getrandmax());
        $this->setCookieCode($cookieCode);
        return $cookieCode;
    }

    public function save($pdo) {
        if ( $this->userNameExists($pdo) ) {
            return $this->update($pdo);
        } else {
            return $this->insert($pdo);
        }
    }

    public function insert($pdo) {
        $sql = 'INSERT INTO `User` (`userName`,`role`,`passwordHash`,`cookieHash`) VALUES (?, ?, ?, ?)';
        $query = $pdo->prepare($sql);
        $result = $query->execute([$this->userName, $this->role, $this->passwordHash, $this->cookieHash]);
        return $result;
    }

    public function update($pdo) {
        $sql = 'UPDATE `User` SET `role`=?, `passwordHash`=?, `cookieHash`=? WHERE `userName`=?';
        $query = $pdo->prepare($sql);
        $result = $query->execute([$this->role, $this->passwordHash, $this->cookieHash, $this->userName] );
        return $result;
    }

    public function userNameExists($pdo) {
        $sql = 'SELECT `userName` FROM User WHERE userName = ?';
        $query = $pdo->prepare($sql);
        $query->execute([$this->userName]);
        return $query->rowCount() > 0;
    }

    public static function createTable($pdo) {
        $sql = 'CREATE TABLE IF NOT EXISTS User (' .
               '`userName` VARCHAR(150) PRIMARY KEY,' . 
               '`role` VARCHAR(40) NULL,' . 
               '`passwordHash` VARCHAR(60) NULL,' . 
               '`cookieHash` VARCHAR(60) NULL)';
        $pdo->query($sql);
    }

}