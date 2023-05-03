<?php


namespace App;


class PricesModel extends Model
{

    public function get_price_groups($lang = "sk")
    {
        $result = null;
        try {
            $result = $this->db->query("SELECT * FROM price_groups_$lang WHERE published=1 ORDER BY ordering;")->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $err) {
        }
        return $result;
    }

    public function get_prices_by_group_id($group_id, $lang = "sk")
    {
        $result = null;
        try {
            $result = $this->db->query("SELECT * FROM prices_$lang WHERE price_group_id=$group_id AND published=1 ORDER BY ordering;")->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $err) {
        }
        return $result;
    }

}