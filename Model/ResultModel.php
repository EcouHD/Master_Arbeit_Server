<?php

require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class ResultModel extends Database

{

    public function getAllResults($limit)

    {

        return $this->select("SELECT * FROM results LIMIT ?", ["i", $limit]);
    }

    public function saveResult($survey_id, $user_id, $question_id, $answer)

    {

        return $this->insertInto(
            "INSERT INTO results (survey_id, user_id, question_id, answer) VALUES (?,?,?,?)",
            ["iiid", $survey_id, $user_id, $question_id, $answer]
        );
    }

    public function getResults($survey_id, $user_id, $question_id)

    {

        return $this->select(
            "SELECT * FROM results WHERE (survey_id = ? AND user_id = ? AND question_id = ?)",
            ["iii", $survey_id, $user_id, $question_id]
        );
    }

    public function getAnswer($survey_id, $user_id, $question_id)

    {

        return $this->select(
            "SELECT answer FROM results WHERE (survey_id = ? AND user_id = ? AND question_id = ?)",
            ["iii", $survey_id, $user_id, $question_id]
        );
    }

    public function updateAnswer($results_id, $answer)

    {

        return $this->update("UPDATE results SET answer = ? WHERE results_id = ?", ["di", $answer, $results_id]);
    }
}
