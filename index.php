<?php

session_start();

require_once("controller/TripController.php");
require_once("controller/UserController.php");
require_once("controller/BookController.php");
require_once("controller/RatingController.php");
require_once("controller/ReviewController.php");
require_once("controller/OtherController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("ASSETS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "assets/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [

    //home, trips and city urls
    "home" => function () {
        TripController::index();
    },
    "trip/info" => function () {
        TripController::trip_info();
    },
    "trip/map" => function () {
        TripController::trip_map();
    },
    "trip/book" => function () {
        BookController::book();
    },
    "trip/add" => function () {
        TripController::add_trip();
    },
    "my/trips" => function () {
        TripController::my_trips();
    },
    "remove/booking" => function () {
        BookController::removeBooking();
    },
    "add" => function () {
        TripController::add_index();
    },
    //login and user urls
    "login" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::login();
        } else {
            UserController::index();
        }
    },
    "logout" => function () {
        UserController::logout();
    },
    "sign-up" => function () {
        UserController::sign_in_index();
    },
    "sign-up/add" => function () {
        UserController::sign_in();
    },
    //api- ajax requests
    "api/trip/search" => function () {
    TripController::searchTripApi();
    },
    "api/trip/by-letter" => function () {
        TripController::sortByLetterTripApi();
    },
    "api/trip/price" => function () {
        TripController::priceTripApi();
    },
    "api/trip/by-rating" => function () {
        TripController::sortByRating();
    },
    "api/trip/rate" => function () {
        RatingController::rateTrip();
    },
    "api/my_trips/search" => function () {
        TripController::searchMyTripsApi();
    },
    "api/reviews" => function () {
        ReviewController::getReviews();
    },
    "api/reviews/add" => function () {
        ReviewController::addReview();
    },
    "api/reviews/edit" => function () {
        ReviewController::editReview();
    },
    "api/reviews/delete" => function () {
        ReviewController::deleteReview();
    },
    "api/image/add" => function () {
        OtherController::getImage();
    },
    "api/color/add" => function () {
        OtherController::getColor();
    },

    //extra
    "" => function () {
        ViewHelper::redirect(BASE_URL . "home");
       
    },
];

try {
    if (isset($urls[$path])) {
       $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    ViewHelper::error404();
} 
