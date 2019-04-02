<?php

class Settings
{
    public static function load($pdo)
    {
        $query = $pdo->prepare('SELECT * FROM Setting');
        $query->execute();
        $settings = array();
        $settingsData = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($settingsData as $row) {
            $settings[$row['setting']] = $row['value'];
        }
        return $settings;
    }

    public static function save($pdo, $settings)
    {
         // TODO: cannot report several errors, they will be overwritten
         $result = 'success';
        foreach ($settings as $setting => $value) {
            if (self::settingExists($pdo, $setting)) {
                $res = self::update($pdo, $setting, $value);
            } else {
                $res =  self::insert($pdo, $setting, $value);
            }
            if ( $res != 'success' ) { $result = $res; }
        }
        return $result;
    }

    public static function settingExists($pdo, $setting)
    {
        $sql = 'SELECT * FROM Setting WHERE setting = ?';
        $query = $pdo->prepare($sql);
        $query->execute([$setting]);
        return $query->rowCount() > 0;
    }

    // $row is an array as follows 'setting'=>'value'
    // $row['setting']     $row['value']
    public static function insert($pdo, $setting, $value)
    {
        $result = 'success';
        $sql = 'INSERT INTO Setting (`setting`, `value`) VALUES (?, ?);';
        $query = $pdo->prepare($sql);
        try {
            $query->execute([$setting, $value]);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $result = 'duplicate';
            } else {
                $result =  'error';
            }
        }
        return $result;
    }

    public static function update($pdo, $setting, $value)
    {
        $result = 'success';
        $sql = 'UPDATE Setting SET `value`=? WHERE `setting`=?';
        $query = $pdo->prepare($sql);
        try {
            $query->execute([$value,$setting]);
            $result = 'success';
        } catch (PDOException $e) {
           $result = 'error';
        }   
        return $result;
    }

    public static function createTable($pdo)
    {
        $sql = 'CREATE TABLE IF NOT EXISTS Setting ( ' .
            'setting VARCHAR(100) PRIMARY KEY,' .
            'value VARCHAR(100) )';
        $pdo->query($sql);
    }
}