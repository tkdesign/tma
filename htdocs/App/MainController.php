<?php

namespace App;

/**
 * Класс MainController - контроллер для обработки маршрутизации
 * @package App
 */
class MainController extends Controller
{

    /**
     * Маршрутизация запросов к серверу. Запуск метода контроллера, соответствующего маршруту
     * @param string $function Имя метода для вызова
     * @param array $args Массив аргументов $_REQUEST
     */
    public function run($function, $args)
    {
        $app = Base::getInstance();
        $this->$function($app, $args);
    }

    /**
     * Метод для отображения главной страницы сайта
     * @param Lib\Base $app Экземпляр базового класса
     * @param array $args Массив аргументов $_REQUEST
     */
    public function main($app, $args)
    {
        $inc = 'main';
        include_once 'ui/layout.php';
    }

    /**
     * Метод для отображения страницы галереи проектов
     * @param Lib\Base $app Экземпляр базового класса
     * @param array $args Массив аргументов $_REQUEST
     */
    public function projects($app, $args)
    {
        $inc = 'projects';
        include_once 'ui/layout.php';
    }

    /**
     * Метод для отображения страницы тарифов
     * @param Lib\Base $app Экземпляр базового класса
     * @param array $args Массив аргументов $_REQUEST
     */
    public function prices($app, $args)
    {
        $inc = 'prices';
        include_once 'ui/layout.php';
    }

    /**
     * Метод для отображения страницы контактной информации
     * @param Lib\Base $app Экземпляр базового класса
     * @param array $args Массив аргументов $_REQUEST
     */
    public function contacts($app, $args)
    {
        $inc = 'contacts';
        include_once 'ui/layout.php';
    }

    /**
     * Метод для отображения страницы подтверждения получения обращения
     * @param Lib\Base $app Экземпляр базового класса
     * @param array $args Массив аргументов $_REQUEST
     */
    public function confirmation($app, $args)
    {
        $inc = 'confirmation';
        include_once 'ui/layout.php';
    }

}
