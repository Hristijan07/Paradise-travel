<?php

require_once("DBInit.php");

class RatingDB {

    public static function getCityRating($city_id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT COUNT(rating_id) FROM rating WHERE city_id = :city_id;");
        $statement -> bindParam(":city_id", $city_id);

        $statement->execute();

        $ratings_number = $statement->fetchColumn(0);
        
        $statement = $db->prepare("SELECT SUM(rating) FROM rating WHERE city_id = :city_id;");
        $statement -> bindParam(":city_id", $city_id);

        $statement->execute();

        $rating_sum = $statement->fetchColumn(0);
        
        $rating = round($rating_sum / $ratings_number,2);

        return $rating;
    }

    public static function checkIfRated($user_id, $city_id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT COUNT(rating_id) FROM rating WHERE user_id = :user_id AND city_id = :city_id;");
        $statement -> bindParam(":user_id", $user_id);
        $statement -> bindParam(":city_id", $city_id);

        $statement->execute();

        return $statement->fetchColumn(0) == 1;
    } 

    public static function checkCityIsRated($city_id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT COUNT(rating_id) FROM rating WHERE city_id = :city_id;");
        $statement -> bindParam(":city_id", $city_id);

        $statement->execute();

        return $statement->fetchColumn(0) > 0;
    } 

    public static function addRating($user_id, $city_id, $rating){
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO rating (user_id, city_id, rating) VALUES
        (:user_id, :city_id, :rating);");
        $statement -> bindParam(":user_id", $user_id);
        $statement -> bindParam(":city_id", $city_id);
        $statement -> bindParam(":rating", $rating);

        $statement->execute();
    }

}
