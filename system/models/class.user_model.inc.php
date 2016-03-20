<?php

class User_Model extends Model {
    public function __construct() {
        $this->mysql();
    }

    public function check_login($username, $password) {
        $sql = "SELECT * FROM presenters WHERE name=:username AND password=:password";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if ($row != null) {
            return array($row['id'], $row['name']);
        } else {
            return null;
        }
    }

    public function reg($username, $email, $password) {
        $sql = "INSERT INTO presenters VALUES(NULL,:username,:email,:password) ";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        $rowCount = $stmt->rowCount();
        $stmt->closeCursor();
        if ($rowCount > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function user_auth($data) {
        $sql = "SELECT * FROM presenters WHERE " . $data[0] . "=:data";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':data', $data[1], PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if ($row == null) {
            return "true";
        } else {
            return "false";
        }
    }
}
