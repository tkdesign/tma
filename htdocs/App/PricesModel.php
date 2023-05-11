<?php


namespace App;

use Exception;
use PDO;

/**
 * Class PricesModel
 * Trieda na prácu s tabuľkami prices_$lang a prices_groups_$lang
 * @package App
 */
class PricesModel extends Model
{

    /**
     * Metóda na načítanie zoznamu tarifných skupín z databázy
     * @param string $lang Prípona tabuľky
     * @return array|null Vracia zoznam skupin
     */
    public function readPriceGroups($lang = "sk")
    {
        $result = null;
        try {
            $result = $this->db->query("SELECT * FROM price_groups_$lang WHERE published=1 ORDER BY ordering;")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $err) {
        }
        return $result;
    }

    /**
     * Metóda na načítanie cenníkov z databázy podľa identifikátora tarifnej skupiny
     * @param int $group_id Identifikátor tarifnej skupiny
     * @param string $lang Prípona tabuľky
     * @return array|null Vracia zoznam cenníkov
     */
    public function readPrices($group_id, $lang = "sk")
    {
        $result = null;
        try {
            $result = $this->db->query("SELECT * FROM prices_$lang WHERE price_group_id=$group_id AND published=1 ORDER BY ordering;")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $err) {
        }
        return $result;
    }

}