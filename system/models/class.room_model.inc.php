<?php

class Room_Model extends Model {
    public function __construct() {
        $this->mysql();
    }

    public function create_room($name) {
        $presenter = $_SESSION['user_name'];
        $email = $_SESSION['email'];
        $sql = 'INSERT INTO rooms (name) VALUES (:name)';
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR, 255);
        $stmt->execute();
        $stmt->closeCursor();
        $room_id = self::$db->lastInsertId();
        $sql = 'INSERT INTO room_owners (room_id, presenter_id)
                VALUES (:room_id, :pres_id)';
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(":room_id", $room_id, PDO::PARAM_INT);
        $stmt->bindParam(":pres_id", $_SESSION["user_id"], PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        return array(
            'room_id' => $room_id,
        );
    }

    public function room_exists($room_id) {
        $sql = "SELECT COUNT(id) AS the_count FROM rooms WHERE id = :room_id";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->execute();
        $room_exists = (bool)$stmt->fetch(PDO::FETCH_OBJ)->the_count;
        $stmt->closeCursor();

        return $room_exists;
    }

    public function open_room($room_id) {
        $sql = "UPDATE rooms SET is_active=1 WHERE id = :room_id";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        return array(
            'room_id' => $room_id,
        );
    }

    public function close_room($room_id) {
        $sql = "UPDATE rooms SET is_active=0 WHERE id = :room_id";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        return array(
            'room_id' => $room_id,
        );
    }

    public function get_room_data($room_id) {
        $sql = "SELECT
                    rooms.id AS room_id,
                    presenters.id AS presenter_id,
                    rooms.name AS room_name,
                    presenters.name AS presenter_name,
                    email, is_active
                FROM rooms
                LEFT JOIN room_owners
                    ON( rooms.id = room_owners.room_id )
                LEFT JOIN presenters
                    ON( room_owners.presenter_id = presenters.id )
                WHERE rooms.id = :room_id
                LIMIT 1";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->execute();
        $room_data = $stmt->fetch(PDO::FETCH_OBJ);
        $stmt->closeCursor();

        return $room_data;
    }

}
