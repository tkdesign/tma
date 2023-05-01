<?php

namespace App;

/**
 * Class Model
 * Abstraktná trieda modelu
 * @package App
 */
abstract class Model
{
    protected $db;
    protected $config;

    /**
     * Konštruktor triedy Model
     * Metóda, ktorá sa volá pri vytváraní inštancie triedy a slúži na inicializáciu jej vlastností.
     * @param $data
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Definovanie metódy triedy modelu na pripojenie k databáze.
     * @return bool Stav pripojenia
     */
    abstract public function connect();

}