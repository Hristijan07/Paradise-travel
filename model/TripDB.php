<?php

require_once("DBInit.php");

class TripDB {

    public static function getAll(){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT trip_id, city_id, name, description, price, date_to, date_from FROM trip");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getAllByName(){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT trip_id, city_id, name, description, price, date_to, date_from FROM trip ORDER BY name");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getTripById($id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM trip WHERE trip_id = :trip_id ;");
        $statement -> bindParam(":trip_id", $id);

        $statement->execute();
        return $statement->fetch();
    }

    public static function search($query){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT trip_id, city_id, name, description, price, date_to, date_from  
        FROM trip WHERE name REGEXP :query");
        $statement->bindValue(":query", $query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function price_higher($price){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT trip_id, city_id, name, description, price, date_to, date_from  
        FROM trip  WHERE price >= :price ORDER BY name");
        $statement->bindValue(":price", $price);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function createTrip($city_id, $name, $description, $price, $date_from, $date_to){
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO trip (city_id, name, description, price, date_from, date_to) VALUES (:city_id, :name, :description, :price, :date_from, :date_to)");
        $statement -> bindParam(":city_id", $city_id);
        $statement -> bindParam(":name", $name);
        $statement -> bindParam(":description", $description);
        $statement -> bindParam(":price", $price);
        $statement -> bindParam(":date_from", $date_from);
        $statement -> bindParam(":date_to", $date_to);

        $statement->execute();

        return $statement->fetch();
    }


}