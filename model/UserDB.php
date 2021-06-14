<?php 

require_once("DBInit.php");

class UserDB {

    public static function validateUsername($username){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT COUNT(user_id) FROM user WHERE user_name = :username;");
        $statement -> bindParam(":username", $username);

        $statement->execute();

        return $statement->fetchColumn(0) == 1;

    }

    public static function validatePassword($username, $password){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT password FROM user WHERE  user_name = :username;");
        $statement -> bindParam(":username", $username);

        $statement->execute();

        $result = $statement->fetch();
        $hash = $result["password"];
        
        if( password_verify($password, $hash)){
            return true;
        } else {
            return false;
        }
    }

    public static function getUser($username){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT user_id, user_name, name, surname, role FROM user WHERE user_name = :username;");
        $statement -> bindParam(":username", $username);

        $statement->execute();

        return $statement->fetch();
    }

    public static function getUserById($user_id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT user_id, user_name, name, surname, role FROM user WHERE user_id = :user_id;");
        $statement -> bindParam(":user_id", $user_id);

        $statement->execute();

        return $statement->fetch();
    }


    public static function insertUser($username, $password, $name, $last_name){
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("INSERT INTO `user` (user_name, password, name, surname, role) VALUES
                                   (:user_name, :password, :name, :last_name, 1)");
        $statement -> bindParam(":user_name", $username);
        $statement -> bindParam(":password", password_hash($password, PASSWORD_DEFAULT));
        $statement -> bindParam(":name", $name);
        $statement -> bindParam(":last_name", $last_name);

        $statement->execute();
    }
}