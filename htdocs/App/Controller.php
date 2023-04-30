<?php

namespace App;

/**
 * Базовый класс модели
 */
abstract class Controller
{

    /**
     * Конструктор класса Controller\
     */
    public function __construct()
    {
    }

    abstract public function run($function, $args);

}