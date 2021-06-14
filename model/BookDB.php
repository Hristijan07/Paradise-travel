<?php

require_once("DBInit.php");

class BookDB {

    public static function checkBooking($user_id, $trip_id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT COUNT(user_id) FROM booking WHERE user_id = :user_id AND trip_id = :trip_id;");
        $statement -> bindParam(":user_id", $user_id);
        $statement -> bindParam(":trip_id", $trip_id);

        $statement->execute();

        return $statement->fetchColumn(0) == 0;
    }

    public static function bookTrip($user_id, $trip_id){
        echo"we are here";
        if (self::checkBooking($user_id, $trip_id)){
            $db = DBInit::getInstance();

            $statement = $db->prepare('INSERT INTO booking (trip_id, user_id, booking) VALUES
                                       (:trip_id, :user_id, "Some booking info");');
            $statement -> bindParam(":user_id", $user_id);
            $statement -> bindParam(":trip_id", $trip_id);
    
            echo "execution";
            $statement->execute();
            return true;
        } else {
            return false;
        }
    }

    public static function allUserBookings($user_id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM booking WHERE user_id = :user_id");
        $statement -> bindParam(":user_id", $user_id);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function removeBooking($booking_id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM booking WHERE booking_id = :booking_id");
        $statement -> bindParam(":booking_id", $booking_id);
        $statement->execute();
    }

    public static function searchUserBookings($user_id, $query){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM trip, booking WHERE name REGEXP :query AND user_id=:user_id AND trip.trip_id = booking.trip_id;");
        $statement -> bindParam(":user_id", $user_id);
        $statement -> bindParam(":query", $query);
        $statement->execute();

        return $statement->fetchAll();
    }
    
}