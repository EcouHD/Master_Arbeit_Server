<?php

require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class UserModel extends Database

{

    public function getUser($uuid)

    {

        return $this->select("SELECT * FROM users WHERE UUID = ?", ["s", $uuid]);
    }

    public function createUser($uuid)

    {

        return $this->insertInto(
            "INSERT INTO users (UUID) VALUES (?)",
            ["s", $uuid]
        );
    }

    public function setAllUserData($input)

    {

        return $this->update(
            "UPDATE users 
            SET radioButton1_x = ?, radioButton1_y = ?, radioButton1_width = ?, radioButton1_height = ?, 
                radioButton2_x = ?, radioButton2_y = ?, radioButton2_width = ?, radioButton2_height = ?,
                radioButton3_x = ?, radioButton3_y = ?, radioButton3_width = ?, radioButton3_height = ?,
                radioButton4_x = ?, radioButton4_y = ?, radioButton4_width = ?, radioButton4_height = ?,
                radioButton5_x = ?, radioButton5_y = ?, radioButton5_width = ?, radioButton5_height = ? 
            WHERE UUID = ?",
            [
                "iiiiiiiiiiiiiiiiiiiis", 
                $input['radioButton1_x'], $input['radioButton1_y'], $input['radioButton1_width'], $input['radioButton1_height'],
                $input['radioButton2_x'], $input['radioButton2_y'], $input['radioButton2_width'], $input['radioButton2_height'],
                $input['radioButton3_x'], $input['radioButton3_y'], $input['radioButton3_width'], $input['radioButton3_height'],
                $input['radioButton4_x'], $input['radioButton4_y'], $input['radioButton4_width'], $input['radioButton4_height'],
                $input['radioButton5_x'], $input['radioButton5_y'], $input['radioButton5_width'], $input['radioButton5_height'],
                $input['UUID']
            ]
        );
    }

    public function setUserAge($uuid, $age)

    {

        return $this->update("UPDATE users SET age = ? WHERE UUID = ?", ["is", $age, $uuid]);
    }
}
