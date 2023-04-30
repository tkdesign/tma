<?php

namespace App;

/**
 * Базовый класс модели
 */
abstract class Model
{
    protected $db;
    protected $config;

    /**
     * Конструктор класса Model\
     * @param $data
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    abstract public function connect();

}