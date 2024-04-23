<?php

require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class UserModel extends Database 

{

    public function getUser($user_id)
    
    {

        return $this->select("SELECT * FROM users WHERE user_id = ?", ["i", $user_id]);
    
    }

}