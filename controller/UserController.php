<?php

require_once("ViewHelper.php");
require_once("model/UserDB.php");

class UserController{

    public static function index(){
        ViewHelper::render("view/login.php");
    }

    public static function login(){
        if (UserDB::validateUsername($_POST["username"])) {
            $username = $_POST["username"];
        } else {
            $username = "";
            $username_error = "Invalid username.";
        }

        if (UserDB::validatePassword($_POST["username"] ,$_POST["password"])) {
            $password = $_POST["password"];
        } else {
            $password_error = "Invalid password.";
        }

        if (!(empty($password_error)) || !(empty($username_error))){    
            ViewHelper::render("view/login.php", [
                "errorPassword" => $password_error,
                "errorUsername" => $username_error,
                "username" => $username,
            ]);
        } else {
            $user = UserDB::getUser($username);
            $_SESSION["user"] = $user;
            ViewHelper::redirect(BASE_URL . "home");
        }
    }

    public static function logout(){
        if (isset($_SESSION["user"])){
            unset($_SESSION["user"]);
            ViewHelper::redirect(BASE_URL . "home");
        }
    }

    public static function sign_in_index($data = [], $errors = []) {
        // If $data is an empty array, let's set some default values
        if (empty($data)) {
            $data = [
                "username" => "",
                "password" => "",
                "password1" => "",
                "name" => "",
                "lastname" => "",
            ];
        }

        // If $errors array is empty, let's make it contain the same keys as
        // $data array, but with empty values
        if (empty($errors)) {
            foreach ($data as $key => $value) {
                $errors[$key] = "";
            }
        }

        $vars = ["data" => $data, "errors" => $errors];
        ViewHelper::render("view/signup.php", $vars);
    }


    public static function sign_in(){
        $rules = [
            "username" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[0-9a-zA-ZšđčćžŠĐČĆŽ\.\-_]+$/"]
            ],
            "password" =>[
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[0-9a-zA-ZšđčćžŠĐČĆŽ\.\-_]+$/"]
            ],
            "password1" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[0-9a-zA-ZšđčćžŠĐČĆŽ\.\-_]+$/"]
            ],
            "name" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[a-zA-ZšđčćžŠĐČĆŽ]+$/"]
            ],
            "lastname" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[a-zA-ZšđčćžŠĐČĆŽ]+$/"]
            ]
        ];
        // Apply filter to all POST variables; from here onwards we never
        // access $_POST directly, but use the $data arrays
        $data = filter_input_array(INPUT_POST, $rules);

        $errors["username"] = $data["username"] === false ? "Only letters, dots, dashes and numbers allowed." : "";
        $errors["password"] = $data["password"] === false ? "Only letters, dots, dashes and numbers allowed." : "";
        $errors["password1"] = $data["password"] === false ? "Only letters, dots, dashes and numbers allowed." : "";
        $errors["name"] = $data["name"] === false ? "Only letters are allowed." : "";
        $errors["lastname"] = $data["lastname"] === false ? "Only letters are allowed." : "";

        if (empty($errors["username"]) && strlen($data["username"]) > 30){$errors["username"] = "Only 30 letters are allowed";}
        if (empty($errors["password"]) && strlen($data["password"]) > 30){$errors["password"] = "Only 30 letters are allowed";}
        if (empty($errors["password1"]) && strlen($data["password1"]) > 30){$errors["password1"] = "Only 30 letters are allowed";}
        if (empty($errors["name"]) && strlen($data["name"]) > 50){$errors["name"] = "Only 50 letters are allowed";}
        if (empty($errors["lastname"]) && strlen($data["lastname"]) > 50){$errors["lastname"] = "Only 50 letters are allowed";}

        if (empty($errors["password"]) && strlen($data["password"]) < 6){$errors["password"] = "At least 6 characters.";}
        if (empty($errors["password1"]) && strlen($data["password1"]) < 6){$errors["password1"] = "At least 6 characters.";}

        if (empty($errors["password1"]) && $data["password"] != $data["password1"]){$errors["password1"] = "Passwords must match.";}
     
        // Is there an error?
        $isDataValid = true;
        foreach ($errors as $key => $error) {
            $isDataValid = $isDataValid && empty($error);
            if(!empty($error)){
                $data[$key] = "";
            }
        }

        if ($isDataValid) {
            UserDB::insertUser($data["username"], $data["password"], $data["name"] ,$data["lastname"]);
            $user = UserDB::getUser($data["username"]);
            $_SESSION["user"] = $user;
            ViewHelper::redirect(BASE_URL . "home");
        } else {
            self::sign_in_index($data, $errors);
        }
    }
}