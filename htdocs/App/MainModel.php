<?php

namespace App;

use Exception;
use PDO;
use stdClass;

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
     * @return array|null Vracia zoznam projektov
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
            $result = $this->db->query("SELECT * FROM projects_$lang WHERE published=1 ORDER BY ordering" . (!empty($lim) ? " LIMIT $lim" : "") . ";")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $err) {
        }
        return $result;
    }

    /**
     * Metóda na získanie počtu riadkov v tabuľke projects_$lang
     * @param string $lang Prípona tabuľky
     * @return array|null Vracia počet riadkov v tabuľke
     */
    public function get_count_rows_in_projects($lang = "sk")
    {
        $total = null;
        try {
            $total = $this->db->query("SELECT COUNT(*) AS count_rows FROM projects_$lang WHERE published=1;")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $err) {
        }
        return $total;
    }

    /**
     * Metóda pridávania nových kontaktných informácií návštevníkov webovej stránky do databázy
     * @param stdClass $fields Polia formulára
     * @return bool Vracia stav vloženia reťazca do databázy
     */
    public function toCRM($fields)
    {
        $data = array(
            ':name' => $fields->name,
            ':email' => $fields->email,
            ':request' => $fields->request
        );
        $stmt = $this->db->prepare('INSERT INTO crm SET name=:name, email=:email, request=:request, created_at=NOW()');
        return $stmt->execute($data);
    }

    /**
     * Metóda načítania zoznamu požiadaviek z databázy
     * @param int $offset Odsadenie od začiatku
     * @param int $limit Limit položiek v dotaze
     * @return array|null Vracia zoznam požiadaviek
     */
    public function get_crm($offset = -1, $limit = -1)
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
            $result = $this->db->query("SELECT * FROM crm ORDER BY id" . (!empty($lim) ? " LIMIT $lim" : "") . ";")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $err) {
        }
        return $result;
    }

    /**
     * Metóda na získanie počtu riadkov v tabuľke crm
     * @return array|null Vracia počet riadkov v tabuľke
     */
    public function get_count_rows_in_crm()
    {
        $total = null;
        try {
            $total = $this->db->query("SELECT COUNT(*) AS count_rows FROM crm;")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $err) {
        }
        return $total;
    }

    /**
     * Metóda na vymazanie riadku v databáze
     * @param int $id Identifikátor riadku v databáze
     * @return bool Vracia stav vymazania riadku v databáze
     */
    public function delete_from_crm($id)
    {
        $data = array(
            ':id' => $id
        );
        $stmt = $this->db->prepare('DELETE FROM crm WHERE id=:id');
        return $stmt->execute($data);
    }

    /**
     * Metóda na vloženie dátumu odpovede do riadku v databáze
     * @param int $id Identifikátor riadku v databáze
     * @return bool Vracia stav aktualizácie riadku v databáze
     */
    public function reply_crm_request($id)
    {
        $data = array(
            ':id' => $id
        );
        $stmt = $this->db->prepare('UPDATE crm SET replied_at=NOW() WHERE id=:id');
        return $stmt->execute($data);
    }
}