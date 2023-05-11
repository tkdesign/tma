<?php


namespace App;

use Exception;

/**
 * Class UsersModel
 * Trieda na prácu s tabuľkou `users`
 * @package App
 */
class UsersModel extends Model
{

    /**
     * Metóda na získanie informácií o používateľovi z databázy podľa jeho používateľského mena
     * @param string $username Meno používateľa v databáze
     * @return array|null Vracia informácie o používateľovi z databázy
     */
    public function readUser($username)
    {
        $result = null;
        try {
            $data = array(
                ':username' => $username
            );
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username=:username AND usertype=1 AND block=0 LIMIT 1");
            $stmt->execute($data);
            $result = $stmt->fetchAll();
        } catch (Exception $err) {
        }
        return $result;
    }
}