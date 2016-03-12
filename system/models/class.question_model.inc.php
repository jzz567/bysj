<?php

class Question_Model extends Model {
    public function get_room_questions($room_id) {
        $sql = "SELECT
                id AS question_id,
                room_id,
                question,
                is_answered,
                vote_count
                FROM questions
                LEFT JOIN question_votes
                ON( questions.id = question_votes.question_id )
                WHERE room_id = :room_id
                ORDER BY is_answered, vote_count DESC";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->execute();
        $questions = $stmt->fetchAll(PDO::FETCH_OBJ);
        $stmt->closeCursor();

        return $questions;
    }

    public function create_question($room_id, $question) {
        $sql = "INSERT INTO questions (room_id, question)
                VALUES (:room_id, :question)";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':room_id', $room_id);
        $stmt->bindParam(':question', $question);
        $stmt->execute();
        $stmt->closeCursor();
        $question_id = self::$db->lastInsertId();
        $sql = "INSERT INTO question_votes
            VALUES (:question_id, 1)";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(":question_id", $question_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        return array(
            'room_id' => $room_id,
            'question_id' => $question_id,
        );
    }

    public function vote_question($room_id, $question_id) {
        $sql = "UPDATE question_votes
                SET vote_count = vote_count+1
                WHERE question_id = :question_id";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':question_id', $question_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        return array(
            'room_id' => $room_id,
            'question_id' => $question_id,
        );
    }

    public function answer_question($room_id, $question_id) {
        $sql = "UPDATE questions
                SET is_answered = 1
                WHERE id = :question_id";
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':question_id', $question_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        return array(
            'room_id' => $room_id,
            'question_id' => $question_id,
        );
    }

}
