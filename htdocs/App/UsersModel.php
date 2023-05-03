<?php


namespace App;


class UsersModel extends Model
{

    public function get_user_by_username($username)
    {
        $result = null;
        try {
            $data = array(
                ':username' => $username
            );
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username=:username AND usertype=1 AND block=0 LIMIT 1");
            $stmt->execute($data);
            $result = $stmt->fetchAll();
        } catch (\Exception $err) {
        }
        return $result;
    }
}