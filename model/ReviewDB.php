<?php

require_once("DBInit.php");

class ReviewDB { 

    public static function get_reviews($city_id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM review WHERE city_id = :city_id");
        $statement -> bindParam(":city_id", $city_id);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function add_review($user_id, $city_id, $review){
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO review (user_id, city_id, review) VALUES
                                   (:user_id, :city_id, :review);");
        $statement -> bindParam(":user_id", $user_id);
        $statement -> bindParam(":city_id", $city_id);
        $statement -> bindParam(":review", $review);
        $statement->execute();
    }

    public static function edit_review($review, $review_id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE review SET review = :review WHERE review_id = :review_id");
        $statement -> bindParam(":review_id", $review_id);
        $statement -> bindParam(":review", $review);
        $statement->execute();
    }

    public static function delete_review($review_id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM review WHERE review_id = :review_id");
        $statement -> bindParam(":review_id", $review_id);
        $statement->execute();
    }

}