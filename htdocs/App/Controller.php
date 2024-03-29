<?php

namespace App;


use Exception;
use stdClass;

/**
 * Class Controller
 * Abstraktná trieda kontroléra.
 * @package App
 */
abstract class Controller
{
    protected stdClass $args;

    /**
     * Controller constructor.
     * Metóda, ktorá sa volá pri vytváraní inštancie triedy a slúži na inicializáciu jej vlastností.
     * @param string $args reťazec parametrov z url
     */
    public function __construct($args)
    {
        if (!empty($args)) {
            try {
                $this->args = json_decode(json_encode($args));
            } catch (Exception $e) {
                $this->args = new stdClass();
            }
        } else {
            $this->args = new stdClass();
        }
    }

    /**
     * Metóda mapovania pravidiel routovania na konkrétne akcie v kontroléri.
     * @param string $function Názov metódy, ktorá sa má zavolať
     */
    abstract public function run($function);

}