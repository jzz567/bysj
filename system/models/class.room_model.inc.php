<?php

class Room_Model extends Model {
    public function create_room($presenter, $email, $name) {
        $sql = 'INSERT INTO rooms (name) VALUES (:name)';
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR, 255);
        $stmt->execute();
        $stmt->closeCursor();
        $room_id = self::$db->lastInsertId();
        $sql = "INSERT INTO presenters (name, email)
                VALUES (:name, :email)
                ON DUPLICATE KEY UPDATE name=:name";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':name', $presenter, PDO::PARAM_STR, 255);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR, 255);
        $stmt->execute();
        $stmt->closeCursor();
        $sql = "SELECT id
                FROM presenters
                WHERE email=:email";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR, 255);
        $stmt->execute();
        $pres_id = $stmt->fetch(PDO::FETCH_OBJ)->id;
        $stmt->closeCursor();
        $sql = 'INSERT INTO room_owners (room_id, presenter_id)
                VALUES (:room_id, :pres_id)';
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(":room_id", $room_id, PDO::PARAM_INT);
        $stmt->bindParam(":pres_id", $pres_id, PDO::PARAM_INT);
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
