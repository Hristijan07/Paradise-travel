<?php

require_once("ViewHelper.php");
require_once("model/BookDB.php");

class BookController { 

    public static function book(){
        if (isset($_SESSION['user'])){
            if (isset($_POST["user_id"]) && !empty($_POST["user_id"]) &&
                isset($_POST["trip_id"]) && !empty($_POST["trip_id"])) {

                $bool = BookDB::bookTrip($_POST["user_id"], $_POST["trip_id"]);
                if($bool){
                    ViewHelper::redirect(BASE_URL . "home");
                } 
            }
        } else {
            ViewHelper::redirect(BASE_URL . "login");
        }
    }

    public static function removeBooking(){
        if (isset($_POST["booking"]) && !empty($_POST["booking"])){
            BookDB::removeBooking($_POST["booking"]);
            ViewHelper::redirect(BASE_URL . "my/trips");
        } else {
            ViewHelper::redirect(BASE_URL . "my/trips");
        }
    }
}