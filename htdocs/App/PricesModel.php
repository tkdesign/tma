<?php


namespace App;


class PricesModel extends Model
{

    /**
     * MainModel constructor.
     * Metóda, ktorá sa volá pri vytváraní inštancie triedy a slúži na inicializáciu jej vlastností.
     * @param array $config Nastavenia pripojenia k databáze
     */
    public function __construct($config)
    {
        parent::__construct($config);
        if (!$this->connect()) {
            echo "Error: Can't connect to a database!";
            exit();
        }
    }

    /**
     * Implementácia metódy na pripojenie k databáze
     * @return bool Stav pripojenia
     */
    public function connect()
    {
        try {
            if (!isset($this->config['db_username']) || !isset($this->config['db_name'])) {
                throw new \Exception();
            }
            $this->db = new \PDO("mysql:host=" . (isset($this->config['db_host']) ? $this->config['db_host'] : "127.0.0.1") . ";dbname=" . $this->config['db_name'], $this->config['db_username'], $this->config['db_password']);
        } catch (\Exception $err) {
            return false;
        }
        return true;
    }

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