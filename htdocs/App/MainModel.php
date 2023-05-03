<?php

namespace App;

/**
 * Class MainModel
 * Trieda modelu reprezentuje dáta a logiku aplikácie.
 * @package App
 */
class MainModel extends Model
{

    /**
     * Metóda načítania zoznamu projektov z databázy
     * @param int $offset Odsadenie od začiatku
     * @param int $limit Limit položiek v dotaze
     * @param string $lang Prípona tabuľky
     * @return |null Zoznam projektov
     */
    public function get_projects($offset = -1, $limit = -1, $lang = "sk")
    {
        $lim = "";
        $offset = intval($offset);
        $limit = intval($limit);
        if ($offset > -1 && $limit > 0) {
            $lim = "$offset,$limit";
        } else if ($offset === -1 && $limit > 0) {
            $lim = "$limit";
        }
        $result = null;
        try {
            $result = $this->db->query("SELECT * FROM projects_$lang WHERE published=1 ORDER BY ordering" . (!empty($lim) ? " LIMIT $lim" : "") . ";")->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $err) {
        }
        return $result;
    }

    /**
     * Metóda na získanie počtu riadkov v tabuľke
     * @param string $lang Prípona tabuľky
     * @return |null Počet riadkov v tabuľke
     */
    public function get_count_rows_in_projects($lang = "sk")
    {
        $total = null;
        try {
            $total = $this->db->query("SELECT COUNT(*) AS count_rows FROM projects_$lang WHERE published=1;")->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $err) {
        }
        return $total;
    }

    /**
     * Spôsob pridávania nových kontaktných informácií návštevníkov webovej lokality do databázy
     * @param $fields Polia formulára
     * @return bool Vracia stav nového riadku vloženého do databázy
     */
    public function toCRM($fields)
    {
        $data = array(
            ':name' => $fields->name,
            ':email' => $fields->email,
            ':request' => $fields->request
        );
        $stmt = $this->db->prepare('INSERT INTO crm SET name=:name, email=:email, request=:request, created_at=NOW()');
        $result = $stmt->execute($data);
        /*if (!$result) {
            $error = $stmt->errorInfo();
            echo "Chyba: " . $error[2];
        }*/
        return $result;
    }
}