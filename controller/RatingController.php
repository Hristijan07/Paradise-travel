<?php

require_once("ViewHelper.php");
require_once("model/RatingDB.php");

class RatingController {
    public static function rateTrip(){
        if (isset($_POST["city_id"]) && !empty($_POST["city_id"]) &&
            isset($_POST["rating"]) && !empty($_POST["rating"])) {

            RatingDB::addRating($_SESSION["user"]["user_id"], $_POST["city_id"], substr($_POST["rating"], -1));

            $rating = RatingDB::getCityRating($_POST["city_id"]);

            header('Content-type: application/json; charset=utf-8');
            echo json_encode($rating);
        }
    }
}