<?php

require_once("DBInit.php");

class CityDB {

    public static function getCityById($id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM city WHERE city_id = :city_id ;");
        $statement -> bindParam(":city_id", $id);

        $statement->execute();

        return $statement->fetch();
    }

    public static function createCity($city_name, $img1, $img2, $img3, $img4, $lon, $lat, $color1, $color2, $color3, $color4){
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO city (city_name, img1, img2, img3, img4, lon, lat, color1, color2, color3, color4) VALUES (:city_name, :img1, :img2, :img3, :img4, :lon, :lat, :color1, :color2, :color3, :color4)");
        $statement -> bindParam(":city_name", $city_name);
        $statement -> bindParam(":img1", $img1);
        $statement -> bindParam(":img2", $img2);
        $statement -> bindParam(":img3", $img3);
        $statement -> bindParam(":img4", $img4);
        $statement -> bindParam(":lon", $lon);
        $statement -> bindParam(":lat", $lat);
        $statement -> bindParam(":color1", $color1);
        $statement -> bindParam(":color2", $color2);
        $statement -> bindParam(":color3", $color3);
        $statement -> bindParam(":color4", $color4);

        $statement->execute();
    }

    public static function getCityByName($city_name){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM city WHERE city_name = :city_name ;");
        $statement -> bindParam(":city_name", $city_name);

        $statement->execute();

        return $statement->fetch();
    }
}