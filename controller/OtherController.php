<?php

class OtherController{

    public static function getImage(){
        if (isset($_GET["image"]) && !empty($_GET["image"])){
            $src = ($_SERVER['DOCUMENT_ROOT'] . ASSETS_URL . "images" . $_GET["image"]);
            if(file_exists($src)){
                echo (ASSETS_URL . "images" . $_GET["image"]);
            } else {
                echo 2;
            }

        } else {
            echo 1;
        }
    }

    public static function checkColor($hex) {
        return preg_match('/^#?(([a-f0-9]{3}){1,2})$/i', $hex);
     }

    public static function getColor(){
        if (isset($_GET["color"]) && !empty($_GET["color"])){
            if(self::checkColor($_GET["color"])){
                echo $_GET["color"];
            } else {
                echo 2;
            }
        } else {
            echo 1;
        }
    }
}