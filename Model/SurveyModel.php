<?php

require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class SurveyModel extends Database

{

    public function getSurveyNames($limit)

    {

        return $this->select("SELECT name FROM surveys LIMIT ?", ["i", $limit]);

    }

    public function getSurvey($name)
    {

	return $this->select("SELECT * FROM surveys WHERE name = ?", ["s", $name]); 

    }
}

