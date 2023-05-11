<?php

namespace App;

use Exception;
use PDO;

/**
 * Class Model
 * Abstraktná trieda modelu
 * @package App
 */
abstract class Model
{
    protected PDO $db;
    protected array $config;

    /**
     * Konštruktor triedy Model
     * Metóda, ktorá sa volá pri vytváraní inštancie triedy a slúži na inicializáciu jej vlastností.
     * @param array $config
     */
    public function __construct($config)
    {
        $this->config = $config;
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
                throw new Exception();
            }
            $this->db = new PDO("mysql:host=" . (isset($this->config['db_host']) ? $this->config['db_host'] : "127.0.0.1") . ";dbname=" . $this->config['db_name'], $this->config['db_username'], $this->config['db_password']);
        } catch (Exception $err) {
            return false;
        }
        return true;
    }

}