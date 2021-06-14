<?php

require_once("ViewHelper.php");
require_once("model/ReviewDB.php");
require_once("model/UserDB.php");

class ReviewController { 

    public static function reviews($data, $hits){
        foreach($hits as $hit){
            $item = [];
            $item["review"] = $hit["review"];
            $item["review_id"] = $hit["review_id"];
            $item["user"] = 0;
            $item["logged"] = 0;
            if (isset($_SESSION['user'])){ 
                $item["logged"] = 1;
                if($_SESSION["user"]["user_id"] == $hit["user_id"]){
                    $item["user"] = 1;
                }
            }
            $user = UserDB::getUserById($hit["user_id"]);
            $item["username"] = $user["user_name"];

            array_push($data, $item);
        }

        return $data;
    }

    public static function getReviews(){
        if(isset($_GET["city_id"]) && !empty($_GET["city_id"])){
            $hits = ReviewDB::get_reviews($_GET["city_id"]);
            $data = [];
         
            $data = self::reviews($data, $hits);
            if(empty($data) && isset($_SESSION['user'])){
                $data["0"] = ["logged" => 1, "only_add" => 1];
            }
               
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($data);
        }
    }

    public static function addReview(){
        if (isset($_POST["city_id"]) && !empty($_POST["city_id"]) &&
            isset($_POST["review"]) && !empty($_POST["review"])) {
                if(strlen($_POST["review"]) > 300){
                    echo 2;
                    return ;
                }
                
                ReviewDB::add_review($_SESSION["user"]["user_id"], $_POST["city_id"], htmlspecialchars($_POST["review"]));
                
                $hits = ReviewDB::get_reviews($_POST["city_id"]);
                $data = [];
             
                $data = self::reviews($data, $hits);
                   
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($data);
        } else {
            echo 1;
        }
    }

    public static function editReview(){
        if (isset($_POST["city_id"]) && !empty($_POST["city_id"]) &&
         isset($_POST["review_id"]) && !empty($_POST["review_id"]) &&
         isset($_POST["review"]) && !empty($_POST["review"])) {
            if(strlen($_POST["review"]) > 300){
                echo 2;
                return ;
            }

            ReviewDB::edit_review(htmlspecialchars($_POST["review"]), $_POST["review_id"]);
            
            $hits = ReviewDB::get_reviews($_POST["city_id"]);
            $data = [];
            
            $data = self::reviews($data, $hits);
                
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($data);
        } else {
            echo 1;
        }
    }

    public static function deleteReview(){
        if (isset($_POST["city_id"]) && !empty($_POST["city_id"]) &&
         isset($_POST["review_id"]) && !empty($_POST["review_id"])) {
            ReviewDB::delete_review($_POST["review_id"]);
            
            $hits = ReviewDB::get_reviews($_POST["city_id"]);
            $data = [];
            
            $data = self::reviews($data, $hits);
                
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($data);
        }
    }

}