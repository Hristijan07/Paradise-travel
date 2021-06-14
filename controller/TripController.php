<?php

require_once("ViewHelper.php");
require_once("model/TripDB.php");
require_once("model/CityDB.php");
require_once("model/BookDB.php");
require_once("model/RatingDB.php");

class TripController {

    public static function getCards($output, $input){
        foreach ($input as $trip){
            $item = [];
            $city = CityDB::getCityById($trip["city_id"]);
            if(RatingDB::checkCityIsRated($city["city_id"])){
                $rating = RatingDB::getCityRating($trip["city_id"]);
            } else {
                $rating = "No rating.";
            }
            
            $item["id"] = $trip["trip_id"];
            $item["img"] = $city["img1"];
            $item["name"] = $trip["name"];
            $item["price"] = $trip["price"];
            $item["rating"] = $rating;
            array_push($output, $item);
        }
        return $output;
    }

    public static function index() {
        $cards = [];

        $trips = TripDB::getAllByName();
        $cards = self::getCards($cards, $trips);
        
        $vars = [
            "cards" => $cards
        ];

        ViewHelper::render("view/trips.php", $vars);
    }

    public static function trip_info(){
        if(isset($_GET["id"]) && !empty($_GET["id"])){
            $id = $_GET["id"];
        }

        $trip = TripDB::getTripById($id);
        $city = CityDB::getCityById($trip["city_id"]);
        if(RatingDB::checkCityIsRated($city["city_id"])){
            $rating = RatingDB::getCityRating($trip["city_id"]);
        } else {
            $rating = "No rating.";
        }

        $arr = ["images" => [$city["img1"], $city["img2"], $city["img3"], $city["img4"]],
              "name" => $trip["name"],
              "description" => $trip["description"],
              "rating" => "Rating: ". $rating,
              "date_from" => $trip["date_from"],
              "date_to" => $trip["date_to"],
              "price" => $trip["price"],
              "lon" => $city["lon"],
              "lat" => $city["lat"],
              "c_palette" => [$city["color1"], $city["color2"], $city["color3"], $city["color4"]],
              "city_id" => $trip["city_id"],
              "trip_id" => $id,
              "booked" => 0,
        ];

        if (isset($_SESSION['user'])){
            if(!BookDB::checkBooking($_SESSION["user"]["user_id"],$id)){
                $arr["booked"] = 1;
            }
            if(!RatingDB::checkIfRated($_SESSION["user"]["user_id"], $trip["city_id"])){
                $arr["rated"] = 1;
            }
        }

        $vars = [
            "city" => $arr
        ];

        ViewHelper::render("view/city.php", $vars);
    }

    public static function trip_map(){
        if (isset($_SESSION['user'])){
            if (isset($_GET["city_id"]) && !empty($_GET["city_id"]) &&
                isset($_GET["trip_id"]) && !empty($_GET["trip_id"])) {
                $city = CityDB::getCityById($_GET["city_id"]);
                $trip = TripDB::getTripById($_GET["trip_id"]);

                $vars = [
                    "city" => $city["city_name"],
                    "lon" => $city["lon"],
                    "lat" => $city['lat'],
                    "image" => $city["img1"],
                    "trip" => $_GET["trip_id"],
                    "price" => $trip["price"],
                    "booked" => 0
                ];
                
                if(!BookDB::checkBooking($_SESSION["user"]["user_id"],$_GET["trip_id"])){
                    $vars["booked"] = 1;
                }

                
                ViewHelper::render("view/map.php", $vars);
            }
        } else {
            ViewHelper::redirect(BASE_URL . "login");
        }
    }

    public static function get_my_trips($hits, $output){
        foreach($hits as $hit){
            $item = [];
            $trip = TripDB::getTripById($hit["trip_id"]);
            $city = CityDB::getCityById($trip["city_id"]);

            $item["trip_id"] = $hit["trip_id"];
            $item["city_id"] = $trip["city_id"];
            $item["image"] = $city["img1"];
            $item["name"] = $trip["name"];
            $item["date_from"] = $trip["date_from"];
            $item["date_to"] = $trip["date_to"];
            $item["price"] = $trip["price"];
            $item["booking"] = $hit["booking_id"];

            array_push($output, $item);
        }
        return $output;
    }

    public static function my_trips(){
        $myTrips = [];
        $hits = BookDB::allUserBookings($_SESSION["user"]["user_id"]);
        
        $myTrips = self::get_my_trips($hits, $myTrips);

        $vars = [
            "trips" => $myTrips
        ];

        ViewHelper::render("view/my_trips.php", $vars);
    }

    public static function add_index($data = [], $errors = []) {
        // If $data is an empty array, let's set some default values
        if (empty($data)) {
            $data = [
                "city_name" => "",
                "img1" => "",
                "img2" => "",
                "img3" => "",
                "img4" => "",
                "lon" => "",
                "lat" => "",
                "clr1" => "",
                "clr2" => "",
                "clr3" => "",
                "clr4" => "",
                "trip_name" => "",
                "price" => "",
                "date_from" => "",
                "date_to" => "",
                "description" => ""
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
        ViewHelper::render("view/add_trip.php", $vars);
    }


    public static function add_trip(){
        $rules = [
            "city_name" => [
                // Only letters, dots, spaces and dashes are allowed
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[ a-zA-ZšđčćžŠĐČĆŽ]+$/"]
            ],
            // we convert HTML special characters
            "img1" => FILTER_SANITIZE_SPECIAL_CHARS,
            "img2" => FILTER_SANITIZE_SPECIAL_CHARS,
            "img3" => FILTER_SANITIZE_SPECIAL_CHARS,
            "img4" => FILTER_SANITIZE_SPECIAL_CHARS,
            "lon" => [
                // Only letters, dots, spaces and dashes are allowed
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[0-9\.\-]+$/"]
            ],
            "lat" => [
                // Only letters, dots, spaces and dashes are allowed
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[0-9\.\-]+$/"]
            ],
            "clr1" => [
                // Only letters, dots, spaces and dashes are allowed
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => '/^#?(([a-f0-9]{3}){1,2})$/i']
            ],
            "clr2" => [
                // Only letters, dots, spaces and dashes are allowed
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => '/^#?(([a-f0-9]{3}){1,2})$/i']
            ],
            "clr3" => [
                // Only letters, dots, spaces and dashes are allowed
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => '/^#?(([a-f0-9]{3}){1,2})$/i']
            ],
            "clr4" => [
                // Only letters, dots, spaces and dashes are allowed
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => '/^#?(([a-f0-9]{3}){1,2})$/i']
            ],
            "trip_name" => [
                // Only letters, dots, spaces and dashes are allowed
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[ a-zA-ZšđčćžŠĐČĆŽ]+$/"]
            ],
            "price" => [
                // We provide a custom function that verifies the data. 
                // If the data is not OK, we return false, otherwise we return the data
                "filter" => FILTER_CALLBACK,
                "options" => function ($value) { return (is_numeric($value) && $value >= 0) ? floatval($value) : false; }
            ],
            "date_from" => [
                // Only letters, dots, spaces and dashes are allowed
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[0-9\.]+$/"]
            ],
            "date_to" => [
                // Only letters, dots, spaces and dashes are allowed
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[0-9\.]+$/"]
            ],
            "description" => FILTER_SANITIZE_SPECIAL_CHARS
        ];
        // Apply filter to all POST variables; from here onwards we never
        // access $_POST directly, but use the $data array
        $data = filter_input_array(INPUT_POST, $rules);

        $errors["city_name"] = empty($data["city_name"]) ? "Only letters allowed." : "";
        $errors["img1"] = empty($data["img1"]) ? "Please enter an image." : "";
        $errors["img2"] = empty($data["img2"]) ? "Please enter an image." : "";
        $errors["img3"] = empty($data["img3"]) ? "Please enter an image." : "";
        $errors["img4"] = empty($data["img4"]) ? "Please enter an image." : "";
        $errors["lon"] = empty($data["lon"]) ? "Write the right coordinates." : "";
        $errors["lat"] = empty($data["lat"]) ? "Write the right coordinates." : "";
        $errors["clr1"] = empty($data["clr1"]) ? "Please enter a hexed color value." : "";
        $errors["clr2"] = empty($data["clr2"]) ? "Please enter a hexed color value." : "";
        $errors["clr3"] = empty($data["clr3"]) ? "Please enter a hexed color value." : "";
        $errors["clr4"] = empty($data["clr4"]) ? "Please enter a hexed color value." : "";
        $errors["trip_name"] = empty($data["trip_name"]) ? "Only letters allowed." : "";
        $errors["price"] = empty($data["price"]) ? "Please enter a price." : "";
        $errors["date_from"] = empty($data["date_from"]) ? "Write appropriate date." : "";
        $errors["date_to"] = empty($data["date_to"]) ? "Write appropriate date." : "";
        $errors["description"] = empty($data["description"]) ? "Write a description." : "";

        if(empty($errors["img1"]) && !file_exists($_SERVER['DOCUMENT_ROOT'] . ASSETS_URL . "images" . $data["img1"])){
            $errors["img1"] = "Image does not exist";}
        if(empty($errors["img2"]) && !file_exists($_SERVER['DOCUMENT_ROOT'] . ASSETS_URL . "images" . $data["img2"])){
            $errors["img2"] = "Image does not exist";}
        if(empty($errors["img3"]) && !file_exists($_SERVER['DOCUMENT_ROOT'] . ASSETS_URL . "images" . $data["img3"])){
            $errors["img3"] = "Image does not exist";}
        if(empty($errors["img4"]) && !file_exists($_SERVER['DOCUMENT_ROOT'] . ASSETS_URL . "images" . $data["img4"])){
            $errors["img4"] = "Image does not exist";}

        if (empty($errors["city_name"]) && strlen($data["city_name"]) > 50){$errors["city_name"] = "Only 50 letters are allowed";}
        if (empty($errors["img1"]) && strlen($data["img1"]) > 50){$errors["img1"] = "Only 50 letters are allowed";}
        if (empty($errors["img2"]) && strlen($data["img2"]) > 50){$errors["img2"] = "Only 50 letters are allowed";}
        if (empty($errors["img3"]) && strlen($data["img3"]) > 50){$errors["img3"] = "Only 50 letters are allowed";}
        if (empty($errors["img4"]) && strlen($data["img4"]) > 50){$errors["img4"] = "Only 50 letters are allowed";}
        if (empty($errors["clr1"]) && strlen($data["clr1"]) > 50){$errors["clr1"] = "Only 50 letters are allowed";}
        if (empty($errors["clr2"]) && strlen($data["clr2"]) > 50){$errors["clr2"] = "Only 50 letters are allowed";}
        if (empty($errors["clr3"]) && strlen($data["clr3"]) > 50){$errors["clr3"] = "Only 50 letters are allowed";}
        if (empty($errors["clr4"]) && strlen($data["clr4"]) > 50){$errors["clr4"] = "Only 50 letters are allowed";}
        if (empty($errors["trip_name"]) && strlen($data["trip_name"]) > 255){$errors["trip_name"] = "Only 255 letters are allowed";}
        if (empty($errors["date_from"]) && strlen($data["date_from"]) > 20){$errors["date_from"] = "Only 20 letters are allowed";}
        if (empty($errors["date_to"]) && strlen($data["date_to"]) > 20){$errors["date_to"] = "Only 20 letters are allowed";}
        if (empty($errors["description"]) && strlen($data["description"]) > 1000){$errors["description"] = "Only 1000 letters are allowed";}
       
        // Is there an error?
        $isDataValid = true;
        foreach ($errors as $key => $error) {
            $isDataValid = $isDataValid && empty($error);
            if(!empty($error)){
                $data[$key] = "";
            }
        }

        if ($isDataValid) {
            CityDB::createCity($data["city_name"], $data["img1"], $data["img2"], $data["img3"], $data["img4"], $data["lon"],$data["lat"], $data["clr1"], $data["clr2"], $data["clr3"] ,$data["clr4"]);
            $city = CityDB::getCityByName($data["city_name"]);
            TripDB::createTrip($city["city_id"], $data["trip_name"], $data["description"], $data["price"], $data["date_from"], $data["date_to"]);
            ViewHelper::redirect(BASE_URL . "home");
        } else {
            self::add_index($data, $errors);
        }
    }


    //Ajax responses
    public static function searchTripApi(){
            if (isset($_GET["query"]) && !empty($_GET["query"])) {
                $trips = TripDB::search($_GET["query"]);
                $hits = [];
                $hits = self::getCards($hits, $trips);       
            } else {
                $hits = [];
                $trips = TripDB::getAllByName();
                $hits = self::getCards($hits, $trips);  
            }
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($hits);
    }

    public static function sortByLetterTripApi(){
        $trips = TripDB::getAllByName();
        $hits = [];
        $hits = self::getCards($hits, $trips); 

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }

    public static function priceTripApi(){
        if (isset($_GET["query"]) && !empty($_GET["query"])) {
            $trips = TripDB::price_higher($_GET["query"]);
            $hits = [];
            $hits = self::getCards($hits, $trips);       
        } else {
            $hits = [];
            $trips = TripDB::getAllByName();
            $hits = self::getCards($hits, $trips);  
        }
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }

    public static function sort_ratings($a, $b) {
        return $a['rating'] - $b['rating'];
    }
    

    public static function sortByRating(){
        $trips = TripDB::getAllByName();
        $hits = [];
        $hits = self::getCards($hits, $trips); 

        $sortArray = array();

        foreach($hits as $hit){
            foreach($hit as $key=>$value){
                if(!isset($sortArray[$key])){
                    $sortArray[$key] = array();
                }
                $sortArray[$key][] = $value;
            }
        } 

        array_multisort($sortArray["rating"],SORT_DESC,$hits);

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }

    public static function searchMyTripsApi(){
        if (isset($_GET["query"]) && !empty($_GET["query"])) {
            $myTrips = [];
            $hits = BookDB::searchUserBookings($_SESSION["user"]["user_id"], $_GET["query"]);
        
            $myTrips = self::get_my_trips($hits, $myTrips); 
        } else {
            $myTrips = [];
            $hits = BookDB::allUserBookings($_SESSION["user"]["user_id"]);
        
            $myTrips = self::get_my_trips($hits, $myTrips); 
        }
        
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($myTrips);
    }
}